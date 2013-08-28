<?php

namespace Adm\Usuario\Repository;

use EnterpriseSolutions\Db\Select;
use Zend\Db\Sql\Select as ZFSelect;
use Zend\Db\Sql\Expression;

class FindDatosDePersonaParaCrearUsuario extends Select
{
	public function _init()
	{
		$this->_select
			 ->from(array('op' => 'org_parte'))
			 ->join(array('od' => 'org_documento'),new Expression('op.org_parte_id = od.org_parte_id and (od.preferencia = 1)'),array('org_documento_id_principal' => 'org_documento_id'),ZFSelect::JOIN_LEFT)
			 ->join(array('odu' => 'org_documento'),'op.org_parte_id = odu.org_parte_id',array('org_documento_id_usuario' => 'org_documento_id'),ZFSelect::JOIN_LEFT)
			 ->join(array('au' => 'adm_usuario'),'odu.org_documento_id = au.org_documento_id',array('adm_usuario_id'),ZFSelect::JOIN_LEFT);
	}
	
	public function addSearchByOrgParteId($orgParteId)
	{
		$this->_select->where("op.org_parte_id = $orgParteId");
	}
}