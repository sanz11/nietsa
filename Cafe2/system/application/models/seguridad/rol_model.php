<?php
class Rol_model extends Model
{
    function __construct()
    {
            parent::__construct();
    $this->load->database();
    $this->load->helper('date');
     $this->load->model('seguridad/permiso_model');
      $this->load->model('seguridad/menu_model');
    $this->somevar ['compania'] = $this->session->userdata('compania');
     $this->somevar ['usuario']    = $this->session->userdata('usuario');
    $this->somevar['hoy']              = mdate("%Y-%m-%d %h:%i:%s",time());
    }
    function listar_roles(){
        $query = $this->db->order_by('ROL_Descripcion')->where('ROL_FlagEstado','1')->get('cji_rol');
        if($query->num_rows>0){
                foreach($query->result() as $fila){
                        $data[] = $fila;
                }
                return $data;
        }
    }

    function obtener_rol($rol){
        $query = $this->db->where('ROL_Codigo',$rol)->get('cji_rol');
        if($query->num_rows>0){
                foreach($query->result() as $fila){
                        $data[] = $fila;
                }
                return $data;
        }
     }
     public function obtener_rol_permiso(){
         $where = array('MENU_Codigo_Padre'=>0,'MENU_FlagEstado'=>'1');
        $qu = $this->db->from('cji_menu')
                ->where($where)
                ->get();
        $rows = $qu->result();
        foreach($rows as $row){
                $where1 = array('MENU_Codigo_Padre'=>$row->MENU_Codigo,'MENU_FlagEstado'=>'1');
                 $qur = $this->db->from('cji_menu')
                    ->where($where1 )
                    ->get();
                 $row->submenus = $qur->result();
            }
            return $rows;
   }

   public function insertar(stdClass $filter,$checkO)
    {
        $this->db->insert("cji_rol",(array)$filter);
        $rol=$this->db->insert_id();

        if(is_array($checkO)){
            foreach($checkO as $indice=>$valor){
                if($valor!=''){
                    $filter=new stdClass();
                    $filter->ROL_Codigo=$rol;
                    $filter->MENU_Codigo=$valor;
                    $filter->COMPP_Codigo=$this->somevar ['compania'];
                    $this->permiso_model->insertar($filter);

                    $temp=$this->menu_model->obtener_datosMenu($valor);
                    $menu=$temp[0];
                    $menu_padre=$menu->MENU_Codigo_Padre;

                    if($menu_padre!=0){
                        $temp=$this->permiso_model->busca_permiso($rol,$menu_padre);
                        if(count($temp)==0){
                            $filter=new stdClass();
                            $filter->ROL_Codigo=$rol;
                            $filter->MENU_Codigo=$menu_padre;
                            $filter->COMPP_Codigo=$this->somevar ['compania'];
                            $this->permiso_model->insertar($filter);
                       }
                    }
             }
           }
        }
    }

    public function modificar($rol,$filter,$checkO)
    { 
     $this->db->where("ROL_Codigo",$rol);
     $this->db->update("cji_rol",(array)$filter);
     //Modificacion de permisos
     $this->permiso_model->eliminar_varios($rol);
     
     if(is_array($checkO)){
         foreach($checkO as $indice=>$valor){
                if($valor!=''){
                    $filter=new stdClass();
                    $filter->ROL_Codigo=$rol;
                    $filter->MENU_Codigo=$valor;
                    $filter->COMPP_Codigo=$this->somevar ['compania'];
                    $this->permiso_model->insertar($filter);
                    $temp=$this->menu_model->obtener_datosMenu($valor);
                    $menu=$temp[0];
                    $menu_padre=$menu->MENU_Codigo_Padre;

                    if($menu_padre!=0){

                        $temp=$this->permiso_model->busca_permiso($rol,$menu_padre);
                        if(count($temp)==0){
                            $filter=new stdClass();
                            $filter->ROL_Codigo=$rol;
                            $filter->MENU_Codigo=$menu_padre;
                            $filter->COMPP_Codigo=$this->somevar ['compania'];
                            $this->permiso_model->insertar($filter);
                       }
                    }
           }
        }
     }
 }
  public function eliminar($id)
    {
      //eliminado de la tabla permiso
      $this->db->delete('cji_permiso',array('ROL_Codigo' => $id));
      // eliminado de la   tabla rol
      $this->db->where("ROL_Codigo",$id);
      $this->db->delete('cji_rol',array('ROL_Codigo' => $id));
    }        
   public function buscar_roles($filter,$number_items='',$offset='')
    {
      $this->db->where('COMPP_Codigo',$this->somevar['compania']);      
        $this->db->where_not_in('ROL_Codigo','0');
        if(isset($filter->nombres) && $filter->nombres!="")
            $this->db->like('ROL_Descripcion',$filter->nombres,'both');
        $query = $this->db->get('cji_rol',$number_items,$offset);
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                    $data[] = $fila;
            }
            return $data;
        }
    }
 }
?>