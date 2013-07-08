<?php

namespace Org\Documento\Service\Listado;
use Zend\Db\Sql\Expression;

use EnterpriseSolutions\Db\Select as DbSelect;


class Select extends DbSelect
{
	public function _init()
	{
		$this->_select
			 ->from(array('od' => 'org_documento'))
			 ->columns(array('org_documento_id','valor'))
			 ->join(
			 	array('odt' => 'org_documento_tipo'), 
			 	'od.org_documento_tipo_codigo = odt.org_documento_tipo_codigo',
			 	array('tipo' => 'nombre')
			 )
			 ->join(
			 	array('op' => 'org_parte'),
			 	'od.org_parte_id = op.org_parte_id',
			 	array('parte' => new Expression(" 
			 			case when op.org_parte_tipo_codigo = 'per' 
			 			then op.nombre_persona||' '||op.apellido_persona
			 			else op.nombre_organizacion end 
			 		")
			 	)
			 );
	}
	
	public function addSearchByOrgDocumentoId($orgDocumentoId)
	{
		$this->_select
			 ->where("od.org_documento_id = $orgDocumentoId");
	}
	
	public function addSearchByOrgParteId($orgParteId)
	{
		$this->_select
			 ->where("odt.org_parte_id = $orgParteId");
	}
	
	public function addSearchByValor($valor)
	{
		$this->_select
			 ->where("od.valor ~* '$valor'");
	}
	
	public function addSearchByParte($parte)
	{
		$this->_select
			 ->where(" ('('||op.nombre_persona || '|' || op.apellido_persona||')') ~* '$parte' or op.nombre_organizacion ~* '$parte'");
	}
}