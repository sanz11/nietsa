<?php

class Inventario extends Controller
{

    public function __construct()
    {
        parent::Controller();
        $this->load->library('pagination');

        ///stv
        $this->load->model('almacen/guiain_model');
        $this->load->model('almacen/guiaindetalle_model');
        //////
        $this->load->model('almacen/inventario_model');
        $this->load->model('almacen/kardex_model');
        $this->load->model('almacen/almacen_model');
        $this->load->model('almacen/almacenproducto_model');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->load->model('maestros/configuracion_model');
    }


    public function listar($j = 0)
    {


        $this->load->library('layout', 'layout');

        $count_datos = $this->inventario_model->count_inventario();
        $data['registros'] = $count_datos[0]->conteo;
        $data['lista'] = array();

        $data['titulo_busqueda'] = 'Listado de Inventarios Realizados';

        $conf['base_url'] = site_url('almacen/inventario/listar/');
        $conf['per_page'] = 15;
        $conf['num_links'] = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['total_rows'] = $data['registros'];
        $conf['last_link'] = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $offset = (int)$this->uri->segment(4);
        $this->pagination->initialize($conf);

        $data['t_indice'] = $j;

        $datos = $this->inventario_model->buscar_inventario(NULL, $conf['per_page'], $offset);
        $data['paginacion'] = $this->pagination->create_links();


        $data['lista'] = $datos;
        $this->layout->view('almacen/inventario_index', $data);
    }

    public function listar_refresh($j = 0)
    {


        $count_datos = $this->inventario_model->count_inventario();
        $data['registros'] = $count_datos[0]->conteo;
        $data['lista'] = array();

        $data['titulo_busqueda'] = 'Listado de Inventarios Realizados';

        $conf['base_url'] = site_url('almacen/inventario/listar/');
        $conf['per_page'] = 15;
        $conf['num_links'] = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['total_rows'] = $data['registros'];
        $conf['last_link'] = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $offset = (int)$this->uri->segment(4);
        $this->pagination->initialize($conf);

        $data['t_indice'] = $j;

        $datos = $this->inventario_model->buscar_inventario(NULL, $conf['per_page'], $offset);
        $data['paginacion'] = $this->pagination->create_links();


        $data['lista'] = $datos;
        $this->load->view('almacen/inventario_index_refresh', $data);
    }

    public function nuevo()
    {

        $data['titulo'] = 'REGISTRO DE NUEVO INVENTARIO';
        $data['action'] = base_url() . 'index.php/almacen/inventario/insertar';
        $data['fecha_registro'] = date('d/m/Y');
        $data['fecha_final'] = '0000-00-0';

        $data['cod_inventario'] = '';
        $compania = $this->session->userdata('compania');

        // $establecimiento = $this->session->userdata('idcompania');

        $data['almacenes'] = $this->almacen_model->buscar_x_compania($compania);

        $data['almacen'] = '';
        $data['titulo'] = '';

        $documento = $this->configuracion_model->obtener_numero_documento($compania, 4);

        $data['serie'] = str_pad($documento[0]->CONFIC_Serie, 3, "0", STR_PAD_LEFT);
        $data['numero'] = str_pad($documento[0]->CONFIC_Numero, 6, "0", STR_PAD_LEFT);

        $this->load->view('almacen/inventario_nuevo', $data);
    }

    public function modificar($cod_inventario)
    {
        $data['titulo'] = 'MODIFICAR INVENTARIO';
        $data['action'] = base_url() . 'index.php/almacen/inventario/editar';


        $data['cod_inventario'] = $cod_inventario;
        $compania = $this->session->userdata('compania');
        $data['almacenes'] = $this->almacen_model->buscar_x_compania($compania);

        $filter = new stdClass();
        $filter->cod_inventario = $cod_inventario;
        $datos = $this->inventario_model->buscar_inventario($filter);
        $data['fecha_registro'] = $datos[0]->INVE_FechaInicio;
        if ($datos[0]->INVE_FlagEstado == 1)
            $data['fecha_final'] = $datos[0]->INVE_FechaFin;
        else
            $data['fecha_final'] = '0000-00-00';

        $data['almacen'] = $datos[0]->ALMAP_Codigo;
        $data['titulo'] = $datos[0]->INVE_Titulo;

        $data['serie'] = str_pad($datos[0]->INVE_Serie, 3, "0", STR_PAD_LEFT);
        $data['numero'] = str_pad($datos[0]->INVE_Numero, 6, "0", STR_PAD_LEFT);

        $this->load->view('almacen/inventario_nuevo', $data);
    }

