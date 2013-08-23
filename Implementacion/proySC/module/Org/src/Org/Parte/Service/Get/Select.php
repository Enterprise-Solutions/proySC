<?php

namespace Org\Parte\Service\Get;
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
			 	'nombre_persona','apellido_persona','fecha_nacimiento','genero_persona','nro_hijos',
			 	'org_religion_id','org_estado_civil_id','nacionalidad_persona',
			 	'documentos' => new Expression(" string_agg(distinct 'org_documento_id:'||od.org_documento_id||','||'valor:'||od.valor||','||'org_documento_tipo_codigo:'||od.org_documento_tipo_codigo||',dir_pais_id:'||od.dir_pais_id||',preferencia:'||od.preferencia||',dir_pais:'||ddp.nombre||',org_documento_tipo:'||odt.nombre,';')"),
			 	'contactos'  => new Expression(" string_agg(distinct 'org_contacto_id:'||oc.org_contacto_id||',contacto:'||oc.contacto||',org_contacto_tipo_codigo:'||oct.org_contacto_tipo_codigo||',org_contacto_tipo:'||oct.nombre,';')"),
			 	'Direcciones' => new Expression("string_agg(distinct 'dir_direccion_id:'||dd.dir_direccion_id||',direccion:'||dd.calle||',dir_barrio_id:'||dd.dir_barrio_id||',dir_barrio:'||db.nombre,';')")	
			 		//'contactos'  => new Expression("string_agg('org_contacto_id:'||oc.org_contacto_id,';')")
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
			 ->join(
			 	array('ddp' => 'dir_pais'),
			 	'od.dir_pais_id = ddp.dir_pais_id',
			 	array(),
			 	ZFSelect::JOIN_LEFT	
			 )
			 ->join(
			 	array('oc' => 'org_contacto'),
			 	'op.org_parte_id = oc.org_parte_id',
			 	array(),
			 	ZFSelect::JOIN_LEFT
			 )
			 ->join(
			 	array('oct' => 'org_contacto_tipo'),
			 	'oc.org_contacto_tipo_codigo = oct.org_contacto_tipo_codigo',
			 	array(),
			 	ZFSelect::JOIN_LEFT
			 )
			 ->join(
			 	array('dd' => 'dir_direccion'),
			 	'op.org_parte_id = dd.org_parte_id',
			 	array(),
			 	ZFSelect::JOIN_LEFT	
			 )
			 ->join(
			 	array('ddt' => 'dir_direccion_tipo'),
			 	'dd.dir_direccion_tipo_id = ddt.dir_direccion_tipo_id',
			 	array(),
			 	ZFSelect::JOIN_LEFT	
			 )
			 ->join(
			 	array('db' => 'dir_barrio'),
			 	'dd.dir_barrio_id = db.dir_barrio_id',
			 	array(),
			 	ZFSelect::JOIN_LEFT	
			 )
			 ->join(
			 	array('re' => 'org_religion'),
			 	'op.org_religion_id = re.org_religion_id',
			 	array('religion' => 'nombre'),
			 	ZFSelect::JOIN_LEFT		
			 )
			 ->join(
			 		array('ec' => 'org_estado_civil'), 
			 		'op.org_estado_civil_id = ec.org_estado_civil_id',
			 		array('estado_civil' => 'nombre'),
			 		ZFSelect::JOIN_LEFT)
			 /*->join(
			 	array('dp' => 'dir_pais'),
			 	'op.nacionalidad_persona = dp.dir_pais_id',
			 	array('nacionalidad'),
			 	ZFSelect::JOIN_LEFT	
			 )*/
			 ->group(array(
			 	'op.org_parte_id',
			 	'op.org_parte_tipo_codigo',
			 	'op.nombre_organizacion',
			 	'op.nombre_persona','op.apellido_persona','op.fecha_nacimiento','op.genero_persona','opt.nombre',
			 	'op.org_religion_id','op.org_estado_civil_id','op.nacionalidad_persona','re.nombre','ec.nombre','op.nro_hijos'
			 	));
			
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