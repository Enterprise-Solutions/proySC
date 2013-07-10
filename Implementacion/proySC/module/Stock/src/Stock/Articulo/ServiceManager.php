<?php

namespace Stock\Articulo;

use Stock\Entity\Articulo;
use Stock\Articulo\Validator\Articulo as ArticuloValidator;

use EnterpriseSolutions\Exceptions\Thrower;

class ServiceManager
{
    /**
     * Doctrine Entity Manager
     * @var Doctrine\Orm\EntityManager
     */
    protected $em;
    
    /**
     * @var Articulo
     */
    protected $articulo;
    
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    public function create($data)
    {
        $this->articulo = new Articulo();
        $this->articulo->setDefaultValues();
        $this->articulo->fromArray($data);
        
        $validator = new ArticuloValidator();
        if (!$validator->isValid($this->articulo)) {
            Thrower::throwValidationException('Error de Validacion', $validator->getMessages());
        }
        
        $this->em->persist($this->articulo);
    }
    
    public function update($data)
    {
        $id = $data['stock_articulo_id'];
        $this->articulo = $this->em->find('Stock\Entity\Articulo', $id);
        $this->articulo->fromArray($data);
        
        $validator = new ArticuloValidator();
        if (!$validator->isValid($this->articulo)) {
            Thrower::throwValidationException('Error de Validacion', $validator->getMessages());
        }
        
        $this->em->persist($this->articulo);
    }
    
    public function delete($data)
    {
        $id = $data['stock_articulo_id'];
        $this->articulo = $this->em->find('Stock\Entity\Articulo', $id);
        
        // APLICAR VALIDACIONES A $this->articulo
        
        $this->em->remove($this->articulo);
    }
    
    public function run()
    {
        try {
            $this->em->flush();
        } catch (\Exception $e) {
            $this->em->clear();
            throw $e;
        }
    }
    
    public function getResult()
    {
        return array(
            'stock_articulo_id' => $this->articulo->getId(),
            'exitoso' => true,
        );
    }
}