<?php

namespace Org\Parte\Persona;

use Org\Parte\ParteTipo;

use Org\Parte\Parte;
use Doctrine\ORM\Mapping as Orm;
use Zend\Form\Annotation as Zf;

/**
 * @author pislas
 * @Zf\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Orm\Entity
 */
class Persona extends Parte
{	
	protected $codigo = 'per';
	
	/**
	 * @Orm\Column(name="nombre_persona")
	 * @Zf\Required({"required":"true"})
	 * @Zf\Filter({"name":"StripTags"})
	 * @Zf\Options({"label": "Nombre"})
	 */
	public $nombre;
	
	/**
	 * @Orm\Column(name="apellido_persona")
	 * @Zf\Required({"required":"true"})
	 * @Zf\Filter({"name":"StripTags"})
	 * @Zf\Options({"label": "Apellido"})
	 */
	public $apellido;
	
	/**
	 * @Orm\Column(name="fecha_nacimiento")
	 * @Zf\Required({"required":"true"})
	 * @Zf\Filter({"name":"StripTags"})
	 * @Zf\Validator({"name":"Date","options":{"format" : "d-m-Y","locale":"py","message": "La fecha debe tener el formato: 'd-m-Y'"}})
	 * @Zf\Options({"label": "Fecha de Nacimiento"})
	 */
	public $fechaDeNacimiento;
	
	/**
	 * @Orm\Column(name="genero_persona")
	 * @Zf\Required({"required":"true"})
	 * @Zf\Filter({"name":"StripTags"})
	 * @Zf\Validator({"name":"Regex","options":{"pattern":"/^(H|M)$/","message":"El valor debe ser H o M"}})
	 * @Zf\Options({"label": "Genero"})
	 */
	public $genero;
}