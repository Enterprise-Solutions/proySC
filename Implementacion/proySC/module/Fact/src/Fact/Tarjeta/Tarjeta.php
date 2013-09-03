<?php

namespace Fact\Tarjeta;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory as InputFilterFactory;
use EnterpriseSolutions\Exceptions\Thrower;

/**
 * @ORM\Entity
 * @ORM\Table(name="fact_tarjeta")
 */
class Tarjeta
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $fact_tarjeta_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $fact_tarjeta_tipo_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $fact_tarjeta_nombre_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $fact_entidad_financiera_id;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=120)
     */
    protected $nombre_titular;
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Column(length=80)
     */
    protected $codigo_seguridad;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $fecha_vencimiento;
    
    /**
     * Input Filter
     * @param array $data
     * @return Ambigous <\Zend\InputFilter\InputFilterInterface, \Zend\InputFilter\CollectionInputFilter, unknown, object>
     */
    protected function getInputFilter($data)
    {
        $inputFilterFactory = new InputFilterFactory();
        $spec = array(
            'fact_tarjeta_tipo_id' => array(
                'name'     => 'fact_tarjeta_tipo_id',
                'required' => true,
            ),
            'fact_tarjeta_nombre_id' => array(
                'name'     => 'fact_tarjeta_nombre_id',
                'required' => true,
            ),
            'fact_entidad_financiera_id' => array(
                'name'     => 'fact_entidad_financiera_id',
                'required' => true,
            ),
            'nombre_titular' => array(
                'name'       => 'nombre_titular',
                'required'   => false,
                'filters'    => array(
                    array('name' => 'StripTags'),
                ),
                'validators' => array(
                    array('name' => 'StringLength', 'options' => array('max' => 120)),
                ),
            ),
            'codigo_seguridad' => array(
                'name'       => 'codigo_seguridad',
                'required'   => false,
                'filters'    => array(
                    array('name' => 'StripTags'),
                ),
                'validators' => array(
                    array('name' => 'StringLength', 'options' => array('max' => 80)),
                ),
            ),
            'fecha_vencimiento' => array(
                'name'       => 'fecha_vencimiento',
                'required'   => false,
                'validators' => array(
                    array('name' => 'Date', 'options' => array('format' => 'd-m-Y', 'locale' => 'py')),
                ),
            ),
        );
        
        $inputFilter = $inputFilterFactory->createInputFilter($spec);
        $inputFilter->setData($data);
        return $inputFilter;
    }
    
    public function getId()
    {
        return $this->fact_tarjeta_id;
    }
    
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