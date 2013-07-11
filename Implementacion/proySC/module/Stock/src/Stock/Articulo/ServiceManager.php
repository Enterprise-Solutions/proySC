<?php

namespace Stock\Articulo;

use Stock\Articulo\Articulo;
use Stock\Articulo\Validator\Articulo as ArticuloValidator;

use Doctrine\ORM\EntityManager;
use EnterpriseSolutions\Exceptions\Thrower;

class ServiceManager
{
    /**
     * Doctrine Entity Manager
     * @var EntityManager
     */
    protected $em;
    
    /**
     * @var Articulo
     */
    protected $articulo;
    
    /**
     * Resultado de la Operacion
     * @var array
     */
    protected $result;
    
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    /**
     * Servicio para crear un articulo
     * @param array $data
     */
    public function create($data)
    {
        $this->articulo = new Articulo();
        $this->articulo->fromArray($data);
        $this->articulo->setDefaultValues();
        
        $validator = new ArticuloValidator();
        if (!$validator->isValid($this->articulo)) {
            Thrower::throwValidationException('Error de Validacion', $validator->getMessages());
        }
        
        $this->em->persist($this->articulo);
    }
    
    /**
     * Sercicio para actualizar un articulo
     * @param array $data
     */
    public function update($data)
    {
        $id = $data['stock_articulo_id'];
        $this->articulo = $this->em->find('Stock\Articulo\Articulo', $id);
        $this->articulo->fromArray($data);
        
        $validator = new ArticuloValidator();
        if (!$validator->isValid($this->articulo)) {
            Thrower::throwValidationException('Error de Validacion', $validator->getMessages());
        }
        
        $this->em->persist($this->articulo);
    }
    
    /**
     * Servicio para eliminar un articulo
     * @param array $data
     */
    public function delete($data)
    {
        $id = $data['stock_articulo_id'];
        $this->articulo = $this->em->find('Stock\Articulo\Articulo', $id);
        
        // APLICAR VALIDACIONES A $this->articulo
        
        $this->em->remove($this->articulo);
    }
    
    protected function setSuccessResult()
    {
        $successResult = array(
        	'stock_articulo_id' => $this->articulo->getId(),
            'exitoso' => true,
        );
        $this->result = $successResult;
    }
    
    public function run()
    {
        try {
            $this->em->flush();
            $this->setSuccessResult();
        } catch (\Exception $e) {
            $this->em->clear();
            throw $e;
        }
    }
    
    public function getResult()
    {
        return $this->result;
    }
}