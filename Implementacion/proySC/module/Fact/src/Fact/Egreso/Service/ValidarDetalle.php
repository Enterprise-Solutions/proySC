<?php

namespace Fact\Egreso\Service;

use EnterpriseSolutions\Exceptions\Thrower;
use Doctrine\ORM\EntityManager;
use Stock\Articulo\Articulo;
use Cont\Moneda\Moneda;

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
    
    /**
     * Moneda utilizada
     * @var Moneda
     */
    protected $moneda;
    
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
            $this->errorMessages[] = 'No se especifico el precio de venta del producto';
            return;
        }
        
        $this->moneda = $this->em->find('Cont\Moneda\Moneda', $this->data['cont_moneda_id']);
        
        if (!$this->rangoPermitido()) {
            $this->status = false;
            $this->errorMessages[] = 'El precio de venta no se encuentra en el rango permitido';
            return;
        }
        
        if ($this->data['precio_unit'] <= 0) {
            $this->status = false;
            $this->errorMessages[] = 'El precio de venta debe ser mayor a 0 (cero)';
        }
        
        if (is_float($this->data['precio_unit']) && !$this->moneda->permiteDecimales()) {
            $this->status = false;
            $this->errorMessages[] = 'La moneda seleccionada no permite valores decimales';
        }
        
        if ($this->cantidadDecimales() > $this->moneda->getCantidadDecimales()) {
            $this->status = false;
            $this->errorMessages[] = 'El costo sobrepasa la cantidad de decimales permitidos';
        }
    }
    
    /**
     * Rango permitido para un precio
     * @return boolean
     */
    protected function rangoPermitido()
    {
        $precio_min = $this->getPrecioUnitMinimo();
        $precio_max = $this->getPrecioUnitMaximo();
        
        if ($this->data['precio_unit'] >= $precio_min && $this->data['precio_unit'] <= $precio_max) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Precio Minimo del Producto (con interes calculado)
     * Redondea siempre para arriba
     * @return number
     */
    protected function getPrecioUnitMinimo()
    {
        $interes     = $this->getInteresPorFormaDePago();
        $descuento   = $this->articulo->getPrecioVenta() * ($this->articulo->getDescuentoMaximo() / 100.0);
        $precio_unit = ($this->articulo->getPrecioVenta() - $descuento) * $interes;
        return round($precio_unit, $this->moneda->getCantidadDecimales());
    }
    
    /**
     * Precio Maximo del Producto (con interes calculado)
     * Redondea siempre para arriba
     * @return number
     */
    protected function getPrecioUnitMaximo()
    {
        $interes     = $this->getInteresPorFormaDePago();
        $precio_unit = $this->articulo->getPrecioVenta() * $interes;
        return round($precio_unit, $this->moneda->getCantidadDecimales());
    }
    
    /**
     * Interes dependiendo de la forma de pago
     * @return number
     */
    protected function getInteresPorFormaDePago()
    {
        $interes = 1.00;
        switch ($this->data['medio_de_pago']) {
        	case 'D':
        	    $interes = 1.04;
        	    break;
        	case 'C':
        	    $interes = 1.08;
        	    break;
        	default:
        	    $interes = 1.00;
        	    break;
        }
        
        return $interes;
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
            'articulo' => $this->articulo->getNombre(),
            'exitoso'  => true,
        );
        
        return array_merge($this->data, $successResult);
    }
}