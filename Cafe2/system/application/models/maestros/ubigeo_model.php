<?php
class Ubigeo_model extends Model{
     var $somevar;
	function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar['hoy']              = mdate("%Y-%m-%d %h:%i:%s",time());
	}
	function listar_departamentos(){
		$query = $this->db->order_by('UBIGC_Descripcion')->where_not_in('UBIGC_CodDpto','00')->where('UBIGC_FlagEstado','1')->where('UBIGC_CodProv','00')->where('UBIGC_CodDist','00')->get('cji_ubigeo');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	function listar_provincias($departamento){
		$where = array('UBIGC_FlagEstado'=>'1','UBIGC_CodDpto'=>$departamento,'UBIGC_CodDist'=>'00');
		$query = $this->db->order_by('UBIGC_Descripcion')->where_not_in('UBIGC_CodProv','00')->where($where)->get('cji_ubigeo');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;		
		}
	}
	function listar_distritos($departamento,$provincia){
		$where = array('UBIGC_FlagEstado'=>'1','UBIGC_CodDpto'=>$departamento,'UBIGC_CodProv'=>$provincia);
		$query = $this->db->order_by('UBIGC_Descripcion')->where_not_in('UBIGC_CodDist','00')->where($where)->get('cji_ubigeo');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;		
		}	
	}
	function obtener_ubigeo($ubigeo){
		$query = $this->db->where('UBIGP_Codigo',$ubigeo)->get('cji_ubigeo');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;		
		}			
	}
	function obtener_ubigeo_dpto($ubigeo){
		$dpto = substr($ubigeo,0,2);
		$prov = substr($ubigeo,2,2);
		$dist = substr($ubigeo,4,2);
              //  if($dpto!='00'){
                    $where = array("UBIGC_CodDpto"=>$dpto,"UBIGC_CodProv"=>'00',"UBIGC_CodDist"=>'00');
                    $query = $this->db->where($where)->get('cji_ubigeo');
                    if($query->num_rows>0){
                            foreach($query->result() as $fila){
                                    $data[] = $fila;
                            }
                            return $data;		
                    }
              //  }
	}
	function obtener_ubigeo_prov($ubigeo){
		$dpto = substr($ubigeo,0,2);
		$prov = substr($ubigeo,2,2);
		$dist = substr($ubigeo,4,2);
              //  if($prov!='00'){
                    $where = array("UBIGC_CodDpto"=>$dpto,"UBIGC_CodProv"=>$prov,"UBIGC_CodDist"=>'00');
                    $query = $this->db->where($where)->get('cji_ubigeo');
                    if($query->num_rows>0){
                            foreach($query->result() as $fila){
                                    $data[] = $fila;
                            }
                            return $data;		
                    }
               // }
	}
        function obtener_ubigeo_dist($ubigeo){
		$dpto = substr($ubigeo,0,2);
		$prov = substr($ubigeo,2,2);
		$dist = substr($ubigeo,4,2);
                if($dist!='00'){
                    $where = array("UBIGC_CodDpto"=>$dpto,"UBIGC_CodProv"=>$prov,"UBIGC_CodDist"=>$dist);
                    $query = $this->db->where($where)->get('cji_ubigeo');
                    if($query->num_rows>0){
                            foreach($query->result() as $fila){
                                    $data[] = $fila;
                            }
                            return $data;		
                    }
                }
	}
}
?>