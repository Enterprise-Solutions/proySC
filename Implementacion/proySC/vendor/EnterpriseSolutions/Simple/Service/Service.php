<?php
namespace EnterpriseSolutions\Simple\Service;
use EnterpriseSolutions\Simple\Repository\DataSource;
use \Exception;
class Service
{
    public function transaccional($service,$ds = null)
    {
        return function($datos) use ($service,$ds) {
            if(!$ds){
                $ds = new DataSource();
            }
            $conn = $ds->_getDbConnection()
            		   ->getDriver()
            		   ->getConnection();
            try{
            	$conn->beginTransaction();
            	$resultado =  $service($datos);
            	$conn->commit();
            }catch(Exception $e){
            	$conn->rollback();
            	throw $e;
            }
            return $resultado;
        };
    }
    
    /*public function auditable($service,$codigoDeOperacion)
    {
        return function($datos) use($codigoDeOperacion,$service){
            $ds = new Framework_Simple_Auditoria_Repository_DataSourceAuditable();
            $resultado = $service($datos,$ds);
            
            $repository = new Framework_Simple_Auditoria_Repository(new Framework_Simple_Repository_DataSource());
            $auditoria = new Framework_Simple_Auditoria_Auditoria($repository);
            $auditoria->auditar($codigoDeOperacion, $ds->_cambiosAuditados);
            
            return $resultado;
        };
    }*/
}