<?php
class Proyecto_model extends Model
{
    var $somevar;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['user'] = $this->session->userdata('user');
        $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
    }
public function listar_proyectos(){
        $where = array("PROYC_FlagEstado"=>1);
        $query = $this->db->order_by('PROYC_Nombre')
                          ->where($where)
                          ->select('PROYP_Codigo,PROYC_Nombre,PROYC_Descripcion,DIREP_Codigo')
                          ->from('cji_proyecto')
                          ->get();
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
 }

public function obtener_datosProyecto($proyecto){
        $query = $this->db->where('PROYP_Codigo',$proyecto)->get('cji_proyecto');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function insertar_datosProyecto($nombres,$descripcion,$encargado,$fechai,$fechaf,$compania){
        $usuario =$this->somevar ['user'];        
        $data = array(
                    "PROYC_Nombre"    => strtoupper($nombres),
                    "PROYC_Descripcion"  => $descripcion,
                    "DIREP_Codigo "      => strtoupper($encargado),
                    "PROYC_FechaInicio"  => $fechai,
                    "PROYC_FechaFin"     => $fechaf,
                     "COMPP_Codigo"       => $compania,
                     "PROYC_CodigoUsuario"  =>  $usuario
                   );
       $this->db->insert("cji_proyecto",$data);
       return $this->db->insert_id();
    }
  public function modificar_datosProyecto($proyecto,$nombres,$descripcion,$encargado,$fechai,$fechaf)
             {
      $data = array(
                    "PROYC_Nombre"       =>$nombres,
                    "PROYC_Descripcion"  =>$descripcion,
                    "DIREP_Codigo"       =>$encargado,
                    "PROYC_FechaInicio"  =>$fechai,
                    "PROYC_FechaFin"     =>$fechaf
                    );
     $this->db->where("PROYP_Codigo",$proyecto);
     $this->db->update("cji_proyecto",$data);
    }






   public function eliminar_proyecto($proyecto)
    {
        $data  = array("PROYC_FlagEstado"=>'0');
        $where = array("PROYP_Codigo"=>$proyecto);
        $this->db->where($where);
        $this->db->update('cji_proyecto',$data);
    }
     public function buscar_proyectos($filter,$number_items='',$offset='')
    {       
       if(isset($filter->PROYC_Nombre) && $filter->PROYC_Nombre!=""){
       $this->db->like('PROYC_Nombre',$filter->PROYC_Nombre);          
       }
        $query = $this->db->order_by('PROYC_Nombre')
                          ->where('PROYC_FlagEstado','1')
                          ->get('cji_proyecto',$number_items='',$offset='');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                    $data[] = $fila;
            }
            return $data;
        }
    }




}
?>