<?php
class Empresa_model extends Model
{
    var $somevar;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
    }
    public function seleccionar()
    {
        $arreglo = array(''=>':: Seleccione ::');
        $filter  = new stdClass();
        $filter->SECCOMP_Codigo='9';
        $lista = $this->listar_empresas($filter);
        if(count($lista)>0){
            foreach($lista as $indice=>$valor)  //1: Empresa de transporte
            {   $indice1   = $valor->EMPRP_Codigo ;
                $valor1    = ($valor->EMPRC_Ruc!='' ? $valor->EMPRC_Ruc.' - ' : '').$valor->EMPRC_RazonSocial;
                $arreglo[$indice1] = $valor1;
            }
        }
        return $arreglo;
    }
    public function listar_sucursalesEmpresa($empresa, $tipoestab=NULL){
        $where = array("cji_emprestablecimiento.EMPRP_Codigo"=>$empresa,"EESTABC_FlagEstado"=>'1');
        if($tipoestab!=NULL)
            $where['EESTABC_FlagTipo']=$tipoestab;
        
        
        $query = $this->db->order_by('EESTABC_FlagTipo desc, TESTP_Codigo , EESTABC_Descripcion, EESTAC_Direccion')
                          ->join('cji_ubigeo', 'cji_ubigeo.UBIGP_Codigo = cji_emprestablecimiento.UBIGP_Codigo', 'left')
                          ->join('cji_tipoestablecimiento', 'cji_tipoestablecimiento.TESTP_Codigo = cji_emprestablecimiento.TESTP_Codigo', 'left')
                          ->where($where)
                          ->where_not_in('EESTABP_Codigo','0')
                          ->select('cji_emprestablecimiento.*, cji_ubigeo.UBIGC_Descripcion UBIGC_Descripcion, cji_tipoestablecimiento.TESTC_Descripcion TESTC_Descripcion')
                          ->from('cji_emprestablecimiento')
                          ->get();
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function listar_contactosEmpresa($empresa){
        $where = array('ECONC_FlagEstado'=>'1','cji_emprcontacto.EMPRP_Codigo'=>$empresa);
        
        $query = $this->db->order_by('cji_emprcontacto.ECONP_Contacto')
                            ->join('cji_persona', 'cji_persona.PERSP_Codigo = cji_emprcontacto.ECONC_Persona', 'left')
                            ->join('cji_directivo', 'cji_directivo.EMPRP_Codigo = cji_emprcontacto.EMPRP_Codigo and cji_directivo.PERSP_Codigo=cji_emprcontacto.ECONC_Persona', 'left')
                            ->join('cji_cargo', 'cji_cargo.CARGP_Codigo = cji_directivo.CARGP_Codigo', 'left')
                            ->join('cji_emprarea', 'cji_emprarea.EMPRP_Codigo = cji_emprcontacto.EMPRP_Codigo and cji_emprarea.DIREP_Codigo=cji_directivo.DIREP_Codigo', 'left')
                            ->join('cji_area', 'cji_area.AREAP_Codigo = cji_emprarea.AREAP_Codigo', 'left')
                            ->where($where)
                            ->group_by('cji_emprcontacto.ECONP_Contacto')
                            ->from('cji_emprcontacto')
                            ->select('cji_emprcontacto.*, cji_persona.PERSC_Nombre , cji_persona.PERSC_ApellidoPaterno , 
                                   cji_persona.PERSC_ApellidoMaterno, cji_area.AREAP_Codigo  AREAP_Codigo,
                                   cji_area.AREAC_Descripcion AREAC_Descripcion,cji_cargo.CARGC_Descripcion  CARGC_Descripcion')
                            ->get();

        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
	
	public function listar_marcasEmpresa($empresa){
        $where = array('EMPRP_Codigo'=>$empresa);
        
        $query = $this->db->order_by('cji_proveedormarca.MARCP_Codigo')
                            ->join('cji_marca', 'cji_proveedormarca.MARCP_Codigo = cji_marca.MARCP_Codigo', 'left')
                            ->where($where)
                            ->from('cji_proveedormarca')
                            ->select('cji_proveedormarca.MARCP_Codigo,MARCC_Descripcion,EMPRP_Codigo,EMPMARP_Codigo	')
                            ->get();

        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
	
    public function listar_empresa_pdf($flagBS,$documento,$nombre)
    {
        $compania = $this->somevar['compania'];

        if($nombre=="--" & $documento=="--"){
             $sql = "SELECT * from cji_empresa  order by 1 asc "; 
        }else if($documento !="--" && $nombre =="--"){
                $sql = "SELECT * from cji_empresa where  EMPRC_Ruc LIKE '%".$documento."%' order by 1 asc "; 
        }else if($nombre !="--" && $documento == "--"){
                $sql = "SELECT * from cji_empresa  where   EMPRC_RazonSocial LIKE '%".$nombre."%' order by 1 asc "; 
        }else{
            $sql = "SELECT * from cji_empresa  where  EMPRC_RazonSocial  LIKE '%".$nombre."%' AND EMPRC_Ruc LIKE '%".$documento."%' order by 1 asc "; 
        }
       

       

        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

	public function listar_tiposEmpresa($proveedor){
        $where = array('PROVP_Codigo'=>$proveedor);
        
        $query = $this->db->order_by('cji_empresatipoproveedor.FAMI_Codigo')
                            ->join('cji_tipoproveedor', 'cji_empresatipoproveedor.FAMI_Codigo = cji_tipoproveedor.FAMI_Codigo', 'left')
                            ->where($where)
                            ->from('cji_empresatipoproveedor')
                            ->select('cji_empresatipoproveedor.EMPTIPOP_Codigo,cji_empresatipoproveedor.FAMI_Codigo,FAMI_Descripcion')
                            ->get();

        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
	
    public function listar_areasEmpresa($empresa){
        $query = $this->db->order_by('EAREAC_Descripcion')->where('EAREAC_FlagEstado','1','EMPRP_Codigo',$empresa)->get('cji_emprarea');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function listar_empresas($filter=null, $number_items='',$offset=''){
        $this->db->order_by('EMPRC_RazonSocial')->where_not_in('EMPRP_Codigo','0')->where('EMPRC_FlagEstado','1');
        if(isset($filter->SECCOMP_Codigo) && $filter->SECCOMP_Codigo!='')
            $this->db->where('SECCOMP_Codigo',$filter->SECCOMP_Codigo);
        $query = $this->db->get('cji_empresa', $number_items,$offset);
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function buscar_empresas($filter,$number_items='',$offset='')
    {       
        if(isset($filter->EMPRC_Ruc) && $filter->EMPRC_Ruc!="")
            $this->db->where('EMPRC_Ruc',$filter->EMPRC_Ruc);
        if(isset($filter->EMPRC_RazonSocial) && $filter->EMPRC_RazonSocial!="")
            $this->db->like('EMPRC_RazonSocial',$filter->EMPRC_RazonSocial);
        if(isset($filter->EMPRC_Telefono) && $filter->EMPRC_Telefono!="")
            $this->db->like('EMPRC_Telefono',$filter->EMPRC_Telefono)->or_like('EMPRC_Movil',$filter->EMPRC_Telefono);
        
        $query = $this->db->order_by('EMPRC_RazonSocial')
                          ->where('EMPRC_FlagEstado','1')
                          ->where_not_in('EMPRP_Codigo','0')
                          ->get('cji_empresa',$number_items,$offset);
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                    $data[] = $fila;
            }
            return $data;
        }
    }
    public function obtener_datosEmpresa($empresa){
		
		$sql="select * from cji_empresa where EMPRP_Codigo='$empresa' group by EMPRP_Codigo";
		$query = $this->db->query($sql);
		
		
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                    $data[] = $fila;
            }//var_dump($sql);
            return $data;
        }
    }
    public function obtener_datosEmpresa2($ruc){
        $query = $this->db->where('EMPRC_Ruc',$ruc)->where('EMPRC_FlagEstado','1')->get('cji_empresa');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function obtener_establecimientoEmpresa($empresa,$tipo_establecimiento){
        $where = array("EMPRP_Codigo"=>$empresa,"TESTP_Codigo"=>$tipo_establecimiento);
        $query = $this->db->where($where)->get('cji_emprestablecimiento');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                    $data[] = $fila;
            }
            return $data;
        }
    }
    public function obtener_establecimientosEmpresa($empresa){
            $where = array("EMPRP_Codigo"=>$empresa,"EESTABC_FlagEstado"=>1);
            $query = $this->db->order_by('EESTABC_Descripcion')->where($where)->get('cji_emprestablecimiento');
            if($query->num_rows>0){
                    foreach($query->result() as $fila){
                            $data[] = $fila;
                    }
                    return $data;
            }
    }
	
    public function obtener_marcasEmpresa($empresa){
	
			$this->db->select('*');
			$this->db->from('cji_proveedormarca');
			$this->db->join('cji_marca','cji_proveedormarca.MARCP_Codigo=cji_marca.MARCP_Codigo','left');
            $where = array("EMPRP_Codigo"=>$empresa);
            $query = $this->db->order_by('EMPRP_Codigo')->where($where)->get();
            if($query->num_rows>0){
                    foreach($query->result() as $fila){
                            $data[] = $fila;
                    }
                    return $data;
            }
    }
	
	 public function obtener_tiposEmpresa($proveedor){
	
			$this->db->select('*');
			$this->db->from('cji_empresatipoproveedor');
			$this->db->join('cji_tipoproveedor','cji_empresatipoproveedor.FAMI_Codigo=cji_tipoproveedor.FAMI_Codigo','left');
            $where = array("PROVP_Codigo"=>$proveedor);
            $query = $this->db->order_by('PROVP_Codigo')->where($where)->get();
            if($query->num_rows>0){
                    foreach($query->result() as $fila){
                            $data[] = $fila;
                    }
                    return $data;
            }
    }
	
    public function obtener_establecimientosEmpresa_principal($empresa){
            $where = array("EMPRP_Codigo"=>$empresa,"EESTABC_FlagEstado"=>1,"EESTABC_FlagTipo"=>1);
            $query = $this->db->order_by('EESTABC_Descripcion')->where($where)->get('cji_emprestablecimiento');
            if($query->num_rows>0){
                    foreach($query->result() as $fila){
                            $data[] = $fila;
                    }
                    return $data;
            }
    }
    public function obtener_contactoEmpresa($empresa){
            $where = array('ECONC_FlagEstado'=>'1','EMPRP_Codigo'=>$empresa);
            $query = $this->db->order_by('ECONP_Contacto')->where($where)->get('cji_emprcontacto');
            if($query->num_rows>0){
                foreach($query->result() as $fila){
                        $data[] = $fila;
                }
                return $data;
            }
    }
	
	
	
    public function obtener_areaEmpresa($empresa,$directivo){
            $where = array('EMPRP_Codigo'=>$empresa,'DIREP_Codigo'=>$directivo);
            $query = $this->db->where($where)->get('cji_emprarea');
            if($query->num_rows>0){
                    foreach($query->result() as $fila){
                            $data[] = $fila;
                    }
                    return $data;
            }
    }


    public function insertar_datosEmpresa($tipocodigo, $ruc,$razon_social,$telefono,$fax,$web,$movil,$email, $sector_comercial='', $ctactesoles='', $ctactedolares='',$direccion='', $USUACodi){
           if($sector_comercial=='' || $sector_comercial=='0') 
               $sector_comercial=NULL;
           $data = array(
                        "TIPCOD_Codigo"    => $tipocodigo,
                        "EMPRC_Ruc"        => $ruc,
                        "EMPRC_RazonSocial"=> strtoupper($razon_social),
                        "SECCOMP_Codigo"   => $sector_comercial,
                        "EMPRC_Telefono"   => $telefono,
                        "EMPRC_Movil"      => $movil,
                        "EMPRC_Fax"        => $fax,
                        "EMPRC_Web"        => strtolower($web),
                        "EMPRC_Email"      => strtolower($email),
                        "EMPRC_CtaCteSoles"    => $ctactesoles,
                        "EMPRC_CtaCteDolares"  => $ctactedolares,
                        "EMPRC_Direccion"  => $direccion,
                        "USUA_Codigo"  => $USUACodi
               
                        );
            $this->db->insert("cji_empresa",$data);
            return $this->db->insert_id();
    }


    public function insertar_sucursalEmpresa($tipo_establecimiento,$empresa,$ubigeo,$descripcion,$direccion){
            
            if($tipo_establecimiento!='0' && $tipo_establecimiento!='')
           $this->db->set('TESTP_Codigo',$tipo_establecimiento);
            $this->db->set('EMPRP_Codigo',$empresa);
            $this->db->set('UBIGP_Codigo',$ubigeo);
            $this->db->set('EESTABC_Descripcion',strtoupper($descripcion));
            $this->db->set('EESTAC_Direccion',strtoupper($direccion));
            $this->db->insert('cji_emprestablecimiento');
			
	       
			$establecimiento=$this->db->insert_id();
 
			//insertar compania
			$this->db->set('EMPRP_Codigo',$empresa);
            $this->db->set('EESTABP_Codigo',$establecimiento);//obtener de algun modo
            $this->db->set('COMPC_FlagEstado',1); 
            $this->db->insert('cji_compania');
			
			$codcompania=$this->db->insert_id();
		//obtener la ultima compania insertada
 
$sql="INSERT INTO cji_configuracion (CONFIP_Codigo, DOCUP_Codigo, CONFIC_Serie, CONFIC_Numero, CONFIC_FechaRegistro, COMPP_Codigo, CONFIC_FlagEstado) VALUES
('', 1, NULL, 0, NOW(), ".$codcompania.", '1'),
('', 2, NULL, 0, NOW(), ".$codcompania.", '1'),
('', 3, NULL, 0, NOW(), ".$codcompania.", '1'),
('', 5, NULL, 0, NOW(), ".$codcompania.", '1'),
('', 6, NULL, 0, NOW(), ".$codcompania.", '1'),
('', 7, NULL, 0, NOW(), ".$codcompania.", '1'),
('', 4, NULL, 0, NOW(), ".$codcompania.", '1'),
('', 9, NULL, 0, NOW(), ".$codcompania.", '1'),
('', 8, NULL, 0, NOW(), ".$codcompania.", '1'),
('', 10, NULL, 0, NOW(), ".$codcompania.", '1'),
('', 11, NULL, 0, NOW(), ".$codcompania.", '1'),
('', 12, NULL, 0, NOW(), ".$codcompania.", '1'),
('', 13, NULL, 0, NOW(), ".$codcompania.", '1'),
('', 14, NULL, 0, NOW(), ".$codcompania.", '1'),
('', 15, NULL, 0, NOW(), ".$codcompania.", '1');";
		$this->db->query($sql);
	 
			//insertar almacen
 
			$this->db->set('TIPALM_Codigo','3');
            $this->db->set('EESTABP_Codigo',$establecimiento);//obtener de algun modo
            $this->db->set('CENCOSP_Codigo','1');
			$this->db->set('ALMAC_Descripcion',strtoupper($descripcion));
            $this->db->set('ALMAC_Direccion',strtoupper($direccion));
            $this->db->set('COMPP_Codigo',$codcompania);//obneter el codigo de la compa�ia
            $this->db->set('ALMAC_FlagEstado','1'); 
            $this->db->insert('cji_almacen');
		
    }
 
	
    public function insertar_sucursalEmpresaPrincipal($tipo_establecimiento,$empresa,$ubigeo,$descripcion,$direccion){
            $this->db->set('TESTP_Codigo',$tipo_establecimiento);
            $this->db->set('EMPRP_Codigo',$empresa);
            $this->db->set('UBIGP_Codigo',$ubigeo);
            $this->db->set('EESTABC_Descripcion',strtoupper($descripcion));
            $this->db->set('EESTAC_Direccion',strtoupper($direccion));
            $this->db->set('EESTABC_FlagTipo','1');
            $this->db->insert('cji_emprestablecimiento');
    }
	
	
	
    public function insertar_contactoEmpresa($empresa,$descripcion,$telefono,$movil,$email,$persona){
            $data = array(
                                    "EMPRP_Codigo"      => $empresa,
                                    "ECONC_Descripcion" => strtoupper($descripcion),
                                    "ECONC_Telefono"    => $telefono,
                                    "ECONC_Movil"       => $movil,
                                    "ECONC_Email"       => $email,
                                    "ECONC_Persona"     => $persona
                                    );
            $this->db->insert("cji_emprcontacto",$data);
    }
	
    public function insertar_marcaEmpresa($empresa,$codigomarca){
            $data = array(
                                    "EMPRP_Codigo"      => $empresa,
                                    "MARCP_Codigo" => $codigomarca
                                    );
            $this->db->insert("cji_proveedormarca",$data);
    }
    public function insertar_directivoEmpresa($empresa,$persona,$cargo){
            $data = array(
                                    "EMPRP_Codigo" => $empresa,
                                    "PERSP_Codigo" => $persona,
                                    "CARGP_Codigo" => $cargo
                                    );
            $this->db->insert("cji_directivo",$data);
            return $this->db->insert_id();
    }
    public function insertar_areaEmpresa($area,$empresa,$directivo,$descripcion){
            $data = array(
                                    "AREAP_Codigo"       => $area,
                                    "EMPRP_Codigo"       => $empresa,
                                    "DIREP_Codigo"       => $directivo,
                                    "EAREAC_Descripcion" => strtoupper($descripcion)
                                    );
            $this->db->insert("cji_emprarea",$data);
    }
    public function modificar_datosEmpresa($empresa, $tipocodigo, $ruc,$razon_social,$telefono,$movil,$fax,$web,$email,$sector_comercial='',$ctactesoles='',$ctactedolares='',$direccion='',$USUACodi){
        if($sector_comercial=='' || $sector_comercial=='0') 
               $sector_comercial=NULL;
        $data = array(
                    "TIPCOD_Codigo"     => $tipocodigo,
                    "EMPRC_Ruc"         => $ruc,
                    "EMPRC_RazonSocial" => strtoupper($razon_social),
                    "SECCOMP_Codigo"   => $sector_comercial,
                    "EMPRC_Telefono"    => $telefono,
                    "EMPRC_Movil"       => $movil,
                    "EMPRC_Fax"         => $fax,
                    "EMPRC_Web"         => strtolower($web),
                    "EMPRC_Email"       => strtolower($email),
                    "EMPRC_CtaCteSoles"   => $ctactesoles,
                    "EMPRC_CtaCteDolares" => $ctactedolares,
                    "EMPRC_Direccion" => $direccion,
                    "USUA_Codigo" => $USUACodi
                     );
        $this->db->where("EMPRP_Codigo",$empresa);
        $this->db->update("cji_empresa",$data);
    }
    public function modificar_sucursalEmpresa($empresa_sucursal,$tipo_establecimiento,$ubigeo,$nombre_sucursal,$direccion){
        if($tipo_establecimiento=='0' || $tipo_establecimiento=='')
                $tipo_establecimiento=NULL;    
        $data = array(
                                     "UBIGP_Codigo"        =>$ubigeo,
                                     "EESTABC_Descripcion" =>strtoupper($nombre_sucursal),
                                     "EESTAC_Direccion"    =>strtoupper($direccion),
                                     "TESTP_Codigo"        =>$tipo_establecimiento
                                     );
            $where = array("EESTABP_Codigo"=>$empresa_sucursal);
            $this->db->where($where);
            $this->db->update("cji_emprestablecimiento",$data);
    }
    public function modificar_sucursalEmpresa2($empresa,$tipo_sucursal,$ubigeo,$descripcion,$direccion){
            $data = array(
                                     "UBIGP_Codigo"        =>$ubigeo,
                                     "EESTABC_Descripcion" =>strtoupper($descripcion),
                                     "EESTAC_Direccion"    =>$direccion
                                     );
            $where = array("EMPRP_Codigo"=>$empresa,"TESTP_Codigo"=>$tipo_sucursal);
            $this->db->where($where);
            $this->db->update("cji_emprestablecimiento",$data);
    }
    public function modificar_sucursalEmpresaPrincipal($empresa,$tipo_sucursal,$ubigeo,$descripcion,$direccion){
            $data = array(
                         "UBIGP_Codigo"        =>$ubigeo,
                         "EESTABC_Descripcion" =>strtoupper($descripcion),
                         "EESTAC_Direccion"    =>$direccion
                         );
    $where = array("EMPRP_Codigo"=>$empresa,"TESTP_Codigo"=>$tipo_sucursal,"EESTABC_FlagTipo"=>'1');
            $this->db->where($where);
            $this->db->update("cji_emprestablecimiento",$data);
    }
    public function modificar_contactoEmpresa($empresa,$descripcion,$persona,$telefono,$movil,$fax,$email){
            $data  = array("ECONC_Descripcion"=>$descripcion,"ECONC_Telefono"=>$telefono,"ECONC_Movil"=>$movil,"ECONC_Fax"=>$fax,"ECONC_Email"=>$email);
            $where = array("EMPRP_Codigo"=>$empresa,"ECONC_Persona"=>$persona);
            $this->db->where($where);
            $this->db->update("cji_emprcontacto",$data);
    }
    public function modificar_areaEmpresa($empresa,$directivo,$area,$descripcion){
            $data  = array("AREAP_Codigo"=>$area,"EAREAC_Descripcion"=>$descripcion);
            $where = array("EMPRP_Codigo"=>$empresa,"DIREP_Codigo"=>$directivo);
            $this->db->where($where);
            $this->db->update('cji_emprarea',$data);
    }
    public function modificar_directivoEmpresa($empresa,$persona,$cargo){
            $data  = array("CARGP_Codigo"=>$cargo);
            $where = array("EMPRP_Codigo"=>$empresa,"PERSP_Codigo"=>$persona);
            $this->db->where($where);
            $this->db->update('cji_directivo',$data);
    }
    /*Eliminar*/
    public function eliminar_sucursalEmpresa($sucursal){
       //$this->db->delete('cji_emprestablecimiento',array('EESTABP_Codigo' => $sucursal));
		$data=array('EESTABC_FlagEstado'=>0);
		$this->db->where('EESTABP_Codigo',$sucursal);
		$this->db->update('cji_emprestablecimiento',$data);
	}
	
	public function eliminar_marcaEmpresa($marca){
        $this->db->delete('cji_proveedormarca',array('EMPMARP_Codigo' => $marca));
    }
	
	public function eliminar_tipoProveedor($tipo){
        $this->db->delete('cji_empresatipoproveedor',array('EMPTIPOP_Codigo' => $tipo));
    }
	
    public function eliminar_empresarContacto($empresa,$persona,$directivo){
            //Elimino de empresacontacto
            $data  = array("ECONC_FlagEstado"=>'0');
            $where = array("EMPRP_Codigo"=>$empresa,"ECONC_Persona"=>$persona);
            $this->db->where($where);
            $this->db->update('cji_emprcontacto',$data);
            //Elimino de directivo
            $data  = array("DIREC_FlagEstado"=>'0');
            $where = array("EMPRP_Codigo"=>$empresa,"PERSP_Codigo"=>$persona);
            $this->db->where($where);
            $this->db->update('cji_directivo',$data);
            //Elimino de empresarea
            $data  = array("EAREAC_FlagEstado"=>'0');
            $where = array("EMPRP_Codigo"=>$empresa,"DIREP_Codigo"=>$directivo);
            $this->db->where($where);
            $this->db->update('cji_emprarea',$data);
            //Elimino de persona
            $data  = array("PERSC_FlagEstado"=>'0');
            $where = array("PERSP_Codigo"=>$persona);
            $this->db->where($where);
            $this->db->update('cji_persona',$data);
    }
    public function eliminar_areaEmpresa($empresa,$area){

    }
    public function eliminar_empresa_total($empresa){
            $this->eliminar_empresa($empresa);
            $this->eliminar_empresaContacto($empresa);
            $this->eliminar_empresaArea($empresa);
            $this->eliminar_empresaSucursal($empresa);
    }
    public function eliminar_empresaSucursal($empresa){
            $data  = array("EESTABC_FlagEstado"=>'0');
            $where = array("EMPRP_Codigo"=>$empresa);
            $this->db->where($where);
            $this->db->update('cji_emprestablecimiento',$data);
    }
    public function eliminar_empresa($empresa){
            $data  = array("EMPRC_FlagEstado"=>'0');
            $where = array("EMPRP_Codigo"=>$empresa);
            $this->db->where($where);
            $this->db->update('cji_empresa',$data);
    }
    public function eliminar_empresaContacto($empresa){
            $data  = array("ECONC_FlagEstado"=>'0');
            $where = array("EMPRP_Codigo"=>$empresa);
            $this->db->where($where);
            $this->db->update('cji_emprcontacto',$data);
    }
    public function eliminar_empresaArea($empresa){
            $data  = array("EAREAC_FlagEstado"=>'0');
            $where = array("EMPRP_Codigo"=>$empresa);
            $this->db->where($where);
            $this->db->update('cji_emprarea',$data);
    }
    public function eliminar_empresaDirectivo($empresa){
            $data  = array("DIREC_FlagEstado"=>'0');
            $where = array("EMPRP_Codigo"=>$empresa);
            $this->db->where($where);
            $this->db->update('cji_directivo',$data);
    }
    
    /*public function buscar_empresa($ruc,$razon_social, $telefono=''){
    $this->db->select('*');
    $this->db->from('cji_empresa');
    $this->db->join('cji_emprcontacto','cji_emprcontacto.EMPRP_Codigo=cji_empresa.EMPRP_Codigo','left');
   $this->db->like('cji_empresa.EMPRC_Ruc',$ruc);
    $this->db->or_like('cji_empresa.EMPRC_RazonSocial',$razon_social,'after');
   //$this->db->or_like('cji_emprcontacto.ECONC_Telefono',$telefono,'after');
   //$this->db->or_like('cji_emprcontacto.ECONC_Movil',$telefono,'after');
            $query = $this->db->get();
            if($query->num_rows>0){
                    foreach($query->result() as $fila){
                            $data[] = $fila;
                    }
                    return $data;
            }
    }*/
    /*varios*/
    public function busca_xnumeroDoc($tipo_docummento, $numero_documento){
            
            /*$query = $this->db->where('TIPCOD_Codigo',$tipo_docummento)
                        ->where('EMPRC_Ruc',$numero_documento)
                        ->get('cji_empresa');*/
            $where = array(
                'cji_empresa.TIPCOD_Codigo' => $tipo_docummento,
                'cji_empresa.EMPRC_Ruc' => $numero_documento
            );                        
            $query = $this->db->select('cji_empresa.*, cji_cliente.CLIP_Codigo')
                            ->from('cji_empresa')
                            ->join('cji_cliente', 'cji_cliente.EMPRP_Codigo = cji_empresa.EMPRP_Codigo')
                            ->where($where)
                            ->get();
            if($query->num_rows>0){
                    foreach($query->result() as $fila){
                            $data[] = $fila;
                    }
                    return $data;
            }
    }

    public function proveedor_busca_xnumeroDoc($tipo_docummento, $numero_documento){
            
            /*$query = $this->db->where('TIPCOD_Codigo',$tipo_docummento)
                        ->where('EMPRC_Ruc',$numero_documento)
                        ->get('cji_empresa');*/
            $where = array(
                'cji_empresa.TIPCOD_Codigo' => $tipo_docummento,
                'cji_empresa.EMPRC_Ruc' => $numero_documento
            );                        
            $query = $this->db->select('cji_empresa.*, cji_proveedor.PROVP_Codigo')
                            ->from('cji_empresa')
                            ->join('cji_proveedor', 'cji_proveedor.EMPRP_Codigo = cji_empresa.EMPRP_Codigo')
                            ->where($where)
                            ->get();
            if($query->num_rows>0){
                    foreach($query->result() as $fila){
                            $data[] = $fila;
                    }
                    return $data;
            }
    }

}
?>