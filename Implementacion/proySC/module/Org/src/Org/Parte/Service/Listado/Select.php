<?php

namespace Org\Parte\Service\Listado;
use Zend\Db\Sql\Expression;

use EnterpriseSolutions\Db\Select as DbSelect;
use Zend\Db\Sql\Select as ZFSelect;
class Select extends DbSelect
{
	public function _init()
	{
		$this->_select
			 ->from(array('op' => 'org_parte'))
			 ->columns(array('org_parte_id',
			 	'org_parte_tipo_codigo',
			 	'nombre_organizacion',
			 	'nombre_persona','apellido_persona','fecha_nacimiento','genero_persona',
			 	'documentos' => new Expression("string_agg(odt.nombre||': '||od.valor,',')")
			 	))
			 ->join(
			 	array('opt' => 'org_parte_tipo'),
			 	'op.org_parte_tipo_codigo = opt.org_parte_tipo_codigo',
			 	array('org_parte_tipo_nombre' => 'nombre'))
			 ->join(
			 	array('od' => 'org_documento'),
			 	"op.org_parte_id = od.org_parte_id",
			 	array(),
			 	//array('documento' => 'valor'),
			 	ZFSelect::JOIN_LEFT
			 )
			 ->join(
			 	array('odt' => 'org_documento_tipo'),
			 	'od.org_documento_tipo_codigo = odt.org_documento_tipo_codigo',
			 	array(),
			 	//array('tipo_documento' => 'nombre'),
			 	ZFSelect::JOIN_LEFT
			 )
			 ->group(array(
			 	'op.org_parte_id',
			 	'op.org_parte_tipo_codigo',
			 	'op.nombre_organizacion',
			 	'op.nombre_persona','op.apellido_persona','op.fecha_nacimiento','op.genero_persona','opt.nombre'));
			
	}
	
	public function addSearchById($id)
	{
		return $this->addSearchByOrgParteId($id);
	}
	
	public function addSearchByOrgParteTipoCodigo($orgParteTipoCodigo)
	{
		$this->_select->where("op.org_parte_tipo_codigo = '$orgParteTipoCodigo'");
	}
	
	public function addSearchByOrgParteId($orgParteId)
	{
		$this->_select
			 ->where("op.org_parte_id = $orgParteId");
	}
	
	public function addSearchByNombre($nombre)
	{
		$this->_select
			->where(" ( ('('||op.nombre_persona || '|' || op.apellido_persona||')') ~* '$nombre' or op.nombre_organizacion ~* '$nombre') or od.valor ~* '$nombre'");
	}
}