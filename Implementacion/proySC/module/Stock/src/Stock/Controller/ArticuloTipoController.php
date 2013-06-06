<?php

namespace Stock\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class ArticuloTipoController extends AbstractActionController
{
    public function indexAction()
    {
        $records = array();
        $numResults = 0;
        
        $results = array(
            'records' => $records,
            'numResults' => $numResults,
        );
        
        return new JsonModel($results);
    }
}