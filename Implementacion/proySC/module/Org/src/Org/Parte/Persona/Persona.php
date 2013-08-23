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
	 * @Orm\Column(name="org_religion_id")
	 */
	public $org_religion_id;
	
	/**
	 * @Orm\Column(name="org_estado_civil_id")
	 */
	public $org_estado_civil_id;
	
	/**
	 * @Orm\Column(name="nacionalidad_persona")
	 */
	public $nacionalidad_persona;
	
	
	/**
	 * @Orm\Column(name="nro_hijos")
	 */
	public $nro_hijos;
	
	public function crear($datos)
	{
		parent::crear($this->_agregarNacionalidad($datos));
	}
	
	public function editar($datos)
	{
		parent::editar($this->_agregarNacionalidad($datos));
	}
	
	/**
	 * @param array $datos
	 * @return array
	 */
	public function _agregarNacionalidad($datos)
	{
		if(isset($datos['dir_pais_id'])){
			$nacionalidad = $this->_repository->findNacionalidadDeDirPaisId($datos['dir_pais_id']);
			$datos['nacionalidad_persona'] = $nacionalidad;
		}
		return $datos;	
	}
	
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
								"pattern" => "/^(F|M)$/",
								"message" => "El valor debe ser F o M"
							)
						)
					)
				),
				'org_religion_id' => array(
					'name' => 'org_religion_id',
					'required' => false,
					'filters' => array(
							array(
									'name' => 'StripTags'
							)
					)
				),
				'org_estado_civil_id' => array(
							'name' => 'org_estado_civil_id',
							'required' => false,
							'filters' => array(
									array(
											'name' => 'StripTags'
									)
							)
				),
				'nacionalidad_persona' => array(
							'name' => 'nacionalidad_persona',
							'required' => false,
							'filters' => array(
									array(
											'name' => 'StripTags'
									)
							)
					),
				'nro_hijos' => array(
						'name' => 'nro_hijos',
						'required' => false,
						'filters' => array(
								array(
									'name' => 'Digits'	
								)
						),
						'validators' => array(
							array(
								'name' => 'Digits',
								'options' => array('message' => 'Nro de hijos debe ser un valor numerico!')	
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
								"pattern" => "/^(F|M)$/",
								"message" => "El valor debe ser F o M"
							)
						)
					)
				),
				'org_religion_id' => array(
							'name' => 'org_religion_id',
							'required' => false,
							'filters' => array(
									array(
											'name' => 'StripTags'
									)
							)
				),
				'org_estado_civil_id' => array(
							'name' => 'org_estado_civil_id',
							'required' => false,
							'filters' => array(
									array(
											'name' => 'StripTags'
									)
							)
				),
				'nacionalidad_persona' => array(
							'name' => 'nacionalidad_persona',
							'required' => false,
							'filters' => array(
									array(
											'name' => 'StripTags'
									)
							)
				),
				'nro_hijos' => array(
							'name' => 'nro_hijos',
							'required' => false,
							'filters' => array(
									array(
											'name' => 'StripTags'
									)
							),
							'validators' => array(
									array(
											'name' => 'Digits',
											'options' => array('message' => 'Nro de hijos debe ser un valor numerico!')
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