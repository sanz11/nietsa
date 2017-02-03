<?php
class Proyecto_model extends model {
    var $somevar;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->somevar['user'] = $this->session->userdata('user');
    }
	public function listar_proyectos(){
        $where = array("PROYC_FlagEstado"=>1);
        $query = $this->db->order_by('PROYC_Nombre')
                          ->where($where)
                          ->select('PROYP_Codigo,PROYC_Nombre,PROYC_Descripcion,DIREP_Codigo')
                          ->from('cji_proyecto')
                          ->get();
        if($query->num_rows()>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
 }

	public function obtener_datosProyecto($proyecto){
        $query = $this->db->where('PROYP_Codigo',$proyecto)->get('cji_proyecto');
        if($query->num_rows()>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    
    public function obtener_direccion($proyecto){
    	$query = $this->db->where('PROYP_Codigo',$proyecto)->get('cji_direccion');
    	if($query->num_rows>0){
    		foreach($query->result() as $fila){
    			$data[] = $fila;
    		}
    		return $data;
    	}
    }
    
    
    public function insertar_datosProyecto($nombreProyecto,$descpProyecto,$fechai,$fechaf,$cbo_clientes)
    {
        $usuario =$this->somevar['user'];        
        $data = array(
                    "PROYC_Nombre"       => strtoupper($nombreProyecto),
                    "PROYC_Descripcion"  => strtoupper($descpProyecto),
                    "PROYC_FechaInicio"  => $fechai,
                    "PROYC_FechaFin"     => $fechaf,
                    "EMPRP_Codigo"       => $cbo_clientes,
                    "PROYC_CodigoUsuario"  =>  $usuario
                   );
       $this->db->insert("cji_proyecto",$data);
       return $this->db->insert_id();
    }
    
    public function insertar_direccion($filter){
    	$data = array(
    			"DIRECC_Descrip"       => $filter -> DIRECC_Descrip,
    			"DIRECC_Referen"       => $filter -> DIRECC_Referen,
    			"DIRECC_Mapa" 		   => $filter -> DIRECC_Mapa,
    			"DIRECC_StreetView"    => $filter -> DIRECC_StreetView,
    			"UBIGP_Domicilio"      => $filter -> UBIGP_Domicilio,
    			"PROYP_Codigo"         => $filter -> PROYP_Codigo,
    			"DIRECC_FlagEstado"    => '1'         
    			);
    	$this->db->insert("cji_direccion",$data);
    	return $this->db->insert_id();
    }
    
 	public function modificar_datosProyecto($proyecto,$nombreProyecto,$descpProyecto,$cbo_clientes,$fechai,$fechaf)
             {
      $data = array(
                    "PROYC_Nombre"       =>$nombreProyecto,
                    "PROYC_Descripcion"  =>$descpProyecto,
                    "EMPRP_Codigo"       =>$cbo_clientes,
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
    
    public function listar_detalle($proyecto)
    {
    	$where = array("PROYP_Codigo"=>$proyecto , "DIRECC_FlagEstado" => '1' );
    	$query = $this->db->order_by('PROYP_Codigo')->where($where)->get('cji_direccion');
    	if($query->num_rows()>0){
    		foreach($query->result() as $fila){
    			$data[] = $fila;
    		}
    		return $data;
    	}
    }
    
    public function obtener_usuario_terminal($usu){
    	$query = $this->db->where('USUA_Codigo',$usu)->get('cji_usuario_terminal');
    	if($query->num_rows>0){
    		foreach($query->result() as $fila){
    			$data[] = $fila;
    		}
    		return $data;
    	}
    }
    
    public function obtener_terminal($terminal){
    	$query = $this->db->where('TERMINAL_Codigo',$terminal)->get('cji_terminal');
    	if($query->num_rows()>0){
    		foreach($query->result() as $fila){
    			$data[] = $fila;
    		}
    		return $data;
    	}
    }
    
    public function obtener_direccion_proyecto($direccion){
    	$query = $this->db->where('DIRECC_Codigo',$direccion)->get('cji_direccion');
    	if($query->num_rows()>0){
    		foreach($query->result() as $fila){
    			$data[] = $fila;
    		}
    		return $data;
    	}
    }
    
    public function listar_detalle_terminal($direccionCodigo,$total="",$inicio="")
    {
    	$where = array("DIRECC_Codigo"=>$direccionCodigo , "TERMINAL_FlagEstado" => '1' );
    	$query = $this->db->order_by('DIRECC_Codigo')->where($where)->get('cji_terminal',$total='',$inicio='');
    	if($query->num_rows()>0){
    		foreach($query->result() as $fila){
    			$data[] = $fila;
    		}
    		return $data;
    	}
    	
    }
    
    public function eliminar_direccion($valor)
    {
    	$data  = array("DIRECC_FlagEstado"=>'0');
    	$where = array("DIRECC_Codigo"=>$valor);
    	$this->db->where($where);
    	$this->db->update('cji_direccion',$data);
    }
    
    public function modificar_direccion($valor ,$filter)
    	{
    	  $where = array("DIRECC_Codigo"=>$valor);
    	  $this->db->where($where);
    	  $this->db->update('cji_direccion',(array)$filter);
    	}
  	 }

  	 
  	 

  	 
?>