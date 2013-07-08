<?php
namespace Org\Documento\Documentos;
use Org\Documento\Documento\Factory;
use Org\Documento\Repository;
use Org\Parte\Parte;

function crearDocumentoParaParte($datos,Parte $parte,Factory $docFactory){
	$documento = $docFactory->crearDocumento($datos['org_documento_tipo_codigo']);
	$documento->setParte($parte);
	$documento->crear($datos);
	return $documento;
}

function crearDocumentosParaParte($datosArray,Parte $parte, Factory $docFactory){
	$agregados = array_map(
		function($datos) use($parte,$docFactory){
			return crearDocumentoParaParte($datos, $parte, $docFactory);
		},
		$datosArray
	);
	return $agregados;
}

function editarDocumentos($datosArray,$listado){
	$editados = array_map(
		function($datos) use ($listado){
			$orgDocumentoId = $datos['org_documento_id'];
			$documento = getDocumento($orgDocumentoId, $listado);
			$documento->editar($datos);
			return $documento;
		},
		$datosArray
	);
	return $editados;
}

function service($datos,$parte,$factory,$repository){
	/*
	 * agregar,editar,borrar
	 * validar listado
	 * persistir
	 * */
	$listado = $repository->findDocumentosDeParte($parte);
	$agregados = crearDocumentosParaParte($datos['agregados'], $parte, $factory);
	$editados  = editarDocumentos($datos['editados'], $listado);
	$borrados  = getDocumentos($datos['borrados'], $listado);
	
	$listado = removerBorradosDeListado($borrados, $listado);
	$listado = array_merge($listado,$agregados);
	$agregados = array_map(function($documento) use($repository){$repository->persistir($documento);}, $agregados);
	$editados = array_map(function($documento) use($repository){$repository->persistir($documento);}, $editados);
	$borrados = array_map(function($documento) use($repository){$repository->borrar($documento);}, $borrados);
	
}

function removerDocumentosBorrados($borrados,$listado){
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

function getDocumento($orgDocumentoId,$listado){
	$encontrados = getDocumentos(array($orgDocumentoId), $listado);
	return count($encontrados == 1)?current($encontrados):false;
}

function getDocumentos($orgDocumentoIds,$listado){
	$encontrados = array_filter(
		$listado,
		function($documento) use($orgDocumentoIds){
			if(in_array($documento->getId(),$orgDocumentoIds)){
				return true;
			}
			return false;
		}
	);
	return $encontrados;
}