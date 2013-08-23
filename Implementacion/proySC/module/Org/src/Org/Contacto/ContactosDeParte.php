<?php
namespace Org\Contacto\ContactosDePartes;
use Org\Parte\Parte;
use Org\Contacto\Repository;
use Org\Contacto\Factory;

function crearContactoParaParte($datos,Parte $parte,Factory $contactoFactory){
	$contacto = $contactoFactory->crearContacto($datos['org_contacto_tipo_codigo']);
	$contacto->setParte($parte);
	$contacto->crear($datos);
	return $contacto;
}

function crearContactosParaParte($datosArray,Parte $parte, Factory $contactoFactory){
	$agregados = array_map(
		function($datos) use($parte,$contactoFactory){
			return crearContactoParaParte($datos, $parte, $contactoFactory);
		},
		$datosArray
	);
	return $agregados;
}

function editarContactos($datosArray,$listado){
	$editados = array_map(
		function($datos) use ($listado){
			$orgContactoId = $datos['org_contacto_id'];
			$contacto = getContacto($orgContactoId, $listado);
			$contacto->editar($datos);
			return $contacto;
		},
		$datosArray
	);
	return $editados;
}

/*function service($datos,$parte,$factory,$repository){

	$listado = $repository->findDocumentosDeParte($parte);
	$agregados = crearContactosParaParte($datos['agregados'], $parte, $factory);
	$editados  = editarDocumentos($datos['editados'], $listado);
	$borrados  = getDocumentos($datos['borrados'], $listado);
	
	$listado = removerBorradosDeListado($borrados, $listado);
	$listado = array_merge($listado,$agregados);
	$agregados = array_map(function($documento) use($repository){$repository->persistir($documento);}, $agregados);
	$editados = array_map(function($documento) use($repository){$repository->persistir($documento);}, $editados);
	$borrados = array_map(function($documento) use($repository){$repository->borrar($documento);}, $borrados);
	
}*/

function removerContactosBorrados($borrados,$listado){
	return array_udiff(
		$listado, $borrados, 
		function($a,$b){
			if($a->getId() == $b->getId()){
				return 0;
			}
			return -1;
		}
	);
}

function getContacto($orgContactoId,$listado){
	$encontrados = getContactos(array($orgContactoId), $listado);
	return count($encontrados == 1)?current($encontrados):false;
}

function getContactos($orgContactoIds,$listado){
	$encontrados = array_filter(
		$listado,
		function($contacto) use($orgContactoIds){
			if(in_array($contacto->getId(),$orgContactoIds)){
				return true;
			}
			return false;
		}
	);
	return $encontrados;
}