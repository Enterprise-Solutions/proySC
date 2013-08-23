<?php
namespace Org\Direccion\DireccionesDeParte;
use Org\Parte\Parte;
use Org\Direccion\Repository;
use Org\Direccion\Factory;

function crearDireccionParaParte($datos,Parte $parte,Factory $dirFactory){
	$direccion = $dirFactory->crearDireccion();
	$direccion->setParte($parte);
	$direccion->crear($datos);
	return $direccion;
}

function crearDireccionesParaParte($datosArray,Parte $parte, Factory $dirFactory){
	$agregados = array_map(
		function($datos) use($parte,$dirFactory){
			return crearDireccionParaParte($datos, $parte, $dirFactory);
		},
		$datosArray
	);
	return $agregados;
}

function editarDirecciones($datosArray,$listado){
	$editados = array_map(
		function($datos) use ($listado){
			$dirDireccionId = $datos['dir_direccion_id'];
			$direccion = getDireccion($dirDireccionId, $listado);
			$direccion->editar($datos);
			return $direccion;
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

function removerDireccionesBorrados($borrados,$listado){
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

function getDireccion($dirDireccionId,$listado){
	$encontrados = getDirecciones(array($dirDireccionId), $listado);
	return count($encontrados == 1)?current($encontrados):false;
}

function getDirecciones($dirDireccionIds,$listado){
	$encontrados = array_filter(
		$listado,
		function($direccion) use($dirDireccionIds){
			if(in_array($direccion->getId(),$dirDireccionIds)){
				return true;
			}
			return false;
		}
	);
	return $encontrados;
}