<?php
class Almacen_Model extends Model
{
    protected $_name = "cji_almacen";
    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->somevar['compania'] = $this->session->userdata('compania');
    }
   /* public function seleccionar($compania='', $default="")
    {
        $nombre_defecto = $default==""?":: Seleccione ::":$default;
        $arreglo = array(''=>$nombre_defecto);
        $listado    = $this->listar($compania);
        if(count($listado)>0){
            foreach($listado as $indice=>$valor){
                $indice1   = $valor->ALMAP_Codigo;
                $valor1    = $valor->EESTABC_Descripcion.' - '.$valor->ALMAC_Descripcion;
                $arreglo[$indice1] = $valor1;
            }
        }
        return $arreglo;
        
    }*/
    
    public function update($id) {
        
        $where = array("PROD_Codigo" => $id);
        $data = array("FAMI_Codigo" => 501);
        $this->db->where($where);
        $result = $this->db->update("cji_producto", $data);
        
        return $result;
    }
    
    
    
      public function seleccionar($compania='')
    {
       
        $listado    = $this->listar($compania);

        if(count($listado) > 0){
            foreach($listado as $indice=>$valor){
                $indice1   = $valor->ALMAP_Codigo;
                $valor1    = $valor->EESTABC_Descripcion.' - '.$valor->ALMAC_Descripcion;
                $arreglo[$indice1] = $valor1;
            }
        }
        return $arreglo;
        
    }
    
    
    public function seleccionar_general($default="")
    {
        $nombre_defecto = $default==""?":: Seleccione ::":$default;
        $arreglo = array(''=>$nombre_defecto);
        foreach($this->listar_general() as $indice=>$valor)
        {
            $indice1   = $valor->ALMAP_Codigo;
            $valor1    = $valor->EESTABC_Descripcion.' - '.$valor->ALMAC_Descripcion;
            $arreglo[$indice1] = $valor1;
        }
        return $arreglo;
    }
	//--------------------------------------------------------
	 
	   public function seleccionar_destino($compania='', $default="")
    {
        $nombre_defecto = $default==""?":: Seleccione ::":$default;
        $arreglo = array('0'=>$nombre_defecto);
        $listado    = $this->listar2($compania);
        if(count($listado)>0){
            foreach($listado as $indice=>$valor){
                $indice1   = $valor->ALMAP_Codigo;
                $valor1    = $valor->EESTABC_Descripcion.' - '.$valor->ALMAC_Descripcion;
                $arreglo[$indice1] = $valor1;
            }
        }
        return $arreglo;
        
    }
	  public function listar2($empresa, $number_items='',$offset='' )
    {   
       
        $this->db->select('*, cji_emprestablecimiento.EESTABC_Descripcion');
        $this->db->from('cji_almacen',$number_items,$offset);
        $this->db->join('cji_tipoalmacen','cji_tipoalmacen.TIPALMP_Codigo=cji_almacen.TIPALM_Codigo');
        $this->db->join('cji_emprestablecimiento','cji_emprestablecimiento.EESTABP_Codigo=cji_almacen.EESTABP_Codigo');
        $this->db->where('cji_almacen.ALMAC_FlagEstado',1);
        $this->db->where('cji_emprestablecimiento.EMPRP_Codigo',$empresa);
        $this->db->where_not_in('cji_almacen.ALMAP_Codigo','0');
        $this->db->order_by('cji_almacen.ALMAC_Descripcion');
        $query = $this->db->get();
        if($query->num_rows>0){
           return $query->result();
        }
    }
	 

    public function obtenerStockAlmacen($compania, $almacen, $producto)
    {
        $query = $this->db->select('ALMPROD_Codigo, ALMPROD_STOCK, ALMPROD_CostoPromedio')
                        ->from('cji_almacenproducto')
                        ->where('COMPP_Codigo', $compania)
                        ->where('ALMAC_Codigo', $almacen)
                        ->where('PROD_Codigo', $producto)
                        ->get();
        if($query->num_rows > 0){
            return $query->row();
        }else{
            return NULL;
        }
    }
	
	
	
	//------------------------------------------------------------
    public function listar($compania='', $number_items='',$offset='' )
    {   
        $compania = $compania != '' ? $compania : $this->somevar['compania'];

        $this->db->select('*, cji_emprestablecimiento.EESTABC_Descripcion');
        $this->db->from('cji_almacen',$number_items,$offset);
        $this->db->join('cji_tipoalmacen','cji_tipoalmacen.TIPALMP_Codigo=cji_almacen.TIPALM_Codigo');
        $this->db->join('cji_emprestablecimiento','cji_emprestablecimiento.EESTABP_Codigo=cji_almacen.EESTABP_Codigo');
        $this->db->where('cji_almacen.ALMAC_FlagEstado',1);
        $this->db->where('cji_almacen.COMPP_Codigo ',$compania);
        $this->db->where_not_in('cji_almacen.ALMAP_Codigo','0');
        $this->db->order_by('cji_almacen.ALMAC_Descripcion');
        $query = $this->db->get();
        if($query->num_rows>0){
           return $query->result();
        }
    }

    public function cargarAlmacenesPorCompania($compania){
        $this->db->select('*, cji_emprestablecimiento.EESTABC_Descripcion');
        $this->db->from('cji_almacen');
        $this->db->join('cji_tipoalmacen','cji_tipoalmacen.TIPALMP_Codigo=cji_almacen.TIPALM_Codigo');
        $this->db->join('cji_emprestablecimiento','cji_emprestablecimiento.EESTABP_Codigo=cji_almacen.EESTABP_Codigo');
        $this->db->where('cji_almacen.ALMAC_FlagEstado',1);
        $this->db->where('cji_almacen.COMPP_Codigo ',$compania);
        $this->db->where_not_in('cji_almacen.ALMAP_Codigo','0');
        $this->db->order_by('cji_almacen.ALMAC_Descripcion');
        $query = $this->db->get();
        if($query->num_rows>0){
            return $query->result();
        }else{
            return FALSE;
        }
    }

    public function listar_general($number_items='',$offset='') // Lista todos los almacenes de todas los establecimientos
    {
        $this->db->select('*, cji_emprestablecimiento.EESTABC_Descripcion');
        $this->db->from('cji_almacen',$number_items,$offset);
        $this->db->join('cji_tipoalmacen','cji_tipoalmacen.TIPALMP_Codigo=cji_almacen.TIPALM_Codigo');
        $this->db->join('cji_emprestablecimiento','cji_emprestablecimiento.EESTABP_Codigo=cji_almacen.EESTABP_Codigo');
        $this->db->where('cji_almacen.ALMAC_FlagEstado',1);
        $this->db->where_not_in('cji_almacen.ALMAP_Codigo','0');
        $this->db->order_by('cji_almacen.ALMAC_Descripcion');
        $query = $this->db->get();
        if($query->num_rows>0){
           return $query->result();
        }
    }
    public function buscar_x_establec($establec)
    {
        $where = array("EESTABP_Codigo"=>$establec, "ALMAC_FlagEstado"=>"1");
        $query = $this->db->order_by('ALMAC_Descripcion')->where($where)->get('cji_almacen');
        if($query->num_rows>0)
            return $query->result();
        else
            return array();
        
    }
    public function buscar_x_compania($compania)
    {
        $where = array("COMPP_Codigo"=>$compania, "ALMAC_FlagEstado"=>"1");
        $query = $this->db->order_by('ALMAC_Descripcion')->where($where)->get('cji_almacen');
        if($query->num_rows>0)
            return $query->result();
        else
            return array();
        
    }
    
    public function obtener($id)
    {
        $where = array("ALMAP_Codigo"=>$id);
        $query = $this->db->order_by('ALMAC_Descripcion')->where($where)->get('cji_almacen',1);
        if($query->num_rows>0)
            return $query->result();
        else
            return array();
    }

    public function insertar(stdClass $filter = null)
    {
        $this->db->insert("cji_almacen",(array)$filter);
    }
    public function modificar($id,$filter)
    {
        $this->db->where("ALMAP_Codigo",$id);
        $this->db->update("cji_almacen",(array)$filter);
    }
    public function eliminar($id)
    {
        $this->db->delete('cji_almacen',array('ALMAP_Codigo' => $id));
    }
	//--------------------------------
	 public function eliminar_x_establecimiento($establecimiento)
    {
        //$this->db->delete('cji_almacen',array('EESTABP_Codigo' => $establecimiento));
		$data = array('ALMAC_FlagEstado' => 0  );
		$this->db->where('EESTABP_Codigo', $establecimiento);
		$this->db->update('cji_almacen', $data); 
	}
	//-----------------------
    public function buscar($filter,$number_items='',$offset='')
    {
        $this->db->select('cji_almacen.*, e.EESTABC_Descripcion, t.TIPALM_Descripcion');
        $this->db->join('cji_tipoalmacen','cji_tipoalmacen.TIPALMP_Codigo=cji_almacen.TIPALM_Codigo');
        $this->db->where('cji_almacen.COMPP_Codigo',$this->somevar['compania']);
        if(isset($filter->ALMAC_Descripcion) && $filter->ALMAC_Descripcion!="")
            $this->db->like('cji_almacen.ALMAC_Descripcion',$filter->ALMAC_Descripcion);
        if(isset($filter->TIPALM_Codigo) && $filter->TIPALM_Codigo!="")
            $this->db->like('cji_almacen.TIPALM_Codigo',$filter->TIPALM_Codigo);
        $query = $this->db->join('cji_emprestablecimiento e','e.EESTABP_Codigo=cji_almacen.EESTABP_Codigo')
                          ->join('cji_tipoalmacen t','t.TIPALMP_Codigo=cji_almacen.TIPALM_Codigo')
                          ->get('cji_almacen', $number_items='',$offset='');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                    $data[] = $fila;
            }
            return $data;
        }
    }
}
?>