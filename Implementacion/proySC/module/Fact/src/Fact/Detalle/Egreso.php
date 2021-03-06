<?php

namespace Fact\Detalle;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory as InputFilterFactory;
use EnterpriseSolutions\Exceptions\Thrower;

/**
 * Detalle del Egreso
 * @author guido
 * 
 * @ORM\Entity
 * @ORM\Table(name="fact_egreso_detalle")
 */
class Egreso
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $fact_egreso_detalle_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $fact_egreso_id;
    
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
    protected $precio_unit;
    
    /**
     * @ORM\Column(type="float")
     */
    protected $porc_impuesto;
    
    /**
     * @ORM\ManyToOne(targetEntity="Fact\Egreso\Egreso", inversedBy="detalle")
     * @ORM\JoinColumn(name="fact_egreso_id", referencedColumnName="fact_egreso_id")
     */
    protected $egreso;
    
    /**
     * Valores por defecto
     * @var array
     */
    protected $defaultValues = array(
    	'cantidad' => 1,
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
            'stock_articulo_id' => array(
                'name'     => 'stock_articulo_id',
                'required' => true,
            ),
            'cantidad' => array(
                'name'       => 'cantidad',
                'required'   => false,
                'filters'    => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'Digits'),
                    array('name' => 'GreaterThan', 'options' => array('min' => 0)),
                ),
            ),
            'precio_unit' => array(
                'name'       => 'precio_unit',
                'required'   => true,
                'filters'    => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                    array('name' => 'GreaterThan', 'options' => array('min' => 0)),
                ),
            ),
            'porc_impuesto' => array(
                'name'       => 'porc_impuesto',
                'required'   => true,
                'filters'    => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                    array('name' => 'InArray', 'options' => array('haystack' => array('10', '5', '0'), 'message' => 'El valor debe ser 10, 5 o 0')),
                )
            ),
        );
    
        $inputFilter = $inputFilterFactory->createInputFilter($spec);
        $inputFilter->setData($data);
        return $inputFilter;
    }
    
    public function setEgreso($egreso)
    {
        $this->egreso = $egreso;
    }
    
    public function fromArray($data)
    {
        $inputFilter = $this->getInputFilter($data);
        if (!$inputFilter->isValid()) {
            Thrower::throwValidationException(null, $inputFilter->getInvalidInput());
        }
        $data = $inputFilter->getValues();
        
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
    
    public function getId()
    {
        return $this->fact_egreso_detalle_id;
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
     * Subtotal del detalle (cantidad * precio_unit)
     * @return number
     */
    public function getSubTotal($medio_de_pago)
    {
        switch ($medio_de_pago) {
            case 'E':
                return $this->cantidad * $this->precio_unit;
                break;
            case 'D':
                $interes = 1.04;
                return $this->cantidad * ($this->precio_unit * $interes);
                break;
            case 'C':
                $interes = 1.08;
                return $this->cantidad * ($this->precio_unit * $interes);
                break;
            default:
                return $this->cantidad * $this->precio_unit;
        }
        
        return $this->cantidad * $this->precio_unit;
    }
}