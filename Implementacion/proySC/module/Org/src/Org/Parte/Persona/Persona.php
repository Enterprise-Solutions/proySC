<?php

namespace Org\Parte\Persona;

use Org\Parte\ParteTipo;

use Org\Parte\Parte;
use Doctrine\ORM\Mapping as Orm;
use Zend\Form\Annotation as Zf;
use Zend\InputFilter\Factory as IfFactory;

/**
 * @author pislas
 * @Orm\Entity
 */
class Persona extends Parte
{	
	protected $codigo = 'per';
	
	/**
	 * @Orm\Column(name="nombre_persona")
	 */
	public $nombre;
	
	/**
	 * @Orm\Column(name="apellido_persona")
	 */
	public $apellido;
	
	/**
	 * @Orm\Column(name="fecha_nacimiento")
	 */
	public $fechaDeNacimiento;
	
	/**
	 * @Orm\Column(name="genero_persona")
	 */
	public $genero;
	
	/**
	 * @param string $operacion
	 * @return InputFilter
	 */
	public function _getInputFilter($operacion,$datos)
	{
		$ifFactory = new IfFactory();
		if($operacion == 'creacion'){
			$spec = array(
				'nombre' => array(
					'name' => 'nombre',
					'required' => true,
					'filters'  => array(
						array(
							'name' => 'StripTags'
						)		
					)
				),
				'apellido' => array(
					'name' => 'apellido',
					'required' => true,
					'filters'  => array(
						array(
							'name' => 'StripTags'
						)		
					)
				),
				'fechaDeNacimiento' => array(
					'name' => 'fechaDeNacimiento',
					'required' => false,
					'filters'  => array(
						array(
							'name' => 'StripTags'
						)
					),
					'validators' => array(
						array(
							'name' => 'Date',
							'options' => array(
								"format" => "d-m-Y","locale"=>"py","message" => "La fecha debe tener el formato: 'd-m-Y'"
							)
						)
					)		
				),
				'genero' => array(
					'name' => 'genero',
					'required' => true,
					'filters'  => array(
							array(
								'name' => 'StripTags'
							)
					),
					'validators' => array(
						array(
							"name" => "Regex",
							'options' => array(
								"pattern" => "/^(H|M)$/",
								"message" => "El valor debe ser H o M"
							)
						)
					)
				)
					
			);
		}else {
			$spec = array(
				'nombre' => array(
					'name' => 'nombre',
					'required' => false,
					'filters'  => array(
						array(
							'name' => 'StripTags'
						)		
					)
				),
				'apellido' => array(
					'name' => 'apellido',
					'required' => false,
					'filters'  => array(
						array(
							'name' => 'StripTags'
						)		
					)
				),
				'fechaDeNacimiento' => array(
					'name' => 'fechaDeNacimiento',
					'required' => false,
					'filters'  => array(
						array(
							'name' => 'StripTags'
						)
					),
					'validators' => array(
						array(
							'name' => 'Date',
							'options' => array(
								"format" => "d-m-Y","locale"=>"py","message" => "La fecha debe tener el formato: 'd-m-Y'"
							)
						)
					)		
				),
				'genero' => array(
					'name' => 'genero',
					'required' => false,
					'filters'  => array(
							array(
								'name' => 'StripTags'
							)
					),
					'validators' => array(
						array(
							"name" => "Regex",
							'options' => array(
								"pattern" => "/^(H|M)$/",
								"message" => "El valor debe ser H o M"
							)
						)
					)
				)
					
			);
		}
		$if =  $ifFactory->createInputFilter($spec);
		$if->setData($datos);
		return $if;
	}
}