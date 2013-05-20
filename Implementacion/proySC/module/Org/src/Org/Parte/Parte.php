<?php

namespace Org\Parte;

class Parte
{
    protected $_codigoDeTipo;
    
    /**
     * @var Org\ParteTipo
     */
    protected $_tipo;
    
    /**
     * @param ParteTipo $tipo
     */
    public function setTipo(ParteTipo $tipo)
    {
        if($this->_tipo){
        	return;
        }
        
        if($this->_codigoDeTipo == $tipo->getCodigo()){
            $this->_tipo = $tipo;    	
        }
    }

    public function getCodigoDeTipo()
    {
    	return $this->_tipo->getCodigo();
    }
}