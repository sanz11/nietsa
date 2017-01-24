<?php
class Movimiento_model extends Model
{
    var $somevar;
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['user'] = $this->session->userdata('user');
        $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
    }
    
public function listCajatotal(){
	$sql = "select DISTINCT CAJA_Codigo, CAJA_Nombre from cji_caja where CAJA_FlagEstado = 1
			and tipCa_codigo not in(0)";
	$query = $this->db->query($sql);
    if ($query->num_rows > 0) {
        foreach ($query->result() as $fila) {
            $data[] = $fila;
        }
        return $data;
        }
}

public function listCaja($filter){
	$sql = "select DISTINCT caja.CAJA_Codigo, CAJA_Nombre from cji_caja caja where caja.CAJA_Codigo = $filter 
			and CAJA_FlagEstado = 1";
	$query = $this->db->query($sql);
	if ($query->num_rows > 0) {
		foreach ($query->result() as $fila) {
			$data[] = $fila;
		}
		return $data;
	}
}

public function getDatosEmpresa($nombre){
$this->db->select(' cli.CLIP_Codigo,emp.EMPRP_Codigo, emp.EMPRC_Ruc,
                    emp.EMPRC_RazonSocial');
    $this->db->from('cji_clientecompania cc','INNER');
    $this->db->join('cji_cliente cli','cli.CLIP_Codigo=cc.CLIP_Codigo');
    $this->db->join('cji_empresa emp','cli.EMPRP_Codigo=emp.EMPRP_Codigo');
    $this->db->where('cli.CLIC_TipoPersona',1); 
    $this->db->where('cli.CLIC_FlagEstado',"1");
    $this->db->like('EMPRC_RazonSocial',$nombre);
    $query= $this->db->get();
    if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
 } 
}


