<?php

class Inventario_model extends model {

    var $somevar;

    public function __construct() {

        parent::__construct();

        $this->load->database();

        $this->somevar['compania'] = $this->session->userdata('compania');

        $this->somevar['idcompania'] = $this->session->userdata('idcompania');
    }

    public function buscar_inventario($filter = null, $number_items = "", $offset = "") {

        if (isset($filter->cod_inventario) && $filter->cod_inventario != '')
            $this->db->where('cji_inventario.INVE_Codigo', $filter->cod_inventario);

        $compania = $this->somevar['compania'];
		$this->db->where('cji_inventario.COMPP_Codigo', $compania);
        $this->db->orderby('cji_inventario.INVE_Codigo', 'DESC');
        $query = $this->db->get('cji_inventario', $number_items, $offset);


        if ($query->num_rows > 0) {

            foreach ($query->result() as $fila) {

                $data[] = $fila;
            }
            return $data;
        }
    }

    public function buscar_inventario_detalles($filter = null, $number_items = "", $offset = "") {

        $compania = $this->somevar['compania'];

        $this->db->select(
                'cji_producto.PROD_Nombre,
                    cji_producto.PROD_Codigo,
                    cji_producto.PROD_Presentacion,
                    cji_inventariodetalle.INVD_Codigo,
                    cji_inventariodetalle.INVD_FlagActivacion,
                    cji_inventariodetalle.INVE_Codigo,
                    cji_inventariodetalle.INVD_Cantidad,
                    cji_inventariodetalle.INVD_Pcosto');

        if (isset($filter->codigo_inventario) && $filter->codigo_inventario != '') {
            $this->db->where('cji_inventariodetalle.INVE_Codigo', $filter->codigo_inventario);
        }
        if (isset($filter->codigo_detalle) && $filter->codigo_detalle != '') {
            $this->db->where('cji_inventariodetalle.INVD_Codigo', $filter->codigo_detalle);
        }
        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo = cji_inventariodetalle.PROD_Codigo ', 'left');
        $this->db->join('cji_almacenproducto', 'cji_almacenproducto.PROD_Codigo = cji_inventariodetalle.PROD_Codigo ', 'left');
        $this->db->join('cji_productoprecio', 'cji_productoprecio.PROD_Codigo = cji_inventariodetalle.PROD_Codigo ', 'left');
        $this->db->orderby('cji_inventariodetalle.INVD_Codigo', 'DESC');
        $this->db->group_by('cji_producto.PROD_Codigo');
        $query = $this->db->get('cji_inventariodetalle', $number_items, $offset);

        if ($query->num_rows > 0) {

            foreach ($query->result() as $fila) {

                

                $data[] = $fila;
            }
            return $data;
        }
    }

    public function getProducto_Atributo($producto, $atributo) {

        $this->db->where(array('cji_productoatributo.ATRIB_Codigo' => $atributo, 'cji_productoatributo.PROD_Codigo' => $producto));
        $query = $this->db->get('cji_productoatributo');

        if ($query->num_rows > 0) {

            foreach ($query->result() as $fila) {

                $data[] = $fila;
            }
            return $data;
        }
    }

    public function insertar($datos) {

        $filter = new stdClass();
        $filter->INVE_Titulo = $datos['titulo'];
        $filter->COMPP_Codigo= $this->somevar['compania'];
        $filter->INVE_Serie = $datos['serie'];
        $filter->INVE_Numero = $datos['numero'];
        $filter->ALMAP_Codigo = $datos['almacen'];
        $filter->INVE_FechaInicio = human_to_mysql($datos['fecha_inicio']);

        $result = $this->db->insert("cji_inventario", (array) $filter);

        return $result;
    }

    public function editar($datos) {

        $filter = new stdClass();
        $filter->INVE_Titulo = $datos['titulo'];
        $filter->ALMAP_Codigo = $datos['almacen'];
        $filter->INVE_FechaInicio = $datos['fecha_inicio'];

        $this->db->where('cji_inventario.INVE_Codigo', $datos['cod_inventario']);
        $result = $this->db->update("cji_inventario", (array) $filter);

        return $result;
    }

    public function insertar_detalle($datos) {

        $filter = new stdClass();
        $filter->INVE_Codigo = $datos['cod_inventario'];
        $filter->PROD_Codigo = $datos['cod_producto'];
        $filter->INVD_Cantidad = $datos['cantidad'];
        $filter->INVD_Pcosto = $datos['p_costo'];
        
        $filter->INVD_FechaRegistro = date('Y-m-d');

        $result = $this->db->insert("cji_inventariodetalle", (array) $filter);

        return $result;
    }

    public function editar_detalle($datos) {

        $filter = new stdClass();
        $filter->INVD_Cantidad = $datos['cantidad'];
		$filter->INVD_Pcosto = $datos['p_costo'];
		
        $this->db->where('cji_inventariodetalle.INVD_Codigo', $datos['cod_detalle']);
        $result = $this->db->update("cji_inventariodetalle", (array) $filter);

        return $result;
    }

    public function editar_detalle_activacion($codigo_detalle) {

        $filter = new stdClass();
        $filter->INVD_FlagActivacion = 1;

        $this->db->where('cji_inventariodetalle.INVD_Codigo', $codigo_detalle);
        $result = $this->db->update("cji_inventariodetalle", (array) $filter);

        return $result;
    }

    public function eliminar_detalle($datos) {

        $this->db->where('cji_inventariodetalle.INVD_Codigo', $datos['cod_detalle']);
        $result = $this->db->delete('cji_inventariodetalle');

        return $result;
    }

    public function count_inventario() {

        $this->db->select('COUNT(cji_inventario.INVE_Codigo) as conteo');
   $compania = $this->somevar['compania'];
 $this->db->where('cji_inventario.COMPP_Codigo', $compania);
        $query = $this->db->get('cji_inventario');

        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }
	
	///gcbq
	   public function activacion_inventario($datos) {

        $filter = new stdClass();
        $filter->INVE_FechaFin =  date('Y-m-d');
		$filter->INVE_FechaRegistro = date('Y-m-d');
		$filter->INVE_FlagEstado=1;
	
		
        $this->db->where('cji_inventario.INVE_Codigo', $datos['cod_inventario']);
        $result = $this->db->update("cji_inventario", (array) $filter);

        return $result;
    }
	 public function eliminar_inventario_detalles($codigo) {

        $this->db->where('cji_inventariodetalle.INVE_Codigo', $codigo);
        $result = $this->db->delete('cji_inventariodetalle');
		
		if ($result)
                $this->eliminar_inventario($codigo);
            
    }
	 public function eliminar_inventario($codigo) {

        $this->db->where('cji_inventario.INVE_Codigo', $codigo);
        $result = $this->db->delete('cji_inventario');

        return $result;
    }

}