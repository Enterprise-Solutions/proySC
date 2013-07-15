<?php

namespace Fact\Ingreso;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Fact\Detalle\Ingreso as IngresoDetalle;

/**
 * Ingresos
 * @author guido
 * 
 * @ORM\Entity
 * @ORM\Table(name="fact_ingreso")
 */
class Ingreso
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $fact_ingreso_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $cont_moneda_id;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=80)
     */
    protected $codigo;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=100)
     */
    protected $doc_nro;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $doc_fecha;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=1)
     */
    protected $doc_tipo;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=1)
     */
    protected $condicion;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=1)
     */
    protected $estado;
    
    /**
     * @ORM\Column(type="float")
     */
    protected $total_excenta;
    
    /**
     * @ORM\Column(type="float")
     */
    protected $total_iva_cinco_porciento;
    
    /**
     * @ORM\Column(type="float")
     */
    protected $total_iva_diez_porciento;
    
    /**
     * @ORM\Column(type="float")
     */
    protected $total_ingreso;
    
    /**
     * @ORM\OneToMany(targetEntity="Fact\Detalle\Ingreso", mappedBy="ingreso")
     */
    protected $detalle;
    
    protected $defaultValues = array(
        'total_excenta'             => 0,
        'total_iva_cinco_porciento' => 0,
        'total_iva_diez_porciento'  => 0,
        'total_ingreso'             => 0,
    );
    
    public function __construct()
    {
        $this->detalle = new ArrayCollection();
    }
    
    /**
     * Setea los valores por defecto
     */
    public function setDefaultValues()
    {
        foreach ($this->defaultValues as $property => $value) {
            if (is_null($this->$property)) {
                $this->$property = $value;
            }
        }
        
        $this->doc_fecha = date('Y-m-d');
    }
    
    public function getId()
    {
        return $this->fact_ingreso_id;
    }
    
    public function add($detalle)
    {
        $this->detalle->add($detalle);
        $this->actualizarTotales($detalle);
    }
    
    protected function actualizarTotales(IngresoDetalle $detalle)
    {
        $subTotal = $detalle->getSubTotal();
        switch ($detalle->getPorcImpuesto()) {
        	case '10':
        	    $this->total_iva_diez_porciento += $subTotal;
        	    break;
        	case '5':
        	    $this->total_iva_cinco_porciento += $subTotal;
        	    break;
        	case '0':
        	    $this->total_excenta += $subTotal;
        	    break;
    	    default:
    	        break;
        }
        
        $this->total_ingreso += $subTotal;
    }
    
    /**
     * Carga los datos en el objeto
     * @param array $data
     */
    public function fromArray($data)
    {
        foreach ($data as $property => $value) {
            $this->$property = $value;
        }
    }
}