<?php

class kardex_Model extends Model {

    protected $_name = "cji_kardex";

    public function __construct() {

        parent::__construct();

        $this->load->database();

        $this->somevar['compania'] = $this->session->userdata('compania');
    }

    public function listar_by_codigo_documento($cod_doc, $tipo, $filter) {


        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo=  cji_kardex.PROD_Codigo');

        $this->db->join('cji_documento', 'cji_documento.DOCUP_Codigo=cji_kardex.DOCUP_Codigo');
        if (isset($filter->producto) && $filter->producto != "")
            $this->db->where('cji_producto.PROD_CodigoUsuario', $filter->producto);
        /*
          if (isset($filter->fechai) && $filter->fechai != "")
          $this->db->where('DATE_FORMAT(cji_kardex.KARD_Fecha,"%Y-%m-%d")  >=', $filter->fechai);

          if (isset($filter->fechaf) && $filter->fechaf != "")
          $this->db->where('DATE_FORMAT(cji_kardex.KARD_Fecha,"%Y-%m-%d") <', $filter->fechaf);
         */
		$conpania=$this->somevar['compania'];
		$this->db->where('cji_kardex.COMPP_Codigo',$conpania);
        $this->db->where('cji_kardex.DOCUP_Codigo', $cod_doc);
        $this->db->where('cji_kardex.KARDC_TipoIngreso', $tipo);
        $this->db->orderby('cji_kardex.KARDP_Codigo', 'DESC');
        $query = $this->db->get('cji_kardex');

        if ($query->num_rows > 0) {

            return $query->result();
        }
    }

    public function listar(stdClass $filter) { /* if(!isset($filter->compania) || $filter->compania=='') */
		//$filter->compania=$this->somevar['compania']


        $ultimo_inventario = $this->listar_by_codigo_documento(4, 3, $filter);
		
        if (!$ultimo_inventario)
            return array();

        $producto_id = $filter->producto;

        $this->db->select('cji_kardex.*,cji_documento.*,sum(cji_kardex.KARDC_Cantidad) as KARDC_Cantidad2');

        $this->db->from('cji_kardex');

        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo=  cji_kardex.PROD_Codigo');

        $this->db->join('cji_documento', 'cji_documento.DOCUP_Codigo=cji_kardex.DOCUP_Codigo');

        $this->db->where('cji_kardex.COMPP_Codigo', $filter->compania);

        if (isset($producto_id) && $producto_id != "") {
            $this->db->where('cji_producto.PROD_CodigoUsuario', $producto_id);
        }
        /*  if (isset($filter->fechai) && $filter->fechai != "")
          $this->db->where('DATE_FORMAT(cji_kardex.KARD_Fecha,"%Y-%m-%d")  >=', $filter->fechai);

          if (isset($filter->fechaf) && $filter->fechaf != "")
          $this->db->where('DATE_FORMAT(cji_kardex.KARD_Fecha,"%Y-%m-%d") <', $filter->fechaf);
         */
        $this->db->where('cji_kardex.KARDP_Codigo >=', $ultimo_inventario[0]->KARDP_Codigo);
 		//var_dump($ultimo_inventario[0]->KARDP_Codigo);
        // $this->db->where('DATE_FORMAT(cji_kardex.KARD_Fecha,"%Y-%m-%d") <', $filter->fechaf);
        $this->db->group_by(array('cji_kardex.DOCUP_Codigo', 'cji_kardex.KARDC_CodigoDoc'));

        $this->db->order_by('cji_kardex.KARDP_Codigo');

        $query = $this->db->get();

        if ($query->num_rows > 0) {

            return $query->result();
        }
    }

    public function listarFIFO(stdClass $filter) {

        $producto_id = $filter->producto;

        $this->db->select('*');

        $this->db->from('cji_kardex');

        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo=cji_kardex.PROD_Codigo');

        $this->db->join('cji_documento', 'cji_documento.DOCUP_Codigo=cji_kardex.DOCUP_Codigo');

        $this->db->where('cji_kardex.COMPP_Codigo', $this->somevar['compania']);

        if (isset($producto_id) && $producto_id != "")
            $this->db->where('cji_producto.PROD_Codigo', $producto_id);

        if (isset($filter->fechai) && $filter->fechai != "")
            $this->db->where('DATE_FORMAT(cji_kardex.KARD_Fecha,"%Y-%m-%d")  >=', $filter->fechai);

        if (isset($filter->fechaf) && $filter->fechaf != "")
            $this->db->where('DATE_FORMAT(cji_kardex.KARD_Fecha,"%Y-%m-%d") <', $filter->fechaf);

        $this->db->order_by('cji_kardex.KARDP_Codigo');

        $query = $this->db->get();

        if ($query->num_rows > 0) {

            return $query->result();
        }
    }

