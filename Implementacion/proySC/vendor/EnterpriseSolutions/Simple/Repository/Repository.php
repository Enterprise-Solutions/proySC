<?php
namespace EnterpriseSolutions\Simple\Repository;
use EnterpriseSolutions\Simple\Repository\DataSource;
class Repository
{
    /**
     * @var DataSource
     */
    public $_ds;
    public function __construct($ds)
    {
        $this->_ds = $ds;
    }
    
    public function persistirCambiosADatos($cambios,$datos,$tabla,$pk)
    {
    	/*if(!$datos){
    		return $this->insertar($tabla, $pk, $cambios,$conn);
    	}else{
    		return $this->update($tabla, $pk, $datos, $cambios,$conn);
    	}*/
        return $this->_ds->persistirCambiosADatos($cambios, $datos, $tabla, $pk);
    }
    
    public function insertarCambios($cambios,$tabla,$pk)
    {
        $conn = $this->_ds->_getDbConnection();
        return $this->_ds->insertar($tabla, $pk, $cambios,$conn);
    }
    
    public function borrar($datos,$tabla,$pk)
    {
    	$conn = $this->_ds->_getDbConnection();
    	return $this->_ds->borrar($tabla, $pk, $datos, $conn);
    }
    
    /*public $_conn;
    public function __construct($conn = null)
    {
        if($conn){
            $this->_conn = $conn;
        }
    }
    
    public function persistirCambiosADatos($cambios,$datos,$tabla,$pk,$conn = null)
    {
        if(!$conn){
            $conn = $this->_getDbConnection();
        }
        if(!$datos){
        	return $this->insertar($tabla, $pk, $cambios,$conn);
        }else{
        	return $this->update($tabla, $pk, $datos, $cambios,$conn);
        }
    }
    
    public function insertar($tabla,$pkName,$datos,$conn)
    {
    	$sql = " insert into $tabla ";
    	$campos = join(',',array_map(
    			function($campo){
    				return $campo['key'];
    			},
    			$datos
    	));
    	$valores = join(',',array_map(
    			function($campo){
    				$valor = $campo['valorNuevo'];
    				return is_string($valor)?"'$valor'":$valor;
    			},
    			$datos
    	));
    	$sql = "insert into $tabla ($campos) values ($valores)";
    	$rs = $conn->exec($sql);
    	$valorPk = $this->_findValorPk($conn, $tabla);
    	$datos[] = array(
    			'key' => $pkName,
    			'valorViejo' => null,
    			'valorNuevo' => $valorPk
    	);
    	return $datos;
    }
    
    public function _findValorPk($conn,$tabla)
    {
    	$seq = "{$tabla}_{$tabla}_id_seq";
    	$sql = "select currval('$seq') as id";
    	$rs = $conn->execute($sql)
    	->fetchAll();
    	return $rs[0]['id'];
    }
    
    public function update($tabla,$pkName,$datos,$cambios,$conn,$where = null){
    	$sets = join(',',array_map(
    			function($cambio){
    				$campo = $cambio['key'];
    				$valor = $cambio['valorNuevo'];
    				$valor = is_string($valor)?"'$valor'":$valor;
    				return "$campo = $valor";
    			},
    			$cambios
    	));
    	if(!$where){
    	$pkValue = $datos[$pkName];
    	$pkValue = is_string($pkValue)?"'$pkValue'":$pkValue;
    	$where = " $pkName = $pkValue ";
    	}
    	$sql = "update $tabla set $sets where $where";
    	$rs = $conn->exec($sql);
    	return $cambios;
    }*/
    
    /*
    public function _getDbConnection()
    {
        if(!$this->_conn){
            $this->_conn = Doctrine_Manager::getInstance()->getCurrentConnection();    
        }
        return $this->_conn;
    }*/
}