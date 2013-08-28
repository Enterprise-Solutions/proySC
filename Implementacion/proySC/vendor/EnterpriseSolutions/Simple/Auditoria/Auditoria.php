<?php
class Framework_Simple_Auditoria_Auditoria
{
    /**
     * @var Framework_Simple_Auditoria_Repository
     */
    public $_repository;
    public $_cambios;
    
    public $_datos;
    public function __construct($repository)
    {
        $this->_repository = $repository;
        $this->_cambios = new Framework_Simple_Cambios_Cambios();        
    }
    
    public function auditar($codigoDeOperacion,$cambios)
    {
        $cambiosAdmAuditoria = $this->_cambios->cambiar(array(),array(
            array('adm_operacion_id' => $this->_repository->findAdmOperacionId($codigoDeOperacion)),
            array('creado_por_id'    => $this->_repository->findAdmUsuarioId()),
            array('creado_fecha'     => $this->_getFechaHora()),
            array('maquina_nombre'    => $this->_getMaquinaNombre()),
            array('maquina_ip'       => $this->_getIpDeCliente()),
            array('browser'          => $this->_getNavegadorDeCliente())
        ));
        $cambiosAdmAuditoria = $this->_repository
                                    ->persistirCambiosADatos($cambiosAdmAuditoria, array(), 'adm_auditoria', 'adm_auditoria_id');
        //$admAuditoriaId = $this->_getValorNuevo($cambiosAdmAuditoria, 'adm_auditoria_id');
        $admAuditoriaId = $this->_cambios->getValorNuevo($cambiosAdmAuditoria, 'adm_auditoria_id');
        foreach($cambios as $fnAuditarCambiosEnTabla){
            $fnAuditarCambiosEnTabla($admAuditoriaId);
        } 
    }
    
    public function _getIpDeCliente()
    {
    	if(isset($_SERVER['REMOTE_ADDR'])){
    		return $_SERVER['REMOTE_ADDR'];
    	}
    	return "";
    }
    
    public function _getNavegadorDeCliente()
    {
    	return isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'';
    }
    
    public function _getFechaHora()
    {
    	return date('d/m/Y g:ia');
    }
    
    public function _getMaquinaNombre()
    {
    	if(isset($_SERVER['REMOTE_HOST'])){
    		return $_SERVER['REMOTE_HOST'];
    	}
    	return "";
    }
    
    public function _getValorNuevo($cambios,$key)
    {
        foreach($cambios as $cambio){
            if($cambio['key'] == $key){
                return $cambio['valorNuevo'];
            }
        }
        return false;
    }
}