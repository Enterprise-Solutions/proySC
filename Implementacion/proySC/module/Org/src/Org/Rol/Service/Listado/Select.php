<?php

namespace Org\Rol\Service\Listado;
use Zend\Db\Sql\Expression;

use EnterpriseSolutions\Db\Select as DbSelect;
use Zend\Db\Sql\Select as ZFSelect;
class Select extends DbSelect
{
	public function _init()
	{
		$this->_select
			 ->from(array('orp' => 'org_parte_rol'))
			 ->columns(array(
			 	'org_parte_rol_id',
			 	'documentos' => new Expression("string_agg('org_documento_id:'||od.org_documento_id::text||','||'valor:'||od.valor||','||'org_documento_tipo_codigo:'||od.org_documento_tipo_codigo,';')")
			 ))
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
			 ->join(array('opt' => 'org_parte_tipo'),'op.org_parte_tipo_codigo = opt.org_parte_tipo_codigo',array('org_parte_tipo_nombre' => 'nombre'))
			 ->join(array('od'  => 'org_documento'),'op.org_parte_id = od.org_parte_id',array(),ZFSelect::JOIN_LEFT)
			 ->join(array('odt' => 'org_documento_tipo'),'od.org_documento_tipo_codigo = odt.org_documento_tipo_codigo',array(),ZFSelect::JOIN_LEFT)
			 //->join(array('odt' => 'org_documento_tipo'),'od.org_documento_tipo = odt.org_documento_tipo',array())
			 ->group(array(
			 	'org_parte_rol_id',
			 	'org_rol_nombre',
			 	'op.org_parte_id',
			 	'op.org_parte_tipo_codigo',
			 	'op.nombre_organizacion',
			 	'op.nombre_persona','op.apellido_persona','op.fecha_nacimiento','op.genero_persona','opt.nombre'));	 
	}
	
	public function addSearchByOrgParteRolId($orgParteRolId)
	{
		$this->_select->where("orp.org_parte_rol_id = $orgParteRolId");
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
			 ->where(" ( ('('||op.nombre_persona || '|' || op.apellido_persona||')') ~* '$nombre' or op.nombre_organizacion ~* '$nombre' ) or od.valor ~* '$nombre'");
	}
	
	public function addSearchByEstado($estado)
	{
		$this->_select
			 ->where(" orp.estado = '$estado'");
	}
}