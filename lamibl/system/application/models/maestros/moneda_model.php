<?php
class Moneda_model extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario']    = $this->session->userdata('usuario');
        $this->somevar['hoy']              = mdate("%Y-%m-%d %h:%i:%s",time());
    }
    public function seleccionar()
    {
        $arreglo = array(''=>':: Seleccione ::');
        foreach($this->listar() as $indice=>$valor)
        {
            $indice1   = $valor->MONED_Codigo;
            $valor1    = $valor->MONED_Descripcion;
            $arreglo[$indice1] = $valor1;
        }
        return $arreglo;
    }
    public function listar()
    {
        $compania = $this->somevar['compania'];
        $where = array("MONED_FlagEstado"=>"1");  //saque esta condicional "COMPP_Codigo"=>$compania
        $query = $this->db->order_by('MONED_Orden')->where('MONED_FlagEstado','1')->get('cji_moneda');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function listartipomoneda()
    {
    	$sql="select moned_codigo,moned_descripcion from cji_moneda";
    	
    	$query = $this->db->query($sql);
    	if($query->num_rows > 0){
    		foreach ($query->result() as $fila){
    			$data[] = $fila;
    		}
    		return $data;
    	}
    }
    public function obtener($moneda)
    {
        $query = $this->db->where('MONED_Codigo',$moneda)->get('cji_moneda');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
  public function insertar(stdClass $filter = null)
    {
        $this->db->insert("cji_moneda",(array)$filter);
    }
    public function modificar($id,$filter)
    {
        $this->db->where("MONED_Codigo",$id);
        $this->db->update("cji_moneda",(array)$filter);
    }
    public function eliminar($id)
    {
        $this->db->delete('cji_moneda',array('MONED_Codigo' => $id));
    }
    public function buscar($filter,$number_items='',$offset='')
    {

    }
   
}
?>