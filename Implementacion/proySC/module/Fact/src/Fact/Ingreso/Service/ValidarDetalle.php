<?php

namespace Fact\Ingreso\Service;

use EnterpriseSolutions\Exceptions\Thrower;
use Doctrine\ORM\EntityManager;

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
        
        $this->validarCantidad();
        $this->validarCosto();
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
     * Valida el costo recibido
     * 
     * Controles:
     *     - Costo mayor a cero
     */
    protected function validarCosto()
    {
        $moneda = $this->em->find('Cont\Moneda\Moneda', $this->data['cont_moneda_id']);
        
        if ($this->data['costo_unit'] <= 0) {
            $this->status = false;
            $this->errorMessages[] = 'El costo debe ser mayor a 0 (cero)';
        }
        
        if (is_float($this->data['costo_unit']) && !$moneda->permiteDecimales()) {
            $this->status = false;
            $this->errorMessages[] = 'La moneda seleccionada no permite valores decimales';
        }
        
        if ($this->cantidadDecimales() > $moneda->getCantidadDecimales()) {
            $this->status = false;
            $this->errorMessages[] = 'El costo sobrepasa la cantidad de decimales permitidos';
        }
    }
    
    /**
     * Cantidad de decimales del costo recibido
     * @return number
     */
    protected function cantidadDecimales()
    {
        return strlen(substr(strrchr(strval($this->data['costo_unit']), "."), 1));
    }
    
    /**
     * Resultado de la validacion
     */
    public function getResult()
    {
        if (!$this->status) {
            Thrower::throwValidationException('Error de Validacion', $this->errorMessages);
        }
        
        $articulo = $this->em->find('Stock\Articulo\Articulo', $this->data['stock_articulo_id']);
        $successResult = array(
            'articulo' => $articulo->getNombre(),
            'exitoso'  => true,
        );
        
        return array_merge($this->data, $successResult);
    }
}