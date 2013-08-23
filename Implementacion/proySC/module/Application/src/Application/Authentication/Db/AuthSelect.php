<?php
namespace Application\Authentication\Db;

use Zend\Db\Sql\Expression;

use EnterpriseSolutions\Db\Select;
class AuthSelect extends Select
{
	/*public function _init()
	{
		$this->_select->from(array('pp'=> 'per_persona'))
		     ->columns(array('nombre_generico','per_persona_id'))
		     ->join(array('ppd' => 'per_persona_doc'), 'pp.per_persona_id = ppd.per_persona_id',array('doc_nro','per_doc_origen_id'))
		     ->join(array('au' => 'adm_usuario'), 'pp.per_persona_id = au.per_persona_id',array('contrasena','activo','bloqueado','adm_usuario_id'))
		     ->join(array('aa' => 'al_alumno'),'pp.per_persona_id = aa.per_persona_id',array())
		     ->group(array('pp.per_persona_id','pp.nombre_generico','ppd.per_persona_doc_id','au.adm_usuario_id','ppd.doc_nro','ppd.per_doc_origen_id','au.contrasena','au.activo','au.bloqueado'))
		     ->where("ppd.es_principal = 'S'")
		     
		     ->limit(10);
		
	}
	
	public function addSearchByDocNro($docNro)
	{
		$this->_select->where("ppd.doc_nro = '$docNro'");
		return $this;
	}
	
	public function addSearchByDirPaisId($dirPaisId)
	{
		$this->_select->where("ppd.per_doc_origen_id = $dirPaisId");
		return $this;
	}
	
	public function addSearchByPerDocTipoId($perDocTipoId)
	{
		$this->_select->where("ppd.per_doc_tipo_id = $perDocTipoId");
		return $this;
	}*/
	
	public function _init()
	{
		$this->_select
			 ->from(array('au' => 'adm_usuario'))
			 ->join(array('od' => 'org_documento'),'au.org_documento_id = od.org_documento_id',array('valor','org_documento_id','dir_pais_id'))
			 ->join(array('op' => 'org_parte'),'od.org_parte_id = op.org_parte_id',array('org_parte_id','sobrenombre','nombre_persona','apellido_persona'));		
	}
	
	public function addSearchByValor($valor)
	{
		$this->_select->where("od.valor = '$valor'");
		return $this;
	}
	
	public function addSearchByOrgDocumentoTipoCodigo($orgDocumentoTipoCodigo)
	{
		$this->_select->where("od.org_documento_tipo_codigo = '$orgDocumentoTipoCodigo'");
		return $this;
	}
	
	public function addSearchByDirPaisId($dirPaisId)
	{
		$this->_select->where("od.dir_pais_id = $dirPaisId");
		return $this;
	}
}