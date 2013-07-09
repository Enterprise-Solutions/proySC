<?php

namespace Stock\Articulo\Validator;

use Zend\Validator\AbstractValidator;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;
use Zend\Validator\Digits;
use Zend\Validator\InArray;
use Zend\I18n\Validator\Float;
use Zend\I18n\Validator\Int;

class Validator extends AbstractValidator
{
    protected $validatorChain;
    protected $paramList;
    protected $errorsValidation;
    
    public function __construct()
    {
        $this->validatorChain   = array();
        $this->paramList        = array();
        $this->errorsValidation = array();
    }
    
    protected function dataValidation($entity)
    {
        // Implementar en el validador dependiendo de lo que se tenga que validar
    }
    
    protected function especialValidation($entity)
    {
        // Implementar en el validador dependiendo de lo que se tenga que validar
        return true;
    }
    
    public function isValid($entity)
    {
        $this->dataValidation($entity);
        $isValidIndividual = true;
        $isValidGeneral    = true;
        $isValidEspecial   = true;
        $size = count($this->validatorChain);
    
        for ($i=0; $i<$size; $i++) {
            $isValidIndividual = $this->validatorChain[$i]->isValid($this->paramList[$i]);
            if (!$isValidIndividual) {
                $isValidGeneral = false;
                $this->addErrorsValidation($this->validatorChain[$i]->getMessages());
            }
        }
        
        $isValidEspecial = $this->especialValidation($entity);
    
        if ($isValidGeneral && $isValidEspecial) {
            return true;
        }
        return false;
    }
    
    protected function addValidator($validator, $param)
    {
        $this->validatorChain[] = $validator;
        $this->paramList[]      = $param;
    }
    
    protected function addErrorsValidation($errors)
    {
        if (!is_array($errors)) {
            $errors = array($errors);
        }
        
        $this->errorsValidation = array_merge($this->errorsValidation, $errors);
    }
    
    protected function getNotEmptyValidator($field)
    {
        $notEmptyValidator = new NotEmpty();
        $notEmptyValidator->setMessage("El campo '$field' es obligatorio.");
        return $notEmptyValidator;
    }
    
    protected function getStringLengthValidator($field, $options = array('min' => 0, 'max' => 10))
    {
        $stringLengthValidator = new StringLength($options);
        $stringLengthValidator->setMessage("El campo '$field' acepta %max% caracteres como maximo.");
        return $stringLengthValidator;
    }
    
    protected function getDigitValidator($field)
    {
        $digitValidator = new Digits();
        $digitValidator->setMessage("El campo '$field' solo permite caracteres numericos.");
        return $digitValidator;
    }
    
    protected function getInArrayValidator($field, $options)
    {
        $valoresPermitidos = join(',', $options);
        
        $inArrayValidator = new InArray();
        $inArrayValidator->setMessage("El campo '$field' es invalido. Valores permitidos: $valoresPermitidos.");
        return $inArrayValidator;
    }
    
    protected function getFloatValidator($field)
    {
        $floatValidator = new Float();
        $floatValidator->setMessage("El campo '$field' solo permite valores decimales.");
        return $floatValidator;
    }
    
    protected function getIntValidator($field)
    {
        $intValidator = new Int();
        $intValidator->setMessage("El campo '$field' no permite valores decimales.");
        return $intValidator;
    }
}