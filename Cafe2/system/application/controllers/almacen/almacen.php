<?php
include("system/application/libraries/cezpdf.php");
include("system/application/libraries/class.backgroundpdf.php");

class Almacen extends controller
{
    public function __construct()
    {
        parent::Controller();
        $this->load->helper('form');
        $this->load->helper('date');
        $this->load->helper('util');
        $this->load->helper('utf_helper');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->model('almacen/almacen_model');
        $this->load->model('almacen/tipoalmacen_model');
        $this->load->model('almacen/almacenproducto_model');
        $this->load->model('almacen/fabricante_model');
        $this->load->model('almacen/unidadmedida_model');
        $this->load->helper('form', 'url');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->load->library('layout', 'layout');
        
    }

    public function listar($j = '0')
    {
        
        $data['txtAlmacen'] = "";
        $data['registros'] = count($this->almacen_model->listar($this->somevar['compania']));
        $conf['base_url'] = site_url('almacen/almacen/listar/');
        $conf['total_rows'] = $data['registros'];
        $conf['per_page'] = 10;
        $conf['num_links'] = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $offset = (int)$this->uri->segment(4);
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $listado = $this->almacen_model->listar($this->somevar['compania'], $conf['per_page'], $offset);
        $item = $j + 1;
        $lista = array();

        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {
                $codigo = $valor->ALMAP_Codigo;
                $editar = "<a href='#' onclick='editar_almacen(" . $codigo . ")'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver = "<a href='#' onclick='ver_almacen(" . $codigo . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                $eliminar = "<a href='#' onclick='eliminar_almacen(" . $codigo . ")'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[] = array($item++, $valor->ALMAC_Descripcion, $valor->EESTABC_Descripcion, $valor->ALMAC_CodigoUsuario, $valor->TIPALM_Descripcion, $editar, $ver, $eliminar);
            }
        }

