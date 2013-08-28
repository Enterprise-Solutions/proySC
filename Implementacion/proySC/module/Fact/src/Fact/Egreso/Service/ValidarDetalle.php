<?php

namespace Fact\Egreso\Service;

use EnterpriseSolutions\Exceptions\Thrower;
use Doctrine\ORM\EntityManager;
use Stock\Articulo\Articulo;

class ValidarDetalle
{
    /**
     * Mensajes de Error
     * @var array
     */
    protected $errorMessages;
    
    /**
     * Datos a validar
     * @var array
     */
    protected $data;
    
    /**
     * Doctrine Entity Manager
     * @var EntityManager
     */
    protected $em;
    
    /**
     * Articulo
     * @var Articulo
     */
    protected $articulo;
    
    /**
     * Estado de la Validacion
     * @var boolean
     */
    protected $status;
    
    public function __construct($em)
    {
        $this->errorMessages = array();
        $this->status = true;
        $this->em = $em;
    }
    
    /**
     * Validar los datos recibidos
     * 
     * controlar los datos recibidos
     * armar la respuesta
     */
    public function validar($data)
    {
        $this->data = $data;
        $this->articulo = $this->getArticulo();
        
        $this->validarCantidad();
        $this->validarPrecio();
        $this->validarExistencia();
    }
    
    /**
     * Obtiene el articulo solicitado
     * @return Ambigous <object, NULL, unknown>
     */
    protected function getArticulo()
    {
        if (!isset($this->data['stock_articulo_id'])) {
            Thrower::throwValidationException('Error de Validacion', 'No se recibio el identificador del articulo');
            return;
        }
        
        try {
            return $this->em->find('Stock\Articulo\Articulo', $this->data['stock_articulo_id']);
        } catch (\Exception $e) {
            Thrower::throwValidationException('Error de Validacion', 'No se encontro el articulo solicitado');
        }
    }
    
    /**
     * Valida la cantidad recibida
     * 
     * Controles:
     *     - Cantidad mayor a cero
     *     - Cantidad es un valor entero
     */
    protected function validarCantidad()
    {
        if (!isset($this->data['cantidad'])) {
            $this->status = false;
            $this->errorMessages[] = 'No se especifico la cantidad del producto';
            return;
        }
        
        if ($this->data['cantidad'] <= 0) {
            $this->status = false;
            $this->errorMessages[] = 'La cantidad debe ser mayor a 0 (cero)';
        }
        
        if (!is_int($this->data['cantidad'])) {
            $this->status = false;
            $this->errorMessages[] = 'La cantidad debe ser un valor entero';
        }
    }
    
    /**
     * Valida el precio recibido
     * 
     * Controles:
     *     - Precio mayor a cero
     */
    protected function validarPrecio()
    {
        if (!isset($this->data['cont_moneda_id'])) {
            $this->status = false;
            $this->errorMessages[] = 'No se especifico la moneda';
            return;
        }
        
        if (!isset($this->data['precio_unit'])) {
            $this->status = false;
            $this->errorMessages[] = 'No se especifico el precio del producto';
            return;
        }
        
        if ($this->data['precio_unit'] != $this->articulo->getPrecioVenta()) {
            $this->status = false;
            $this->errorMessages[] = 'El precio de venta no coincide con el establecido para el articulo';
            return;
        }
        
        $moneda = $this->em->find('Cont\Moneda\Moneda', $this->data['cont_moneda_id']);
        
        if ($this->data['precio_unit'] <= 0) {
            $this->status = false;
            $this->errorMessages[] = 'El precio unitario debe ser mayor a 0 (cero)';
        }
        
        if (is_float($this->data['precio_unit']) && !$moneda->permiteDecimales()) {
            $this->status = false;
            $this->errorMessages[] = 'La moneda seleccionada no permite valores decimales';
        }
        
        if ($this->cantidadDecimales() > $moneda->getCantidadDecimales()) {
            $this->status = false;
            $this->errorMessages[] = 'El costo sobrepasa la cantidad de decimales permitidos';
        }
    }
    
    /**
     * Valida la existencia del articulo
     * 
     * Controles:
     *     - Debe existir la cantidad de articulos solicitados en estado disponible
     */
    protected function validarExistencia()
    {
        $detalles = $this->articulo->getDetalle();
        $disponibles = 0;
        
        foreach ($detalles as $detalle) {
            if ($detalle->getEstado() === 'D') {
                $disponibles++;
            }
        }
        
        if (!isset($this->data['cantidad'])) {
            $this->status = false;
            $this->errorMessages[] = 'No se especifico la cantidad';
            return;
        }
        
        if ($this->data['cantidad'] > $disponibles) {
            $this->status = false;
            $this->errorMessages[] = 'No existe la cantidad de articulos solicitada';
        }
    }
    
    /**
     * Cantidad de decimales del costo recibido
     * @return number
     */
    protected function cantidadDecimales()
    {
        return strlen(substr(strrchr(strval($this->data['precio_unit']), "."), 1));
    }
    
    /**
     * Resultado de la validacion
     */
    public function getResult()
    {
        if (!$this->status) {
            Thrower::throwValidationException('Error de Validacion', $this->errorMessages);
        }
        
        $successResult = array(
            'articulo'           => $this->articulo->getNombre(),
            'precio_venta_final' => $this->articulo->getPrecioVentaFinal($this->data['medio_de_pago']),
            'exitoso'            => true,
        );
        
        return array_merge($this->data, $successResult);
    }
}