    public function insertar()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $datos = $_POST;

            $resul = $this->inventario_model->insertar($datos);

            if ($resul)
                die('ok');
            else
                die('ERROR: No se puedo completar la operación.');
        }
    }

    public function editar()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $datos = $_POST;

            $resul = $this->inventario_model->editar($datos);

            if ($resul)
                die('ok');
            else
                die('ERROR: No se puedo completar la operación.');
        }
    }

    public function agregar_detalle($cod_inventario)
    {
        $data['compania'] = $this->somevar['compania'];
        $data['titulo'] = 'AGREGAR DETALLE AL INVENTARIO';
        $data['action'] = base_url() . 'index.php/almacen/inventario/insertar_detalle';


        $data['cod_inventario'] = $cod_inventario;

        $filter = new stdClass();
        $filter->cod_inventario = $cod_inventario;
        $datos = $this->inventario_model->buscar_inventario($filter);
        $data['fecha_registro'] = $datos[0]->INVE_FechaInicio;
        $data['INVE_FlagEstado'] = $datos[0]->INVE_FlagEstado;
        if ($datos[0]->INVE_FlagEstado == 1)
            $data['fecha_final'] = $datos[0]->INVE_FechaFin;
        else
            $data['fecha_final'] = '0000-00-00';

        $data['titulo'] = $datos[0]->INVE_Titulo;
        $data['serie'] = str_pad($datos[0]->INVE_Serie, 3, "0", STR_PAD_LEFT);
        $data['numero'] = str_pad($datos[0]->INVE_Numero, 6, "0", STR_PAD_LEFT);

        $this->load->view('almacen/inventario_nuevo_detalle', $data);
    }

    public function insertar_detalle()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $datos = $_POST;

            $result = $this->inventario_model->insertar_detalle($datos);

            if ($result)
                $this->cargar_detalle($datos['cod_inventario']);
        }
    }

    public function editar_detalle()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $datos = $_POST;

            $result = $this->inventario_model->editar_detalle($datos);

            if ($result)
                $this->cargar_detalle($datos['cod_inventario']);
        }
    }

    public function eliminar_detalle()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $datos = $_POST;

            $result = $this->inventario_model->eliminar_detalle($datos);

            if ($result)
                $this->cargar_detalle($datos['cod_inventario']);
        }
    }

    public function inve()
    {
        //16836- 22336
        for ($i = 21501; $i <= 22336; $i++) {
            $this->generar_movimiento($i, 31);
            echo $i . '<br>';
        }
        echo 'done';
    }

    public function generar_movimiento($cod_detalle, $cod_inventario)
    {

        //    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //  $datos = $_POST;

        //  $cod_detalle = $datos['cod_detalle'];

        $filter_ = new stdClass();
        $filter_->codigo_detalle = $cod_detalle;

        $data = $this->inventario_model->buscar_inventario_detalles($filter_);


        $filter = new stdClass();
        $filter->KARD_Fecha = date('Y-m-d');

        $filter->KARDC_Cantidad = $data[0]->INVD_Cantidad;
        $filter->PROD_Codigo = $data[0]->PROD_Codigo;


        ///////
        $filter->KARDC_Costo = $data[0]->INVD_Pcosto;
        /////////


        $filter->KARDC_TipoIngreso = 3;
        $filter->LOTP_Codigo = NULL;
        $filter->TIPOMOVP_Codigo = NULL;

        ///stv
        $prod = '';
        $cod_inv = '';
        $cod_inv = $data[0]->INVE_Codigo;
        $prod = $data[0]->PROD_Codigo;
        ////

        $filter->KARDC_CodigoDoc = $data[0]->INVE_Codigo;

        $this->kardex_model->insertar(4, $filter);


        ////////////aumentado  stv

        $filter7 = new stdClass();
        $filter7->cod_inventario = $cod_inv;
        $data_inv = $this->inventario_model->buscar_inventario($filter7);
        $almacen = '';
        if (count($data_inv) > 0) {
            $almacen = $data_inv[0]->ALMAP_Codigo;
        }

        //////cabecera
        $filter3 = new stdClass();
        $filter3->TIPOMOVP_Codigo = 2;
        $filter3->ALMAP_Codigo = $almacen;
        $filter3->PROVP_Codigo = 1114;
        $filter3->DOCUP_Codigo = 8;
        $filter3->GUIAINC_Fecha = date('Y-m-d');
        $filter3->GUIAINC_Observacion = '';
        $filter3->USUA_Codigo = 1;
        $filter3->GUIAINC_Automatico = 1;
        $guia_id = $this->guiain_model->insertar($filter3);


        ////////detalle
        $filter4 = new stdClass();
        $filter4->GUIAINP_Codigo = $guia_id;
        $filter4->PRODCTOP_Codigo = $prod;
        $filter4->UNDMED_Codigo = 8;
        $filter4->GUIIAINDETC_GenInd = NULL;

        /////
        $filter4->GUIAINDETC_Cantidad = 0;  //$data[0]->INVD_Cantidad
        //////

        ////////
        $filter4->GUIAINDETC_Costo = $data[0]->INVD_Pcosto;;
        ////////
// No estoy muy seguro de si debe agarrar este precio, porque puede ser $costo, $venta

        $filter4->GUIAINDETC_Descripcion = 'G';
        $this->guiaindetalle_model->insertar($filter4);


        //////kardex

//                    $filter = new stdClass();
//                    $filter->KARD_Fecha = date('Y-m-d');
//
//                    $filter->KARDC_Cantidad = 0;
//                    $filter->PROD_Codigo = $data[0]->PROD_Codigo;
//
//                    $filter->KARDC_Costo = 0;
//                    $filter->KARDC_TipoIngreso = 3;
//                    $filter->LOTP_Codigo = NULL;
//                    $filter->TIPOMOVP_Codigo = NULL;    
//                        
//                    $filter->KARDC_CodigoDoc = $guia_id;
//
//                    $this->kardex_model->insertar(5, $filter);

        ///////////


        $filter__ = new stdClass();
        $filter__->cod_inventario = $data[0]->INVE_Codigo;

        $datos_inventaio = $this->inventario_model->buscar_inventario($filter__);

        $this->almacenproducto_model->colocar_stock($datos_inventaio[0]->ALMAP_Codigo, $data[0]->PROD_Codigo, $data[0]->INVD_Cantidad);

        $result = $this->inventario_model->editar_detalle_activacion($cod_detalle);

        if ($result)
            $this->cargar_detalle($cod_inventario);
        //echo 'A-';
        else
            die('ERROR');
        //   }
    }

    public function cargar_detalle($cod_inventario, $j = 0)
    {

        $data['lista'] = array();
        $filter = new stdClass();
        $filter->codigo_inventario = $cod_inventario;
        $c_datos = count($this->inventario_model->buscar_inventario_detalles($filter));

        $conf['base_url'] = site_url('almacen/inventario/cargar_detalle/' + $cod_inventario);
        $conf['per_page'] = 10;
        $conf['num_links'] = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['total_rows'] = $c_datos;
        $conf['last_link'] = "&gt;&gt;";
        $conf['uri_segment'] = 5;
        $offset = (int)$this->uri->segment(5);
        $this->pagination->initialize($conf);

        $data['t_indice'] = $j;


        $datos = $this->inventario_model->buscar_inventario_detalles($filter, $conf['per_page'], $j);

        $data['paginacion'] = $this->pagination->create_links();


        $data['lista'] = $datos;
        $this->load->view('almacen/inventario_detalle_refresh', $data);
    }

    public function encuentrax_producto()
    {
        $compania = $this->somevar['compania'];
        $keyword = $this->input->post('term');


        $query = mysql_query("SELECT `cji_producto`.*

         FROM (`cji_productocompania`) 

         LEFT JOIN `cji_producto` ON `cji_producto`.`PROD_Codigo` = `cji_productocompania`.`PROD_Codigo` 
         
         WHERE PROD_FlagBienServicio = 'B' 
         AND   `cji_productocompania`.`COMPP_Codigo`='" . $compania . "'
         AND   `cji_producto`.`PROD_FlagEstado`=1
         AND `cji_producto`.`PROD_Nombre` LIKE '" . $keyword . "%' ORDER BY `cji_producto`.`PROD_Nombre` LIMIT 10");


        $result = array();


        while ($data = mysql_fetch_assoc($query)) {

            //

            $cod_prod = $data['PROD_Codigo'];

//            $que = mysql_query("SELECT PRODATRIB_String FROM  `cji_productoatributo` WHERE  `ATRIB_Codigo` =4  AND PROD_Codigo=" . $cod_prod);
//
//            $dat = mysql_fetch_assoc($que);

            //stock

            $consulta = mysql_fetch_assoc(mysql_query("SELECT ALMPROD_Stock FROM  `cji_almacenproducto` WHERE    PROD_Codigo=" . $cod_prod));

//            //ATRIBUTO 2
//
//            $atrib2 = mysql_fetch_assoc(mysql_query("SELECT PRODATRIB_String FROM  `cji_productoatributo` WHERE  `ATRIB_Codigo` =1 AND PROD_Codigo=" . $cod_prod));
//
//            //PRECIO 
//
//            $precio = mysql_fetch_assoc(mysql_query("SELECT PRODPREC_Precio FROM  `cji_productoprecio` WHERE  `PRODPREC_FlagEstado` =1 AND PROD_Codigo=" . $cod_prod));

            //------------------------------------------------------------------------------------------	

            $result[] = array("value" => $data['PROD_Nombre'], "codigo" => $data['PROD_Codigo'], "codinterno" => $data['PROD_CodigoUsuario'], "stock" => $consulta['ALMPROD_Stock']);
        }


        echo json_encode($result);
    }

    ///gcbq
    public function activacion_inventario()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $datos = $_POST;

            $result = $this->inventario_model->activacion_inventario($datos);

            if ($result)
                $this->cargar_detalle($datos['cod_inventario']);
        }

    }

    public function imprimir_detalle_inventario()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filter = new stdClass();
            $filter->codigo_inventario = $_POST['cod_inventario'];
            $lista = $this->inventario_model->buscar_inventario_detalles($filter);

            if (count($lista) > 0) {
                echo '<table>';
                echo '<tr class="cabeceraTabla">
            <td style="width: 50px">ITEM</td>
            <td style="width: 550px;">ARTICULO</td>
            <td style="width: 70px">CANTIDAD</td>
			<td style="width: 70px">PRECIO</td>
        </tr>';
                foreach ($lista as $indice => $valor) {
                    echo '<tr>';
                    echo '<td>';
                    echo $indice + 1;
                    echo '</td>';
                    echo '<td>' . $valor->PROD_Nombre . ' ' . $valor->PROD_Presentacion . '</td>';
                    echo '<td style="border:1px solid black;width:50px;height:20px;">';
                    if ($valor->INVD_Cantidad != 0.00) echo $valor->INVD_Cantidad;
                    echo '</td>';
                    echo '<td style="border:1px solid black;width:50px;height:20px;">';
                    if ($valor->INVD_Pcosto != 0) echo $valor->INVD_Pcosto;
                    echo '</td>';
                    echo '</tr>';


                }

                echo '</table>';
            }

        }
    }

    public function eliminar_historia()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filter = new stdClass();
            $filter->codigo_inventario = $_POST['cod_inventario'];
            $lista = $this->inventario_model->buscar_inventario_detalles($filter);
            $flagestado = '';
            if (count($lista) > 0) {
                foreach ($lista as $indice => $valor) {
                    if ($valor->INVD_FlagActivacion == 1) {
                        $flagestado = 1;
                        break;
                    } else {
                        $flagestado = 0;
                    }

                }
                if ($flagestado == 1) {
                    echo 'NO se puede Borrar Contiene Articulos ya Ingresados y Articulos Activados';
                } else {
                    $this->inventario_model->eliminar_inventario_detalles($_POST['cod_inventario']);
                    echo 'Inventario y Articulos No activados BORRADOS';
                }
            } else {
                $this->inventario_model->eliminar_inventario($_POST['cod_inventario'], '');
                echo 'Inventario Borrado No Contiene Articulos';

            }


        }
    }


}