        $data['lista'] = $lista;
        $data['titulo_busqueda'] = "BUSCAR ALMACEN";
        $data['nombre_almacen'] = form_input(array('name' => 'nombre_almacen', 'id' => 'nombre_almacen', 'value' => '', 'maxlength' => '100', 'class' => 'cajaMedia'));
        $data['tipo_almacen'] = form_dropdown('tipo_almacen', $this->tipoalmacen_model->seleccionar(), 'large', "id='tipo_almacen' class='comboMedio'");
        $data['form_open'] = form_open(base_url() . 'index.php/almacen/almacen/buscar', array("name" => "form_busquedaAlmacen", "id" => "form_busquedaAlmacen"));
        $data['form_close'] = form_close();
        $data['titulo_tabla'] = "Relaci&oacute;n DE ALMACENES";
        $data['oculto'] = form_hidden(array('accion' => "", 'codigo' => "", 'modo' => "insertar", 'base_url' => base_url()));
        $this->layout->view('almacen/almacen_index', $data);

    }
    
    public function tipoalmacen($j='0'){
    	 $codigos = $this->input->post('codigo');
    	
    	$listatipoalamacen = $this->tipoalmacen_model->listar();
    	$item = $j + 1;
    	$listar = array();
    	if (count($listatipoalamacen) > 0) {
	    	foreach ($listatipoalamacen as $indice => $valor){
	    		$codigo = $valor->TIPALMP_Codigo;
	    		$descripcion = $valor->TIPALM_Descripcion;
	    		//$eliminar = '<a href="#" onclick="eliminar_tipoalmacen('.$codigo.')"><img src="'.base_url().'images/eliminar.png" width="16" height="16" border="0" title="eliminar" />';
	    		$editar = "<a href='#' onclick='editar_tipoalmacen(" . $codigo . ")'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
	    		
	    		$lista[] = array($item++,$descripcion,$editar);
	    	}
    	}
    	$data["lista"] = $lista;
    	$data["titulo_busqueda"] = "TIPO ALMACEN";
    	$data["titulo_tabla"] = "Lista de Tipo Almacen";
    	
    	if($codigos == ""){
    		$data['txtdescripcion'] = "";
    		$this->layout->view('almacen/tipoalmacen_index', $data);
    	}else{
    		$buscarta = $this->tipoalmacen_model->buscar($codigos);
    		$descripciones = $buscarta[0]->TIPALM_Descripcion;
    		$data['txtdescripcion'] = "hola";	
    		$this->load->view('almacen/tipoalmacen_index', $data);
    	}
    	
    	 
    }
    
    	
    
    public function agregarta(){
    	$descipcion = $this->input->post("descripcion");
    	$this->tipoalmacen_model->insertar($descipcion);
    }
    
    public function eliminarta(){
    	$codigo = $this->input->post('codigo');
    	$this->tipoalmacen_model->eliminar_tipoalmacen($codigo);
    }

    public function nuevo()
    {
        $lista_compania = $this->compania_model->obtener_compania($this->somevar['compania']);
        $lista_estab = $this->emprestablecimiento_model->obtener($lista_compania[0]->EESTABP_Codigo);

        $this->load->library('layout', 'layout');
        $lblEstab = form_label("Establecimiento", "Establecimiento");
        $lblDescripcion = form_label("Nombre Almacen", "Nombre Almacen");
        $lblTipoAlmacen = form_label('Tipo Almacen', 'Tipo Almacen');
        $lblCodigoUsuario = form_label("CÃ³digo", "CodigoUsuario");
        $nombre_estab = form_input(array('name' => 'establecimiento', 'id' => 'establecimiento', 'value' => $lista_estab[0]->EESTABC_Descripcion, 'maxlength' => '100', 'class' => 'cajaGrande cajaSoloLectura', 'readonly' => 'readonly'));
        $nombre_almacen = form_input(array('name' => 'descripcion', 'id' => 'descripcion', 'value' => '', 'maxlength' => '100', 'class' => 'cajaMedia'));
        $tipo_almacen = form_dropdown('tipo_almacen', $this->tipoalmacen_model->seleccionar(), 'large', "id='tipo_almacen' class='comboMedio'");
        $codigo_usuario = form_input(array('name' => 'codigo_usuario', 'id' => 'codigo_usuario', 'value' => '', 'maxlength' => '20', 'class' => 'cajaPequena'));
        $data['titulo'] = "REGISTRAR ALMACEN";
        $data['form_open'] = form_open(base_url() . 'index.php/almacen/almacen/grabar', array("name" => "frmAlmacen", "id" => "frmAlmacen"));
        $data['form_close'] = form_close();
        $data['campos'] = array($lblEstab, $lblDescripcion, $lblTipoAlmacen, $lblCodigoUsuario);
        $data['valores'] = array($nombre_estab, $nombre_almacen, $tipo_almacen, $codigo_usuario);
        $data['oculto'] = form_hidden(array('codigo' => "", 'base_url' => base_url(), 'almacen_id' => ''));
        $data['onload'] = "onload=\"$('#nombres').focus();\"";
        $this->layout->view('almacen/almacen_nuevo', $data);
    }

    public function editar($id)
    {
        $lista_compania = $this->compania_model->obtener_compania($this->somevar['compania']);
        $lista_estab = $this->emprestablecimiento_model->obtener($lista_compania[0]->EESTABP_Codigo);

        $this->load->library('layout', 'layout');
        $oAlmacen = $this->almacen_model->obtener($id);
        $lblEstab = form_label("Establecimiento", "Establecimiento");
        $lblDescripcion = form_label("Nombre Almacen", "Nombre Almacen");
        $lblTipoAlmacen = form_label("Tipo Almacen", "Tipo almacen");
        $lblCodigoUsuario = form_label("CÃ³digo", "CodigoUsuario");
        $nombre_estab = form_input(array('name' => 'establecimiento', 'id' => 'establecimiento', 'value' => $lista_estab[0]->EESTABC_Descripcion, 'maxlength' => '100', 'class' => 'cajaGrande cajaSoloLectura', 'readonly' => 'readonly'));
        $nombre_almacen = form_input(array('name' => 'descripcion', 'id' => 'descripcion', 'value' => $oAlmacen[0]->ALMAC_Descripcion, 'maxlength' => '100', 'class' => 'cajaMedia'));
        $tipo_almacen = form_dropdown('tipo_almacen', $this->tipoalmacen_model->seleccionar(), $oAlmacen[0]->TIPALM_Codigo, "id='tipo_almacen' class='fuente8'");
        $codigo_usuario = form_input(array('name' => 'codigo_usuario', 'id' => 'codigo_usuario', 'value' => $oAlmacen[0]->ALMAC_CodigoUsuario, 'maxlength' => '20', 'class' => 'cajaPequena'));
        $data['form_open'] = form_open(base_url() . 'index.php/almacen/almacen/grabar/', array("name" => "frmAlmacen", "id" => "frmAlmacen"));
        $data['campos'] = array($lblEstab, $lblDescripcion, $lblTipoAlmacen, $lblCodigoUsuario);
        $data['valores'] = array($nombre_estab, $nombre_almacen, $tipo_almacen, $codigo_usuario);
        $data['oculto'] = form_hidden(array('codigo' => "", 'base_url' => base_url(), 'almacen_id' => $id));
        $data['form_close'] = form_close();
        $data['titulo'] = "Editar ALMACEN";
        $this->layout->view('almacen/almacen_nuevo', $data);
    }

    public function grabar()
    {
        $this->form_validation->set_rules('descripcion', 'Nombre de almacen', 'required');
        $this->form_validation->set_rules('tipo_almacen', 'Tipo de almacen', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->nuevo();
        } else {
            $descripcion = $this->input->post("descripcion");
            $tipo_almacen = $this->input->post("tipo_almacen");
            $almacen_id = $this->input->post("almacen_id");
            $codigo_usuario = $this->input->post("codigo_usuario");
            $filter = new stdClass();
            $lista_compania = $this->compania_model->obtener_compania($this->somevar['compania']);
            $filter->EESTABP_Codigo = $lista_compania[0]->EESTABP_Codigo;
            $filter->ALMAC_Descripcion = strtoupper($descripcion);
            $filter->TIPALM_Codigo = $tipo_almacen;
            $filter->CENCOSP_Codigo = 1;
            $filter->ALMAC_CodigoUsuario = $codigo_usuario;
            if (isset($almacen_id) && $almacen_id > 0) {
                $this->almacen_model->modificar($almacen_id, $filter);
            } else {
                $filter->COMPP_Codigo = $this->somevar['compania'];
                $this->almacen_model->insertar($filter);
            }
            header("location:" . base_url() . "index.php/almacen/almacen/listar");
        }
    }

    public function eliminar()
    {
        $id = $this->input->post('almacen');
        $this->almacen_model->eliminar($id);
    }

    public function ver($codigo)
    {
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

    public function buscar($j = 0)
    {
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
        $offset = (int)$this->uri->segment(4);
        $listado = $this->almacen_model->buscar($filter, $conf['per_page'], $offset);
        $item = $j + 1;
        $lista = array();
        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {
                $codigo = $valor->ALMAP_Codigo;
                $editar = "<a href='#' onclick='editar_almacen(" . $codigo . ")'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver = "<a href='#' onclick='ver_almacen(" . $codigo . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                $eliminar = "<a href='#' onclick='eliminar_almacen(" . $codigo . ")'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[] = array($item++, $valor->ALMAC_Descripcion, $valor->EESTABC_Descripcion, $valor->ALMAC_CodigoUsuario, $valor->TIPALM_Descripcion, $editar, $ver, $eliminar);
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

    public function reportes()
    {
        $combo = '';
        $this->load->library('layout', 'layout');
        $data['titulo'] = "REPORTES DE ALMACEN";
        $data['combo'] = $combo;
        $data['cboAlmacen'] = form_dropdown("almacen_id", $this->almacen_model->seleccionar("TODOS"), false, " class='comboMedio' id='almacen_id'");
        $this->layout->view('almacen/alamcen_reporte', $data);
    }

    public function reporte_xls($almacen_id = "")
    {
        $listado = $this->almacenproducto_model->listar($almacen_id);
        $xls = utf8_decode_seguro('<b>REPORTE DE PRODUCTOS POR ALMACEN: ') . '</b>';
        $date = date('Y-m-d');
        //$item               = $j+1;
        $kk = 1;
        $lista = array();
        $producto_anterior = 0;
        $cantidad_anterior = 0;
        $costo_anterior = 0;
        $filtro = $almacen_id != "" ? true : false;
        header('Content-Disposition: attachment; filename="' . $date . '.xls"');
        header("Content-Type: application/vnd.ms-excel");
        $xls .= "
		<table border=1>
		<tr><th>Item</th><th>" . utf8_decode_seguro('CÃ³digo Interno') . "</th><th>" . utf8_decode_seguro('DescripciÃ³n') . "</th><th>" . utf8_decode_seguro('CÃ³digo de Usuario') . "</th><th>Stock</th><th>Uni.</th><th>Costo</th><th>Valor</th></tr>
		";
        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {
                $almacen = $valor->ALMAC_Codigo;
                $producto = $valor->PROD_Codigo;
                $cantidad = $valor->ALMPROD_Stock;
                $costo = $valor->ALMPROD_CostoPromedio;
                $producto = $valor->PROD_Codigo;
                $kardex = "<a href='#' onclick='ver_kardex(" . $producto_anterior . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                if ($producto != $producto_anterior && $producto_anterior != 0) {
                    $kk++;
                    $datos_producto = $this->producto_model->obtener_producto($producto_anterior);
                    $nombre_prod = $datos_producto[0]->PROD_Nombre;
                    $codigo_prod = $datos_producto[0]->PROD_CodigoInterno;
                    $fabricante = $datos_producto[0]->FABRIP_Codigo;
                    $flagGenInd = $datos_producto[0]->PROD_GenericoIndividual;
                    $datos_fab = $this->fabricante_model->obtener($fabricante);
                    $nombre_fab = $datos_fab[0]->FABRIC_Descripcion;
                    $datos_unidad = $this->producto_model->obtener_producto_unidad($producto_anterior);
                    $unidad_med = $datos_unidad[0]->UNDMED_Codigo;
                    $datos_unidad2 = $this->unidadmedida_model->obtener($unidad_med);
                    $nombre_und = $datos_unidad2[0]->UNDMED_Simbolo;
                    $xls .= "<tr><td>" . ($indice++) . "</td><td>" . $codigo_prod . "</td><td>" . utf8_decode_seguro($nombre_prod) . "</td><td>" . $valor->PROD_CodigoUsuario . "</td><td>" . $cantidad_anterior . "</td><td>" . $nombre_und . "</td><td>" . number_format($costo_anterior, 2) . "</td><td>" . number_format($cantidad_anterior * $costo_anterior, 2) . "</td></tr>";
                } elseif ($producto == $producto_anterior) {
                    $cantidadn = $cantidad_anterior + $cantidad;
                    $coston = ($cantidad_anterior * $costo_anterior + $cantidad * $costo) / $cantidadn;
                    $cantidad = $cantidadn;
                    $costo = $coston;
                }
                $producto_anterior = $producto;
                $cantidad_anterior = $cantidad;
                $costo_anterior = $costo;
            }
            $datos_producto = $this->producto_model->obtener_producto($producto);
            $nombre_prod = $datos_producto[0]->PROD_Nombre;
            $codigo_prod = $datos_producto[0]->PROD_CodigoInterno;
            $fabricante = $datos_producto[0]->FABRIP_Codigo;
            $flagGenInd = $datos_producto[0]->PROD_GenericoIndividual;
            $datos_fab = $this->fabricante_model->obtener($fabricante);
            $nombre_fab = $datos_fab[0]->FABRIC_Descripcion;
            $datos_unidad = $this->producto_model->obtener_producto_unidad($producto);
            $unidad_med = $datos_unidad[0]->UNDMED_Codigo;
            $datos_unidad2 = $this->unidadmedida_model->obtener($unidad_med);
            $nombre_und = $datos_unidad2[0]->UNDMED_Simbolo;
            $xls .= "<tr><td>" . ($indice++) . "</td><td>" . $codigo_prod . "</td><td>" . utf8_decode_seguro($nombre_prod) . "</td><td>" . $valor->PROD_CodigoUsuario . "</td><td>" . $cantidad_anterior . "</td><td>" . $nombre_und . "</td><td>" . number_format($costo_anterior, 2) . "</td><td>" . number_format($cantidad_anterior * $costo_anterior, 2) . "</td></tr>";
        }
        $data['xls'] = $xls;
        $this->load->view('almacen/almacen_reporte_xls', $data);
    }
}

?>