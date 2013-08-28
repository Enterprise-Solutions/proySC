<?php

namespace Stock\Articulo;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Articulo
 * @author guido  
 * 
 * @ORM\Entity
 * @ORM\Table(name="stock_articulo")
 * 
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
     * Nombre del Articulo - Se usa en la descripcion de la factura
     * @ORM\Column(type="string")
     * @ORM\Column(length=120)
     */
    protected $nombre;
    
    /**
     * Codigo de Barra o Identificador del Articulo
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
     * Tipo de Articulo (P = Producto, S = Servicio)
     * @ORM\Column(type="string")
     * @ORM\Column(length=1)
     */
    protected $tipo;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $tiempo_garantia;     
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=80)
     */
    protected $ncm;
    
    /**
     * @ORM\Column(type="float")
     */
    protected $descuento_maximo;
    
    /**
     * Impuesto (5%, 10%, Excenta)
     * @ORM\Column(type="float")
     */
    protected $porcentaje_impuesto;
    
    /**
     * @ORM\Column(type="float")
     */
    protected $precio_venta;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=120)
     */
    protected $modelo;
    
    /**
     * A = Activo O = Obsoleto / Borrado
     * @ORM\Column(type="string")
     * @ORM\Column(length=1)
     */
    protected $estado;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $imagen;
    
    /**
     * Existencia real (default=0)
     * @ORM\Column(type="integer")
     */
    protected $existencia;
    
    /**
     * Existencia minima (default=0)
     * @ORM\Column(type="integer")
     */
    protected $existencia_minima;
    
    /**
     * Referencia Código Artículo del Proveedor
     * @ORM\Column(type="string")
     * @ORM\Column(length=80)
     */
    protected $rcap;
    
    /**
     * Moneda del Articulo
     * @ORM\Column(type="integer")
     */
    protected $cont_moneda_id;
    
    /**
     * Marca del Articulo
     * @ORM\Column(type="integer")
     */
    protected $stock_marca_id;
    
    /**
     * Categoria del Articulo
     * @ORM\Column(type="integer")
     */
    protected $stock_categoria_id;
    
    /**
     * Tipo de Garantia del Articulo
     * @ORM\Column(type="integer")
     */
    protected $stock_garantia_tipo_id;
    
    /**
     * Detalles del Articulo
     * @ORM\OneToMany(targetEntity="Stock\Detalle\Detalle", mappedBy="articulo")
     */
    protected $detalle;
    
    protected $defaultValues = array(
    	'porcentaje_impuesto' => '10',
        'precio_venta'        => '0',
        'estado'              => 'A',
        'rcap'                => '',
        'existencia'          => 0,
        'existencia_minima'   => 0,
    );
    
    public function __construct()
    {
        $this->detalle = new ArrayCollection();
    }
    
    public function __get($property)
    {
        return $this->$property;
    }
    
    /**
     * Id del Articulo
     */
    public function getId()
    {
        return $this->stock_articulo_id;
    }
    
    public function getDetalle()
    {
        return $this->detalle;
    }
    
    /**
     * Setea los valores por default
     */
    public function setDefaultValues()
    {
        foreach ($this->defaultValues as $property => $value) {
            if (!$this->$property) {
                $this->$property = $value;
            }
        }
    }
    
    /**
     * Carga las propiedades del articulo desde un array
     * @param array $data
     */
    public function fromArray($data)
    {
        foreach ($data as $property => $value) {
            $this->$property = $value;
        }
    }
    
    public function getNombre()
    {
        return $this->nombre;
    }
    
    public function getPrecioVenta()
    {
        return $this->precio_venta;
    }
    
    public function getPrecioVentaFinal($medio_de_pago)
    {
        switch ($medio_de_pago) {
        	case 'E':
        	    return $this->precio_venta;
        	    break;
        	case 'D':
        	    $interes = 1.04;
        	    return $this->precio_venta * $interes;
        	    break;
        	case 'C':
        	    $interes = 1.08;
        	    return $this->precio_venta * $interes;
        	    break;
        	default:
        	    return $this->precio_venta;
        	    break;
        }
        return $this->precio_venta;
    }
    
    public function addExistencia()
    {
        $this->existencia++;
    }
    
    public function removeExistencia()
    {
        $this->existencia--;
    }
}