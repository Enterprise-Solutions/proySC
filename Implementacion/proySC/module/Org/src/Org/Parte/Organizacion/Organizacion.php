<?php

namespace Org\Parte\Organizacion;

use Org\Parte\Parte;
use Doctrine\ORM\Mapping as Orm;
use Zend\Form\Annotation as Zf;
use Zend\InputFilter\Factory as IfFactory;

/**
 * @author pislas
 * @Orm\Entity
 */
class Organizacion extends Parte
{
	protected $codigo = 'org';
		
	/**
	 * @Orm\Column(name="nombre_organizacion")
	 * @Zf\Required({"required":"true"})
	 * @Zf\Filter({"name":"StripTags"})
	 * @Zf\Options({"label": "Nombre"})
	 */
	public $nombre; 
	
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
					)
						
			);
		}
		$if =  $ifFactory->createInputFilter($spec);
		$if->setData($datos);
		return $if;
	}
}