<?php
class Framework_Simple_Auditoria_Repository extends Framework_Simple_Repository_Repository
{
    /**
     * @param string $codigoDeOperacion
     * @return int
     */
    public function findAdmOperacionId($codigoDeOperacion)
    {
        $query = new Framework_Simple_Auditoria_Repository_FindOperacion();
        $query->addSearchByCodigo($codigoDeOperacion);
        $rs = $query->execute();
        if(count($rs) == 1){
            return $rs[0]['adm_operacion_id'];
        }
    }
    
    /**
     * 
     */
    public function findAdmUsuarioId()
    {
        return 1;        
    }
}