<?php
class Bancocta_Model extends Model
{
    protected $_name = "cji_bancocta";
    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function seleccionar($banco, $default="")
    {
        $nombre_defecto = $default==""?":: Seleccione ::":$default;
        $arreglo = array(''=>$nombre_defecto);
        foreach($this->listar($banco) as $indice=>$valor)
        {
            $indice1   = $valor->CTAP_Codigo;
            $valor1    = $valor->CTAC_Nro.' - '.($valor->CTAC_Nro=='S' ? 'SOLES' : 'DOLARES');
            $arreglo[$indice1] = $valor1;
        }
        return $arreglo;
    }
    public function listar($banco)
    {   $where = array("CTAC_FlagEstado"=>"1", "BANP_Codigo"=>$banco);
        
        $query = $this->db
                ->where($where)
                ->get('cji_bancocta');
        if($query->num_rows>0){
          return $query->result();
        }
    }
    public function obtener($cta)
    {   $where = array("CTAP_Codigo"=>$cta);
        
        $query = $this->db
                ->where($where)
                ->get('cji_bancocta');
        if($query->num_rows>0){
          return $query->result();
        }
    }
    
   
}
?>