<?php

namespace Stock\Articulo\Validator;

use Zend\Validator\ValidatorChain;

class Articulo extends Validator
{
    protected function dataValidation($articulo)
    {
        $this->validateContMoneda($articulo);
        $this->validateNombre($articulo);
        $this->validateCodigo($articulo);
        $this->validateTiempoGarantia($articulo);
        $this->validateModelo($articulo);
        $this->validateEstado($articulo);
        $this->validateTipo($articulo);
        $this->validatePorcentajeImpuesto($articulo);
        $this->validatePrecioVenta($articulo);
        $this->validateDescuentoMaximo($articulo);
        $this->validateExistencia($articulo);
        $this->validateExistenciaMinima($articulo);
        $this->validateRcap($articulo);
    }
    
    protected function validateContMoneda($articulo)
    {
        $contMonedaValidator = new ValidatorChain();
        $contMonedaValidator->addValidator($this->getNotEmptyValidator('cont_moneda_id'));
        
        $this->addValidator($contMonedaValidator, $articulo->cont_moneda_id);
    }
    
    protected function validateNombre($articulo)
    {
        $nombreValidator = new ValidatorChain();
        $nombreValidator->addValidator($this->getNotEmptyValidator('nombre'))
                        ->addValidator($this->getStringLengthValidator('nombre', array('max' => 120)));
        
        $this->addValidator($nombreValidator, $articulo->nombre);
    }
    
    protected function validateCodigo($articulo)
    {
        $codigoValidator = new ValidatorChain();
        $codigoValidator->addValidator($this->getNotEmptyValidator('codigo'))
                        ->addValidator($this->getStringLengthValidator('codigo', array('max' => 80)));
        
        $this->addValidator($codigoValidator, $articulo->codigo);
    }
    
    protected function validateTiempoGarantia($articulo)
    {
        $tiempoGarantiaValidator = new ValidatorChain();
        $tiempoGarantiaValidator->addValidator($this->getDigitValidator('tiempo_garantia'));
        
        $this->addValidator($tiempoGarantiaValidator, $articulo->tiempo_garantia);
    }
    
    protected function validateModelo($articulo)
    {
        if (is_null($articulo->modelo)) {
            return;
        }
        
        $modeloValidator = new ValidatorChain();
        $modeloValidator->addValidator($this->getStringLengthValidator('modelo', array('max' => 120)));
        
        $this->addValidator($modeloValidator, $articulo->modelo);
    }
    
    protected function validateEstado($articulo)
    {
        if (is_null($articulo->estado)) {
            return;
        }
        
        $estadoValidator = new ValidatorChain();
        $estadoValidator->addValidator($this->getInArrayValidator('estado', array('A', 'O')));
        
        $this->addValidator($estadoValidator, $articulo->estado);
    }
    
    protected function validateTipo($articulo)
    {
        $tipoValidator = new ValidatorChain();
        $tipoValidator->addValidator($this->getNotEmptyValidator('tipo'))
                      ->addValidator($this->getInArrayValidator('tipo', array('P', 'S')));
        
        $this->addValidator($tipoValidator, $articulo->tipo);
    }
    
    protected function validatePorcentajeImpuesto($articulo)
    {
        $impuestoValidaor = new ValidatorChain();
        $impuestoValidaor->addValidator($this->getNotEmptyValidator('porcentaje_impuesto'))
                         ->addValidator($this->getFloatValidator('porcentaje_impuesto'));
        
        $this->addValidator($impuestoValidaor, $articulo->porcentaje_impuesto);
    }
    
    /**
     * @todo Agregar validador de monedas
     * Dependiendo de si la moneda permita o no decimales hay que controlar el valor recibido
     */
    protected function validatePrecioVenta($articulo)
    {
        $precioValidator = new ValidatorChain();
        $precioValidator->addValidator($this->getNotEmptyValidator('precio_venta'));
        
        $this->addValidator($precioValidator, $articulo->precio_venta);
    }
    
    protected function validateDescuentoMaximo($articulo)
    {
        if (is_null($articulo->descuento_maximo)) {
            return;
        }
        
        $descuentoValidator = new ValidatorChain();
        $descuentoValidator->addValidator($this->getFloatValidator('descuento_maximo'));
        
        $this->addValidator($descuentoValidator, $articulo->descuento_maximo);
    }
    
    protected function validateExistencia($articulo)
    {
        if ($articulo->tipo == 'S') {
            if (!is_null($articulo->existencia)) {
                $this->addErrorsValidation("Un articulo de tipo servicio no puede tener existencia.");
            }
        } else {
            $existenciaValidator = new ValidatorChain();
            $existenciaValidator->addValidator($this->getNotEmptyValidator('existencia'))
                                ->addValidator($this->getIntValidator('existencia'));
            
            $this->addValidator($existenciaValidator, $articulo->existencia);
        }
    }
    
    protected function validateExistenciaMinima($articulo)
    {
        if ($articulo->tipo == 'S') {
        	if (!is_null($articulo->existencia_minima)) {
        		$this->addErrorsValidation("Un articulo de tipo servicio no puede tener existencia minima.");
        	};
        } else {
            $existenciaMinValidator = new ValidatorChain();
            $existenciaMinValidator->addValidator($this->getNotEmptyValidator('existencia_minima'))
                                   ->addValidator($this->getIntValidator('existencia_minima'));
            
            $this->addValidator($existenciaMinValidator, $articulo->existencia_minima);
        }
    }
    
    protected function validateRcap($articulo)
    {
        if (is_null($articulo->rcap)) {
        	return;
        }
        
        $rcapValidator = new ValidatorChain();
        $rcapValidator->addValidator($this->getStringLengthValidator('rcap', array('max' => 80)));
        
        $this->addValidator($rcapValidator, $articulo->rcap);
    }
}