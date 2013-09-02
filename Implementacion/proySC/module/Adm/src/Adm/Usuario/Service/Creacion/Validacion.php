<?php

namespace Adm\Usuario\Service\Creacion;

class Validacion
{
	public function crearValidadorDePersona()
	{
		return function($params,$resultado){
			if($params['documentos_de_usuario'] > 0){
				$resultado['valido'] = false;
				$resultado['mensajes'][] = "La persona ya es usuario del sistema";
			}
			if(!$params['org_documento_id']){
				$resultado['valido'] = false;
				$resultado['mensajes'][] = "La persona no tiene documento de identificaci—n";
			}
			return $resultado;
		};
	}
	
	public function crearValidadorDeContrasenhaYConfirmacion($requisitos)
	{
		$validadores = array();
		if($requisitos['longitud_minima']){
			$validadores[] = $this->_crearValidadorDeLongitudMinima($requisitos['longitud_minima'], 'contrasenha');
		}
		if($requisitos['tiene_mayusculas']){
			$validadores[] = $this->_crearValidadorDeMayusculas('contrasenha');
		}
		if($requisitos['tiene_minusculas']){
			$validadores[] = $this->_crearValidadorDeMinusculas('contrasenha');
		}
		if($requisitos['tiene_numeros']){
			$validadores[] = $this->_crearValidadorDeNumeros('contrasenha');
		}
		if($requisitos['tiene_caracteres_especiales']){
			$validadores[] = $this->_crearValidadorDeCaracteresEspeciales('contrasenha');
		}
		$validadores[] = $this->_crearValidadorDeConfirmacion('contrasenha', 'confirmacion');
		return $validadores;
	}
	
	public function _crearValidadorDeLongitudMinima($longitudMinima,$contrasenhaKey)
	{
		return function($params,$resultado)use($longitudMinima,$contrasenhaKey){
			$contrasenha = $params[$contrasenhaKey];
			if(strlen($contrasenha) < $longitudMinima){
				$resultado['valido'] = false;
				$resultado['mensajes'][] = "La contrase–a debe contener al menos $longitudMinima caracteres.";
			}
			return $resultado;
		};
	}
	
	public function _crearValidadorDeMayusculas($contrasenhaKey)
	{
		return function($params,$resultado)use($contrasenhaKey){
			$contrasenha = $params[$contrasenhaKey];
			if(!(bool) preg_match("/[A-Z]/",$contrasenha)){
				$resultado['valido'] = false;
				$resultado['mensajes'][] = "La contrase–a debe contener al menos una letra mayœscula.";
			}
			return $resultado;
		};
	}
	
	public function _crearValidadorDeMinusculas($contrasenhaKey)
	{
		return function($params,$resultado)use($contrasenhaKey){
			$contrasenha = $params[$contrasenhaKey];
			if(!(bool) preg_match("/[a-z]/",$contrasenha)){
				$resultado['valido'] = false;
				$resultado['mensajes'][] = "La contrase–a debe contener al menos una letra minœscula.";
			}
			return $resultado;
		};
	}
	
	public function _crearValidadorDeNumeros($contrasenhaKey)
	{
		return function($params,$resultado)use($contrasenhaKey){
			$contrasenha = $params[$contrasenhaKey];
			if(!(bool) preg_match("/[0-9]/",$contrasenha)){
				$resultado['valido'] = false;
				$resultado['mensajes'][] = "La contrase–a debe contener al menos un nœmero.";
			}
			return $resultado;
		};
	}
	
	public function _crearValidadorDeCaracteresEspeciales($contrasenhaKey)
	{
		return function($params,$resultado)use($contrasenhaKey){
			$contrasenha = $params[$contrasenhaKey];
			if(!(bool) preg_match('/[~@#\^\$&\*\(\)_\+=\[\]\{\}\|\\,\.\?-]/',$contrasenha)){
				$resultado['valido'] = false;
				$resultado['mensajes'][] = 'La contrase–a debe contener al menos un caracter especial como: ~ @ # ^ $ & * ( ) - _ + = [ ] { } |\ , . ?';
			}
			return $resultado;
		};
	}
	
	public function _crearValidadorDeConfirmacion($contrasenhaKey,$confirmacionKey)
	{
		return function($params,$resultado) use($contrasenhaKey,$confirmacionKey){
			$contrasenha = $params[$contrasenhaKey];
			$confirmacion = $params[$confirmacionKey];
			if($contrasenha != $confirmacion){
				$resultado['valido'] = false;
				$resultado['mensajes'][] = "La confirmaci—n no coincide con la contrase–a";
			}
			return $resultado;
		};
	}
}