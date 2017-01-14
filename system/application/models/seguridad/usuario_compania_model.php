<?php
class Usuario_compania_model extends Model
{
	public function __construct()
	{
            parent::__construct();
            $this->load->database();
            $this->load->helper('date');
            $this->somevar ['compania'] = $this->session->userdata('compania');
            $this->somevar ['usuario']  = $this->session->userdata('usuario');
            $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
            $this->load->model('maestros/empresa_model');
            $this->load->model('maestros/emprestablecimiento_model');
	}
	public function listar($usuario, $empresa='')
	{
            $compania = $this->somevar['compania'];
            $where = array("cji_usuario.USUA_Codigo"=>$usuario,"USUCOMC_Default"=>"1");
            if($empresa!='')
                $where["cji_compania.EMPRP_Codigo"]=$empresa;
            
            $query = $this->db->
                    join('cji_usuario','cji_usuario.USUA_Codigo=cji_usuario_compania.USUA_Codigo')->
                    join('cji_compania','cji_compania.COMPP_Codigo=cji_usuario_compania.COMPP_Codigo')->
                    where($where)->
                    get('cji_usuario_compania');
            if($query->num_rows>0){
                foreach($query->result() as $fila){
                    $data[] = $fila;
                }
                return $data;
            }
	}
        
        public function listar_empresas()
        {     $user = $this->session->userdata('user');
        
              $query = $this->db->select('cji_compania.EMPRP_Codigo')
                              ->where('cji_compania.COMPC_FlagEstado','1')
                              ->where('cji_usuario_compania.USUA_Codigo', $user)
                              ->join('cji_compania', 'cji_compania.COMPP_Codigo = cji_usuario_compania.COMPP_Codigo', 'left')
                              ->group_by('cji_compania.EMPRP_Codigo')
                              ->get('cji_usuario_compania');
              if($query->num_rows>0){
                foreach($query->result() as $fila){
                  $data[] = $fila;
                }
                return $data;
              }
              else
                  return array();
        }
        
        public function listar_establecimiento($user='', $default=false)
        {     if($user=='')
                  $where['cji_usuario_compania.USUA_Codigo'] = $this->session->userdata('user');
              else
                  $where['cji_usuario_compania.USUA_Codigo'] = $user;
              if($default==true)
                  $where['cji_usuario_compania.USUCOMC_Default'] = '1';
              
              $query = $this->db->where($where)
                              ->join('cji_compania', 'cji_compania.COMPP_Codigo = cji_usuario_compania.COMPP_Codigo', 'left')
                              ->get('cji_usuario_compania');
            
              if($query->num_rows>0){
                  foreach($query->result() as $fila){
                     $data[] = $fila;
                  }
                  return $data;
              }
              else
                  return array();
        }
        
        public function listar_compania(){
            $array_empresas = $this->listar_empresas();
            $arreglo = array();
            foreach($array_empresas as $indice=>$valor){
                    $empresa           = $valor->EMPRP_Codigo;
                    $datos_empresa     = $this->empresa_model->obtener_datosEmpresa($empresa);
                    $razon_social      = $datos_empresa[0]->EMPRC_RazonSocial;
                    $arreglo[]=array('tipo'=>'1', 'nombre'=>$razon_social, 'compania'=>'');

                    $array_establecimiento = $this->listar_establecimiento();
                    foreach($array_establecimiento as $indice=>$valor){
                        $compania               = $valor->COMPP_Codigo;
                        $datos_establecimiento  = $this->emprestablecimiento_model->obtener($valor->EESTABP_Codigo);
                        $nombre_establecimiento = $datos_establecimiento[0]->EESTABC_Descripcion;
                        $arreglo[]=array('tipo'=>'2', 'nombre'=>$nombre_establecimiento, 'compania'=>$compania);
                    }

            }
            return $arreglo;
        }
        
        public function insertar(stdClass $filter = null)
        {
            $this->db->insert("cji_usuario_compania",(array)$filter);
        }
}
?>