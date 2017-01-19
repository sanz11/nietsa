<?php
class Cliente_model extends Model{
    var $somevar;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->load->model('maestros/empresa_model');
        $this->load->model('maestros/ubigeo_model');
        $this->load->model('maestros/persona_model');
		$this->load->model('maestros/companiaconfiguracion_model');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
    }
public function optenercuentaEmpresa($values){
    $this->db->select("EMPRC_CtaCteSoles,EMPRC_CtaCteDolares,EMPRC_RazonSocial");
    $this->db->where('EMPRP_Codigo', $values);
    $query= $this->db->get('cji_empresa');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }

    }
    public function optenerCuentaProveedor($values){
       $this->db->select("EMPRC_CtaCteSoles,EMPRC_CtaCteDolares,EMPRC_RazonSocial");
       $this->db->join('cji_empresa e','e.EMPRP_Codigo=p.EMPRP_Codigo');
    $this->db->where('p.PROVP_Codigo', $values);
    
    $query= $this->db->get('cji_proveedor p');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        } 
    }
    public function buscarClienteRuc($keyword, $compania){
        $query = $this->db->select('c.USUA_Codigo, c.CLIP_Codigo, c.CLIC_TipoPersona, c.EMPRP_Codigo, c.PERSP_Codigo, p.PERSC_Nombre,
                                p.PERSC_ApellidoPaterno, p.PERSC_Ruc,
                                e.EMPRC_RazonSocial, e.EMPRC_Ruc')
                ->from('cji_cliente c')
                ->join('cji_clientecompania ce', 'ce.CLIP_Codigo = c.CLIP_Codigo', 'inner')
                ->join('cji_empresa e', 'e.EMPRP_Codigo = c.EMPRP_Codigo', 'inner')
                ->join('cji_persona p', 'p.PERSP_Codigo = c.PERSP_Codigo', 'inner')
                ->like('e.EMPRC_Ruc ', $keyword)
                ->where('ce.COMPP_Codigo ', $compania)
                ->get();
        if($query->num_rows > 0){
            return $query->result();
        }else{
            return NULL;
        }
    }

    public function listar_cliente($number_items='',$offset='')
    {
        $compania = $this->somevar['compania'];
 
        if($number_items=="" && $offset==""){
                $limit="";
        }
        else{
                $limit="limit $offset,$number_items";
        }
		//---------------------------------------------------
		if(COMPARTIR_CLICOMPANIA==1){
		      $clientecompania="";

		}else{
				  $clientecompania=  "and cc.COMPP_Codigo=".$compania." ";
		};
		//------------------------------------------------------
        $sql = "
                select
				CLIC_flagCalifica,
                cli.USUA_Codigo,
                cli.CLIP_Codigo CLIP_Codigo,
                cli.EMPRP_Codigo EMPRP_Codigo,
                cli.PERSP_Codigo PERSP_Codigo,
                cli.CLIC_TipoPersona CLIC_TipoPersona,
                cc.COMPP_Codigo COMPP_Codigo,
                emp.EMPRC_RazonSocial nombre,
                emp.EMPRC_Ruc ruc,
                '' dni,
                emp.EMPRC_Telefono telefono,
                emp.EMPRC_Fax fax
                from cji_clientecompania cc
                inner join cji_cliente as cli on cli.CLIP_Codigo=cc.CLIP_Codigo
                inner join cji_empresa as emp on cli.EMPRP_Codigo=emp.EMPRP_Codigo
                where cli.CLIC_TipoPersona=1
                and cli.CLIC_FlagEstado=1 ".
                $clientecompania."
                and cli.CLIP_Codigo!=0
                UNION
                select
				CLIC_flagCalifica,
                cli.USUA_Codigo,
                cli.CLIP_Codigo as CLIP_Codigo,
                cli.EMPRP_Codigo EMPRP_Codigo,
                cli.PERSP_Codigo PERSP_Codigo,
                cli.CLIC_TipoPersona CLIC_TipoPersona,
                cc.COMPP_Codigo COMPP_Codigo,
                concat(pers.PERSC_Nombre,' ',pers.PERSC_ApellidoPaterno) as nombre,
                pers.PERSC_Ruc ruc,
                pers.PERSC_NumeroDocIdentidad dni,
                pers.PERSC_Telefono telefono,
                pers.PERSC_Fax fax
                from cji_clientecompania as cc
                inner join cji_cliente as cli on cli.CLIP_Codigo=cc.CLIP_Codigo
                inner join cji_persona as pers on cli.PERSP_Codigo=pers.PERSP_Codigo
                where cli.CLIC_TipoPersona=0
                and cli.CLIC_FlagEstado=1 ".
                $clientecompania."
                and cli.CLIP_Codigo!=0 
                order by nombre
                ".$limit."
            ";
        $query = $this->db->query($sql);
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function obtener($cliente)
    {
	 if($cliente==""){
	 $cliente='1';
	 }
        $query = $this->db->where('CLIP_Codigo',$cliente)->get('cji_cliente');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $empresa_id   = $fila->EMPRP_Codigo;
                $persona_id   = $fila->PERSP_Codigo;
                $tipo         = $fila->CLIC_TipoPersona;
                $resultado = new stdClass();
                if($tipo==1){
                    $datos_empresa = $this->empresa_model->obtener_datosEmpresa($empresa_id);
                    $datos_empresaSucursal = $this->empresa_model->obtener_establecimientoEmpresa($empresa_id,'1');
                    if(count($datos_empresaSucursal)>0){
                        $direccion = $datos_empresaSucursal[0]->EESTAC_Direccion;
                        $ubigeo    = $datos_empresaSucursal[0]->UBIGP_Codigo;
                    }
                    else{
                        $direccion = "";
                        $ubigeo    = "000000";
                    }
                    $resultado->tipo       = $tipo;
                    $resultado->empresa    = $empresa_id;
                    $resultado->persona    = $persona_id;
                    $resultado->cliente    = $cliente;
                    $resultado->nombre     = $datos_empresa[0]->EMPRC_RazonSocial;
                    $resultado->ruc        = $datos_empresa[0]->EMPRC_Ruc;
                    $resultado->dni        = "";
                    $resultado->direccion  = $direccion;
                    $resultado->ubigeo     = $ubigeo;
                    $resultado->telefono   = "";
                    $resultado->fax        = "";
					$resultado->correo     = $datos_empresa[0]->EMPRC_Email;
                }
                elseif($tipo==0){
                    $datos_persona = $this->persona_model->obtener_datosPersona($persona_id);
                    $ubigeo        = $datos_persona[0]->UBIGP_Domicilio;
                    $resultado->tipo       = $tipo;
                    $resultado->empresa    = $empresa_id;
                    $resultado->persona    = $persona_id;
                    $resultado->cliente    = $cliente;
                    $resultado->nombre     = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno." ".$datos_persona[0]->PERSC_ApellidoMaterno;
                    $resultado->ruc        = $datos_persona[0]->PERSC_Ruc;
                    $resultado->dni        = $datos_persona[0]->PERSC_NumeroDocIdentidad;
                    $resultado->direccion  = $datos_persona[0]->PERSC_Direccion;
                    $resultado->ubigeo     = $ubigeo;
                    $resultado->telefono   = "";
                    $resultado->fax        = "";
                    $resultado->correo     = $datos_persona[0]->PERSC_Email;
					
                }
                $resultado->distrito     = "";
                $resultado->provincia    = "";
                $resultado->departamento = "";
                if($ubigeo!='' && $ubigeo!='000000'){
                    $datos_ubigeo_dist = $this->ubigeo_model->obtener_ubigeo_dist($ubigeo);
                    $datos_ubigeo_prov = $this->ubigeo_model->obtener_ubigeo_prov($ubigeo);
                    $datos_ubigeo_dep  = $this->ubigeo_model->obtener_ubigeo_dpto($ubigeo);
                    if(count($datos_ubigeo_dist)>0)
                        $resultado->distrito     = $datos_ubigeo_dist[0]->UBIGC_Descripcion;
                    if(count($datos_ubigeo_prov)>0)
                        $resultado->provincia    = $datos_ubigeo_prov[0]->UBIGC_Descripcion;
                    if(count($datos_ubigeo_dep)>0)
                        $resultado->departamento = $datos_ubigeo_dep[0]->UBIGC_Descripcion;
                }
            }
            return $resultado;
        }
    }
    public function buscar_cliente($filter, $number_items='',$offset='')
    {       $where='';
            $where_empr='';
            $where_pers='';
			$where_calif='';

            if(isset($filter->tipo) && $filter->tipo=="J"){
                $where=' and cli.CLIC_TipoPersona = "1"';

                if(isset($filter->numdoc) && $filter->numdoc!="")
                    $where_empr.=' and emp.EMPRC_Ruc like "'.$filter->numdoc.'"';
                if(isset($filter->nombre) && $filter->nombre!="")
                    #Cambio10-08-2016
                    $where_empr.=' and emp.EMPRC_RazonSocial like "%'.$filter->nombre.'%"';
                if(isset($filter->telefono) && $filter->telefono!="")
                    $where_empr.=' and (emp.EMPRC_Telefono like "%'.$filter->telefono.'%" or emp.EMPRC_Movil like "%'.$filter->telefono.'%")';
            }
            else{
                if(isset($filter->tipo) && $filter->tipo=="N"){
                    $where=' and cli.CLIC_TipoPersona = "0"';

                    if(isset($filter->numdoc) && $filter->numdoc!="")
                        $where_pers.=' and (pers.PERSC_NumeroDocIdentidad like "'.$filter->numdoc.'" or pers.PERSC_Ruc like "'.$filter->numdoc.'")';
                    if(isset($filter->nombre) && $filter->nombre!="")
                        $where_pers.='and (pers.PERSC_Nombre like "%'.$filter->nombre.'%" or  pers.PERSC_ApellidoPaterno like "%'.$filter->nombre.'%"  or pers.PERSC_ApellidoMaterno like "%'.$filter->nombre.'%")';
                    if(isset($filter->telefono) && $filter->telefono!="")
                        $where_pers.='and (pers.PERSC_Telefono like "%'.$filter->telefono.'%" or pers.PERSC_Movil like "%'.$filter->telefono.'%")';
                }
                else{
                    if(isset($filter->numdoc) && $filter->numdoc!=""){
                        $where_empr.=' and emp.EMPRC_Ruc like "'.$filter->numdoc.'"';
                        $where_pers.=' and (pers.PERSC_NumeroDocIdentidad like "'.$filter->numdoc.'" or pers.PERSC_Ruc like "'.$filter->numdoc.'")';
                    }
                    if(isset($filter->nombre) && $filter->nombre!=""){
                        $where_empr.=' and emp.EMPRC_RazonSocial like "%'.$filter->nombre.'%"';
                        $where_pers.='and (pers.PERSC_Nombre like "%'.$filter->nombre.'%" or  pers.PERSC_ApellidoPaterno like "%'.$filter->nombre.'%"  or pers.PERSC_ApellidoMaterno like "%'.$filter->nombre.'%")';                   
                    }
                    if(isset($filter->telefono) && $filter->telefono!=""){
                        $where_empr.=' and (emp.EMPRC_Telefono like "%'.$filter->telefono.'%" or emp.EMPRC_Movil like "%'.$filter->telefono.'%")';
                        $where_pers.='and (pers.PERSC_Telefono like "%'.$filter->telefono.'%" or pers.PERSC_Movil like "% '.$filter->telefono.' %")';
                    }
                }      
            }
            if(isset($filter->calificaciones) && $filter->calificaciones!=""){
			$where_calif='and CLIC_flagCalifica='.$filter->calificaciones.' ';
			}else{
			$where_calif='';
			}
            if($number_items=="" && $offset==""){
                    $limit="";
            }
            else{
                    $limit="limit $offset,$number_items";
            }
            $compania = $this->somevar['compania'];
 
		//-------------------------------------	
				if(COMPARTIR_CLICOMPANIA==1){
					$clientecompania="";
				}else{
					$clientecompania=  "and cc.COMPP_Codigo=".$compania." ";
				};
			
		///-------------------------------------	
			
			
			
            $sql = "
                    select
					CLIC_flagCalifica,
                    cli.USUA_Codigo USUA_Codigo,
                    cli.CLIP_Codigo CLIP_Codigo,
                    cli.EMPRP_Codigo EMPRP_Codigo,
                    cli.PERSP_Codigo PERSP_Codigo,
                    cli.CLIC_TipoPersona CLIC_TipoPersona,
                    cc.COMPP_Codigo COMPP_Codigo,
                    emp.EMPRC_RazonSocial nombre,
                    emp.EMPRC_Ruc ruc,
                    '' dni,
                    emp.EMPRC_Telefono telefono,
                    emp.EMPRC_Fax fax
                    from cji_clientecompania as  cc
                    inner join cji_cliente as cli on cli.CLIP_Codigo=cc.CLIP_Codigo
                    inner join cji_empresa as emp on cli.EMPRP_Codigo=emp.EMPRP_Codigo
                    where cli.CLIC_TipoPersona=1
                    and cli.CLIC_FlagEstado=1
                     ".$clientecompania."
                    and cli.CLIP_Codigo!=0 ".$where." ".$where_empr." ".$where_calif."
                    UNION
                    select
					CLIC_flagCalifica,
                    cli.USUA_Codigo USUA_Codigo,
                    cli.CLIP_Codigo as CLIP_Codigo,
                    cli.EMPRP_Codigo EMPRP_Codigo,
                    cli.PERSP_Codigo PERSP_Codigo,
                    cli.CLIC_TipoPersona CLIC_TipoPersona,
                    cc.COMPP_Codigo COMPP_Codigo,
                    concat(pers.PERSC_Nombre,' ',pers.PERSC_ApellidoPaterno) as nombre,
                    pers.PERSC_Ruc ruc,
                    pers.PERSC_NumeroDocIdentidad dni,
                    pers.PERSC_Telefono telefono,
                    pers.PERSC_Fax fax
                    from cji_clientecompania as cc
                    inner join cji_cliente as cli on cli.CLIP_Codigo=cc.CLIP_Codigo
                    inner join cji_persona as pers on cli.PERSP_Codigo=pers.PERSP_Codigo
                    where cli.CLIC_TipoPersona=0
                    and cli.CLIC_FlagEstado=1
                     ".$clientecompania."
                    and cli.CLIP_Codigo!=0 ".$where." ".$where_pers." ".$where_calif."
                    order by nombre
                    ".$limit."
                    ";
            $query = $this->db->query($sql);
            if($query->num_rows>0){
                    foreach($query->result() as $fila){
                            $data[] = $fila;
                    }
                    return $data;
            }
    }
    public function obtener_datosCliente($cliente){
        $query = $this->db->where('CLIP_Codigo',$cliente)->get('cji_cliente');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function obtener_datosCliente2($empresa){
        $query = $this->db->where('EMPRP_Codigo',$empresa)->get('cji_cliente');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function obtener_datosCliente3($persona){
        $query = $this->db->where('PERSP_Codigo',$persona)->get('cji_cliente');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function insertar_datosCliente($empresa,$persona,$tipo_persona, $categoria, $forma_pago,$calificaciones,$USUACodi){
        $compania = $this->somevar['compania'];
        if($forma_pago=='' || $forma_pago=='0')
            $forma_pago=NULL;
        $data = array(
                    "EMPRP_Codigo"      => $empresa,
                    "PERSP_Codigo"      => $persona,
                    "CLIC_TipoPersona"  => $tipo_persona,
                    "TIPCLIP_Codigo"    => $categoria,
                    "FORPAP_Codigo"     => $forma_pago,
					"CLIC_flagCalifica" => $calificaciones,
                    "USUA_Codigo" => $USUACodi
                );
        $this->db->insert("cji_cliente",$data);
        $cliente = $this->db->insert_id();
        
        $this->insertar_cliente_compania($cliente);
    }
    public function insertar_cliente_compania($cliente){
        $data = array(
                      "CLIP_Codigo"        => $cliente,
                      "COMPP_Codigo"       => $this->somevar['compania'],
                     );
        $this->db->insert("cji_clientecompania",$data);
    }
    public function modificar_datosCliente($cliente, $categoria, $forma_pago,$calificaciones,$USUACodi){
            if($forma_pago=='' || $forma_pago=='0')
                $forma_pago=NULL;
            
            $data = array(
                        "TIPCLIP_Codigo"     => $categoria,
                        "FORPAP_Codigo"     => $forma_pago,
                        "CLIC_flagCalifica"=>$calificaciones,
						"USUA_Codigo"=>$USUACodi,
                         );
            $this->db->where("CLIP_Codigo",$cliente);
            $this->db->update("cji_cliente",$data);
    }
    public function eliminar_clienteSucursal($sucursal){
            $data  = array("EESTABC_FlagEstado"=>'0');
            $where = array("EESTABP_Codigo"=>$sucursal);
            $this->db->where($where);
            $this->db->update('cji_emprestablecimiento',$data);
    }
    public function eliminar_cliente($cliente){
            $compania = $this->somevar['compania'];
            
            /*$data  = array("CLIC_FlagEstado"=>'0');
            $where = array("CLIP_Codigo"=>$cliente);
            $this->db->where($where);
            $this->db->update('cji_cliente',$data);*/
        
            $this->db->delete('cji_clientecompania',array('CLIP_Codigo' => $cliente, 'COMPP_Codigo'=>$compania));
    }

function getUsuarioNombre($cod){
    $this->db->select('USUA_usuario,PERSC_Nombre,ROL_Codigo');
    $this->db->join('cji_persona p','p.PERSP_Codigo=u.PERSP_Codigo');
    $where = array('USUA_Codigo' => $cod);
    $query = $this->db->where($where)->get('cji_usuario u');
    if ($query->num_rows > 0) {
        foreach ($query->result() as $fila) {
            $data[] = $fila;
        }
        return $data;
    }
}
}
?>