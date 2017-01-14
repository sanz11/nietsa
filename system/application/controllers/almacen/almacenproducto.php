<?php

class Almacenproducto extends controller {

    public function __construct() {
        parent::Controller();
        $this->load->model('almacen/almacenproducto_model');
        $this->load->model('almacen/almacen_model');
        $this->load->model('almacen/producto_model');
        $this->load->model('almacen/unidadmedida_model');
        $this->load->model('almacen/fabricante_model');
        $this->load->helper('form', 'url');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->somevar['compania'] = $this->session->userdata('compania');
    }

    public function listar($j = '0') {
        $this->load->library('layout', 'layout');
        $almacen_id = $this->input->post("nombre_prod");
        $data['nombre_prod'] = $almacen_id;
        // $data['registros']='';
        $data['registros'] = count($this->almacenproducto_model->listar($almacen_id));
        $conf['base_url'] = site_url('almacen/almacenproducto/listar');
        $conf['per_page'] = 20;
        $conf['num_links'] = 10;
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['total_rows'] = $data['registros'];
        $conf['uri_segment'] = 4;
        $offset = (int) $this->uri->segment(4);
        $listado = $this->almacenproducto_model->listar($almacen_id, $conf['per_page'], $offset);

        if (!$listado)
            $listado = $this->almacenproducto_model->listar2($almacen_id, $conf['per_page'], $offset);

        $item = $j + 1;
        $kk = 1;
        $lista = array();
        $producto_anterior = 0;
        $cantidad_anterior = 0;
        $costo_anterior = 0;
        $filtro = $almacen_id != "" ? true : false;
        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {
                $almacen = $valor->ALMAC_Codigo;
                $producto = $valor->PROD_Codigo;
                $producto1 = $valor->PROD_Codigo;
                $cantidad = $valor->ALMPROD_Stock;
                $costo = $valor->ALMPROD_CostoPromedio;
                $datos_producto = $this->producto_model->obtener_producto($producto);
                $nombre_prod = $datos_producto[0]->PROD_Nombre;
                $codigo_prod = $datos_producto[0]->PROD_CodigoUsuario;
                $fabricante = $datos_producto[0]->FABRIP_Codigo;
                $flagGenInd = $datos_producto[0]->PROD_GenericoIndividual;
                $datos_fab = $this->fabricante_model->obtener($fabricante);
                if ($datos_fab)
                    $nombre_fab = $datos_fab[0]->FABRIC_Descripcion;

                $nombre_fab = '';
                $nombre_prod1 = '"' . $nombre_prod . '"';
                $codigo_prod1 = '"' . $codigo_prod . '"';
                $datos_unidad = $this->producto_model->obtener_producto_unidad($producto);
                $unidad_med = $datos_unidad[0]->UNDMED_Codigo;
                $datos_unidad2 = $this->unidadmedida_model->obtener($unidad_med);
                $nombre_und = $datos_unidad2[0]->UNDMED_Simbolo;
				$dato_almacen = $this->almacenproducto_model->obtener_almacen($almacen);
                $kardex = "<a href='#' onclick='ver_kardex(" . $producto . "," . $codigo_prod1 . "," . $nombre_prod1 . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Ver Kardex'></a>";
                $lista[] = array($item++, $codigo_prod, $nombre_prod, $nombre_fab, $cantidad, $nombre_und, $costo_anterior, $cantidad_anterior * $costo_anterior, $kardex, $flagGenInd, $producto,$dato_almacen[0]->ALMAC_Descripcion);
            }
        }
        $data['registros'] = $kk;
        $data['lista'] = $lista;
        $data['titulo_tabla'] = "STOCK DE ALMACENES";
        $data['form_open'] = form_open(base_url() . 'index.php/almacen/almacenproducto/listar', array("name" => "frmStock", "id" => "frmStock"));
        $data['cboAlmacen'] = form_dropdown("almacen_id", $this->almacen_model->seleccionar($this->somevar['compania']), $almacen_id, " class='comboMedio' id='almacen_id'");
        $data['form_close'] = form_close();
        $data['form_open2'] = form_open(base_url() . 'index.php/almacen/kardex/listar', array("name" => "frmkardex", "id" => "frmkardex"));
        $data['form_close2'] = form_close();
        $data['oculto'] = form_hidden(array('accion' => "", 'codigo' => "", 'modo' => "insertar", 'base_url' => base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('almacen/almacenproducto_index', $data);
    }

    public function listar_general($j = '0') {
        $data['codigo'] = "";
        $data['nombre'] = "";
        $data['familia'] = "";
        $data['marca'] = "";

        $this->load->library('layout', 'layout');
        $data['registros'] = count($this->producto_model->listar_productos_general('B'));
        $data['action'] = base_url() . "index.php/almacen/almacenproducto/buscar_general";
        $data['action2'] = base_url() . "index.php/almacen/kardex/listar";
        $conf['base_url'] = site_url('almacen/almacenproducto/listar_general');
        $conf['per_page'] = 50;
        $conf['num_links'] = 10;
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['total_rows'] = $data['registros'];
        $conf['uri_segment'] = 4;
        $offset = (int) $this->uri->segment(4);


        $lista_producto = $this->producto_model->listar_productos_general('B', $conf['per_page'], $offset);
        $lista_establec = $this->emprestablecimiento_model->listar($this->session->userdata('empresa'));
        $item = $j + 1;
        $lista = array();
        if (count($lista_producto) > 0) {
            foreach ($lista_producto as $producto) {
                $stock = array();
                $total = 0;
                foreach ($lista_establec as $establec) {
                    $lista_almacen = $this->almacen_model->buscar_x_establec($establec->EESTABP_Codigo);
                    $cantidad = 0;
                    foreach ($lista_almacen as $almacen) {
                        $cantidad += $this->producto_model->obtener_stock($producto->PROD_Codigo, '', $almacen->ALMAP_Codigo);
                    }
                    $total+=$cantidad;
                    $stock[] = $cantidad;
                }
                $stock[] = $total;
                $lista[] = array($item++, $producto->PROD_Codigo, $producto->PROD_GenericoIndividual, $producto->PROD_CodigoUsuario, $producto->PROD_Nombre, $stock);
            }
        }
        $data['lista_establec'] = $lista_establec;
        $data['lista'] = $lista;
        $data['titulo_tabla'] = "STOCK DE GENERAL DE PRODUCTOS";
        $data['oculto'] = form_hidden(array('accion' => "", 'codigo' => "", 'modo' => "insertar", 'base_url' => base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('almacen/almacenproducto_general', $data);
    }

    public function buscar_general($j = '0') {
        $codigo = $this->input->post('txtCodigo');
        $nombre = $this->input->post('txtNombre');
        $familia = $this->input->post('txtFamilia');
        $marca = $this->input->post('txtMarca');

        if (count($_POST) > 0) {
            $this->session->set_userdata(array('codigo' => $codigo, 'nombre' => $nombre, 'familia' => $familia, 'marca' => $marca));
        } else {
            $codigo = $this->session->userdata('codigo');
            $nombre = $this->session->userdata('nombre');
            $familia = $this->session->userdata('famlia');
            $marca = $this->session->userdata('marca');
        }

        $filter = new stdClass();
        $filter->flagBS = 'B';
        $filter->codigo = $codigo;
        $filter->nombre = $nombre;
        $filter->familia = $familia;
        $filter->marca = $marca;

        $data['codigo'] = $codigo;
        $data['nombre'] = $nombre;
        $data['familia'] = $familia;
        $data['marca'] = $marca;

        $this->load->library('layout', 'layout');
        $data['registros'] = count($this->producto_model->buscar_productos_general($filter));
        $data['action'] = base_url() . "index.php/almacen/almacenproducto/buscar_general";
        $data['action2'] = base_url() . "index.php/almacen/kardex/listar";
        $conf['base_url'] = site_url('almacen/almacenproducto/buscar_general');
        $conf['per_page'] = 50;
        $conf['num_links'] = 10;
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['total_rows'] = $data['registros'];
        $conf['uri_segment'] = 4;
        $offset = (int) $this->uri->segment(4);


        $lista_producto = $this->producto_model->buscar_productos_general($filter, $conf['per_page'], $offset);
        $lista_establec = $this->emprestablecimiento_model->listar($this->session->userdata('empresa'));
        $item = $j + 1;
        $lista = array();
        if (count($lista_producto) > 0) {
            foreach ($lista_producto as $producto) {
                $stock = array();
                $total = 0;
                foreach ($lista_establec as $establec) {
                    $lista_almacen = $this->almacen_model->buscar_x_establec($establec->EESTABP_Codigo);
                    $cantidad = 0;
                    foreach ($lista_almacen as $almacen) {
                        $cantidad += $this->producto_model->obtener_stock($producto->PROD_Codigo, '', $almacen->ALMAP_Codigo);
                    }
                    $total+=$cantidad;
                    $stock[] = $cantidad;
                }
                $stock[] = $total;
                $lista[] = array($item++, $producto->PROD_Codigo, $producto->PROD_GenericoIndividual, $producto->PROD_CodigoUsuario, $producto->PROD_Nombre, $stock);
            }
        }
        $data['lista_establec'] = $lista_establec;
        $data['lista'] = $lista;
        $data['titulo_tabla'] = "STOCK DE GENERAL DE PRODUCTOS";
        $data['oculto'] = form_hidden(array('accion' => "", 'codigo' => "", 'modo' => "insertar", 'base_url' => base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('almacen/almacenproducto_general', $data);
    }

    public function ver($codigo) {
        $this->load->library('layout', 'layout');
        $datos_almacen = $this->almacen_model->obtener($codigo);
        $nombre_almacen = $datos_almacen[0]->ALMAC_Descripcion;
        $tipo_almacen = $datos_almacen[0]->TIPALM_Codigo;
        $datos_tipoalmacen = $this->tipoalmacen_model->obtener($tipo_almacen);
        $nombre_tipoalmacen = $datos_tipoalmacen[0]->TIPALM_Descripcion;
        $data['nombre_almacen'] = $nombre_almacen;
        $data['nombre_tipoalmacen'] = $nombre_tipoalmacen;
        $data['titulo'] = "VER ALMACEN";
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('almacen/almacen_ver', $data);
    }

    public function buscar($j = 0) {
        $this->load->library('layout', 'layout');
        $nombre_almacen = $this->input->post('nombre_almacen');
        $tipo_almacen = $this->input->post('tipo_almacen');
        $filter = new stdClass();
        $filter->ALMAC_Descripcion = $nombre_almacen;
        $filter->TIPALM_Codigo = $tipo_almacen;
        $data['registros'] = count($this->almacen_model->buscar($filter));
        $conf['base_url'] = site_url('almacen/almacen/buscar/');
        $conf['per_page'] = 10;
        $conf['num_links'] = 3;
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['total_rows'] = $data['registros'];
        $offset = (int) $this->uri->segment(4);
        $listado = $this->almacen_model->buscar($filter, $conf['per_page'], $offset);
        $item = $j + 1;
        $lista = array();
        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {
                $codigo = $valor->ALMAP_Codigo;
                $editar = "<a href='#' onclick='editar_almacen(" . $codigo . ")' target='_parent'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver = "<a href='#' onclick='ver_almacen(" . $codigo . ")' target='_parent'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                $eliminar = "<a href='#' onclick='eliminar_almacen(" . $codigo . ")' target='_parent'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[] = array($item++, $valor->ALMAC_Descripcion, $valor->TIPALM_Descripcion, $editar, $ver, $eliminar);
            }
        }
        $data['titulo_tabla'] = "RESULTADO DE BUSQUEDA de ALMACENES";
        $data['titulo_busqueda'] = "BUSCAR ALMACEN";
        $data['nombre_almacen'] = form_input(array('name' => 'nombre_almacen', 'id' => 'nombre_almacen', 'value' => $nombre_almacen, 'maxlength' => '100', 'class' => 'cajaMedia'));
        $data['tipo_almacen'] = form_dropdown('tipo_almacen', $this->tipoalmacen_model->seleccionar(), $tipo_almacen, "id='tipo_almacen' class='comboMedio'");
        $data['form_open'] = form_open(base_url() . 'index.php/almacen/almacen/buscar', array("name" => "form_busquedaAlmacen", "id" => "form_busquedaAlmacen"));
        $data['form_close'] = form_close();
        $data['lista'] = $lista;
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('almacen/almacen_index', $data);
    }

}

?>