<?php

class Pago_Model extends Model
{

    protected $_name = "cji_pago";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('pago');
        $this->load->model('tesoreria/cheque_model');
    }

    public function listar($cuenta)
    {
        $where = array("CUE_Codigo" => $cuenta, "FLUCAJ_FlagEstado" => '1');

        $query = $this->db->order_by('FLUCAJ_FechaOperacion')
            ->join('cji_formapago', 'cji_formapago.FORPAP_Codigo = cji_flujocaja.FORPAP_Codigo', 'left')
            ->where($where)
            ->select('cji_flujocaja.*, cji_formapago.FORPAC_Descripcion FORPAC_Descripcion')
            ->from('cji_flujocaja')
            ->get();
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function listar_ultimos($tipo_cuenta, $codigo, $nummax = '')
    {
        $where = array("PAGC_TipoCuenta" => $tipo_cuenta, "PAGC_FlagEstado" => '1');
        if ($tipo_cuenta == '1')
            $where = array('cji_pago.CLIP_Codigo' => $codigo);
        else
            $where = array('cji_pago.PROVP_Codigo' => $codigo);

        //echo $codigo;
        /* $query = $this->db->order_by('PAGC_FechaOper', 'DESC')->order_by('PAGC_FechaRegistro', 'DESC')
          ->where($where)
          ->join('cji_moneda', 'cji_moneda.MONED_Codigo = cji_pago.MONED_Codigo', 'left')
          //->join('cji_cuentaspago', 'cji_cuentaspago.PAGP_Codigo = cji_pago.PAGP_Codigo','left')
          //->join('cji_cuentas', 'cji_cuentaspago.CUE_Codigo=cji_cuentas.CUE_Codigo')
          ->select('cji_pago.*, cji_moneda.MONED_Simbolo')
          ->from('cji_pago', $nummax)
          ->get(); */
        $query = $this->db->group_by('cji_cuentaspago.PAGP_Codigo')->order_by('PAGC_FechaOper', 'DESC')->order_by('PAGC_FechaRegistro', 'DESC')
            ->where($where)
            ->join('cji_pago', 'cji_cuentaspago.PAGP_Codigo = cji_pago.PAGP_Codigo')
            ->join('cji_moneda', 'cji_moneda.MONED_Codigo = cji_pago.MONED_Codigo', 'left')
            ->join('cji_cuentas', 'cji_cuentaspago.CUE_Codigo=cji_cuentas.CUE_Codigo')
            ->join('cji_comprobante', 'cji_cuentas.CUE_CodDocumento=cji_comprobante.CPP_Codigo')
            ->select('cji_pago.*, cji_moneda.MONED_Simbolo,cji_comprobante.CPC_Serie,cji_comprobante.CPC_Numero,cji_comprobante.CPC_TipoDocumento')
            ->from('cji_cuentaspago', $nummax)
            ->get();
        if ($query->num_rows > 0) {
            return $query->result();
        } else
            return array();
    }

    public function insertar($filter = null, $tipo_cuenta, $forma_pago, $compania)
    {
        $cheque = '';
        $new_filter = (array)$filter;
        //var_dump($new_filter);
//        var_dump($new_filter['PAGC_TipoCuenta']);
//        var_dump($new_filter['PAGC_FormaPago']);
//        var_dump($tipo_cuenta);
//        var_dump($forma_pago);
        if ($new_filter['PAGC_TipoCuenta'] == $tipo_cuenta && $new_filter['PAGC_FormaPago'] == 3) {  // 3: Cheque
            //$filter2 = new stdClass();            
            //  var_dump($new_filter);
            $filter2['CHEC_Nro'] = $new_filter['nroCheque'];
            $filter2['CHEC_FEmis'] = $new_filter['fechaEmi'];
            $filter2['CHEC_FVenc'] = $new_filter['fechaVenc'];
            $filter2['COMPP_Codigo'] = $compania;
            //return $filter2;
            //exit();
            $cheque = $this->cheque_model->insertar($filter2);
            unset($filter->nroCheque);
            unset($filter->fechaEmi);
            unset($filter->fechaVenc);
            //  var_dump($filter2);
        }
        $filter_pago = (array)$filter;
//        var_dump($cheque);
//        var_dump($new_filter);
//        echo "<br/>";
//        var_dump($filter_pago);
        if ($cheque != '')
            $filter_pago['CHEP_Codigo'] = $cheque;
//        echo "<br/>";
//        var_dump($filter_pago);
//        var_dump($new_filter);
//        exit();
        $this->db->insert("cji_pago", $filter_pago);
        $id = $this->db->insert_id();
        return $id;
    }

    public function buscar_x_fechas($f_ini, $f_fin, $tipo_cuenta)
    {
        $where = array('PAGC_FechaOper >=' => $f_ini, 'PAGC_FechaOper <=' => $f_fin, 'PAGC_TipoCuenta' => $tipo_cuenta, 'PAGC_FlagEstado' => '1');
        $query = $this->db->where($where)
            ->join('cji_moneda m', 'm.MONED_Codigo = p.MONED_Codigo', 'left')
            ->select('p.*, m.MONED_Simbolo')->from('cji_pago p')->get();
        if ($query->num_rows > 0)
            return $query->result();
        else
            return array();
    }

    public function anular($pago)
    {
        $data = array("PAGC_FlagEstado" => '0');
        $this->db->where("PAGP_Codigo", $pago);
        $this->db->update('cji_pago ', $data);
    }

    public function eliminar_delete($pago)
    {
        $this->db->where("PAGP_Codigo", $pago);
        $this->db->update('cji_pago ');
    }

    public function sumar_pagos($listado_pagos, $moneda = '2')
    {
        $suma = 0;

        foreach ($listado_pagos as $indice => $valor) {
            $suma += round(cambiar_moneda($valor->CPAGC_Monto, $valor->CPAGC_TDC, $valor->MONED_Codigo, $moneda), 2);
        }

        return $suma;
    }

    public function obtener_forma_pago($forma_pago)
    {
        $result = '';
        switch ($forma_pago) {
            case '1':
                $result = 'EFECTIVO';
                break;
            case '2':
                $result = 'DEPOSITO';
                break;
            case '3':
                $result = 'CHEQUE';
                break;
            case '4':
                $result = 'CANJE POR FACTURA';
                break;
            case '5':
                $result = 'NOTAS DE CREDITO';
                break;
            case '6':
                $result = 'DESCUENTO';
                break;
        }

        return $result;
    }

}

?>