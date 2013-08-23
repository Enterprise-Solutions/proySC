<?php

namespace Fact\Egreso;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vendedor
 * @author guido
 *
 * @ORM\Entity
 * @ORM\Table(name="fact_rol_egreso")
 */
class Vendedor
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
    protected $vendedor;
    
    /**
     * @ORM\ManyToOne(targetEntity="Fact\Egreso\Egreso")
     * @ORM\JoinColumn(name="fact_egreso_id", referencedColumnName="fact_egreso_id")
     */
    protected $egreso;
    
    public function setEgreso($egreso)
    {
        $this->egreso = $egreso;
    }
    
    public function setVendedor($vendedor)
    {
        $this->vendedor = $vendedor;
    }
}