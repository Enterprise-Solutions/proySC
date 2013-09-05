<?php
namespace EnterpriseSolutions\Simple\Cambios;
class Cambios
{
    public function cambiar($datos,$cambios)
    {
        $deltas = array_map(
        		function($cambio) use($datos){
        			$key = current(array_keys($cambio));
        			$valorNuevo = $cambio[$key];
        			$valorViejo = isset($datos[$key])?$datos[$key]:null;
        			$delta = compact('key','valorNuevo','valorViejo');
        			return $delta;
        		},
        		$cambios
        );
        return $deltas;
    }
    
    public function generarCambiosDeBorrado($datos)
    {
    	$keys = array_keys($datos);
    	$cambios = array_map(
    		function($key) use($datos){
    			return array(
    				'valorNuevo' => '',
    				'valorViejo' => $datos[$key],
    				'key' => $key
    			);
    		}, 
    		$keys
    	);
    	return $cambios;		
    }
    
    public function getCamposCambiados($cambios)
    {
    	$cambios = array_filter(
    		$cambios,
    		function($cambio){
    			if($cambio['valorNuevo'] != $cambio['valorViejo']){
    				return true;
    			}
    			return false;
    	});
    	return array_map(
    		function($cambio){
    			return $cambio['key'];
    		}, 
    		$cambios
    	);
    }
    
    public function getValorViejo($cambios,$key)
    {
        return $this->_getValor($cambios, $key, 'valorViejo');
    }
    
    public function getValorNuevo($cambios,$key)
    {
        return $this->_getValor($cambios, $key, 'valorNuevo');
    }
    
    public function _getValor($cambios,$key,$tipoValor)
    {
        foreach($cambios as $cambio){
        	if($cambio['key'] == $key){
        		return $cambio[$tipoValor];
        	}
        }
        return false;
    }
    
    public function _tieneCampo($cambios,$campo)
    {
        foreach($cambios as $cambio){
            if($cambio['key'] == $campo){
                return true;
            }
        }
        return false;
    }
}