    public function listarLIFO(stdClass $filter) {

        $producto_id = $filter->producto;

        $this->db->select('cji_kardex.*,cji_documento.*');

        $this->db->from('cji_kardex');

        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo=cji_kardex.PROD_Codigo');

        $this->db->join('cji_documento', 'cji_documento.DOCUP_Codigo=cji_kardex.DOCUP_Codigo');

        $this->db->where('cji_kardex.COMPP_Codigo', $this->somevar['compania']);

        if (isset($producto_id) && $producto_id != "")
            $this->db->where('cji_producto.PROD_Codigo', $producto_id);

        if (isset($filter->fechai) && $filter->fechai != "")
            $this->db->where('DATE_FORMAT(cji_kardex.KARD_Fecha,"%Y-%m-%d") >=', $filter->fechai);

        if (isset($filter->fechaf) && $filter->fechaf != "")
            $this->db->where('DATE_FORMAT(cji_kardex.KARD_Fecha,"%Y-%m-%d") <', $filter->fechaf);

        $this->db->order_by('cji_kardex.KARDP_Codigo');

        $query = $this->db->get();

        if ($query->num_rows > 0) {

            return $query->result();
        }
    }

    public function obtener($documento_id, $codigo_doc) {

        $where = array("COMPP_Codigo" => $this->somevar['compania'], "DOCUP_Codigo" => $documento_id, "KARDC_CodigoDoc" => $codigo_doc);

        $query = $this->db->where($where)->get('cji_kardex');

        if ($query->num_rows > 0) {

            return $query->result();
        }
    }

    public function obtener_stock($producto_id) {

        $where = array("COMPP_Codigo" => $this->somevar['compania'], "PROD_Codigo" => $producto_id);

        $query = $this->db->order_by('KARDP_Codigo', 'desc')->where($where)->get('cji_kardex', 1);

        if ($query->num_rows > 0) {

            return $query->result();
        }
    }

    public function obtener_registros_x_dcto($producto_id, $documento_id, $codigo_doc) {

        $where = array("COMPP_Codigo" => $this->somevar['compania'], "PROD_Codigo" => $producto_id, "DOCUP_Codigo" => $documento_id, "KARDC_CodigoDoc" => $codigo_doc);

        $query = $this->db->where($where)->get('cji_kardex');

        if ($query->num_rows > 0) {

            return $query->result();
        }
    }

    public function insertar($dcto_id, stdClass $filter = null) {

        $fecha = $filter->KARD_Fecha;

        $cantidad = $filter->KARDC_Cantidad;

        $producto = $filter->PROD_Codigo;

        $costo = $filter->KARDC_Costo;

        $lote = $filter->LOTP_Codigo;

        if ($dcto_id == 5) {

            $tipo = 1; //Ingreso
        } elseif ($dcto_id == 6 || $dcto_id == 7) {
			
				$tipo = 2; //Salida	
					
            
        } elseif ($dcto_id == 4) {
            $tipo = 3; //Inventario
        }

        $data = array(
            "PROD_Codigo" => $producto,
            "DOCUP_Codigo" => $dcto_id,
            "TIPOMOVP_Codigo" => $filter->TIPOMOVP_Codigo,
            "KARDC_CodigoDoc" => $filter->KARDC_CodigoDoc,
            "KARDC_TipoIngreso" => $tipo,
            "KARD_Fecha" => $fecha,
            "KARDC_Cantidad" => $cantidad,
            "KARDC_Costo" => $costo,
            "COMPP_Codigo" => $this->somevar['compania'],
            "LOTP_Codigo" => $lote
        );

        $result = $this->db->insert("cji_kardex", $data);
        return $result;
    }

	public function insertar_dsnto($dcto_id, stdClass $filter = null) {

        $fecha = $filter->KARD_Fecha;

        $cantidad = $filter->KARDC_Cantidad;

        $producto = $filter->PROD_Codigo;

        $costo = $filter->KARDC_Costo;

        $lote = $filter->LOTP_Codigo;

        $tipo = 3; //Inventario
        

        $data = array(
            "PROD_Codigo" => $producto,
            "DOCUP_Codigo" => $dcto_id,
            "TIPOMOVP_Codigo" => $filter->TIPOMOVP_Codigo,
            "KARDC_CodigoDoc" => $filter->KARDC_CodigoDoc,
            "KARDC_TipoIngreso" => $tipo,
            "KARD_Fecha" => $fecha,
            "KARDC_Cantidad" => $cantidad,
            "KARDC_Costo" => $costo,
            "COMPP_Codigo" => $this->somevar['compania'],
            "LOTP_Codigo" => $lote
        );

        $result = $this->db->insert("cji_kardex", $data);
        return $result;
    }
	
    public function eliminar($documento_id, $codigo, $producto_id) {

        $where = array("COMPP_Codigo" => $this->somevar['compania'], "PROD_Codigo" => $producto_id, "DOCUP_Codigo" => $documento_id, "KARDC_CodigoDoc" => $codigo);

        $data = array(
            'KARDC_Cantidad' => 0
        );

        $this->db->where($where);

        $this->db->update('cji_kardex', $data);
    }

}

?>