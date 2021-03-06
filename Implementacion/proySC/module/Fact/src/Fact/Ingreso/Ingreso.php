<?php

namespace Fact\Ingreso;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\InputFilter\Factory as InputFilterFactory;
use EnterpriseSolutions\Exceptions\Thrower;
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
     * @ORM\Column(type="string")
     */
    protected $fecha_vencimiento;
    
    /**
     * Especifica si el movimiento requiere o no una moneda
     * @var boolean
     */
    protected $requiere_moneda;
    
    /**
     * @ORM\OneToMany(targetEntity="Fact\Detalle\Ingreso", mappedBy="ingreso")
     */
    protected $detalle;
    
    protected $defaultValues = array(
        'cont_moneda_id'            => 1,
        'total_excenta'             => 0,
        'total_iva_cinco_porciento' => 0,
        'total_iva_diez_porciento'  => 0,
        'total_ingreso'             => 0,
    );
    
    /**
     * Input Filter
     * @param array $data
     * @return Ambigous <\Zend\InputFilter\InputFilterInterface, \Zend\InputFilter\CollectionInputFilter, unknown, object>
     */
    protected function getInputFilter($data)
    {
        $inputFilterFactory = new InputFilterFactory();
        $spec = array(
            'cont_moneda_id' => array(
                'name'     => 'cont_moneda_id',
                'required' => $this->requiere_moneda,
            ),
            'codigo' => array(
                'name'       => 'codigo',
                'required'   => false,
                'filters'    => array(
                    array('name' => 'StripTags'),
                ),
                'validators' => array(
                    array('name' => 'StringLength', 'options' => array('max' => 80)),
                ),
            ),
            'doc_nro' => array(
                'name'       => 'doc_nro',
                'required'   => true,
                'filters'    => array(
                    array('name' => 'StripTags'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                    array('name' => 'StringLength', 'options' => array('max' => 100)),
                ),
            ),
            'doc_fecha' => array(
                'name'       => 'doc_fecha',
                'required'   => true,
                'filters'    => array(
                    array('name' => 'StripTags'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                    array('name' => 'Date', 'options' => array('format' => 'd-m-Y', 'locale' => 'py')),
                ),
            ),
            'doc_tipo' => array(
                'name'       => 'doc_tipo',
                'required'   => true,
                'filters'    => array(
                    array('name' => 'StringToUpper'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                    array('name' => 'Regex', 'options' => array('pattern' => "/^(F|T|R)$/", 'message' => 'El valor debe ser F (Factura), T (Traslado), R (Remision)')),
                )
            ),
            'condicion' => array(
                'name'       => 'condicion',
                'required'   => true,
                'filters'    => array(
                    array('name' => 'StringToUpper'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                    array('name' => 'Regex', 'options' => array('pattern' => "/^(C|D)$/", 'message' => 'El valor debe ser C (Contado) o D (Credito)')),
                )
            ),
            'estado' => array(
                'name'       => 'estado',
                'required'   => true,
                'filters'    => array(
                    array('name' => 'StringToUpper'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                    array('name' => 'Regex', 'options' => array('pattern' => "/^(P)$/", 'message' => 'El valor debe ser P (Pagado)')),
                )
            ),
            'fecha_vencimiento' => array(
                'name'       => 'fecha_vencimiento',
                'required'   => false,
                'filters'    => array(
                    array('name' => 'StripTags'),
                ),
                'validators' => array(
                    array('name' => 'Date', 'options' => array('format' => 'd-m-Y', 'locale' => 'py')),
                ),
            ),
        );
        
        $inputFilter = $inputFilterFactory->createInputFilter($spec);
        $inputFilter->setData($data);
        return $inputFilter;
    }
    
    /**
     * Los ingresos requieren moneda por defecto
     */
    public function __construct()
    {
        $this->detalle = new ArrayCollection();
        $this->requiere_moneda = true;
    }
    
    public function esMovimientoInterno()
    {
        $this->requiere_moneda = false;
    }
    
    public function getDetalle()
    {
        return $this->detalle;
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
    }
    
    public function setEstado($estado)
    {
        switch ($this->estado) {
        	case 'P':
        	    $this->estado = $estado;
        	    break;
        	case 'A':
        	    $errorMessage = 'El ingreso esta anulado. No se puede cambiar el estado.';
        	    Thrower::throwValidationException('Error de Validacion', $errorMessage);
        	    break;
        	default:
        	    $this->estado = $estado;
        	    break;
        }
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
        $inputFilter = $this->getInputFilter($data);
        if (!$inputFilter->isValid()) {
            Thrower::throwValidationException('Error de Validacion', $inputFilter->getMessages());
        }
        $data = $inputFilter->getValues();
        
        foreach ($data as $property => $value) {
            $this->$property = $value;
        }
    }
}