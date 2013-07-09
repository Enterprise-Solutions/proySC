<?php

namespace Stock\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Articulo
 * @author guido
 * 
 * @ORM\Entity
 * @ORM\Table(name="stock_articulo")
 */
class Articulo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $stock_articulo_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $stock_garantia_tipo_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $cont_moneda_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $stock_marca_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $stock_categoria_id;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=40)
     */
    protected $nombre;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=80)
     */
    protected $codigo;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=500)
     */
    protected $descripcion;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $tiempo_garantia;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=100)
     */
    protected $modelo;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=1)
     */
    protected $estado;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=1)
     */
    protected $tipo;
    
    /**
     * @ORM\Column(type="float")
     * @ORM\Column(precision=2)
     */
    protected $porcentaje_impuesto;
    
    /**
     * @ORM\Column(type="float")
     * @ORM\Column(precision=2)
     */
    protected $precio_venta;
    
    /**
     * @ORM\Column(type="float")
     * @ORM\Column(precision=2)
     */
    protected $descuento_maximo;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $foto;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $existencia;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=80)
     */
    protected $ncm;
    
    public function __get($property)
    {
        return $this->$property;
    }
    
    public function getId()
    {
        return $this->stock_articulo_id;
    }
    
    public function setDefaultValues()
    {
        $this->existencia = 0;
    }
    
    public function fromArray($data)
    {
        foreach ($data as $property => $value) {
            $this->$property = $value;
        }
    }
}