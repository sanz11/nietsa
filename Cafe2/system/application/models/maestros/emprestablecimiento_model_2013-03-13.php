<?php
class Emprestablecimiento_model extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->load->model('maestros/ubigeo_model');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario'] = $this->session->userdata('usuario');
        $this->somevar['hoy'] = mdate("%Y-%m-%d %h:%i:%s",time());
    }
    public function listar($empresa, $tipo='')
    {   $this->db->where('cji_emprestablecimiento.EMPRP_Codigo', $empresa)->where('EESTABC_FlagEstado','1');
        if($tipo!=='')
            $this->db->where('cji_emprestablecimiento.EESTABC_FlagTipo', $tipo);
        $this->db->join('cji_compania', 'cji_compania.EESTABP_Codigo = cji_emprestablecimiento.EESTABP_Codigo', 'left');
        $this->db->where_not_in('cji_emprestablecimiento.EESTABP_Codigo','0')->order_by('EESTABC_Descripcion')->select('cji_emprestablecimiento.*,cji_compania.COMPP_Codigo');
        $query = $this->db->get('cji_emprestablecimiento');
        if($query->num_rows>0){
            $result= $query->result();
            foreach($result as $key => $reg){
                $result[$key]->distrito     = "";
                $result[$key]->provincia    = "";
                $result[$key]->departamento = "";
                if($reg->UBIGP_Codigo!='' && $reg->UBIGP_Codigo!='000000'){
                    $datos_ubigeo_dist = $this->ubigeo_model->obtener_ubigeo_dist($reg->UBIGP_Codigo);
                    $datos_ubigeo_prov = $this->ubigeo_model->obtener_ubigeo_prov($reg->UBIGP_Codigo);
                    $datos_ubigeo_dep  = $this->ubigeo_model->obtener_ubigeo_dpto($reg->UBIGP_Codigo);
                    if(count($datos_ubigeo_dist)>0)
                        $result[$key]->distrito     = $datos_ubigeo_dist[0]->UBIGC_Descripcion;
                    if(count($datos_ubigeo_prov)>0)
                        $result[$key]->provincia    = $datos_ubigeo_prov[0]->UBIGC_Descripcion;
                    if(count($datos_ubigeo_dep)>0)
                        $result[$key]->departamento = $datos_ubigeo_dep[0]->UBIGC_Descripcion;
                }
            }
            return $result;
        }else
            return array();
    }
    public function obtener($id){
        $where = array("EESTABP_Codigo"=>$id,"EESTABC_FlagEstado"=>"1");
        $query = $this->db->where($where)->get('cji_emprestablecimiento');
        if($query->num_rows>0){
                foreach($query->result() as $fila){
                    $fila->distrito     = "";
                    $fila->provincia    = "";
                    $fila->departamento = "";
                    if($fila->UBIGP_Codigo!='' && $fila->UBIGP_Codigo!='000000'){
                        $datos_ubigeo_dist = $this->ubigeo_model->obtener_ubigeo_dist($fila->UBIGP_Codigo);
                        $datos_ubigeo_prov = $this->ubigeo_model->obtener_ubigeo_prov($fila->UBIGP_Codigo);
                        $datos_ubigeo_dep  = $this->ubigeo_model->obtener_ubigeo_dpto($fila->UBIGP_Codigo);
                        if(count($datos_ubigeo_dist)>0)
                            $fila->distrito     = $datos_ubigeo_dist[0]->UBIGC_Descripcion;
                        if(count($datos_ubigeo_prov)>0)
                            $fila->provincia    = $datos_ubigeo_prov[0]->UBIGC_Descripcion;
                        if(count($datos_ubigeo_dep)>0)
                            $fila->departamento = $datos_ubigeo_dep[0]->UBIGC_Descripcion;
                    }    
                    $data[] = $fila;
                }
                return $data;
        }
    }
    public function insertar(stdClass $filter = null)
    {
        $this->db->insert("cji_emprestablecimiento",(array)$filter);
    }
    public function modificar($id,$filter)
    {
        $this->db->where("EESTABP_Codigo",$id);
        $this->db->update("cji_emprestablecimiento",(array)$filter);
    }
    public function eliminar($id)
    {
        $this->db->delete('cji_emprestablecimiento',array('EESTABP_Codigo' => $id));
    }
  public function eliminarlog_establecimiento($id)
    {
        //$this->db->delete('cji_emprestablecimiento',array('EESTABP_Codigo' => $id));
		$data=array('EESTABC_FlagEstado'=>0);
		$this->db->where('EESTABP_Codigo',$id);
		$this->db->update('cji_emprestablecimiento',$data);
	
	}
}
?>