public function buscar_movimiento($filter){
    	$sql = "SELECT DISTINCT cji_caja.CAJA_Codigo, cji_caja.CAJA_Nombre FROM `cji_caja` 
    			INNER JOIN `cji_usuario` ON cji_caja.USUA_Codigo = cji_usuario.USUA_Codigo 
    			INNER JOIN `cji_persona` ON cji_usuario.PERSP_Codigo = cji_persona.PERSP_Codigo 
    			WHERE cji_persona.PERSC_Nombre LIKE '%".$filter->PERSC_Nombre."%'
    			AND cji_caja.CAJA_FlagEstado = '1'";
    	$query = $this->db->query($sql);
    	if ($query->num_rows > 0) {
    		foreach ($query->result() as $fila) {
    			$data[] = $fila;
    		}
    		return $data;
    	}
    }
    
	public function listar_cajas(){
        $where = array("CAJA_FlagEstado"=>1);
        $query = $this->db->order_by('CAJA_Nombre')
                          ->where($where)
                          ->select('CAJA_Codigo,CAJA_Nombre,CAJA_tipo,tipCa_codigo')
                          ->from('cji_caja')
                          ->get();
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
 	}
 	
 	public function listar_tipoCaja()
 	{
 		$where = array("tipCa_FlagEstado" => '1' );
 		$query = $this->db->order_by('tipCa_codigo')->where($where)->get('cji_tipocaja');
 		if($query->num_rows>0){
 			foreach($query->result() as $fila){
 				$data[] = $fila;
 			}
 			return $data;
 		}
 	}
 	
 
 	public function listar_cuenta($compania)
 	{
 		$where = array("EMPRE_Codigo"=>$compania , "CUENT_FlagEstado" => '1' );
 		$query = $this->db->order_by('CUENT_Codigo')->where($where)->get('cji_cuentasempresas');
 		if($query->num_rows>0){
 			foreach($query->result() as $fila){
 				$data[] = $fila;
 			}
 			return $data;
 		}
 	}
 	
 	
 	public function listar_cuenta_banco($banco)
 	{
 		$compania =$this->somevar ['compania'];
 		$where = array("BANP_Codigo"=>$banco , "EMPRE_Codigo"=>$compania, "CUENT_FlagEstado" => '1' );
 		$query = $this->db->order_by('CUENT_Codigo')->where($where)->get('cji_cuentasempresas');
 		if($query->num_rows>0){
 			foreach($query->result() as $fila){
 				$data[] = $fila;
 			}
 			return $data;
 		}
 	} 	

 	
 	public function listar_banco_cuenta($banco)
 	{   
 		$where = array("BANC_FlagEstado"=>"1", "BANP_Codigo" => $banco);
 		$query = $this->db->order_by('BANC_Nombre')->where($where)->get('cji_banco');
 		if($query->num_rows>0)
 		  {
 			return $query->result();
 		  }
 	}
 	
 	public function obtener_numeroSerie($serie){
 		$query = $this->db->where('CHEK_Codigo',$serie)->get('cji_chekera');
 		if($query->num_rows>0){
 			foreach($query->result() as $fila){
 				$data[] = $fila;
 			}
 			return $data;
 		}
 	}
 	
 	public function obtener_chequera($cuenta){
 		$query = $this->db->where('CUENT_Codigo',$cuenta)->get('cji_chekera');
 		if($query->num_rows>0){
 			foreach($query->result() as $fila){
 				$data[] = $fila;
 			}
 			return $data;
 		}
 	}
 	
 	public function obtener_chequeraCodigo($chequera){
 		$query = $this->db->where('CHEK_Codigo',$chequera)->get('cji_chekera');
 		if($query->num_rows>0){
 			foreach($query->result() as $fila){
 				$data[] = $fila;
 			}
 			return $data;
 		}
 	}
 	
 	public function obtener_cuenta_caja($caja){
 		$query = $this->db->where('CAJA_Codigo',$caja)->get('cji_caja_cuenta');
 		if($query->num_rows>0){
 			foreach($query->result() as $fila){
 				$data[] = $fila;
 			}
 			return $data;
 		}
 	}
 	
 	public function obtener_cuenta_chequera($caja){
 		$query = $this->db->where('CAJA_Codigo',$caja)->get('cji_caja_chekera');
 		if($query->num_rows>0){
 			foreach($query->result() as $fila){
 				$data[] = $fila;
 			}
 			return $data;
 		}
 	}
 	
 	public function listar_chequera($cuenta)
 	{
 		$where = array("CHEK_FlagEstado"=>"1");
 		$query = $this->db
 					  ->order_by('SERIP_Codigo')
 					  ->where_in("CUENT_Codigo",$cuenta)
 					  ->where($where)
 					  ->get('cji_chekera');
 		if($query->num_rows>0)
 		{
 			return $query->result();
 		}
 	}
 	
 	public function listar_moneda_cuenta($cuenta)
 	{
 		$where = array("MONED_FlagEstado"=>"1", "MONED_Codigo" => $cuenta);
 		$query = $this->db->order_by('MONED_Descripcion')->where($where)->get('cji_moneda');
 		if($query->num_rows>0)
 		{
 			return $query->result();
 		}
 	}
 	
 	
 	
 	public function obtener_datosCuenta($cuenta){
 		$query = $this->db->where('CUENT_Codigo',$cuenta)->get('cji_cuentasempresas');
 		if($query->num_rows>0){
 			foreach($query->result() as $fila){
 				$data[] = $fila;
 			}
 			return $data;
 		}
 	}
 	
 	
 	public function obtener_datosCuenta_banco($compania){
 		$query = $this->db->where('EMPRE_Codigo',$compania)->get('cji_cuentasempresas');
 		if($query->num_rows>0){
 			foreach($query->result() as $fila){
 				$data[] = $fila;
 			}
 			return $data;
 		}
 	}
 	
 	public function obtener_datosCaja($caja){
 		$query = $this->db->where('CAJA_Codigo',$caja)->get('cji_caja');
 		if($query->num_rows>0){
 			foreach($query->result() as $fila){
 				$data[] = $fila;
 			}
 			return $data;
 		}
 	}
 	
 	public function obtener_datosTipoCaja($caja){
 		$query = $this->db->where('tipCa_codigo',$caja)->get('cji_tipocaja');
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
    
    public function obtener_direccion($proyecto){
    	$query = $this->db->where('PROYP_Codigo',$proyecto)->get('cji_direccion');
    	if($query->num_rows>0){
    		foreach($query->result() as $fila){
    			$data[] = $fila;
    		}
    		return $data;
    	}
    }
    
    
    public function insertar_datosCaja($nombreCaja,$cboTipCaja,$tipo_caja,$cboResponsable,$observaciones)
    {
        $usuario =$this->somevar ['user'];        
        $data = array(
                    "CAJA_Nombre"        => strtoupper($nombreCaja),
        			"CAJA_Observaciones" => strtoupper($observaciones),
                    "tipCa_codigo"  	 => $cboTipCaja,
                    "CAJA_tipo"      	 => $tipo_caja,
        			"USUA_Codigo"     	 => $cboResponsable,
        			"CAJA_FlagEstado"    => '1',
                    "CAJA_CodigoUsuario" =>  $usuario
                   );
       $this->db->insert("cji_caja",$data);
       return $this->db->insert_id();
    }
    
    public function modificar_datosCaja($codigo,$nombreCaja,$cboTipCaja,$tipo_caja,$cboResponsable,$observaciones)
    {
    	
    	$data = array(
    			"CAJA_Codigo"        => $codigo,
    			"CAJA_Nombre"        => strtoupper($nombreCaja),
    			"CAJA_Observaciones" => strtoupper($observaciones),
    			"tipCa_codigo"  	 => $cboTipCaja,
    			"CAJA_tipo"      	 => $tipo_caja,
    			"USUA_Codigo"     	 => $cboResponsable
    	);
    	$this->db->where("CAJA_Codigo",$codigo);
    	$this->db->update("cji_caja",$data);
    }
    
    public function insertar_cuenta($filter){
    	$data = array(
    			"CAJA_Codigo"         => $filter -> CAJA_Codigo,
    			"CUENT_Codigo"        => $filter -> CUENT_Codigo,
    			"TIPOING_Codigo" 	  => $filter -> TIPOING_Codigo,
    			"CAJCUENT_LIMITE"     => $filter -> CAJCUENT_LIMITE,
    			"CAJCUENT_FlagEstado" => '1'         
    			);
    	$this->db->insert("cji_caja_cuenta",$data);
    	return $this->db->insert_id();
    }
    
    public function modificar_cuenta($valor ,$filter)
    {
    	$where = array("CAJCUENT_Codigo"=>$valor);
    	$this->db->where($where);
    	$this->db->update('cji_caja_cuenta',(array)$filter);
    }
    
    public function eliminar_cuenta($valor)
    {
    	$data  = array("CAJCUENT_FlagEstado"=>'0');
    	$where = array("CAJCUENT_Codigo"=>$valor);
    	$this->db->where($where);
    	$this->db->update('cji_caja_cuenta',$data);
    }
    
    public function insertar_chekera($filter){
    	$data = array(
    			"CAJCHEK_Descripcion"  => $filter -> CAJCHEK_Descripcion,
    			"CAJA_Codigo"          => $filter -> CAJA_Codigo,
    			"CHEK_Codigo"          => $filter -> CHEK_Codigo,
    			"CAJCHEK_FlagEstado"   => '1'
    	);
    	$this->db->insert("cji_caja_chekera",$data);
    	return $this->db->insert_id();
    }
    
    public function modificar_chekera($valor ,$filter)
    {
    	$where = array("CAJCHEK_Codigo"=>$valor);
    	$this->db->where($where);
    	$this->db->update('cji_caja_chekera',(array)$filter);
    }
    
    public function eliminar_chekera($valor)
    {
    	$data  = array("CAJCHEK_FlagEstado"=>'0');
    	$where = array("CAJCHEK_Codigo"=>$valor);
    	$this->db->where($where);
    	$this->db->update('cji_caja_chekera',$data);
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

    
   public function eliminar_caja($caja)
    {
        $data  = array("CAJA_FlagEstado"=>'0');
        $where = array("CAJA_Codigo"=>$caja);
        $this->db->where($where);
        $this->db->update('cji_caja',$data);
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
    	if($query->num_rows>0){
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
    	
    	public function comboBancoTipoCliente($filter){
    		$sql = "select CLIC_TipoPersona from cji_cliente clie where clie.CLIP_Codigo = $filter";
    	
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	
    	}
    	
    	public function comboBanco($filter){
    		$sql = "select DISTINCT BANC_Nombre ,clie.CLIP_Codigo ,banco.BANP_Codigo ,empre.EMPRP_Codigo from cji_cuentasempresas cuem
    		inner join cji_empresa empre on cuem.EMPRE_Codigo = empre.EMPRP_Codigo
    		inner join cji_banco banco on cuem.BANP_Codigo = banco.BANP_Codigo
    		inner join cji_cliente clie on clie.EMPRP_Codigo = cuem.EMPRE_Codigo
    		where CLIP_Codigo = $filter";
    		
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    		
    	}
    	
    	public function comboBancoClienteNatural($filter){
    		$sql = "select DISTINCT BANC_Nombre ,clie.CLIP_Codigo ,banco.BANP_Codigo,perso.PERSP_Codigo from cji_cuentasempresas cuem
    		inner join cji_persona perso on perso.PERSP_Codigo = cuem.PERSP_Codigo
    		inner join cji_banco banco on cuem.BANP_Codigo = banco.BANP_Codigo
    		inner join cji_cliente clie on clie.PERSP_Codigo = perso.PERSP_Codigo
    		where CLIP_Codigo = $filter;";
    	
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	
    	}
    	
    	public function comboBancoTipoProveedor($filter){
    		$sql = "select PROVC_TipoPersona from cji_proveedor pro where pro.PROVP_Codigo = $filter";
    		 
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    		 
    	}
    	
    	public function comboBancoProveedor($filter){
    		$sql="select DISTINCT BANC_Nombre ,prove.PROVP_Codigo ,banco.BANP_Codigo,empre.EMPRP_Codigo from cji_cuentasempresas cuem
    		inner join cji_empresa empre on cuem.EMPRE_Codigo = empre.EMPRP_Codigo
    		inner join cji_banco banco on cuem.BANP_Codigo = banco.BANP_Codigo
    		inner join cji_proveedor prove on prove.EMPRP_Codigo = cuem.EMPRE_Codigo
    		where prove.PROVP_Codigo = $filter";
    		$query = $this->db->query($sql);
    		if($query->num_rows >0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function comboBancoProveedorNatural($filter){
    		$sql="select DISTINCT BANC_Nombre ,prove.PROVP_Codigo ,banco.BANP_Codigo ,persona.PERSP_Codigo from cji_cuentasempresas cuem
		    		inner join cji_persona persona on cuem.PERSP_Codigo = persona.PERSP_Codigo
		    		inner join cji_banco banco on cuem.BANP_Codigo = banco.BANP_Codigo
		    		inner join cji_proveedor prove on prove.PERSP_Codigo = cuem.PERSP_Codigo
		    		where prove.PROVP_Codigo = $filter";
    		$query = $this->db->query($sql);
    		if($query->num_rows >0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function comboBancoDirectivo($filter){
    		$sql="select DISTINCT BANC_Nombre ,direc.DIREP_Codigo ,banco.BANP_Codigo ,per.PERSP_Codigo from cji_cuentasempresas cuem
    		inner join cji_persona per on per.PERSP_Codigo = cuem.PERSP_Codigo
    		inner join cji_banco banco on cuem.BANP_Codigo = banco.BANP_Codigo
    		inner join cji_directivo direc on direc.PERSP_Codigo = cuem.PERSP_Codigo
    		where per.PERSP_Codigo = $filter and PERSC_FlagEstado = 1";
    		
    		$query = $this->db->query($sql);
    		if($query->num_rows >0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function comboBancoCaja($filter){
    		$sql="select DISTINCT BANC_Nombre ,caja.CAJA_Codigo ,banco.BANP_Codigo from cji_cuentasempresas cuem
    		inner join cji_caja_cuenta cajacuenta on cajacuenta.CUENT_Codigo = cuem.CUENT_Codigo
    		inner join cji_banco banco on  cuem.BANP_Codigo = banco.BANP_Codigo 
    		inner join cji_caja caja on caja.CAJA_Codigo = cajacuenta.CAJA_Codigo
    		where caja.CAJA_Codigo = $filter and caja.CAJA_FlagEstado = 1;";
    	
    		$query = $this->db->query($sql);
    		if($query->num_rows >0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function SeleccionarCuentaProveedor($filter,$filter1){
    		$sql = "select * from cji_cuentasempresas cuentaempresa inner join cji_banco banco on cuentaempresa.BANP_Codigo = banco.BANP_Codigo
					inner join cji_empresa empresa on  cuentaempresa.EMPRE_Codigo = empresa.EMPRP_Codigo
					inner join cji_proveedor prove on  prove.EMPRP_Codigo = empresa.EMPRP_Codigo
					where prove.PROVP_Codigo = $filter1 and banco.BANP_Codigo = $filter ";
    		 
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function SeleccionarCuentaCliente($filter,$filter1){
    		$sql = "select * from cji_cuentasempresas cuentaempre inner join cji_banco banco
			    	on cuentaempre.BANP_Codigo = banco.BANP_Codigo where cuentaempre.BANP_Codigo = $filter
			    	and EMPRE_Codigo = $filter1 ";
    		 
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	
    	public function comboCuentaProve($filter,$filter1){
    		$sql = "select * from cji_cuentasempresas cuentaempresa inner join cji_banco banco on cuentaempresa.BANP_Codigo = banco.BANP_Codigo
					inner join cji_empresa empresa on  cuentaempresa.EMPRE_Codigo = empresa.EMPRP_Codigo
					inner join cji_proveedor prove on  prove.EMPRP_Codigo = empresa.EMPRP_Codigo
					where prove.PROVP_Codigo = $filter1 and banco.BANP_Codigo = $filter";
    	
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	
    	}
    	
    	public function comboCuentaProveedorNatural($filter,$filter1){
    		$sql = "select * from cji_cuentasempresas cuentaempresa 
					inner join cji_banco banco on cuentaempresa.BANP_Codigo = banco.BANP_Codigo
					inner join cji_persona persona on  cuentaempresa.PERSP_Codigo = persona.PERSP_Codigo
					inner join cji_proveedor prove on  prove.PERSP_Codigo = persona.PERSP_Codigo
					where prove.PROVP_Codigo = $filter1 and banco.BANP_Codigo = $filter";
    		 
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    		 
    	}
    	
    	public function comboCuenta($filter,$filter1){
    		$sql = "SELECT DISTINCT CUENT_NumeroEmpresa , CUENT_Codigo , banco.BANC_Nombre
					FROM cji_cuentasempresas cuemp 
					inner join cji_banco banco on cuemp.BANP_Codigo = banco.BANP_Codigo 
					inner join cji_cliente cliente on cliente.EMPRP_Codigo = cuemp.EMPRE_Codigo
					where banco.BANP_Codigo = $filter and cliente.CLIP_Codigo = $filter1 ";
    		 
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    		 
    	}
    	
    	public function comboCuentaClienteNatural($filter,$filter1){
    		$sql = "SELECT DISTINCT CUENT_NumeroEmpresa , CUENT_Codigo FROM cji_cuentasempresas cuemp inner join cji_banco banco 
    				on cuemp.BANP_Codigo = banco.BANP_Codigo inner join cji_persona persona 
    				on persona.PERSP_Codigo = cuemp.PERSP_Codigo where banco.BANP_Codigo = $filter
						and persona.PERSP_Codigo = $filter1
						";
    		 
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    		 
    	}
    	
    	public function comboCuentaDirectivo($filter,$filter1){
    		$sql="SELECT DISTINCT CUENT_NumeroEmpresa , CUENT_Codigo
 					FROM cji_cuentasempresas cuemp inner join cji_banco banco 
    				on cuemp.BANP_Codigo = banco.BANP_Codigo inner join cji_persona per
    				on per.PERSP_Codigo = cuemp.PERSP_Codigo where banco.BANP_Codigo = $filter
						and per.PERSP_Codigo = $filter1
						and PERSC_FlagEstado = 1";
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    		
    	}
    	
    	
    	public function comboCuentaCaja($filter,$filter1){
    		$sql="select DISTINCT CUENT_NumeroEmpresa ,cuem.CUENT_Codigo from cji_cuentasempresas cuem
    		inner join cji_caja_cuenta cajacuenta on cajacuenta.CUENT_Codigo = cuem.CUENT_Codigo
    		inner join cji_banco banco on  cuem.BANP_Codigo = banco.BANP_Codigo 
    		inner join cji_caja caja on caja.CAJA_Codigo = cajacuenta.CAJA_Codigo
    		where banco.BANP_Codigo = $filter
				and caja.CAJA_Codigo = $filter1
				and caja.CAJA_FlagEstado = 1;";
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	
    	}
    	
    	public function obtenerCuenta($filter){
    		$sql="SELECT * FROM  cji_cuentasempresas cuempre inner join cji_banco banco
				  on cuempre.BANP_Codigo = banco.BANP_Codigo inner join cji_moneda moneda
				  on moneda.MONED_Codigo = cuempre.MONED_Codigo where cuempre.CUENT_NumeroEmpresa='$filter'";
    		
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	
    	
    	
    	public function insertar_responsablevimiento($filter=null){
    		 
    			$this->db->insert("cji_reponsblmoviminto", (array) $filter);
    			$CajaMOvimiento = $this->db->insert_id();
    			return $CajaMOvimiento;
    		
    	}
    	
    	
    	public function buscar_cajamovimiento($filter,$filter1){
    		$sql="SELECT * FROM  cji_reponsblmoviminto where (DIREP_Codigo = $filter or CLIP_Codigo = $filter 
    		or PROVP_Codigo = $filter or CAJA_Codigo = $filter) and RESPNMOV_TipBenefi = '$filter1'";
    		
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function insertar_cajamovimiento($filter=null){
    		$this->db->insert("cji_cajamovimiento", (array) $filter);
    		$CajaMOvimiento = $this->db->insert_id();
    		return $CajaMOvimiento;
    	}
    	
    	
    	
    	public function combo_cajanuevo($number_items = '', $offset = '') {
    		$usuario =$this->somevar ['user'];
    		
    		$sql="select DISTINCT caja.CAJA_Codigo,CAJA_Nombre
				from cji_caja caja inner join cji_cajamovimiento cajamovi 
				on caja.CAJA_Codigo = cajamovi.CAJA_Codigo where CAJA_CodigoUsuario = $usuario ";
    		
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function listaDeCajaCod_Estado($codigo,$estado,$number_items = '', $offset = '') {
    		$sql="select caja_nombre,CAJAMOV_Monto_G,CAJAMOV_Monto_B,cajamov_fechaSistema,MONED_Codigo_B,MONED_Codigo_G ,CAJAMOV_FlagEstado,
    		CUNTCONTBL_Codigo_G ,CUNTCONTBL_Codigo_B,CAJAMOV_MovDinero,CAJAMOV_Codigo
    		from cji_caja caja inner join cji_cajamovimiento cajamovi
    		on caja.CAJA_Codigo = cajamovi.CAJA_Codigo where cajamovi.CAJA_Codigo =  $codigo
    		and  CAJAMOV_FlagEstado = $estado; ";
    		
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function listaDeCajaCod_Estado3($codigo,$number_items = '', $offset = '') {
    		$sql="select caja_nombre,CAJAMOV_Monto_G,CAJAMOV_Monto_B,cajamov_fechaSistema,MONED_Codigo_B,MONED_Codigo_G ,CAJAMOV_FlagEstado,
    		CUNTCONTBL_Codigo_G ,CUNTCONTBL_Codigo_B,CAJAMOV_MovDinero,CAJAMOV_Codigo
    		from cji_caja caja inner join cji_cajamovimiento cajamovi
    		on caja.CAJA_Codigo = cajamovi.CAJA_Codigo where cajamovi.CAJA_Codigo =  $codigo; ";
    	
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function listarnombrecaja_codigo($filter, $number_items = '', $offset = ''){
    		$sql="select caja_nombre,CAJAMOV_Monto_G,CAJAMOV_Monto_B,cajamov_fechaSistema,MONED_Codigo_B,MONED_Codigo_G ,CAJAMOV_FlagEstado,
			CUNTCONTBL_Codigo_G ,CUNTCONTBL_Codigo_B,CAJAMOV_MovDinero,CAJAMOV_Codigo
				from cji_caja caja inner join cji_cajamovimiento cajamovi 
				on caja.CAJA_Codigo = cajamovi.CAJA_Codigo where cajamovi.CAJA_Codigo =  $filter
    			and  CAJAMOV_FlagEstado = 1; ";
    		
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function listaEstado_cajamovi($filter,$number_items = '', $offset = ''){
    		$sql="select caja_nombre,CAJAMOV_Monto_G,CAJAMOV_Monto_B,cajamov_fechaSistema,MONED_Codigo_B,MONED_Codigo_G ,CAJAMOV_FlagEstado,
			CUNTCONTBL_Codigo_G ,CUNTCONTBL_Codigo_B,CAJAMOV_MovDinero,CAJAMOV_Codigo
				from cji_caja caja inner join cji_cajamovimiento cajamovi 
				on caja.CAJA_Codigo = cajamovi.CAJA_Codigo where CAJAMOV_FlagEstado = $filter;";
    		
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function listaEstadoTotal_cajamovi($number_items = '', $offset = ''){
    		$sql="select caja_nombre,CAJAMOV_Monto_G,CAJAMOV_Monto_B,cajamov_fechaSistema,MONED_Codigo_B,MONED_Codigo_G ,CAJAMOV_FlagEstado,
    		CUNTCONTBL_Codigo_G ,CUNTCONTBL_Codigo_B,CAJAMOV_MovDinero,CAJAMOV_Codigo
    		from cji_caja caja inner join cji_cajamovimiento cajamovi
    		on caja.CAJA_Codigo = cajamovi.CAJA_Codigo";
    	
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function lista_cajamovimiento(){
    		$sql="select cajamovi.CAJAMOV_Codigo,CAJAMOV_FlagEstado,caja_nombre,CAJAMOV_Monto_G,CAJAMOV_Monto_B,cajamov_fechaSistema,MONED_Codigo_B,MONED_Codigo_G ,
					CUNTCONTBL_Codigo_G ,CUNTCONTBL_Codigo_B,CAJAMOV_MovDinero from cji_caja caja inner join cji_cajamovimiento cajamovi 
					on caja.CAJA_Codigo = cajamovi.CAJA_Codigo where CAJAMOV_FlagEstado = 1";
    		$query = $this->db->query($sql);
    		if($query->num_rows > 0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function lista_cuentacontable(){
    		$sql="select * from cji_cuentacontable where cuntcontbl_flagestado = 1;";
    		
    		$query = $this->db->query($sql);
    		if($query->num_rows > 0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    		
    	}
    	
    	public function buscar_caja($filter, $number_items = '', $offset = ''){
    		$sql="select caja.CAJA_Codigo,caja_nombre,cajamov_tipbenefi,CAJAMOV_Monto_B,cajamov_fechaSistema,cajamov_tipinicio
					from cji_caja caja inner join cji_cajamovimiento cajamovi
					on caja.CAJA_Codigo = cajamovi.CAJA_Codigo where caja.CAJA_Codigo = $filter";
    		
    		$query = $this->db->query($sql);
    		if($query->num_rows > 0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    
    	public function buscar_bancos_caja($filter){
    		$sql="select DISTINCT caja.CAJA_Codigo, CAJA_Nombre,CUENT_NumeroEmpresa ,cuentaempresa.CUENT_Codigo ,banco.BANP_Codigo,BANC_Nombre
					 from cji_caja_cuenta cajacuenta INNER JOIN cji_caja caja on cajacuenta.CAJA_Codigo = caja.CAJA_Codigo 
					 inner join cji_cuentasempresas cuentaempresa on cajacuenta.CUENT_Codigo = cuentaempresa.CUENT_Codigo
					inner join cji_banco banco on cuentaempresa.BANP_Codigo = banco.BANP_Codigo where caja.CAJA_Codigo = $filter and CAJA_FlagEstado = 1;";
    		 
    		$query = $this->db->query($sql);
    		if($query->num_rows > 0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function buscar_caja_codigo($filter,$filter1){
    		$sql="select DISTINCT caja.CAJA_Codigo, CAJA_Nombre,CUENT_NumeroEmpresa,banco.BANP_Codigo,BANC_Nombre,cuentaempresa.CUENT_Codigo  from cji_caja_cuenta cajacuenta 
					INNER JOIN cji_caja caja on cajacuenta.CAJA_Codigo = caja.CAJA_Codigo inner join cji_cuentasempresas cuentaempresa
					on cajacuenta.CUENT_Codigo = cuentaempresa.CUENT_Codigo 
					inner join cji_banco banco on cuentaempresa.BANP_Codigo = banco.BANP_Codigo 
					where caja.CAJA_Codigo = $filter and banco.BANP_Codigo = $filter1 and CAJA_FlagEstado = 1 ;";
    	
    		$query = $this->db->query($sql);
    		if($query->num_rows > 0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function obtener_cajadiaria($filter){
    		$sql="select DISTINCT BANC_Nombre,CUENT_NumeroEmpresa,CUENT_TipoCuenta, MONED_Descripcion ,MONEDA.moned_codigo from cji_cuentasempresas
				cuentasempresas inner join cji_moneda MONEDA on MONEDA.moned_codigo = cuentasempresas.moned_codigo
				inner join cji_banco banco on cuentasempresas.BANP_Codigo = banco.BANP_Codigo  where CUENT_NumeroEmpresa = $filter 
				and CUENT_FlagEstado = 1;";
    		 
    		$query = $this->db->query($sql);
    		if($query->num_rows > 0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function eliminar_cajamovimiento($filter){
    		$sql="update cji_cajamovimiento set CAJAMOV_FlagEstado = 0 where CAJAMOV_Codigo = $filter;";
    		
    		$query = $this->db->query($sql);
    		if($query->num_rows > 0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    		
    	}
    	public function listaBancoCaja($caja,$banco){
    		$sql="select * from cji_caja_cuenta cajacuenta 
					inner join cji_cuentasempresas cuentaempresa on cajacuenta.CUENT_Codigo = cuentaempresa.CUENT_Codigo
					inner join cji_caja caja on cajacuenta.CAJA_Codigo = caja.CAJA_Codigo 
					inner join cji_banco banco on banco.BANP_Codigo = cuentaempresa.BANP_Codigo where  caja.CAJA_Codigo = $caja and banco.BANP_Codigo = $banco";
    		
    		$query = $this->db->query($sql);
    		if($query->num_rows > 0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function listaBanco($caja){
    		$sql="select * from cji_caja_cuenta cajacuenta 
				inner join cji_cuentasempresas cuentaempresa on cajacuenta.CUENT_Codigo = cuentaempresa.CUENT_Codigo
				inner join cji_caja caja on cajacuenta.CAJA_Codigo = caja.CAJA_Codigo 
				inner join cji_banco banco on cuentaempresa.BANP_Codigo = banco.BANP_Codigo  where  caja.CAJA_Codigo = $caja";
    	
    		$query = $this->db->query($sql);
    		if($query->num_rows > 0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	
    	public function listaBancoTR($filter){
    		$sql="select * from cji_cuentasempresas cuentaempresa
    		inner join cji_banco banco on banco.BANP_Codigo =  cuentaempresa.BANP_Codigo where EMPRE_Codigo = $filter  or PERSP_Codigo = $filter";
    		
    		$query = $this->db->query($sql);
    		if($query->num_rows > 0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function listaBancoCajaTR($filter,$banco){
    		$sql="select * from cji_cuentasempresas cuentaempresa
		    		inner join cji_banco banco on banco.BANP_Codigo =  cuentaempresa.BANP_Codigo where (EMPRE_Codigo = $filter  or PERSP_Codigo = $filter)
						and banco.BANP_Codigo = $banco";
    	
    		$query = $this->db->query($sql);
    		if($query->num_rows > 0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function listaCajaMovimiento($filter){
    		$sql="select * from cji_cajamovimiento cajamovi inner join cji_cuentasempresas cuentaempresa ON cajamovi.CUENT_Codigo_B = cuentaempresa.CUENT_Codigo 
    		where CAJAMOV_Codigo = $filter;";
    		
    		$query = $this->db->query($sql);
    		if($query->num_rows > 0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	public function listaCajaMovimientoTR($filter){
    		$sql="select * from cji_cajamovimiento cajamovi inner join cji_cuentasempresas cuentaempresa ON cajamovi.CUENT_Codigo_G = cuentaempresa.CUENT_Codigo
    		where CAJAMOV_Codigo = $filter;";
    	
    		$query = $this->db->query($sql);
    		if($query->num_rows > 0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	}
    	
    	
    	
    	
    	public function obtener_datosCajaMovimiento($filter){
    		$sql="select EMPRC_RazonSocial,CUENT_NumeroEmpresa,banco.BANP_Codigo,BANC_Nombre,MONED_Descripcion,CUENT_TipoCuenta,cajamovi.CAJAMOV_Codigo,caja_nombre,caja.CAJA_Codigo,
    				CAJAMOV_Monto_G,cajamov_fechaSistema,MONED_Codigo_G , CAJAMOV_FormaPago_G,cuentaempresa.CUENT_Codigo,
					CUNTCONTBL_Codigo_G ,CAJAMOV_MovDinero , CUENT_Codigo_G,CUENT_Codigo_B,RESPMOV_Codigo,caja.CAJA_Codigo,MONED_Codigo_G,
					CAJAMOV_Justificacion,CAJAMOV_Observacion	,CAJAMOV_TipoRespo,EMPRE_Codigo,PERSP_Codigo
					from cji_caja caja 
					inner join cji_cajamovimiento cajamovi on caja.CAJA_Codigo = cajamovi.CAJA_Codigo 
					inner join cji_cuentasempresas cuentaempresa on cuentaempresa.CUENT_Codigo = cajamovi.CUENT_Codigo_G 
					inner join cji_empresa empresa on cuentaempresa.EMPRE_Codigo = empresa.EMPRP_Codigo 
					inner join cji_banco banco on banco.BANP_Codigo = cuentaempresa.BANP_Codigo 
					inner join cji_moneda moneda on moneda.MONED_Codigo = cuentaempresa.MONED_Codigo where CAJAMOV_Codigo = $filter ;";
    	
    		$query = $this->db->query($sql);
    		if($query->num_rows > 0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    	
    	}
    	
    	public function obtener_datosCajaDiaria($filter){
    		$sql="select EMPRC_RazonSocial,CUENT_NumeroEmpresa,banco.BANP_Codigo,BANC_Nombre,MONED_Descripcion,CUENT_TipoCuenta,cajamovi.CAJAMOV_Codigo,
    			  caja_nombre,caja.CAJA_Codigo,CAJAMOV_Monto_G,cajamov_fechaSistema,MONED_Codigo_G , CAJAMOV_FormaPago_G,CUNTCONTBL_Codigo_G,CAJAMOV_MovDinero, 
    			  CUENT_Codigo_G,CUENT_Codigo_B,RESPMOV_Codigo,caja.CAJA_Codigo,MONED_Codigo_G,CAJAMOV_Justificacion,CAJAMOV_Observacion,CAJAMOV_TipoRespo,
    			  cuentaempresa.CUENT_Codigo
					from cji_caja caja 
					inner join cji_cajamovimiento cajamovi on caja.CAJA_Codigo = cajamovi.CAJA_Codigo 
					inner join cji_cuentasempresas cuentaempresa on cuentaempresa.CUENT_Codigo = cajamovi.CUENT_Codigo_B
					inner join cji_empresa empresa on cuentaempresa.EMPRE_Codigo = empresa.EMPRP_Codigo 
					inner join cji_banco banco on banco.BANP_Codigo = cuentaempresa.BANP_Codigo 
					inner join cji_moneda moneda on moneda.MONED_Codigo = cuentaempresa.MONED_Codigo where CAJAMOV_Codigo = $filter ;";
    		 
    		$query = $this->db->query($sql);
    		if($query->num_rows > 0){
    			foreach ($query->result() as $fila){
    				$data[] = $fila;
    			}
    			return $data;
    		}
    		 
    	}
    	
    	
  	 }


  	 
?>