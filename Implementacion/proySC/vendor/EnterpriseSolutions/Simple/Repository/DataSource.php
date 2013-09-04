<?php
namespace EnterpriseSolutions\Simple\Repository;
use EnterpriseSolutions\Simple\Cambios\Cambios;
use Zend\Db\Adapter\Adapter;
class DataSource
{
    public $_conn;
    public $_cambios;
    public function __construct(Adapter $conn)
    {
    	if($conn){
    		$this->_conn = $conn;
    	}
    	$this->_conn = $conn;
    	$this->_cambios = new Cambios();
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
        /*if(!$conn){
        	$conn = $this->_getDbConnection();
        }*/
    	
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
    	//$rs = $conn->exec($sql);
    	$rs = $conn->query($sql,Adapter::QUERY_MODE_EXECUTE);
    	if($this->_cambios->_tieneCampo($datos, $pkName)){
    	    $valorPk = $this->_cambios->getValorNuevo($datos, $pkName);
    	}else{
    	    $valorPk = $this->_findValorPk($conn, $tabla);
    	}
    	
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
    	//$rs = $conn->execute($sql)
    	//->fetchAll();
    	$rs = $conn->query($sql,Adapter::QUERY_MODE_EXECUTE)->toArray();
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
    	//$rs = $conn->exec($sql);
    	$rs = $conn->query($sql,Adapter::QUERY_MODE_EXECUTE);
    	return $cambios;
    }
    
    public function borrar($tabla,$pkName,$datos,$conn)
    {
    	$pkValue = $datos[$pkName];
    	$sql = "delete from $tabla where $pkName = $pkValue";
    	$conn->query($sql,Adapter::QUERY_MODE_EXECUTE);
    	return $this->_cambios->generarCambiosDeBorrado($datos);
    }
    
    /**
    * @return Adapter
    */
    public function _getDbConnection()
    {
    	return $this->_conn;
    /*if(!$this->_conn){
    $this->_conn = Doctrine_Manager::getInstance()->getCurrentConnection();
    }
    return $this->_conn;*/
    }
}