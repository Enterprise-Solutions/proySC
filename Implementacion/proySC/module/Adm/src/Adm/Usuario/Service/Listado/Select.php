<?php
namespace Adm\Usuario\Service\Listado;
use Zend\Db\Sql\Expression;

use EnterpriseSolutions\Db\Select as EsSelect;

class Select extends EsSelect
{
	public function _init()
	{
		$this->_select
			 ->from(array('au' => 'adm_usuario'))
			 ->columns(array(
			 	'adm_usuario_id',
			 	'documento_identidad' => new Expression(" od.valor||' ('||odt.nombre||' - '||dp.nombre||')' "),	
			 	'estado_usuario' => new Expression(" case when estado = 'A' then 'Activo' else 'Bloqueado' end"),
			 	'estado',	
			 	'roles' => new Expression("''")
			 ))
			 ->join(array('od' => 'org_documento'),'au.org_documento_id = od.org_documento_id',array())
			 ->join(array('op' => 'org_parte'),'od.org_parte_id = op.org_parte_id',array('nombre' => 'nombre_persona','apellido' => 'apellido_persona'))
			 ->join(array('dp' => 'dir_pais'),'od.dir_pais_id = dp.dir_pais_id',array())
			 ->join(array('odt' => 'org_documento_tipo'),'od.org_documento_tipo_codigo = odt.org_documento_tipo_codigo',array());		
	}
	
	public function addSearchByEstado($estado)
	{
		$this->_select->where("au.estado = '$estado");
	}
	
	public function addSearchByNombre($nombre)
	{
		$this->_select->where("(op.nombre_persona ~* '$nombre') or (op.apellido_persona ~* '$nombre') or (od.valor ~* '$nombre')");
	}
}