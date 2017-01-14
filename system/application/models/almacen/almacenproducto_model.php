<?php

class Almacenproducto_Model extends Model {

    protected $_name = "cji_almacenproducto";

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('almacen/producto_model');
        $this->somevar['compania'] = $this->session->userdata('compania');
    }

    public function listar($almacen_id = "", $number_items = '', $offset = '') {
        $this->db->select('*');
        $this->db->from('cji_almacenproducto');
        $this->db->join('cji_almacen', 'cji_almacen.ALMAP_Codigo=cji_almacenproducto.ALMAC_Codigo');
        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo=cji_almacenproducto.PROD_Codigo');
        $this->db->join('cji_familia', 'cji_familia.FAMI_Codigo=cji_producto.FAMI_Codigo', 'left');
        $this->db->join('cji_fabricante', 'cji_fabricante.FABRIP_Codigo=cji_producto.FABRIP_Codigo', 'left');
        $this->db->limit($number_items, $offset);
        $this->db->where('cji_almacen.COMPP_Codigo', $this->somevar['compania']);
        $this->db->where('cji_producto.PROD_FlagEstado', '1');
        if ($almacen_id != "") {
            $this->db->like('cji_producto.PROD_CodigoUsuario', $almacen_id);
        }
        $this->db->order_by('cji_producto.PROD_Nombre');
        $this->db->order_by('cji_almacenproducto.ALMAC_Codigo');
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function listar2($almacen_id = "", $number_items = '', $offset = '') {
        $number_items=50;
        $this->db->select('*');
        $this->db->from('cji_almacenproducto');
        $this->db->join('cji_almacen', 'cji_almacen.ALMAP_Codigo=cji_almacenproducto.ALMAC_Codigo');
        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo=cji_almacenproducto.PROD_Codigo');
        $this->db->join('cji_familia', 'cji_familia.FAMI_Codigo=cji_producto.FAMI_Codigo', 'left');
        $this->db->join('cji_fabricante', 'cji_fabricante.FABRIP_Codigo=cji_producto.FABRIP_Codigo', 'left');
        $this->db->limit($number_items, $offset);
        $this->db->where('cji_almacen.COMPP_Codigo', $this->somevar['compania']);
        $this->db->where('cji_producto.PROD_FlagEstado', '1');
        if ($almacen_id != "") {
            $this->db->like('cji_producto.PROD_Nombre', $almacen_id, 'both');
        }
        $this->db->order_by('cji_producto.PROD_Nombre');
        $this->db->order_by('cji_almacenproducto.ALMAC_Codigo');
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function listar_almacen($almacen_id = "", $number_items = '', $offset = '') {

        // print_r($_SESSION);

        $this->db->from('cji_almacenproducto');
        $this->db->join('cji_almacen', 'cji_almacen.ALMAP_Codigo=cji_almacenproducto.ALMAC_Codigo');
        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo=cji_almacenproducto.PROD_Codigo');
        $this->db->join('cji_familia', 'cji_familia.FAMI_Codigo=cji_producto.FAMI_Codigo', 'left');
        $this->db->join('cji_fabricante', 'cji_fabricante.FABRIP_Codigo=cji_producto.FABRIP_Codigo', 'left');
        $this->db->limit($number_items, $offset);
        //  $this->db->where('cji_almacen.COMPP_Codigo',$this->somevar['compania']);
        $this->db->where('cji_producto.PROD_FlagEstado', '1');
        if ($almacen_id != "") {
            $this->db->like('cji_producto.PROD_Nombre', $almacen_id);
        }
        $this->db->where('cji_almacenproducto.COMPP_Codigo', $this->somevar['compania']);
        $this->db->order_by('cji_producto.PROD_Nombre');
        $this->db->order_by('cji_almacenproducto.ALMAC_Codigo');

        $query = $this->db->get();
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function colocar_stock($almacen_id, $producto_id, $cantidad) {

        $filter = new stdClass();
        $filter->COMPP_Codigo = $this->somevar['compania'];
        $filter->ALMAC_Codigo = $almacen_id;
        $filter->PROD_Codigo = $producto_id;
        $stock = $this->obtener($almacen_id, $producto_id);
        if (count($stock) > 0) {
            $almacenprod_id = $stock[0]->ALMPROD_Codigo;
            $cantidad_total = $cantidad;

            $filter->ALMPROD_Stock = $cantidad_total;
            $this->db->where("ALMPROD_Codigo", $almacenprod_id);
            $this->db->update("cji_almacenproducto", (array) $filter);
        } else {
            $filter->ALMPROD_Stock = $cantidad;
            $filter->ALMPROD_CostoPromedio = 0;
            $this->db->insert("cji_almacenproducto", (array) $filter);
            $almacenprod_id = $this->db->insert_id();
        }
        //Aumento stock a la tabla producto
        $this->producto_model->modificar_stock($producto_id, $cantidad);
        return $almacenprod_id;
    }

    public function listar_compania($compania, $producto) {
        $this->db->select('*');
        $this->db->from('cji_almacenproducto');
        $this->db->join('cji_almacen', 'cji_almacen.ALMAP_Codigo=cji_almacenproducto.ALMAC_Codigo');
        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo=cji_almacenproducto.PROD_Codigo');
        $this->db->join('cji_familia', 'cji_familia.FAMI_Codigo=cji_producto.FAMI_Codigo', 'left');
        $this->db->join('cji_fabricante', 'cji_fabricante.FABRIP_Codigo=cji_producto.FABRIP_Codigo', 'left');
        $this->db->where('cji_almacen.COMPP_Codigo', $compania);
        $this->db->where('cji_almacenproducto.PROD_Codigo', $producto);
        $this->db->order_by('cji_producto.PROD_Nombre');
        $this->db->order_by('cji_almacenproducto.ALMAC_Codigo');
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function obtener($almacen_id, $producto_id) {
        $compania = $this->somevar['compania'];
        $where = array("ALMAC_Codigo" => $almacen_id, "PROD_Codigo" => $producto_id);
        $query = $this->db->order_by('ALMAC_Codigo')->where($where)->get('cji_almacenproducto');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function aumentar($almacen_id, $producto_id, $cantidad, $costo) {
        $filter = new stdClass();
        $filter->COMPP_Codigo = $this->somevar['compania'];
        $filter->ALMAC_Codigo = $almacen_id;
        $filter->PROD_Codigo = $producto_id;
        $stock = $this->obtener($almacen_id, $producto_id);
        if (count($stock) > 0) {
            $almacenprod_id = $stock[0]->ALMPROD_Codigo;
            $anterior = $stock{0}->ALMPROD_Stock;
            $costo_anterior = $stock[0]->ALMPROD_CostoPromedio;
            $cantidad_total = $cantidad + $anterior;
            if ($cantidad_total == 0)
                $costo_promedio = 0;
            else
                $costo_promedio = ($anterior * $costo_anterior + $cantidad * $costo) / $cantidad_total;
            $filter->ALMPROD_Stock = $cantidad_total;
            $filter->ALMPROD_CostoPromedio = $costo_promedio;
            $this->db->where("ALMPROD_Codigo", $almacenprod_id);
            $this->db->update("cji_almacenproducto", (array) $filter);
        }else {
            $filter->ALMPROD_Stock = $cantidad;
            $filter->ALMPROD_CostoPromedio = $costo;
            $this->db->insert("cji_almacenproducto", (array) $filter);
            $almacenprod_id = $this->db->insert_id();
        }
        //Aumento stock a la tabla producto
        $datos_producto = $this->producto_model->obtener_producto($producto_id);
        $stock_inicial = $datos_producto[0]->PROD_Stock;
        $this->producto_model->modificar_stock($producto_id, ($stock_inicial + $cantidad));
        //Actualizo el ultimo costo
        $this->producto_model->modificar_ultCosto($producto_id, $costo);
        return $almacenprod_id;
    }

    public function disminuir($almacen_id, $producto_id, $cantidad, $costo) {
        $stock = $this->obtener($almacen_id, $producto_id);
        if (count($stock) > 0) {
            $almacenprod_id = $stock[0]->ALMPROD_Codigo;
            $anterior = $stock[0]->ALMPROD_Stock;
            $costo_anterior = $stock[0]->ALMPROD_CostoPromedio;
            if ($cantidad != $anterior) {
                $cantidad_total = $anterior - $cantidad;
                $costo_promedio = ($anterior * $costo_anterior - $cantidad * $costo) / $cantidad_total;
            } else {
                $cantidad_total = 0;
                $costo_promedio = 0;
            }
            $filter = new stdClass();
            $filter->ALMAC_Codigo = $almacen_id;
            $filter->PROD_Codigo = $producto_id;
            $filter->COMPP_Codigo = $this->somevar['compania'];
            $filter->ALMPROD_Stock = $cantidad_total;
            $filter->ALMPROD_CostoPromedio = $costo_promedio;
            $this->db->where("ALMPROD_Codigo", $almacenprod_id);
            $this->db->update("cji_almacenproducto", (array) $filter);
            //Disminuyo stock a la tabla producto
            $datos_producto = $this->producto_model->obtener_producto($producto_id);
            $stock_inicial = $datos_producto[0]->PROD_Stock;
            $this->producto_model->modificar_stock($producto_id, ($stock_inicial - $cantidad));
            //Actualizo el ultimo costo
            $this->producto_model->modificar_ultCosto($producto_id, $costo);
            return $almacenprod_id;
        }
    }

    public function disminuir2($almacen_id, $producto_id, $cantidad, $costo) {
        $stock = $this->obtener($almacen_id, $producto_id);
        if (count($stock) > 0) {
            $almacenprod_id = $stock[0]->ALMPROD_Codigo;
            $cantidad_original = $stock[0]->ALMPROD_Stock;
            $costo_anterior = $stock[0]->ALMPROD_CostoPromedio;
            if ($cantidad != $cantidad_original) {
                $cantidad_total = $cantidad_original - $cantidad;
                $costo_promedio = ($cantidad_original * $costo_anterior - $cantidad * $costo) / $cantidad_total;
            } else {
                $cantidad_total = 0;
                $costo_promedio = 0;
            }
            $filter = new stdClass();
            $filter->ALMAC_Codigo = $almacen_id;
            $filter->PROD_Codigo = $producto_id;
            $filter->COMPP_Codigo = $this->somevar['compania'];
            $filter->ALMPROD_Stock = $cantidad_total;
            $filter->ALMPROD_CostoPromedio = $costo_promedio;
            $this->db->where("ALMPROD_Codigo", $almacenprod_id);
            $this->db->update("cji_almacenproducto", (array) $filter);
            //Disminuyo stock a la tabla producto
            $datos_producto = $this->producto_model->obtener_producto($producto_id);
            $stock_inicial = $datos_producto[0]->PROD_Stock;
            $this->producto_model->modificar_stock($producto_id, ($stock_inicial - $cantidad));
            //Actualizo el ultimo costo
            $this->producto_model->modificar_ultCosto($producto_id, $costo);
            return $almacenprod_id;
        }
    }

    public function devolver($almacen_id, $producto_id, $cantidad, $costo) {
        $filter = new stdClass();
        $filter->COMPP_Codigo = $this->somevar['compania'];
        $filter->ALMAC_Codigo = $almacen_id;
        $filter->PROD_Codigo = $producto_id;
        $stock = $this->obtener($almacen_id, $producto_id);
        if (count($stock) > 0) {
            $almacenprod_id = $stock->ALMPROD_Codigo;
            $anterior = $stock->ALMPROD_Stock;
            $costo_anterior = $stock->ALMPROD_CostoPromedio;
            $cantidad_total = $cantidad + $anterior;
            if ($cantidad_total == 0)
                $costo_promedio = 0;
            else
                $costo_promedio = ($anterior * $costo_anterior + $cantidad * $costo) / $cantidad_total;
            $filter->ALMPROD_Stock = $cantidad_total;
            $filter->ALMPROD_CostoPromedio = $costo_promedio;
            $this->db->where("ALMPROD_Codigo", $almacenprod_id);
            $this->db->update("cji_almacenproducto", (array) $filter);
        }
        else {
            $filter->ALMPROD_Stock = $cantidad;
            $filter->ALMPROD_CostoPromedio = $costo;
            $this->db->insert("cji_almacenproducto", (array) $filter);
            $almacenprod_id = $this->db->insert_id();
        }
        //Aumento stock a la tabla producto
        $datos_producto = $this->producto_model->obtener_producto($producto_id);
        $stock_inicial = $datos_producto[0]->PROD_Stock;
        $this->producto_model->modificar_stock($producto_id, ($stock_inicial + $cantidad));
        return $almacenprod_id;
    }

    public function buscar_x_fechas($f_ini, $f_fin, $producto_busca, $companias = '') {
        if ($producto_busca != "")
            $where = array('ap.ALMPROD_FechaRegistro >=' => $f_ini, 'ap.ALMPROD_FechaRegistro <=' => $f_fin, 'ap.PROD_Codigo' => $producto_busca);
        else
            $where = array('ap.ALMPROD_FechaRegistro >=' => $f_ini, 'ap.ALMPROD_FechaRegistro <=' => $f_fin);
        $companias = is_array($companias) ? $companias : array($this->somevar['compania']);

        $query = $this->db->where($where)
                        ->where_in('ap.COMPP_Codigo', $companias)
                        //->join('cji_pago p', 'p.PAGP_Codigo = cp.PAGP_Codigo', 'left')
                        //->join('cji_moneda m', 'm.MONED_Codigo = p.MONED_Codigo', 'left')
                        //->join('cji_cuentas c', 'c.CUE_Codigo = cp.CUE_Codigo', 'left')
                        //->join('cji_moneda m2', 'm2.MONED_Codigo = c.MONED_Codigo', 'left')
                        //->select('p.*, m.MONED_Simbolo, c.CUE_FechaOper, m2.MONED_Simbolo MONED_Simbolo2, c.CUE_Monto, cp.CPAGC_Monto')->from('cji_almacenproducto ap')->get();
                        ->select('ap.*')->from('cji_almacenproducto ap')->get();
        if ($query->num_rows > 0)
            return $query->result();
        else
            return array();
        /*
          $where = array('p.PAGC_FechaOper >='=>$f_ini,'p.PAGC_FechaOper <='=>$f_fin, 'p.PAGC_TipoCuenta'=>$tipo_cuenta, 'p.PAGC_FlagEstado'=>'1');
          $companias=is_array($companias) ? $companias :  array($this->somevar['compania']);

          $query = $this->db->where($where)
          ->where_in('c.COMPP_Codigo', $companias)
          ->join('cji_pago p', 'p.PAGP_Codigo = cp.PAGP_Codigo', 'left')
          ->join('cji_moneda m', 'm.MONED_Codigo = p.MONED_Codigo', 'left')
          ->join('cji_cuentas c', 'c.CUE_Codigo = cp.CUE_Codigo', 'left')
          ->join('cji_moneda m2', 'm2.MONED_Codigo = c.MONED_Codigo', 'left')
          ->select('p.*, m.MONED_Simbolo, c.CUE_FechaOper, m2.MONED_Simbolo MONED_Simbolo2, c.CUE_Monto, cp.CPAGC_Monto')->from('cji_cuentaspago cp')->get();
          if($query->num_rows>0)
          return $query->result();
          else
          return array();
         */
    }
	public function obtener_almacen($almacen_id){
	 $where = array("ALMAP_Codigo" => $almacen_id);
        $query = $this->db->where($where)->get('cji_almacen');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
	}
	
	
	

}

?>