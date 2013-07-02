<?php

namespace Org\Rol\Service\Listado;
use Zend\Db\Sql\Expression;

use EnterpriseSolutions\Db\Select as DbSelect;
class Select extends DbSelect
{
	public function _init()
	{
		$this->_select
			 ->from(array('orp' => 'org_parte_rol'))
			 ->columns(array('org_parte_rol_id'))
			 ->join(array('rol'  => 'org_rol'),'orp.org_rol_codigo = rol.org_rol_codigo',array('org_rol_nombre' => 'nombre'))
			 ->join(
			 		array('op'  => 'org_parte'),
			 		'orp.org_parte_id = op.org_parte_id',
			 		array(
			 			'org_parte_id',
			 			'nombre' => new Expression("case when op.org_parte_tipo_codigo = 'per' then op.nombre_persona else op.nombre_organizacion end"),
			 			'apellido' => 'apellido_persona',
			 			'fechaDeNacimiento' => 'fecha_nacimiento',
			 			'genero' => 'genero_persona'
			 		)
			 )
			 ->join(array('opt' => 'org_parte_tipo'),'op.org_parte_tipo_codigo = opt.org_parte_tipo_codigo',array('org_parte_tipo_nombre' => 'nombre'));	 
	}
	
	public function addSearchByOrgParteTipoCodigo($codigo)
	{
		$this->_select->where("op.org_parte_tipo_codigo = '$codigo'");
	}
	
	public function addSearchByOrgRolCodigo($codigo)
	{
		$this->_select->where("orp.org_rol_codigo = '$codigo'");
	}
	
	public function addSearchByNombre($nombre)
	{
		$this->_select
			 ->where(" ('('||op.nombre_persona || '|' || op.apellido_persona||')') ~* '$nombre' or op.nombre_organizacion ~* '$nombre'");
	}
}