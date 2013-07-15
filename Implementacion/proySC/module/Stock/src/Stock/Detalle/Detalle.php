<?php

namespace Stock\Detalle;

use Doctrine\ORM\Mapping as ORM;

/**
 * Detalle de Articulo
 * @author guido
 * 
 * @ORM\Entity
 * @ORM\Table(name="stock_articulo_detalle")
 */
class Detalle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $stock_articulo_detalle_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $stock_articulo_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $fact_compra_detalle_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $fact_venta_detalle_id;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=80)
     */
    protected $codigo_interno;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $fecha_vencimiento;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=1)
     */
    protected $estado;
    
    /**
     * @ORM\ManyToOne(targetEntity="Stock\Articulo\Articulo", inversedBy="detalle")
     * @ORM\JoinColumn(name="stock_articulo_id", referencedColumnName="stock_articulo_id")
     */
    protected $articulo;
    
    /**
     * @ORM\ManyToOne(targetEntity="Fact\Detalle\Ingreso")
     * @ORM\JoinColumn(name="fact_compra_detalle_id", referencedColumnName="fact_compra_detalle_id")
     */
    protected $ingresoDetalle;
    
    protected $defaultValues = array(
        'estado' => 'D',
    );
    
    public function fromArray($data)
    {
        foreach ($data as $property => $value) {
            $this->$property = $value;
        }
    }
    
    public function setDefaultValues()
    {
        foreach ($this->defaultValues as $property => $value) {
            if (is_null($this->$property)) {
                $this->$property = $value;
            }
        }
    }
    
    public function getArticulo()
    {
        return $this->articulo;
    }
    
    public function setIngresoDetalle($ingresoDetalle)
    {
        $this->ingresoDetalle = $ingresoDetalle;
    }
    
    public function setArticulo($articulo)
    {
        $this->articulo = $articulo;
    }
}