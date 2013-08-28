<?php
class Framework_Simple_Auditoria_Repository_DataSourceAuditable extends Framework_Simple_Repository_DataSource
{
    public $_auditoria;
    public $_cambios;
    public $_cambiosAuditados;
    public function __construct()
    {
    	$this->_cambios = new Framework_Simple_Cambios_Cambios();
    	$this->_cambiosAuditados = array();
    }
    
    public function insertar($tabla,$pkName,$datos,$conn)
    {
    	$cambios = parent::insertar($tabla, $pkName, $datos, $conn);
    	$pkValorCampo = $this->_cambios->getValorNuevo($cambios, $pkName);
    	$this->_cambiosAuditados[] = $this->fnAuditarCambiosEnTabla($cambios, $tabla, $pkName, $pkValorCampo);
    	return $cambios;
    }
    
    public function update($tabla,$pkName,$datos,$cambios,$conn,$where = null)
    {
    	$cambios = parent::update($tabla, $pkName, $datos, $cambios, $conn);
    	//$pkValorCampo = $this->_cambios->getValorNuevo($cambios, $pkName);
    	$pkValorCampo = $datos[$pkName];
    	$this->_cambiosAuditados[] = $this->fnAuditarCambiosEnTabla($cambios, $tabla, $pkName, $pkValorCampo);
    	return $cambios;
    }
    
    public function auditarCambioEnCampo($cambio,$admAudTablaId)
    {
    	$datosAdmAudCampo = array();
    	$campo = $cambio['key'];
    	$valor_viejo = $cambio['valorViejo'] != null? $cambio['valorViejo']:'';
    	$valor_nuevo = $cambio['valorNuevo'] != null? $cambio['valorNuevo']:'';
    	$tipo_dato   = '__';
    	$cambiosAdmAudCampo = $this->_cambios->cambiar(array(),array(
    			array('adm_aud_tabla_id' => $admAudTablaId),
    			array('campo' => $campo),
    			array('tipo_dato' => $tipo_dato),
    			array('valor_viejo' => $valor_viejo),
    			array('valor_nuevo' => $valor_nuevo)
    	));
    	$this->persistirCambiosADatos($cambiosAdmAudCampo, $datosAdmAudCampo, 'adm_aud_campo', 'adm_aud_campo_id');
    }
    
    public function auditarCambiosEnTabla($cambios,$tabla,$pkNombreCampo,$pkValorCampo,$admAuditoriaId)
    {
    	$datosAdmAudTabla = array();
    	$cambiosAdmAudTabla = $this->_cambios->cambiar(array(),array(
    			array('tabla' => $tabla),
    			array('pk_nombre_campo' => $pkNombreCampo),
    			array('pk_valor_campo'  => $pkValorCampo),
    			array('adm_auditoria_id' => $admAuditoriaId)
    	));
    	$cambiosAdmAudTabla = $this->persistirCambiosADatos($cambiosAdmAudTabla, $datosAdmAudTabla, 'adm_aud_tabla', 'adm_aud_tabla_id');
    	//$admAudTablaId = $this->_getValorNuevo($cambiosAdmAudTabla, 'adm_aud_tabla_id');
    	$admAudTablaId = $this->_cambios->getValorNuevo($cambiosAdmAudTabla, 'adm_aud_tabla_id');
    	foreach($cambios as $cambio){
    		$this->auditarCambioEnCampo($cambio, $admAudTablaId);
    	}
    }
    
    public function fnAuditarCambiosEnTabla($cambios,$tabla,$pkNombreCampo,$pkValorCampo)
    {
    	$self = $this;
    	return function($admAuditoriaId) use($cambios,$tabla,$pkNombreCampo,$pkValorCampo,$self){
    		$self->auditarCambiosEnTabla($cambios, $tabla, $pkNombreCampo, $pkValorCampo, $admAuditoriaId);
    	};
    }
}