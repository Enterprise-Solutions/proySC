<?php

namespace Fact\Detalle;

use Doctrine\ORM\Mapping as ORM;

/**
 * Detalle del Ingreso
 * @author guido
 * 
 * @ORM\Entity
 * @ORM\Table(name="fact_compra_detalle")
 */
class Ingreso
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $fact_compra_detalle_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $fact_compra_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $stock_articulo_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $cantidad;
    
    /**
     * @ORM\Column(type="float")
     */
    protected $costo_unit;
    
    /**
     * @ORM\Column(type="float")
     */
    protected $porc_impuesto;
    
    /**
     * @ORM\ManyToOne(targetEntity="Fact\Ingreso\Ingreso", inversedBy="detalle")
     * @ORM\JoinColumn(name="fact_compra_id", referencedColumnName="fact_ingreso_id")
     */
    protected $ingreso;
    
    /**
     * Valores por defecto
     * @var array
     */
    protected $defaultValues = array(
    	'cantidad' => 1,
    );
    
    public function setIngreso($ingreso)
    {
        $this->ingreso = $ingreso;
    }
    
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
    
    public function getArticuloId()
    {
        return $this->stock_articulo_id;
    }
    
    public function getCantidad()
    {
        return $this->cantidad;
    }
    
    /**
     * Impuesto del articulo comprado
     * @return string
     */
    public function getPorcImpuesto()
    {
        return strval($this->porc_impuesto);
    }
    
    /**
     * Subtotal del detalle (cantidad * costo_unit)
     * @return number
     */
    public function getSubTotal()
    {
        return $this->cantidad * $this->costo_unit;
    }
}