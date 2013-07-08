<?php

namespace Stock\Articulo\Validator;

use Zend\Validator\AbstractValidator;

class Articulo extends AbstractValidator
{
    public function isValid($articulo)
    {
        return true;
    }
}