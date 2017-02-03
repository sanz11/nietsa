<?php

class Cuentas_model extends Model {

    var $somevar;

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar['hoy'] = mdate("%Y-%m-%d %h:%i:%s", time());
    }

    public function tipodoc_get() {
        $query = $this->select('DOCUP_Codigo,DOCUC_Descripcion')->from('cji_cuentas')->where_in('DOCUP_Codigo', array(8, 9, 14))->get();
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function listar($tipo_cuenta = '1', $number_items = '', $offset = '', $filter = NULL, $cond_pago = '', $comprobante = '') {
        //////////////////////
//        if (isset($filter->fechai) && $filter->fechai != '' && isset($filter->fechaf) && $filter->fechaf != '')
//            $where .= ' and cp.CPC_Fecha BETWEEN "' . human_to_mysql($filter->fechai) . '" AND "' . human_to_mysql($filter->fechaf) . '"';
        //////////////////////
        $where = '';
        //var_dump($cond_pago);
        //var_dump($comprobante);

        if ($comprobante != '' && isset($comprobante)) {
            if ($comprobante == 9) {
                $where.= " AND cji_cuentas.DOCUP_Codigo =9 ";
            } else if ($comprobante == 8) {
                $where.= " AND cji_cuentas.DOCUP_Codigo =8 ";
            }
        }

        if ($cond_pago != '' && isset($cond_pago)) {
            if ($cond_pago == 'C') {
                $where.= " AND cji_cuentas.CUE_FlagEstadoPago ='C' ";
            } else if ($cond_pago == 'P') {
                $where.= " AND cji_cuentas.CUE_FlagEstadoPago IN ('V','A') ";
            } else if ($cond_pago == 'T') {
                $where.= " AND cji_cuentas.CUE_FlagEstadoPago IN ('C','V','A') ";
            }
        }

        if (isset($filter->cliente) && $filter->cliente != "")
            $where.=" AND cji_comprobante.CLIP_Codigo=" . $filter->cliente;

        if (isset($filter->proveedor) && $filter->proveedor != "")
            $where.=" AND cji_comprobante.PROVP_Codigo=" . $filter->proveedor;
            
            if (isset($filter->MONED_Codigo) && $filter->MONED_Codigo != "" && $filter->MONED_Codigo != 0)
           $where.=" AND cji_comprobante.MONED_Codigo=" . $filter->MONED_Codigo;
           
        //var_dump($filter->proveedor);
        $compania = $this->somevar['compania'];
        //$where = array("cji_cuentas.CUE_TipoCuenta" => $tipo_cuenta, 'cji_cuentas.COMPP_Codigo' => $this->somevar['compania']);
        /* $this->db->order_by('cji_cuentas.CUE_FechaRegistro', 'desc')
          ->join('cji_comprobante', 'cji_comprobante.CPP_Codigo = cji_cuentas.CUE_CodDocumento', 'left')
          ->join('cji_moneda', 'cji_moneda.MONED_Codigo = cji_cuentas.MONED_Codigo', 'left')
          ->where($where);
          //var_dump($filter);
          //var_dump($cond_pago);
          if ($cond_pago!='') {
          $this->db->where_in('cji_cuentas.CUE_FlagEstadoPago', array('V', 'A'));
          }
          if (isset($filter->cliente) && $filter->cliente != "")
          $this->db->where('cji_comprobante.CLIP_Codigo', $filter->cliente);

          $this->db->select('cji_cuentas.*, cji_comprobante.PROVP_Codigo, cji_comprobante.CLIP_Codigo, cji_comprobante.CPC_TipoDocumento, cji_comprobante.CPC_Serie, cji_comprobante.CPC_Numero, cji_moneda.MONED_Simbolo')
          ->from('cji_cuentas', $number_items, $offset);
          $query = $this->db->get(); */
        $sql = "SELECT cji_cuentas.*, cji_comprobante.PROVP_Codigo, 
                cji_comprobante.CLIP_Codigo, cji_comprobante.CPC_TipoDocumento, 
                cji_comprobante.CPC_Serie, cji_comprobante.CPC_Numero, 
                cji_moneda.MONED_Simbolo FROM cji_cuentas
                LEFT JOIN cji_comprobante 
                    ON cji_comprobante.CPP_Codigo = cji_cuentas.CUE_CodDocumento
                LEFT JOIN cji_moneda 
                    ON cji_moneda.MONED_Codigo = cji_cuentas.MONED_Codigo
                WHERE cji_cuentas.CUE_TipoCuenta= $tipo_cuenta AND cji_cuentas.CUE_FlagEstado=1
                AND cji_cuentas.COMPP_Codigo= " . $this->somevar['compania'];
        //var_dump($where);
        if ($tipo_cuenta == 1) {
            $sql.=" AND cji_comprobante.CPC_TipoOperacion='V'";
        } else {
            $sql.=" AND cji_comprobante.CPC_TipoOperacion='C'";
        }
        $limit = "";
        $sql.= $where;
        if ($where == '')
            $limit = " LIMIT 0,50";


        $todos = "";
        if ($where == '') {
            $todos = " AND cji_cuentas.CUE_FlagEstadoPago IN ('V','A') ";
            $sql.=$todos;
            //$this->db->where_in('cji_cuentas.CUE_FlagEstadoPago', array('V', 'A'));
        } else {
            $sql.=$where;
        }
        //var_dump($todos);
        $sql.=" ORDER BY cji_cuentas.CUE_FechaRegistro DESC " . $limit;

        //echo $sql;
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function condicion_pago() {
        $query = $this->select('DISTINCT(CUE_FlagEstadoPago)')->from('cji_cuentas')->get();
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function buscar_notas_credito_cliente($codigo) {
        $query = $this->db->select('cji_nota.*')
            ->from('cji_nota')
            ->where('CLIP_Codigo', $codigo)
            ->where('CRED_FlagEstado', '1')
            ->where('CRED_Flag', '1')
            ->get();
        if ($query->num_rows > 0) {
            return $query->result();
        }
        else
            return NULL;
    }

    public function buscar_notas_credito_proveedor($codigo) {
        $query = $this->db->select('cji_nota.*')
            ->from('cji_nota')
            ->where('PROVP_Codigo', $codigo)
            ->where('CRED_FlagEstado', '1')
            ->where('CRED_Flag', '1')
            ->get();
        if ($query->num_rows > 0) {
            return $query->result();
        }
        else
            return NULL;
    }

    public function buscar($tipo_cuenta, $codigo, $estado = array('V', 'A'), $f_ini = '', $f_fin = '',$order='asc') {
        $compania = $this->somevar['compania'];
        $where = array("cji_cuentas.CUE_TipoCuenta" => $tipo_cuenta, 'cji_cuentas.COMPP_Codigo' => $this->somevar['compania']);
        if ($tipo_cuenta == '1')
            $where['co.CLIP_Codigo'] = $codigo;
        else
            $where['co.PROVP_Codigo'] = $codigo;
        if ($f_ini != '' && $f_fin != '') {
            $where['cji_cuentas.CUE_FechaOper >='] = $f_ini;
            $where['cji_cuentas.CUE_FechaOper <='] = $f_fin;
        }

        if (isset($filter->codigo) && $filter->FORPAC_Descripcion != '')
            $this->db->like('FORPAC_Descripcion', $filter->FORPAC_Descripcion, 'right');

         $this->db->order_by('cji_cuentas.CUE_FechaOper',$order)
                ->join('cji_comprobante co', 'co.CPP_Codigo = cji_cuentas.CUE_CodDocumento', 'left')
                ->join('cji_moneda m', 'm.MONED_Codigo = cji_cuentas.MONED_Codigo', 'left')
                ->where($where)
				->where("cji_cuentas.CUE_FlagEstado",1)
                ->where_in('cji_cuentas.CUE_FlagEstadoPago', $estado) 
                ->select('cji_cuentas.*, co.CPC_Fecha, co.CPC_TipoDocumento, co.CPC_Serie, co.CPC_Numero, co.CPC_TDC, m.MONED_Simbolo');
		$query = $this->db->get('cji_cuentas');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        else
            return array();
    }

    function obtener($cuenta) {
        $where = array('CUE_Codigo' => $cuenta);
        $query = $this->db->where($where)->get('cji_cuentas');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function insertar(stdClass $filter = null) {
        $this->db->insert('cji_cuentas', (array) $filter);
        $id = $this->db->insert_id();
        return $id;
    }

    function modificar_estado($cuenta, $estado) {
        $data = array("CUE_FlagEstadoPago" => $estado);
        $this->db->where('CUE_Codigo', $cuenta);
        $this->db->update("cji_cuentas", $data);
    }

    public function tabla_resumen($f_ini, $f_fin) {
        $where = array('p.PAGC_FechaOper >=' => $f_ini, 'p.PAGC_FechaOper <=' => $f_fin);
        $this->db->select('fp.FORPAP_Codigo,fp.FORPAC_Descripcion,p.*,COUNT(FORPAP_Codigo) AS CANTIDAD');
        $this->db->from('cji_formapago fp');
        $this->db->join('cji_pago p', 'p.PAGC_FormaPago = fp.FORPAP_Codigo', 'left');
        $query = $this->db
                ->where($where)
                ->or_where('p.PAGC_FechaOper IS NULL')
                ->select_sum('p.PAGC_Monto')
                ->group_by('fp.FORPAP_Codigo')
                ->get('');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function eliminar($codigo) {
        $data = array("CUE_FlagEstado" => '0');
        $this->db->where("CUE_Codigo", $codigo);
        $this->db->update('cji_cuentas', $data);
    }
function modificar_estado_comprobante($comprobante, $estado) {
        $data = array("CUE_FlagEstadoPago" => $estado);
        $this->db->where('CUE_CodDocumento', $comprobante);
        $this->db->update("cji_cuentas", $data);
    }
	
	function obtener_segun_comprobante($comprobante) {
        $where = array('CUE_CodDocumento' => $comprobante);
        $query = $this->db->where($where)->get('cji_cuentas');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

	function listar_alertas(){
	$query = $this->db->order_by('BANP_Codigo')->where('BANC_FlagEstado','1')->get('cji_banco');
	if($query->num_rows>0){
		foreach($query->result() as $fila){
			$data[] = $fila;
		}
            return $data;		
	}
    }
    
 
    
    
    

}

?>