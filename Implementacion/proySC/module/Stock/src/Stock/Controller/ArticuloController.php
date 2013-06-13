<?php

namespace Stock\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class ArticuloController extends AbstractActionController
{
    public function indexAction()
    {
        $results = array("records" => array(), "numResults" => 0);
        return new JsonModel($results);
    }
}