<?php

namespace Stock\Articulo;

use Stock\Articulo\Service\Create;
use Stock\Entity\Articulo;

class ServiceManager
{
    /**
     * Doctrine Entity Manager
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
        $this->persist($articulo);
    }
    
    public function update($data)
    {
        $articulo = $this->em->find('Stock\Entity\Articulo', $data['stock_articulo_id']);
        $articulo->fromArray($data);
        $this->persist($articulo);
    }
    
    public function delete($id)
    {
        $articulo = $this->em->find('Stock\Entity\Articulo', $id);
        $this->em->remove($articulo);
        $this->em->flush();
    }
    
    protected function persist($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
    
    public function getResult()
    {
        return array('exitoso' => true);
    }
}