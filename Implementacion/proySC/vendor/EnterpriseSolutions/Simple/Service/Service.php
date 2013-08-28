<?php
class Framework_Simple_Service_Service
{
    public function transaccional($service,$ds = null)
    {
        return function($datos,$ds = null) use ($service) {
            if(!$ds){
                $ds = new Framework_Simple_Repository_DataSource();
            }
            $conn = $ds->_getDbConnection();
            try{
            	$conn->beginTransaction();
            	$resultado =  $service($datos,$ds);
            	$conn->commit();
            }catch(Exception $e){
            	$conn->rollback();
            	throw $e;
            }
            return $resultado;
        };
    }
    
    public function auditable($service,$codigoDeOperacion)
    {
        return function($datos) use($codigoDeOperacion,$service){
            $ds = new Framework_Simple_Auditoria_Repository_DataSourceAuditable();
            $resultado = $service($datos,$ds);
            
            $repository = new Framework_Simple_Auditoria_Repository(new Framework_Simple_Repository_DataSource());
            $auditoria = new Framework_Simple_Auditoria_Auditoria($repository);
            $auditoria->auditar($codigoDeOperacion, $ds->_cambiosAuditados);
            
            return $resultado;
        };
    }
}