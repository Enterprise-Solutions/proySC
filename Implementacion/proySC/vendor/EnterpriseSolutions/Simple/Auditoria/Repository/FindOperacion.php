<?php
class Framework_Simple_Auditoria_Repository_FindOperacion extends Framework_QueryObject_Sql
{
    public function init()
    {
        $this->select("op.adm_operacion_id")
             ->from("
                 adm_operacion op
                 join adm_cu cu on op.adm_cu_id = cu.adm_cu_id
                 join adm_modulo mod on cu.adm_modulo_id = mod.adm_modulo_id 
             ");
    }
    
    public function addSearchByCodigo($codigo)
    {
        $this->where("
            op.codigo||'_'||cu.codigo||'_'||mod.codigo = '$codigo'
        ");                
    }
}