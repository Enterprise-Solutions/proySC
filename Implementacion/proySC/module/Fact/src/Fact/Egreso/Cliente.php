<?php

namespace Fact\Egreso;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente
 * @author guido
 *
 * @ORM\Entity
 * @ORM\Table(name="fact_rol_egreso")
 */
class Cliente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $fact_rol_egreso_id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Org\Rol\RolDeParte")
     * @ORM\JoinColumn(name="org_parte_rol_id", referencedColumnName="org_parte_rol_id")
     */
    protected $cliente;
    
    /**
     * @ORM\ManyToOne(targetEntity="Fact\Egreso\Egreso")
     * @ORM\JoinColumn(name="fact_egreso_id", referencedColumnName="fact_egreso_id")
     */
    protected $egreso;
    
    public function setEgreso($egreso)
    {
        $this->egreso = $egreso;
    }
    
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
    }
}