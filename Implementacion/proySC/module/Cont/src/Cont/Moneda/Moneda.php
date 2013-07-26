<?php

namespace Cont\Moneda;

use Doctrine\ORM\Mapping as ORM;

/**
 * Moneda
 * @author guido
 * 
 * @ORM\Entity
 * @ORM\Table(name="cont_moneda")
 */
class Moneda
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $cont_moneda_id;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=120)
     */
    protected $nombre;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=120)
     */
    protected $nombre_plural;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=20)
     */
    protected $simbolo;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=500)
     */
    protected $descripcion;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=1)
     */
    protected $permite_decimal;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $cnt_decimales;
    
    public function permiteDecimales()
    {
        if ($this->permite_decimal == 'S') {
            return true;
        }
        return false;
    }
    
    public function getCantidadDecimales()
    {
        return $this->cnt_decimales;
    }
}