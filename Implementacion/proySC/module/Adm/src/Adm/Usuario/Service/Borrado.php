<?php
namespace Adm\Usuario\Service;
use Adm\Usuario\Repository;
class Borrado
{
	public $_repository;
	public function __construct(Repository $repository)
	{
		$this->_repository = $repository;
	}
	
	public function ejecutar($params)
	{
		$rs = $this->_repository->findAdmUsuarios($params);
		$self = $this;
		$borrados = array_map(
			function($datosAdmUsuario) use($self){
				return $self->borrarAdmUsuario($datosAdmUsuario);
			}, 
			$rs
		);
		return $this->_construirRespuesta($rs);	
	}
	
	public function borrarAdmUsuario($rowAdmUsuario)
	{
		$admUsuario = array_intersect_key(
			$rowAdmUsuario,
			array_flip(array('adm_usuario_id','estado','contrasenha','fecha_modif_contrasenha','org_documento_id'))
		);
		return $this->_repository->borrar($admUsuario, 'adm_usuario', 'adm_usuario_id');
	}
	
	public function _construirRespuesta($rs)
	{
		$idsBorrados = array();
		$idsBorrados = array_reduce(
			$rs, 
			function($idsBorrados,$row){
				$idsBorrados[] = $row['adm_usuario_id'];
				return $idsBorrados;
			},
			$idsBorrados
		);
		return array(
				'status'  => true,
				'mensaje' => 'Borrado de usuario/s exitoso',
				'datos'   => array(
					'borrados' => $idsBorrados
				)
		);
	}
}