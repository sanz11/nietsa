<?php
class Tipoestablecimiento_model extends Model
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
	public function listar_tiposEstablecimiento($number_items='',$offset='')
	{
		$query = $this->db->order_by('TESTC_Descripcion')->where('TESTC_FlagEstado','1')->get('cji_tipoestablecimiento',$number_items,$offset);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	public function obtener_tipoEstablecimiento($tipo)
	{
		$query = $this->db->where('TESTP_Codigo',$tipo)->get('cji_tipoestablecimiento');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	public function insertar_establecimiento($descripcion)
	{
         $compania = $this->somevar['compania'];
		$data = array(
                                   "TESTC_Descripcion" => strtoupper($descripcion),
                                   "COMPP_Codigo"       => $compania
                                   );
		$this->db->insert("cji_tipoestablecimiento",$data);
	}
	public function modificar_establecimiento($establecimiento,$descripcion)
	{
		$data = array("TESTC_Descripcion"=>strtoupper($descripcion));
		$this->db->where("TESTP_Codigo",$establecimiento);
		$this->db->update("cji_tipoestablecimiento",$data);
	}
	public function eliminar_establecimiento($establecimiento)
	{
		$where  = array("TESTP_Codigo"=>$establecimiento);
		$this->db->delete("cji_tipoestablecimiento",$where);
	}
	public function buscar_establecimientos($filter,$number_items='',$offset='')
	{
            $this->db->where('COMPP_Codigo',$this->somevar['compania']);
            $this->db->where_not_in('TESTP_Codigo','0');
            if(isset($filter->nombre_establecimiento) && $filter->nombre_establecimiento!="")
                $this->db->like('TESTC_Descripcion',$filter->nombre_establecimiento);
            $query = $this->db->get('cji_tipoestablecimiento',$number_items='',$offset='');
            if($query->num_rows>0){
                foreach($query->result() as $fila){
                        $data[] = $fila;
                }
            return $data;
            }
	}
}
?>