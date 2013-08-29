<?php

namespace Fact\Tarjeta\Service;

use Doctrine\ORM\EntityManager;
use Fact\Tarjeta\Tarjeta;

class Crear
{
    /**
     * Doctrine Entity Manager
     * @var EntityManager
     */
    protected $em;
    
    /**
     * Tarjeta
     * @var Tarjeta
     */
    protected $tarjeta;
    
    public function __construct($em)
    {
        $this->em = $em;
        $this->tarjeta = null;
    }
    
    public function ejecutar($data)
    {
        $this->crearTarjeta($data);
    }
    
    protected function crearTarjeta($data)
    {
        $this->tarjeta = new Tarjeta();
        $this->tarjeta->fromArray($data);
        $this->em->persist($this->tarjeta);
    }
    
    public function persistir()
    {
        $this->em->flush();
    }
    
    public function getRespuesta()
    {
        return array(
            'fact_tarjeta_id' => $this->tarjeta->getId(),
            'exitoso'         => true,
        );
    }
}