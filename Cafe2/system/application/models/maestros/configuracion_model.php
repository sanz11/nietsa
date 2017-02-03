<?php

class Configuracion_model extends Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->load->model('maestros/compania_model');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario'] = $this->session->userdata('usuario');
        $this->somevar['hoy'] = mdate("%Y-%m-%d %h:%i:%s", time());
    }

    public function obtener_configuracion($compania) {
        $where = array("COMPP_Codigo" => $compania, "CONFIC_FlagEstado" => "1");
        $query = $this->db->where($where)->get('cji_configuracion');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function update_numero_presupuesto($numero, $compania) {
        $where = array("COMPP_Codigo" => $compania, "DOCUP_Codigo" => 13);
        $data['CONFIC_Numero']=$numero;
        $this->db->where($where);
        $this->db->update('cji_configuracion', $data);
    }

    function obtener_numero_documento($compania, $tipo_doc) {
        $where = array("COMPP_Codigo" => $compania, "DOCUP_Codigo" => $tipo_doc);
        $query = $this->db->where($where)->get('cji_configuracion');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    
       function obtener_numero_documento_oc($compania) {
        $where = array("COMPP_Codigo" => $compania, "DOCUP_Codigo" => 3);
        $query = $this->db->where($where)->get('cji_configuracion');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }
    
    
    
    
    
    public function modificar_configuracion($compania, $documento, $numero, $serie = null) {
        $data['CONFIC_Numero'] = $numero;
        if ($serie != null)
            $data['CONFIC_Serie'] = $serie;
        $where = array("COMPP_Codigo" => $compania, "DOCUP_Codigo" => $documento);
        $this->db->where($where);
        $this->db->update('cji_configuracion', $data);
    }

    public function modificar_configuracion_total($compania, $logo, $tipo_valorizacion, $datos, $datos_serie) {
        //$this->db->trans_start();
        $this->compania_model->modificar($compania, $logo, $tipo_valorizacion);
        $this->modificar_configuracion($compania, '1', $datos['orden_pedido'], $datos_serie['orden_pedido']);
        $this->modificar_configuracion($compania, '2', $datos['cotizacion'], $datos_serie['cotizacion']);
        $this->modificar_configuracion($compania, '3', $datos['orden_compra'], $datos_serie['orden_compra']);
        $this->modificar_configuracion($compania, '4', $datos['inventario'], $datos_serie['inventario']);
        $this->modificar_configuracion($compania, '5', $datos['guia_ingreso'], $datos_serie['guia_ingreso']);
        $this->modificar_configuracion($compania, '6', $datos['guia_salida'], $datos_serie['guia_salida']);
        $this->modificar_configuracion($compania, '7', $datos['vale_salida'], $datos_serie['vale_salida']);
        $this->modificar_configuracion($compania, '8', $datos['factura'], $datos_serie['factura']);
        $this->modificar_configuracion($compania, '9', $datos['boleta'], $datos_serie['boleta']);
        $this->modificar_configuracion($compania, '10', $datos['guia_remision'], $datos_serie['guia_remision']);
        $this->modificar_configuracion($compania, '11', $datos['nota_credito'], $datos_serie['nota_credito']);
        $this->modificar_configuracion($compania, '12', $datos['nota_debito'], $datos_serie['nota_debito']);
        $this->modificar_configuracion($compania, '13', $datos['presupuesto'], $datos_serie['presupuesto']);
        $this->modificar_configuracion($compania, '14', $datos['comprobante_general'], $datos_serie['comprobante_general']);
        //$this->db->trans_complete();
    }

}

?>