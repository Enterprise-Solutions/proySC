<?php

namespace Org\Parte\Persona;

use Org\Parte\ParteTipo;

use Org\Parte\Parte;
use Doctrine\ORM\Mapping as Orm;
use Zend\Form\Annotation as Zf;

/**
 * @author pislas
 * @Zf\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Orm\Entity @Orm\Table(name="org_parte")
 */
class Persona extends Parte
{
	protected $_codigoDeTipo = 'per';
	
	/**
	 * @Orm\OneToOne(targetEntity="Org\Parte\ParteTipo")
	 * @Orm\JoinColumn(name="org_parte_tipo_id",referencedColumnName="org_parte_tipo_id")
	 */
	protected $_tipo;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="org_parte_id")
	 * @Zf\Exclude()
	 */
	protected $id;
	
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
	 * @Zf\Validator({"name":"Date"})
	 * @Zf\Options({"label": "Fecha de Nacimiento"})
	 */
	public $fechaDeNacimiento;
	
	/**
	 * @Orm\Column(name="genero_persona")
	 * @Zf\Required({"required":"true"})
	 * @Zf\Filter({"name":"StripTags"})
	 * @Zf\Validator({"name":"Regex","options":{"pattern":"/^(H|M)$/"}})
	 * @Zf\Options({"label": "Genero"})
	 */
	public $genero;
}