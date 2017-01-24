<?php

class Tipocambio_Model extends Model {

    protected $_name = "cji_tipocambio";

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->somevar['compania'] = $this->session->userdata('compania');
    }

    public function cambioxdia($fecha_dia) {
        $this->db->where("TIPCAMC_Fecha", "$fecha_dia");
        $query = $this->db->get('cji_tipocambio');
        if ($query->num_rows > 0) {
            return $query->result();
        }
       /* $sql="SELECT TIPCAMC_FactorConversion FROM cji_tipocambio WHERE DATE_FORMAT(TIPCAMC_Fecha,'YYYYMMDD')=DATE_FORMAT('$fecha_dia','YYYYMMDD')";
        echo $sql;
        $query = $this->db->query($sql);
        
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }

        return array();*/
    }

    public function listar($fecha = '', $number_items = '', $offset = '') {
        if ($fecha != '')
            $this->db->where('TIPCAMC_Fecha', $fecha);
        $this->db->where('TIPCAMC_FlagEstado', 1);
        $this->db->order_by('TIPCAMC_Fecha', 'desc');
        $this->db->group_by('TIPCAMC_Fecha');
        $query = $this->db->get('cji_tipocambio', $number_items, $offset);

        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function obtener($id) {
        $where = array("cji_tipocambio" => $id);
        $query = $this->db->where($where)->get('cji_tipocambio', 1);
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function obtener2($moneda_id) {
        $where = array("TIPCAMC_MonedaOrigen" => 1, "TIPCAMC_MonedaDestino" => $moneda_id, "TIPCAMC_FlagEstado" => 1);
        $query = $this->db->order_by("TIPCAMP_Codigo", "desc")->where($where)->get('cji_tipocambio', 1);
        if ($query->num_rows > 0) {
            return $query->row();
        }
    }

    public function insertar(stdClass $filter = null) {
        $this->db->insert("cji_tipocambio", (array) $filter);
    }

    public function eliminar_varios(stdClass $filter = null) {
        if (isset($filter->TIPCAMC_Fecha) && $filter->TIPCAMC_Fecha != "")
            $where = array("TIPCAMC_Fecha" => $filter->TIPCAMC_Fecha);

        $this->db->delete('cji_tipocambio', $where);
    }

    public function buscar($filter, $number_items = '', $offset = '') {
        if (isset($filter->TIPCAMC_Fecha) && $filter->TIPCAMC_Fecha != "")
            $this->db->where('TIPCAMC_Fecha', $filter->TIPCAMC_Fecha);

        if (isset($filter->TIPCAMC_MonedaDestino) && $filter->TIPCAMC_MonedaDestino != "")
            $this->db->where('TIPCAMC_MonedaDestino', $filter->TIPCAMC_MonedaDestino);

        $query = $this->db->where('COMPP_Codigo', $this->somevar['compania'])
                ->where('TIPCAMC_FlagEstado', '1')
                ->order_by('TIPCAMC_Fecha', 'desc')
                ->get('cji_tipocambio', $number_items, $offset);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    //PARA EL CASO DE LAS FECHAS VALIDAS DE NUESTRO TIPO DE CAMBIO
    public function obtener_x_fecha($fecha = "") {
        if ($fecha != '')
            $this->db->where('TIPCAMC_Fecha', $fecha);
        $this->db->where('TIPCAMC_FlagEstado', 1);
        $this->db->order_by('TIPCAMC_Fecha', 'desc');
        $this->db->group_by('TIPCAMC_Fecha');
        $query = $this->db->get('cji_tipocambio');
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function obtener_tdc_dolar($fecha) {
        $filter = new stdClass();
        $filter->TIPCAMC_Fecha = date('Y-m-d', time());
        $filter->TIPCAMC_MonedaDestino = '2';
        $temp = $this->buscar($filter);
        $tdc = '';
        if (count($temp) > 0)
            $tdc = $temp[0]->TIPCAMC_FactorConversion;
        return $tdc;
    }

}

?>