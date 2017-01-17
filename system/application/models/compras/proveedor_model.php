<?php

class Proveedor_model extends Model {

    var $somevar;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->load->model('maestros/empresa_model');
        $this->load->model('maestros/persona_model');
        $this->load->model('maestros/ubigeo_model');
        $this->load->model('maestros/companiaconfiguracion_model');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar['hoy'] = mdate("%Y-%m-%d %h:%i:%s", time());
    }

    public function buscarProveedor($keyword, $compania){
        $query = $this->db->select('pr.PROVP_Codigo, pr.PROVC_TipoPersona, pr.EMPRP_Codigo, pr.PERSP_Codigo, p.PERSC_Nombre,
                                p.PERSC_ApellidoPaterno, p.PERSC_Ruc,
                                e.EMPRC_RazonSocial, e.EMPRC_Ruc ')
            ->from('cji_proveedor pr')
            ->join('cji_proveedorcompania ce', 'ce.PROVP_Codigo = pr.PROVP_Codigo', 'inner')
            ->join('cji_empresa e', 'e.EMPRP_Codigo = pr.EMPRP_Codigo', 'inner')
            ->join('cji_persona p', 'p.PERSP_Codigo = pr.PERSP_Codigo', 'inner')
            ->like('e.EMPRC_RazonSocial ', $keyword)
            ->or_like('p.PERSC_Nombre', $keyword)
            ->or_like('p.PERSC_Nombre', $keyword)
            ->get();

        if($query->num_rows > 0){
            return $query->result();
        }else{
            return NULL;
        }
    }

    public function buscarProveedorRuc($keyword, $compania){
        $query = $this->db->select('pr.PROVP_Codigo, pr.PROVC_TipoPersona, pr.EMPRP_Codigo, pr.PERSP_Codigo, p.PERSC_Nombre,
                                p.PERSC_ApellidoPaterno, p.PERSC_Ruc,
                                e.EMPRC_RazonSocial, e.EMPRC_Ruc ')
            ->from('cji_proveedor pr')
            ->join('cji_proveedorcompania ce', 'ce.PROVP_Codigo = pr.PROVP_Codigo', 'inner')
            ->join('cji_empresa e', 'e.EMPRP_Codigo = pr.EMPRP_Codigo', 'inner')
            ->join('cji_persona p', 'p.PERSP_Codigo = pr.PERSP_Codigo', 'inner')
            ->like('e.EMPRC_Ruc ', $keyword)
            ->get();

        if($query->num_rows > 0){
            return $query->result();
        }else{
            return NULL;
        }
    }

    public function obtener_proveedor_info($proveedor) {
        if ($proveedor == "") {
            $proveedor = '1';
        }
        $query = $this->db->where('PROVP_Codigo', $proveedor)->get('cji_proveedor');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $empresa_id = $fila->EMPRP_Codigo;
                $persona_id = $fila->PERSP_Codigo;
                $tipo = $fila->PROVC_TipoPersona;
                $resultado = new stdClass();
                if ($tipo == 1) {
                    $datos_empresa = $this->empresa_model->obtener_datosEmpresa($empresa_id);
                    $datos_empresaSucursal = $this->empresa_model->obtener_establecimientoEmpresa($empresa_id, '1');
                    if (count($datos_empresaSucursal) > 0) {
                        $direccion = $datos_empresaSucursal[0]->EESTAC_Direccion;
                        $ubigeo = $datos_empresaSucursal[0]->UBIGP_Codigo;
                    } else {
                        $direccion = "";
                        $ubigeo = "000000";
                    }
                    $resultado->tipo = $tipo;
                    $resultado->empresa = $empresa_id;
                    $resultado->persona = $persona_id;
                    $resultado->cliente = $proveedor;
                    $resultado->nombre = $datos_empresa[0]->EMPRC_RazonSocial;
                    $resultado->ruc = $datos_empresa[0]->EMPRC_Ruc;
                    $resultado->dni = "";
                    $resultado->direccion = $direccion;
                    $resultado->ubigeo = $ubigeo;
                    $resultado->telefono = "";
                    $resultado->fax = "";
                } elseif ($tipo == 0) {
                    $datos_persona = $this->persona_model->obtener_datosPersona($persona_id);
                    $ubigeo = $datos_persona[0]->UBIGP_Domicilio;
                    $resultado->tipo = $tipo;
                    $resultado->empresa = $empresa_id;
                    $resultado->persona = $persona_id;
                    $resultado->cliente = $proveedor;
                    $resultado->nombre = $datos_persona[0]->PERSC_Nombre . " " . $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno;
                    $resultado->ruc = $datos_persona[0]->PERSC_Ruc;
                    $resultado->dni = $datos_persona[0]->PERSC_NumeroDocIdentidad;
                    $resultado->direccion = $datos_persona[0]->PERSC_Direccion;
                    $resultado->ubigeo = $ubigeo;
                    $resultado->telefono = "";
                    $resultado->fax = "";
                }
                $resultado->distrito = "";
                $resultado->provincia = "";
                $resultado->departamento = "";
                if ($ubigeo != '' && $ubigeo != '000000') {
                    $datos_ubigeo_dist = $this->ubigeo_model->obtener_ubigeo_dist($ubigeo);
                    $datos_ubigeo_prov = $this->ubigeo_model->obtener_ubigeo_prov($ubigeo);
                    $datos_ubigeo_dep = $this->ubigeo_model->obtener_ubigeo_dpto($ubigeo);
                    if (count($datos_ubigeo_dist) > 0)
                        $resultado->distrito = $datos_ubigeo_dist[0]->UBIGC_Descripcion;
                    if (count($datos_ubigeo_prov) > 0)
                        $resultado->provincia = $datos_ubigeo_prov[0]->UBIGC_Descripcion;
                    if (count($datos_ubigeo_dep) > 0)
                        $resultado->departamento = $datos_ubigeo_dep[0]->UBIGC_Descripcion;
                }
            }
            return $resultado;
        }
    }

    public function obtener_Proveedor($proveedor) {
        $this->db->join('cji_empresa', 'cji_empresa.EMPRP_Codigo=cji_proveedor.EMPRP_Codigo')->where('cji_proveedor.PROVP_Codigo ', $proveedor);
        $query = $this->db->get('cji_proveedor');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function get_proveedor($ruc) {
        $this->db->select('cji_proveedor.PROVP_Codigo')->from('cji_proveedor')
                ->join('cji_empresa', 'cji_proveedor.EMPRP_Codigo=cji_empresa.EMPRP_Codigo')
                ->where('cji_empresa.EMPRC_Ruc', "$ruc");
        $query = $this->db->get('');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function listar_proveedor($number_items = '', $offset = '') {
        $compania = $this->somevar['compania'];

        /* $names = $this->companiaconfiguracion_model->listar('2');
          $w_i = "";
          if(count($names) > 0){
          $w_i = " AND prov.COMPP_Codigo IN (SELECT COMPP_Codigo FROM cji_companiaconfiguracion WHERE COMPCONFIC_Proveedor='1')";
          }else{
          $w_i = " AND prov.COMPP_Codigo IN ($compania)";
          } */

        if ($number_items == "" && $offset == "")
            $limit = "";
        else
            $limit = "limit $offset,$number_items";
			
		if(COMPARTIR_PROVCOMPANIA==1){
		      $provedorcompania="";
		}else{
			  $provedorcompania=  "and cc.COMPP_Codigo=".$compania." ";
		};
        $sql = "
                select
                prov.PROVP_Codigo PROVP_Codigo,
                prov.EMPRP_Codigo EMPRP_Codigo,
                prov.PERSP_Codigo PERSP_Codigo,
                prov.PROVC_TipoPersona PROVC_TipoPersona,
                pc.COMPP_Codigo COMPP_Codigo,
                emp.EMPRC_RazonSocial nombre,
                emp.EMPRC_Ruc ruc,
                '' dni,
                emp.EMPRC_Telefono telefono,
                emp.EMPRC_Fax fax,
                emp.EMPRC_Movil movil,
                emp.EMPRC_CtaCteSoles ctactesoles,
                emp.EMPRC_CtaCteDolares ctactedolares
                from cji_proveedorcompania as pc
                inner join cji_proveedor as prov on prov.PROVP_Codigo=pc.PROVP_Codigo
                inner join cji_empresa as emp on prov.EMPRP_Codigo=emp.EMPRP_Codigo
                where prov.PROVC_TipoPersona=1
                and prov.PROVC_FlagEstado=1
                and prov.PROVP_Codigo!=0
				" .$provedorcompania. "
                UNION
                select
                prov.PROVP_Codigo as PROVP_Codigo,
                prov.EMPRP_Codigo EMPRP_Codigo,
                prov.PERSP_Codigo PERSP_Codigo,
                prov.PROVC_TipoPersona PROVC_TipoPersona,
                pc.COMPP_Codigo COMPP_Codigo,
                concat(pers.PERSC_Nombre,' ',pers.PERSC_ApellidoPaterno) as nombre,
                pers.PERSC_Ruc ruc,
                pers.PERSC_NumeroDocIdentidad dni,
                pers.PERSC_Telefono telefono,
                pers.PERSC_Fax fax,
                pers.PERSC_Movil movil,
                pers.PERSC_CtaCteSoles ctactedoles,
                pers.PERSC_CtaCteDolares ctactedolares
                from cji_proveedorcompania as pc
                inner join cji_proveedor as prov on prov.PROVP_Codigo=pc.PROVP_Codigo
                inner join cji_persona as pers on prov.PERSP_Codigo=pers.PERSP_Codigo
                where prov.PROVC_TipoPersona=0
                and prov.PROVC_FlagEstado=1
                and prov.PROVP_Codigo!=0
				" .$provedorcompania. "
                order by nombre
                " . $limit . "
               ";
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function buscar_proveedor($filter, $number_items = '', $offset = '') {
        $where = '';
        $where_empr = '';
        $where_pers = '';

        if (isset($filter->tipo) && $filter->tipo == "J") {
            $where = ' and prov.PROVC_TipoPersona = "1"';

            if (isset($filter->numdoc) && $filter->numdoc != "")
                $where_empr = ' and emp.EMPRC_Ruc like "' . $filter->numdoc . '"';
            if (isset($filter->nombre) && $filter->nombre != "")
                $where_empr = ' and emp.EMPRC_RazonSocial like "%' . $filter->nombre . '%"';
            if (isset($filter->telefono) && $filter->telefono != "")
                $where_empr = ' and (emp.EMPRC_Telefono like "%' . $filter->telefono . '%" or emp.EMPRC_Movil like "%' . $filter->telefono . '%")';


            if (isset($filter->codmarca) && $filter->codmarca != '')
                $where.=' and emp.EMPRP_Codigo IN (SELECT EMPRP_Codigo FROM cji_proveedormarca WHERE MARCP_Codigo =' . $filter->codmarca . ')';

            if (isset($filter->codtipoproveedor) && $filter->codtipoproveedor != '')
                $where.=' and prov.PROVP_Codigo IN (SELECT PROVP_Codigo FROM cji_empresatipoproveedor WHERE FAMI_Codigo =' . $filter->codtipoproveedor . ')';
        }
        else {
            if (isset($filter->tipo) && $filter->tipo == "N") {
                $where = ' and prov.PROVC_TipoPersona = "0"';

                if (isset($filter->numdoc) && $filter->numdoc != "")
                    $where_pers = ' and pers.PERSC_NumeroDocIdentidad like "' . $filter->numdoc . '"';
                if (isset($filter->nombre) && $filter->nombre != "")
                    $where_pers = 'and (pers.PERSC_Nombre like "%' . $filter->nombre . '%" or  pers.PERSC_ApellidoPaterno like "%' . $filter->nombre . '%"  or pers.PERSC_ApellidoMaterno like "%' . $filter->nombre . '%")';
                if (isset($filter->telefono) && $filter->telefono != "")
                    $where_pers = 'and (pers.PERSC_Telefono like "%' . $filter->telefono . '%" or pers.PERSC_Movil like "%' . $filter->telefono . '%")';
            }
            else {
                if (isset($filter->numdoc) && $filter->numdoc != "") {
                    $where_empr = ' and emp.EMPRC_Ruc like "' . $filter->numdoc . '"';
                    $where_pers = ' and pers.PERSC_NumeroDocIdentidad like "' . $filter->numdoc . '"';
                }
                if (isset($filter->nombre) && $filter->nombre != "") {
                    $where_empr = ' and emp.EMPRC_RazonSocial like "%' . $filter->nombre . '%"';
                    $where_pers = 'and (pers.PERSC_Nombre like "%' . $filter->nombre . '%" or  pers.PERSC_ApellidoPaterno like "%' . $filter->nombre . '%"  or pers.PERSC_ApellidoMaterno like "%' . $filter->nombre . '%")';
                }
                if (isset($filter->telefono) && $filter->telefono != "") {
                    $where_empr = ' and (emp.EMPRC_Telefono like "%' . $filter->telefono . '%" or emp.EMPRC_Movil like "%' . $filter->telefono . '%")';
                    $where_pers = 'and (pers.PERSC_Telefono like "%' . $filter->telefono . '%" or pers.PERSC_Movil like "% ' . $filter->telefono . ' %")';
                }
            }
        }

        if ($number_items == "" && $offset == "")
            $limit = "";
        else
            $limit = "limit $offset,$number_items";

        $compania = $this->somevar['compania'];

        /* $names = $this->companiaconfiguracion_model->listar('2');
          $w_i = "";
          if(count($names) > 0){
          $w_i = " AND prov.COMPP_Codigo IN (SELECT COMPP_Codigo FROM cji_companiaconfiguracion WHERE COMPCONFIC_Proveedor='1')";
          }else{
          $w_i = " AND prov.COMPP_Codigo IN ($compania)";
          } */
		if(COMPARTIR_PROVCOMPANIA==1){
		      $provedorcompania="";
		}else{
			  $provedorcompania=  "and cc.COMPP_Codigo=".$compania." ";
		};
        $sql = "
                select
                prov.PROVP_Codigo PROVP_Codigo,
                prov.EMPRP_Codigo EMPRP_Codigo,
                prov.PERSP_Codigo PERSP_Codigo,
                prov.PROVC_TipoPersona PROVC_TipoPersona,
                pc.COMPP_Codigo COMPP_Codigo,
                emp.EMPRC_RazonSocial nombre,
                emp.EMPRC_Ruc ruc,
                '' dni,
                emp.EMPRC_Telefono telefono,
                emp.EMPRC_Fax fax,
                emp.EMPRC_Movil movil
                from cji_proveedorcompania as pc
                inner join cji_proveedor as prov on prov.PROVP_Codigo=pc.PROVP_Codigo
                inner join cji_empresa as emp on prov.EMPRP_Codigo=emp.EMPRP_Codigo
                where prov.PROVC_TipoPersona=1
                and prov.PROVC_FlagEstado=1
                " .$provedorcompania . "
                and prov.PROVP_Codigo!=0 " . $where . " " . $where_empr . "
                UNION
                select
                prov.PROVP_Codigo as PROVP_Codigo,
                prov.EMPRP_Codigo EMPRP_Codigo,
                prov.PERSP_Codigo PERSP_Codigo,
                prov.PROVC_TipoPersona PROVC_TipoPersona,
                pc.COMPP_Codigo COMPP_Codigo,
                concat(pers.PERSC_Nombre,' ',pers.PERSC_ApellidoPaterno) as nombre,
                pers.PERSC_Ruc ruc,
                pers.PERSC_NumeroDocIdentidad dni,
                pers.PERSC_Telefono telefono,
                pers.PERSC_Fax fax,
                pers.PERSC_Movil movil
                from cji_proveedorcompania as pc
                inner join cji_proveedor as prov on prov.PROVP_Codigo=pc.PROVP_Codigo
                inner join cji_persona as pers on prov.PERSP_Codigo=pers.PERSP_Codigo
                where prov.PROVC_TipoPersona=0
                and prov.PROVC_FlagEstado=1
                " .$provedorcompania . "
                and prov.PROVP_Codigo!=0 " . $where . " " . $where_pers . "
                order by nombre
                " . $limit . "
               ";
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function obtener($proveedor) {
        $query = $this->db->where('PROVP_Codigo', $proveedor)->get('cji_proveedor');
        $resultado = new stdClass();
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $proveedor_id = $fila->PROVP_Codigo;
                $empresa_id = $fila->EMPRP_Codigo;
                $persona_id = $fila->PERSP_Codigo;
                $tipo = $fila->PROVC_TipoPersona;
                if ($tipo == 1) {

                    $datos_empresa = $this->empresa_model->obtener_datosEmpresa($empresa_id);
                    $datos_empresaSucursal = $this->empresa_model->obtener_establecimientoEmpresa($empresa_id, '1');
                    $ubigeo = '';
                    $direccion = '';
                    if (count($datos_empresaSucursal) > 0) {
                        $direccion = $datos_empresaSucursal[0]->EESTAC_Direccion;
                        if ($datos_empresaSucursal[0]->UBIGP_Codigo != '000000' && $datos_empresaSucursal[0]->UBIGP_Codigo != '') {
                            $datos_ubigeo = $this->ubigeo_model->obtener_ubigeo($datos_empresaSucursal[0]->UBIGP_Codigo);
                            if (count($datos_ubigeo) > 0)
                                $ubigeo = $datos_ubigeo[0]->UBIGC_Descripcion;
                        }
                    }
                    $resultado->tipo = $tipo;
                    $resultado->empresa = $empresa_id;
                    $resultado->persona = $persona_id;
                    $resultado->proveedor = $proveedor;
                    $resultado->nombre = $datos_empresa[0]->EMPRC_RazonSocial;
                    $resultado->ruc = $datos_empresa[0]->EMPRC_Ruc;
                    $resultado->direccion =$datos_empresa[0]->EMPRC_Direccion;// $direccion;
                    $resultado->distrito = $ubigeo;
                    $resultado->telefono = $datos_empresa[0]->EMPRC_Telefono;
                    $resultado->fax = $datos_empresa[0]->EMPRC_Fax;
                }
                elseif ($tipo == 0) {
                    $datos_persona = $this->persona_model->obtener_datosPersona($persona_id);
                    $ubigeo = '';
                    if ($datos_persona[0]->UBIGP_Domicilio != '000000' && $datos_persona[0]->UBIGP_Domicilio != '') {
                        $datos_ubigeo = $this->ubigeo_model->obtener_ubigeo($datos_persona[0]->UBIGP_Domicilio);
                        if (count($datos_ubigeo) > 0)
                            $ubigeo = $datos_ubigeo[0]->UBIGC_Descripcion;
                    }
                    $resultado->tipo = $tipo;
                    $resultado->empresa = $empresa_id;
                    $resultado->persona = $persona_id;
                    $resultado->proveedor = $proveedor;
                    $resultado->nombre = $datos_persona[0]->PERSC_Nombre . " " . $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno;
                    $resultado->ruc = $datos_persona[0]->PERSC_Ruc;
                    $resultado->direccion = $datos_persona[0]->PERSC_Direccion;
                    $resultado->distrito = $ubigeo;
                    $resultado->telefono = $datos_persona[0]->PERSC_Telefono;
                    $resultado->fax = $datos_persona[0]->PERSC_Fax;
                }
            }
        }
        return $resultado;
    }

    public function obtener_datosProveedor($proveedor) {
        $query = $this->db->where('PROVP_Codigo', $proveedor)->get('cji_proveedor');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function obtener_datosProveedor2($empresa) {
        $query = $this->db->where('EMPRP_Codigo', $empresa)->get('cji_proveedor');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function obtener_datosProveedor3($persona) {
        $query = $this->db->where('PERSP_Codigo', $persona)->get('cji_proveedor');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function insertar_tipoProveedor($proveedor, $familia) {
        $data = array(
            "FAMI_Codigo" => $familia,
            "PROVP_Codigo" => $proveedor
        );
        $this->db->insert("cji_empresatipoproveedor", $data);
    }

    public function insertar_datosProveedor($empresa, $persona, $tipo_persona) {
        $compania = $this->somevar['compania'];
        $data = array(
            "PERSP_Codigo" => $persona,
            "EMPRP_Codigo" => $empresa,
            "PROVC_TipoPersona" => $tipo_persona
        );
        $this->db->insert("cji_proveedor", $data);
        $proveedor = $this->db->insert_id();
        $this->insertar_proveedor_compania($proveedor);
    }

    public function insertar_proveedor_compania($proveedor) {
        $data = array(
            "PROVP_Codigo" => $proveedor,
            "COMPP_Codigo" => $this->somevar['compania'],
        );
        $this->db->insert("cji_proveedorcompania", $data);
    }

    public function modificar_datosProveedor($proveedor, $persona, $empresa) {
        $data = array(
            "PERSP_Codigo" => $persona,
            "EMPRP_Codigo" => $empresa
        );
        $this->db->where("PROVP_Codigo", $proveedor);
        $this->db->update("cji_proveedor", $data);
    }

    public function listar_proveedor_pdf($flagBS, $documento, $nombre)
    {
       $where = " ";
     
       
        if( $documento!="--"){

             $sql ="select e.EMPRC_Ruc ruc,  e.EMPRC_RazonSocial nombre,e.EMPRC_Telefono telefono, e.EMPRC_Movil movil, pr.PROVP_Codigo, pr.PROVC_TipoPersona, pr.EMPRP_Codigo, pr.PERSP_Codigo, e.EMPRC_RazonSocial, e.EMPRC_Ruc from cji_proveedor as pr inner join cji_empresa as e on e.EMPRP_Codigo = pr.EMPRP_Codigo where e.EMPRC_Ruc= '".$documento."' ";
        }
         if( $nombre!="--" && $documento=="--"){

             $sql ="select e.EMPRC_Ruc ruc,  e.EMPRC_RazonSocial nombre,e.EMPRC_Telefono telefono, e.EMPRC_Movil movil, pr.PROVP_Codigo, pr.PROVC_TipoPersona, pr.EMPRP_Codigo, pr.PERSP_Codigo, e.EMPRC_RazonSocial, e.EMPRC_Ruc from cji_proveedor as pr inner join cji_empresa as e on e.EMPRP_Codigo = pr.EMPRP_Codigo where e.EMPRC_RazonSocial like '%".$nombre."%' ";
        }
        if($documento=="--" && $nombre=="--"){
        

        $sql = "select e.EMPRC_Ruc ruc,  e.EMPRC_RazonSocial nombre,e.EMPRC_Telefono telefono, e.EMPRC_Movil movil, pr.PROVP_Codigo, pr.PROVC_TipoPersona, pr.EMPRP_Codigo, pr.PERSP_Codigo, e.EMPRC_RazonSocial, e.EMPRC_Ruc from cji_proveedor as pr inner join cji_empresa as e on e.EMPRP_Codigo = pr.EMPRP_Codigo "; 
       
            }

        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function eliminar_proveedorSucursal($sucursal) {
        $data = array("EESTABC_FlagEstado" => '0');
        $where = array("EESTABP_Codigo" => $sucursal);
        $this->db->where($where);
        $this->db->update('cji_emprestablecimiento', $data);
    }

    public function eliminar_proveedor($proveedor) {
        $compania = $this->somevar['compania'];

        /* $data  = array("PROVC_FlagEstado"=>'0');
          $where = array("PROVP_Codigo"=>$proveedor);
          $this->db->where($where);
          $this->db->update('cji_proveedor',$data); */

        $this->db->delete('cji_proveedorcompania', array('PROVP_Codigo' => $proveedor, 'COMPP_Codigo' => $compania));
    }

}

?>