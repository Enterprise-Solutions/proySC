<?php

namespace Stock\Articulo;

use Stock\Articulo\Service\Create;
use Stock\Entity\Articulo;

class ServiceManager
{
    /**
     * @var Doctrine\Orm\EntityManager
     */
    protected $em;
    
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    public function create($data)
    {
        $articulo = new Articulo();
        $articulo->fromArray($data);
        
        $this->em->persist($articulo);
        $this->em->flush();
    }
    
    public function update($data)
    {
        
    }
    
    public function delete($data)
    {
        
    }
    
    public function getResult()
    {
        return array('exitoso' => true);
    }
}