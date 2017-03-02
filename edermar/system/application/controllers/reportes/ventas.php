<?php

include("system/application/libraries/cezpdf.php");
include("system/application/libraries/class.backgroundpdf.php");

class Ventas extends Controller {

    public function __construct() {
        parent::Controller();
        $this->load->helper('form');
        $this->load->helper('date');
        $this->load->helper('util');
        $this->load->model('reportes/ventas_model');
        $this->load->model('almacen/producto_model');
        $this->load->model('ventas/comprobantedetalle_model');
        $this->load->model('maestros/moneda_model');
        $this->load->model('tesoreria/cuentas_model');
        $this->load->model('tesoreria/pago_model');
        $this->load->model('tesoreria/cuentaspago_model');

        $this->somevar['user'] = $this->session->userdata('user');
        $this->somevar['rol'] = $this->session->userdata('rol');
        $this->somevar['empresa'] = $this->session->userdata('empresa');
    }

    public function filtroVendedor() {
        $this->load->library('layout', 'layout');
        $data['fecha_inicio'] = '';
        $data['fecha_fin'] = '';

        if (isset($_POST['reporte'])) {
            $data['fecha_inicio'] = $_POST['fecha_inicio'];
            $data['fecha_fin'] = $_POST['fecha_fin'];
            $data['resumen'] = $this->ventas_model->ventas_por_vendedor_resumen($data['fecha_inicio'], $data['fecha_fin']);
            $data['mensual'] = $this->ventas_model->ventas_por_vendedor_mensual($data['fecha_inicio'], $data['fecha_fin']);
            $data['anual'] = $this->ventas_model->ventas_por_vendedor_anual($data['fecha_inicio'], $data['fecha_fin']);
        }
        $this->layout->view('reportes/ventas_por_vendedor', $data);
    }
    
    public function filtroCliente() {
    	$this->load->library('layout', 'layout');
    	$data['fecha_inicio'] = '';
    	$data['fecha_fin'] = '';
    
    	if (isset($_POST['reporte'])) {
    		$data['cliente'] = $_POST['cliente'];
    		$data['nombre_cliente'] = $_POST['nombre_cliente'];
    		$data['buscar_cliente'] = $_POST['buscar_cliente'];
    		$data['fecha_inicio'] = $_POST['fecha_inicio'];
    		$data['fecha_fin'] = $_POST['fecha_fin'];
    		$data['resumen'] = $this->ventas_model->ventas_por_cliente_resumen($data['fecha_inicio'], $data['fecha_fin'],$data['cliente']);
    		$data['mensual'] = $this->ventas_model->ventas_por_cliente_mensual($data['fecha_inicio'], $data['fecha_fin'],$data['cliente']);
    		$data['anual'] = $this->ventas_model->ventas_por_cliente_anual($data['fecha_inicio'], $data['fecha_fin'],$data['cliente']);
    	}
    	$this->layout->view('reportes/ventas_por_cliente', $data);
    }
	
	public function filtroTienda() {
		
		 $monthf = date('m');
      $yearf = date('Y');
       
	   $monthi = date('m');
      $yeari = date('Y');
       //date('Y-m-d', mktime(0,0,0, $monthf, $dayf, $yearf))
		
        $this->load->library('layout', 'layout');
        $data['fecha_inicio'] = '';
        $data['fecha_fin'] = '';

        if (isset($_POST['reporte'])) {
            $data['fecha_inicio'] = $_POST['fecha_inicio'];
            $data['fecha_fin'] = $_POST['fecha_fin'];
			
			$data['resumen'] = $this->ventas_model->ventas_por_tienda_resumen($data['fecha_inicio'], $data['fecha_fin']);
         $data['mensual'] = $this->ventas_model->ventas_por_tienda_mensual($data['fecha_inicio'], $data['fecha_fin']);
         $data['anual'] = $this->ventas_model->ventas_por_tienda_anual($data['fecha_inicio'], $data['fecha_fin']);
        }
		 
        $this->layout->view('reportes/ventas_por_tienda', $data);
    }

    public function filtroMarca() {
        $this->load->library('layout', 'layout');
        $data['fecha_inicio'] = '';
        $data['fecha_fin'] = '';

        if (isset($_POST['reporte'])) {
            $data['fecha_inicio'] = $_POST['fecha_inicio'];
            $data['fecha_fin'] = $_POST['fecha_fin'];
            $data['resumen'] = $this->ventas_model->ventas_por_marca_resumen($data['fecha_inicio'], $data['fecha_fin']);
            $data['mensual'] = $this->ventas_model->ventas_por_marca_mensual($data['fecha_inicio'], $data['fecha_fin']);
            $data['anual'] = $this->ventas_model->ventas_por_marca_anual($data['fecha_inicio'], $data['fecha_fin']);
        }
        $this->layout->view('reportes/ventas_por_marca', $data);
    }

    public function filtroFamilia() {
        $this->load->library('layout', 'layout');
        $data['fecha_inicio'] = '';
        $data['fecha_fin'] = '';

        if (isset($_POST['reporte'])) {
            $data['fecha_inicio'] = $_POST['fecha_inicio'];
            $data['fecha_fin'] = $_POST['fecha_fin'];
            $data['resumen'] = $this->ventas_model->ventas_por_familia_resumen($data['fecha_inicio'], $data['fecha_fin']);
            $data['mensual'] = $this->ventas_model->ventas_por_familia_mensual($data['fecha_inicio'], $data['fecha_fin']);
            $data['anual'] = $this->ventas_model->ventas_por_familia_anual($data['fecha_inicio'], $data['fecha_fin']);
        }
        $this->layout->view('reportes/ventas_por_familia', $data);
    }
	//gcbq
 public function filtroProducto() {
        $this->load->library('layout', 'layout');
        $data['fecha_inicio'] = '';
        $data['fecha_fin'] = '';

        if (isset($_POST['reporte'])) {
            $data['fecha_inicio'] = $_POST['fecha_inicio'];
            $data['fecha_fin'] = $_POST['fecha_fin'];
            $data['resumen'] = $this->ventas_model->ventas_por_producto_resumen($data['fecha_inicio'], $data['fecha_fin']);
            $data['mensual'] = $this->ventas_model->ventas_por_producto_mensual($data['fecha_inicio'], $data['fecha_fin']);
            $data['anual'] = $this->ventas_model->ventas_por_producto_anual($data['fecha_inicio'], $data['fecha_fin']);
        }
        $this->layout->view('reportes/ventas_por_producto', $data);
    }
    
        public function Producto_stock() {
        $this->load->library('layout', 'layout');
     
        $listado_productos = $this->ventas_model->producto_stock();
        
         if(count($listado_productos)>0){
         foreach($listado_productos as $indice=>$valor){
                            $nombre         = $valor->PROD_Nombre;
                            $fecha            = $valor->fecha;
                            $dias            = $valor->dias;
                            $lista[]        = array($nombre,$fecha,$dias);
                    }
        }
        $data['lista'] = $lista;
        
        $this->layout->view('reportes/producto_stock', $data);
    }
    
    public function filtroDiario() {
        $this->load->library('layout', 'layout');
       $fecha_actual = date('Y-m-d'); 
        $data['fecha_inicio'] =   $fecha_actual;
        $data['fecha_fin'] =   $fecha_actual;

        if (isset($_POST['reporte'])) {
            $data['fecha_inicio'] = $_POST['fecha_inicio'];
            $data['fecha_fin'] = $_POST['fecha_fin'];
            //$data['resumen'] = $this->ventas_model->ventas_por_dia($data['fecha_inicio'], $data['fecha_fin']);
        }
        $data['resumen'] = $this->ventas_model->ventas_por_dia($data['fecha_inicio'], $data['fecha_fin']);
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('reportes/ventas_por_dia', $data);
    }

    public function ventasdiario($tipo = 'F') {

        $this->load->library('layout', 'layout');
        $hoy = date('Y-m-d');
        $data['titulo'] = "Ventas Diarias";
        $data['tipo_docu'] = $tipo;
        $data['titulo_tabla'] = "Ventas del dia";
        $data['lista'] = $this->ventas_model->ventas_diarios($tipo, $hoy);
        $data['fecha'] = $hoy;

        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('reportes/ventas_diarios', $data);
    }

    public function registro_ventas($tipo_oper, $tipo = 'F', $fecha1 = '', $fecha2 = '') {

        $this->load->library('layout', 'layout');

        if ($tipo_oper == 'V')
            $data['titulo'] = "Registro de Ventas Desde " . $fecha1 . " Hasta " . $fecha2;
        else
            $data['titulo'] = "Registro de Compras Desde " . $fecha1 . " Hasta " . $fecha2;

        $data['tipo_docu'] = $tipo;
        $data['tipo_oper'] = $tipo_oper;
        if ($tipo_oper == 'V')
            $data['titulo_tabla'] = "Registro de Ventas ";
        else
            $data['titulo_tabla'] = "Registro de Compras ";
        $data['lista'] = $this->ventas_model->registro_ventas($tipo_oper, $tipo, $fecha1, $fecha2);
        // echo $this->db->last_query();
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('reportes/registro_ventas', $data);
    }
public function ejecutarAjax(){
    $tipo_oper=$this->input->post('tipo_oper');
    $tipo=$this->input->post('tipo_doc');
    $fecha1=$this->input->post('fecha1');
    $fecha2=$this->input->post('fecha2');
    
 $lista= $this->ventas_model->registro_ventas($tipo_oper, $tipo, $fecha1, $fecha2); 
 $RetornarTable="";
$RetornarTable.='<table class="fuente8 tableReporte" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                    <tr class="cabeceraTabla ">
                        <td width="10%">FEHCA DE EMISION</td>
                        <td width="7%">TIPO</td>
                        <td width="5%">SERIE</td>
                        <td width="5%">NUMERO</td>
                        <td width="10%">NOMBRE Y/O RAZON SOCIAL</td>
                        <td width="5%">RUC</td>
                        <td width="5%">VALOR VENTA</td>
                        <td width="5%">I.G.V</td>
                        <td width="5%">TOTAL IMPORTE</td>
                    </tr>';
if(count($lista)>0){
    $valor_ventaS = 0;
    $valor_igvS = 0;
    $valor_totalS =0;
    $valor_ventaD = 0;
    $valor_igvD = 0;
    $valor_totalD =0;
  foreach ($lista as $indice => $valor) {
                            $fecha = $valor->CPC_Fecha;
                            $tipo = $valor->CPC_TipoDocumento;
                            $serie = $valor->CPC_Serie;
                            $numero = $valor->CPC_Numero;
                            $flag = $valor->CPC_FlagEstado;
                            $tipo_persona = $valor->CLIC_TipoPersona;
                            $tipo_proveedor = $valor->PROVC_TipoPersona;
                            $tipo_Moneda=$valor->MONED_Simbolo;
                            $cod_Moneda=$valor->MONED_Codigo;
                            if ($flag == 1) {
                                $venta = $valor->CPC_subtotal;
                                $igv = $valor->CPC_igv;
                                $total = $valor->CPC_total;

                               if($cod_Moneda==1){
                                $valor_ventaS += $venta;
                                $valor_igvS += $igv;
                                $valor_totalS +=$total;}
                                if($cod_Moneda==2){
                                $valor_ventaD += $venta;
                                $valor_igvD += $igv;
                                $valor_totalD +=$total;}    
                                
                                
                                if ($tipo_oper == 'V') {
                                    if ($tipo_persona == '0') {
                                        $nombre = $valor->PERSC_Nombre . " " . $valor->PERSC_ApellidoPaterno . " " . $valor->PERSC_ApellidoMaterno;
                                        $ruc = $valor->PERSC_Ruc;
                                    } else {
                                        $nombre = $valor->EMPRC_RazonSocial;
                                        $ruc = $valor->EMPRC_Ruc;
                                    }
                                } else {
                                    if ($tipo_proveedor == '0') {
                                        $nombre = $valor->PERSC_Nombre . " " . $valor->PERSC_ApellidoPaterno . " " . $valor->PERSC_ApellidoMaterno;
                                        $ruc = $valor->PERSC_Ruc;
                                    } else {
                                        $nombre = $valor->EMPRC_RazonSocial;
                                        $ruc = $valor->EMPRC_Ruc;
                                    }
                                }
                            } else {

                                $nombre = "ANULADO";
                                $ruc = "";
                                $venta = "";
                                $igv = "";
                                $total = "";
                            }
                           // $class = $indice % 2 == 0 ? 'itemParTabla' : 'itemImparTabla';
   $RetornarTable.='<tr>
                <td><div align="center">'.$fecha.'</div></td>
                <td><div align="left">';
                if ($tipo == 'F')
                $RetornarTable.="Factura";
                    elseif($tipo == 'B')
                  $RetornarTable.="Boleta";
              elseif($tipo == 'N')
                $RetornarTable.="Comprobante";
    $RetornarTable.='</div></td>';
   $RetornarTable.='<td><div align="center">'.$serie.'</div></td>
                    <td><div align="center">'.$numero.'</div></td>
                    <td><div align="center">'.$nombre.'</div></td>
                    <td><div align="center">'.$ruc.'</div></td>';
    //$RetornarTable.='<td><div align="center">';
                        //if ($venta != NULL)
                         //$RetornarTable.=$venta;
                         //else
                        //$RetornarTable.="0.00";
    //$RetornarTable.='</div></td>';
    //$RetornarTable.='</div></td><td><div align="center">';
                    //if ($igv != NULL)
                    //    $RetornarTable.=$igv;
                    //else
                    //$RetornarTable.="0.00";
    //$RetornarTable.='</div></td>';
    //$RetornarTable.='<td><div align="center">'.$tipo_Moneda.'&nbsp;'.$total.'</div></td>';
   $RetornarTable.='<td><div align="center">'.$valor_ventaS.'</div></td><td><div align="center">'.$valor_igvS.'</div></td>
<td><div align="center">S/.'.number_format($valor_totalS, 2).'</div></td> ';
                        

              
}

}                                      
else {
$RetornarTable.='<table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">
                        <tbody>
                            <tr>
                                <td width="100%" class="mensaje">No hay ning&uacute;n registro que cumpla con los criterios de b&uacute;squeda</td>
                            </tr>
                        </tbody>
                    </table>';

}

echo $RetornarTable;
 
}
    public function ventasdiario_fecha($tipo = 'F', $hoy) {

        $this->load->library('layout', 'layout');

        $data['titulo'] = "Ventas Diarias";
        $data['tipo_docu'] = $tipo;
        $data['titulo_tabla'] = "Ventas del dia";
        $data['lista'] = $this->ventas_model->ventas_diarios($tipo, $hoy);
        $data['fecha'] = $hoy;

        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('reportes/ventas_diarios', $data);
    }

    public function ventas_pdf($tipo_doc = "F", $hoy) {

        if ($tipo_doc == "F")
            $titulo = "REPORTE FACTURAS";
        if ($tipo_doc == "B")
            $titulo = "REPORTE BOLETAS";
        if ($tipo_doc == "N")
            $titulo = "REPORTE COMPROBANTES";
        $lista = $this->ventas_model->ventas_diarios($tipo_doc, $hoy);
        $this->cezpdf = new Cezpdf('a4', 'landscape');
        $this->cezpdf->ezText(($titulo . "  DIARIO  "), 11, array("left" => 180));

        $this->cezpdf->ezText('', '');
        /* Listado de detalles */
        $db_data = array();
        $valor_venta = 0;
        $valor_igv = 0;
        $valor_total = 0;
        foreach ($lista as $indice => $valor) {
            $tipo = $valor->CPC_TipoDocumento;
            $tipo_persona = $valor->CLIC_TipoPersona;
            $flag = $valor->CPC_FlagEstado;
            $nombre = '';
            if ($flag == 1) {

                if ($tipo_doc != "F") {
                    $subtotal = number_format($valor->CPC_total / 1.18, 2);
                    $igv = number_format($subtotal * 0.18, 2);
                } else {
                    $igv = $valor->CPC_igv;
                    $subtotal = $valor->CPC_subtotal;
                }
                $total = $valor->CPC_total;
                $valor_venta +=$subtotal;
                $valor_igv +=$igv;
                $valor_total +=$total;


                if ($tipo_doc == 'F')
                    $nombre = 'Factura';
                else
                    $nombre = 'Boleta';

                if ($tipo_persona == '0') {
                    $nombre_cliente = $valor->PERSC_Nombre . " " . $valor->PERSC_ApellidoPaterno . " " . $valor->PERSC_ApellidoMaterno;
                    $ruc = $valor->PERSC_Ruc;
                } else {
                    $nombre_cliente = $valor->EMPRC_RazonSocial;
                    $ruc = $valor->EMPRC_Ruc;
                }
            } else {
                $nombre_cliente = "ANULADO";
                $ruc = "";
                $subtotal = "";
                $igv = "";
                $total = "";
            }

            $db_data[] = array(
                'cols1' => $valor->CPC_Fecha,
                'cols2' => $nombre,
                'cols3' => $valor->CPC_Serie,
                'cols4' => $valor->CPC_Numero,
                'cols5' => $nombre_cliente,
                'cols6' => $ruc,
                'cols7' => $subtotal,
                'cols8' => $igv,
                'cols9' => $total,
            );
        }
        $col_names = array(
            'cols1' => 'Fecha',
            'cols2' => 'Tipo',
            'cols3' => 'Serie',
            'cols4' => 'Numero',
            'cols5' => 'Cliente',
            'cols6' => 'Ruc',
            'cols7' => 'Valor Venta',
            'cols8' => '   I.G.V      ',
            'cols9' => 'Importe Total',
        );

        $this->cezpdf->ezTable($db_data, $col_names, '', array(
            'width' => 450,
            'showLines' => 2,
            'shaded' => 0,
            'Leading' => 10,
            'showHeadings' => 1,
            'xPos' => 300,
            'fontSize' => 8,
            'cols' => array(
                'cols1' => array('width' => 58, 'justification' => 'center'),
                'cols2' => array('width' => 42, 'justification' => 'left'),
                'cols3' => array('width' => 35, 'justification' => 'left'),
                'cols4' => array('width' => 45, 'justification' => 'left'),
                'cols5' => array('width' => 155, 'justification' => 'center'),
                'cols6' => array('width' => 66, 'justification' => 'left'),
                'cols7' => array('width' => 54, 'justification' => 'left'),
                'cols9' => array('width' => 48, 'justification' => 'left'),
                'cols9' => array('width' => 48, 'justification' => 'left')
            )
        ));

        $db_data = array(
            array(
                'cols1' => '',
                'cols2' => '',
                'cols3' => '',
                'cols4' => '',
                'cols5' => '',
                'cols6' => number_format($valor_venta, 2)
                , 'cols7' => number_format($valor_igv, 2),
                'cols8' => number_format($valor_total, 2)),
        );



        $this->cezpdf->ezText('', '');
        $this->cezpdf->ezTable($db_data, "", "", array(
            'width' => 505,
            'showLines' => 0,
            'shaded' => 20,
            'showHeadings' => 0,
            'xPos' => 'center',
            'fontSize' => 9,
            'cols' => array(
                'cols1' => array('width' => 10, 'justification' => 'left'),
                'cols2' => array('width' => 10, 'justification' => 'left'),
                'cols3' => array('width' => 40, 'justification' => 'left'),
                'cols4' => array('width' => 45, 'justification' => 'left'),
                'cols5' => array('width' => 50, 'justification' => 'left'),
                'cols6' => array('width' => 55, 'justification' => 'left'),
                'cols7' => array('width' => 45, 'justification' => 'left'),
                'cols8' => array('width' => 55, 'justification' => 'left'),
            )
        ));




        $this->cezpdf->ezText('', 8);
        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => $tipo_doc . '.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');
        $this->cezpdf->ezStream($cabecera);
    }

    public function registro_ventas_pdf($tipo_oper, $tipo_doc = "F", $fecha1, $fecha2) {
        if ($tipo_oper == 'V') {
            $titulo_personal = 'Cliente';
            if ($tipo_doc == "F")
                $titulo = "REGISTRO DE  VENTAS FACTURAS";
            if ($tipo_doc == "B")
                $titulo = "REPORTE DE  VENTAS BOLETAS";
            if ($tipo_doc == "N")
                $titulo = "REPORTE DE  VENTAS COMPROBANTES";
        }

        else {

            $titulo_personal = 'Proveedor';

            if ($tipo_doc == "F")
                $titulo = "REGISTRO DE  COMPRAS FACTURAS";
            if ($tipo_doc == "B")
                $titulo = "REPORTE DE  COMPRAS BOLETAS";
            if ($tipo_doc == "N")
                $titulo = "REPORTE DE  COMPRAS COMPROBANTES";
        }
        $lista = $this->ventas_model->registro_ventas($tipo_oper, $tipo_doc, $fecha1, $fecha2);
        $this->cezpdf = new Cezpdf('a4', 'landscape');
        $this->cezpdf->ezText(($titulo), 11, array("left" => 180));

        $this->cezpdf->ezText('', '');
        /* Listado de detalles */
        $db_data = array();
        $valor_venta = 0;
        $valor_igv = 0;
        $valor_total = 0;
        foreach ($lista as $indice => $valor) {
            $tipo = $valor->CPC_TipoDocumento;
            $tipo_persona = $valor->CLIC_TipoPersona;
            $flag = $valor->CPC_FlagEstado;
            $nombre = '';
            if ($flag == 1) {

                if ($tipo_doc != "F") {
                    $subtotal = number_format($valor->CPC_total / 1.18, 2);
                    $igv = number_format($subtotal * 0.18, 2);
                } else {
                    $igv = $valor->CPC_igv;
                    $subtotal = $valor->CPC_subtotal;
                }
                $total = $valor->CPC_total;
                $valor_venta +=$subtotal;
                $valor_igv +=$igv;
                $valor_total +=$total;


                if ($tipo_doc == 'F')
                    $nombre = 'Factura';
                else
                    $nombre = 'Boleta';
                if ($tipo_persona == '0') {
                    $nombre_cliente = $valor->PERSC_Nombre . " " . $valor->PERSC_ApellidoPaterno . " " . $valor->PERSC_ApellidoMaterno;
                    $ruc = $valor->PERSC_Ruc;
                } else {
                    $nombre_cliente = $valor->EMPRC_RazonSocial;
                    $ruc = $valor->EMPRC_Ruc;
                }
            } else {
                $nombre_cliente = "ANULADO";
                $ruc = "";
                $subtotal = "";
                $igv = "";
                $total = "";
                if ($tipo_doc == 'F')
                    $nombre = 'Factura';
                else
                    $nombre = 'Boleta';
            }

            $db_data[] = array(
                'cols1' => $valor->CPC_Fecha,
                'cols2' => $nombre,
                'cols3' => $valor->CPC_Serie,
                'cols4' => $valor->CPC_Numero,
                'cols5' => $nombre_cliente,
                'cols6' => $ruc,
                'cols7' => $subtotal,
                'cols8' => $igv,
                'cols9' => $total,
            );
        }
        $col_names = array(
            'cols1' => 'Fecha',
            'cols2' => 'Tipo',
            'cols3' => 'Serie',
            'cols4' => 'Numero',
            'cols5' => $titulo_personal,
            'cols6' => 'Ruc',
            'cols7' => 'Valor Venta',
            'cols8' => '   I.G.V      ',
            'cols9' => 'Importe Total',
        );

        $this->cezpdf->ezTable($db_data, $col_names, '', array(
            'width' => 450,
            'showLines' => 1,
            'shaded' => 1,
            'Leading' => 10,
            'showHeadings' => 1,
            'xPos' => 300,
            'fontSize' => 8,
            'cols' => array(
                'cols1' => array('width' => 58, 'justification' => 'center'),
                'cols2' => array('width' => 42, 'justification' => 'left'),
                'cols3' => array('width' => 35, 'justification' => 'left'),
                'cols4' => array('width' => 45, 'justification' => 'left'),
                'cols5' => array('width' => 155, 'justification' => 'center'),
                'cols6' => array('width' => 66, 'justification' => 'left'),
                'cols7' => array('width' => 54, 'justification' => 'left'),
                'cols9' => array('width' => 48, 'justification' => 'left'),
                'cols9' => array('width' => 48, 'justification' => 'left')
            )
        ));

        $db_data = array(
            array(
                'cols1' => '',
                'cols2' => '',
                'cols3' => '',
                'cols4' => '',
                'cols5' => '',
                'cols6' => number_format($valor_venta, 2)
                , 'cols7' => number_format($valor_igv, 2),
                'cols8' => number_format($valor_total, 2)),
        );



        $this->cezpdf->ezText('', '');
        $this->cezpdf->ezTable($db_data, "", "", array(
            'width' => 505,
            'showLines' => 0,
            'shaded' => 20,
            'showHeadings' => 0,
            'xPos' => 'center',
            'fontSize' => 9,
            'cols' => array(
                'cols1' => array('width' => 10, 'justification' => 'left'),
                'cols2' => array('width' => 10, 'justification' => 'left'),
                'cols3' => array('width' => 40, 'justification' => 'left'),
                'cols4' => array('width' => 45, 'justification' => 'left'),
                'cols5' => array('width' => 50, 'justification' => 'left'),
                'cols6' => array('width' => 55, 'justification' => 'left'),
                'cols7' => array('width' => 45, 'justification' => 'left'),
                'cols8' => array('width' => 55, 'justification' => 'left'),
            )
        ));




        $this->cezpdf->ezText('', 8);
        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => $tipo_doc . '.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');
        $this->cezpdf->ezStream($cabecera);
    }

    public function registro_ventas_excel($tipo_oper, $tipo_doc = "F", $fecha1, $fecha2) {
        if ($tipo_oper == 'V') {
            $titulo_personal = 'Cliente';
            if ($tipo_doc == "F")
                $titulo = "REGISTRO DE  VENTAS FACTURAS";
            if ($tipo_doc == "B")
                $titulo = "REPORTE DE  VENTAS BOLETAS";
            if ($tipo_doc == "N")
                $titulo = "REPORTE DE  VENTAS COMPROBANTES";
        }

        else {
            $titulo_personal = 'Proveedor';
            if ($tipo_doc == "F")
                $titulo = "REGISTRO DE  COMPRAS FACTURAS";
            if ($tipo_doc == "B")
                $titulo = "REPORTE DE  COMPRAS BOLETAS";
            if ($tipo_doc == "N")
                $titulo = "REPORTE DE  COMPRAS COMPROBANTES";
        }
        $this->load->library("PHPExcel");

        $phpExcel = new PHPExcel();
        $prestasi = $phpExcel->setActiveSheetIndex(0);
        //merger
        $phpExcel->getActiveSheet()->mergeCells('A1:J1');
        //manage row hight
        $phpExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
        //style alignment
        $styleArray = array(
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        $phpExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $phpExcel->getActiveSheet()->getStyle('A1:J1')->applyFromArray($styleArray);
        //border
        $styleArray1 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        //background
        $styleArray12 = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => 'FFEC8B',
                ),
            ),
        );
        //freeepane
        $phpExcel->getActiveSheet()->freezePane('A5');
        //coloum width
        $phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $phpExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $prestasi->setCellValue('A1', $titulo);
        if ($tipo_oper == 'V') {
            $phpExcel->getActiveSheet()->getStyle('A2:V4')->applyFromArray($styleArray12);


            $phpExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('A2:A4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('A2:A4');
            $prestasi->setCellValue('A2', 'Número Correlativo del Registro o Código unico de la operación');

            $phpExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('B2:B4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('B2:B4');
            $prestasi->setCellValue('B2', 'Fecha de emisión del comprobante de pago o documento.');

            $phpExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('C2:C4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('C2:C4');
            $prestasi->setCellValue('C2', 'Fecha de vencimiento y/o pago.');


            $phpExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('D2:F2')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('D2:F2');
            $prestasi->setCellValue('D2', 'Comprobante de Pago o Documento');

            $phpExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('D3:D4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('D3:D4');
            $prestasi->setCellValue('D3', 'Tipo (Tabla 10)');

            $phpExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('E3:E4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('E3:E4');
            $prestasi->setCellValue('E3', 'N° de serie o N° de serie de la maquina registradora');

            $phpExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('F3:F4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('F3:F4');
            $prestasi->setCellValue('F3', 'Número');


            $phpExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('G2:I2')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('G2:I2');
            $prestasi->setCellValue('G2', 'Información del Cliente');

            $phpExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('G3:H3')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('G3:H3');
            $prestasi->setCellValue('G3', 'Documento de Identidad');

            $phpExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('G4')->applyFromArray($styleArray1);
            $prestasi->setCellValue('G4', 'Tipo (Tabla 2)');

            $phpExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('H4')->applyFromArray($styleArray1);
            $prestasi->setCellValue('H4', 'Número');

            $phpExcel->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('I3:I4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('I3:I4');
            $prestasi->setCellValue('I3', 'Apellidos y Nombres, Denominación o Razón Social');


            $phpExcel->getActiveSheet()->getStyle('J2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('J2:J4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('J2:J4');
            $prestasi->setCellValue('J2', 'Valor Facturado de la Exportación');

            $phpExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('K2:K4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('K2:K4');
            $prestasi->setCellValue('K2', 'Base imponible de la operación grabada');

            $phpExcel->getActiveSheet()->getStyle('L2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('L2:N2')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('L2:N2');
            $prestasi->setCellValue('L2', 'Importe Total de la Operación Exonerada o Inafecta');

            $phpExcel->getActiveSheet()->getStyle('L3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('L3:L4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('L3:L4');
            $prestasi->setCellValue('L3', 'Exonerada');

            $phpExcel->getActiveSheet()->getStyle('M3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('M3:M4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('M3:M4');
            $prestasi->setCellValue('M3', 'Inafecta');

            $phpExcel->getActiveSheet()->getStyle('N3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('N3:N4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('N3:N4');
            $prestasi->setCellValue('N3', 'ISC');

            $phpExcel->getActiveSheet()->getStyle('O2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('O2:O4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('O2:O4');
            $prestasi->setCellValue('O2', 'IGV Y/O IPM');

            $phpExcel->getActiveSheet()->getStyle('P2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('P2:P4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('P2:P4');
            $prestasi->setCellValue('P2', 'OTROS TRIBUTOS Y CARGOS QUE NO FORMAN PARTE DE LA BASE IMPONIBLE');

            $phpExcel->getActiveSheet()->getStyle('Q2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('Q2:Q4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('Q2:Q4');
            $prestasi->setCellValue('Q2', 'IMPORTE TOTAL DEL COMPROBANTE DE PAGO');

            $phpExcel->getActiveSheet()->getStyle('R2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('R2:R4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('R2:R4');
            $prestasi->setCellValue('R2', 'TIPO DE CAMBIO');

            $phpExcel->getActiveSheet()->getStyle('S2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('S2:V2')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('S2:V2');
            $prestasi->setCellValue('S2', 'REFERENCIA DEL COMPROBANTE DE PAGO O DOCUMENTO ORIGINAL QUE SE MODIFICA');

            $phpExcel->getActiveSheet()->getStyle('S3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('S3:S4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('S3:S4');
            $prestasi->setCellValue('S3', 'FECHA');

            $phpExcel->getActiveSheet()->getStyle('T3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('T3:T4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('T3:T4');
            $prestasi->setCellValue('T3', 'TIPO TABLA(10)');

            $phpExcel->getActiveSheet()->getStyle('U3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('U3:U4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('U3:U4');
            $prestasi->setCellValue('U3', 'SERIE');

            $phpExcel->getActiveSheet()->getStyle('V3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('V3:V4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('V3:V4');
            $prestasi->setCellValue('V3', 'N° DEL COMPROBATE DE PAGO O DOCUMENTO');
        } else {
            $phpExcel->getActiveSheet()->getStyle('A2:AB4')->applyFromArray($styleArray12);


            $phpExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('A2:A4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('A2:A4');
            $prestasi->setCellValue('A2', 'Número Correlativo del Registro o Código unico de la operación');

            $phpExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('B2:B4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('B2:B4');
            $prestasi->setCellValue('B2', 'Fecha de emisión del comprobante de pago o documento.');

            $phpExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('C2:C4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('C2:C4');
            $prestasi->setCellValue('C2', 'Fecha de vencimiento y/o pago.');


            $phpExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('D2:F2')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('D2:F2');
            $prestasi->setCellValue('D2', 'Comprobante de Pago o Documento');

            $phpExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('D3:D4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('D3:D4');
            $prestasi->setCellValue('D3', 'Tipo (Tabla 10)');

            $phpExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('E3:E4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('E3:E4');
            $prestasi->setCellValue('E3', 'SERIE O CODIGO DE LA DEPENDENCIA ADUANERA (TABLA11)');

            $phpExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('F3:F4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('F3:F4');
            $prestasi->setCellValue('F3', 'AÑO DE EMISION DE LA DUA O DSI');

            $phpExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('G2:G4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('G2:G4');
            $prestasi->setCellValue('G2', ' N° DEL COMPROBANTE DE PAGO,
                                            DOCUMENTO, N° DE ORDEN DEL
                                           FORMULARIO F?SICO O VIRTUAL, 
                                          N° DE DUA, DSI O LIQUIDACIÓN DE 
                                         COBRANZA U OTROS DOCUMENTOS 
                                      EMITIDOS POR SUNAT PARA ACREDITAR 
                                      EL CRÉDITO FISCAL EN LA IMPORTACIÓN
                                     ');

            $phpExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('H2:J2')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('H2:J2');
            $prestasi->setCellValue('H2', 'INFORMACIÓN DEL PROVEEDOR');

            $phpExcel->getActiveSheet()->getStyle('H3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('H3:I3')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('H3:I3');
            $prestasi->setCellValue('H3', 'Documento de Identidad');

            $phpExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('H4')->applyFromArray($styleArray1);
            $prestasi->setCellValue('H4', 'TIPO (TABLA 2)');

            $phpExcel->getActiveSheet()->getStyle('I4')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('I4')->applyFromArray($styleArray1);
            $prestasi->setCellValue('I4', 'NÚMERO');

            $phpExcel->getActiveSheet()->getStyle('J3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('J3:J4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('J3:J4');
            $prestasi->setCellValue('J3', 'APELLIDOS Y NOMBRES, DENOMINACION SOCIAL O RAZON SOCIAL');

            $phpExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('K2:L2')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('K2:L2');
            $prestasi->setCellValue('K2', ' ADQUISICIONES GRAVADAS DESTINADAS A OPERACIONES	
             GRAVADAS Y/O DE EXPORTACIÓN');

            $phpExcel->getActiveSheet()->getStyle('K3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('K3:K4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('K3:K4');
            $prestasi->setCellValue('K3', 'BASE IMPONIBLE');

            $phpExcel->getActiveSheet()->getStyle('L3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('L3:L4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('L3:L4');
            $prestasi->setCellValue('L3', 'IGV');


            $phpExcel->getActiveSheet()->getStyle('M2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('M2:N2')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('M2:N2');
            $prestasi->setCellValue('M2', ' ADQUISICIONES GRAVADAS DESTINADAS A OPERACIONES	
            GRAVADAS Y/O DE EXPORTACIÓN Y A OPERACIONES NO GRAVADAS');

            $phpExcel->getActiveSheet()->getStyle('M3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('M3:M4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('M3:M4');
            $prestasi->setCellValue('M3', 'BASE IMPONIBLE');

            $phpExcel->getActiveSheet()->getStyle('N3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('N3:N4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('N3:N4');
            $prestasi->setCellValue('N3', 'IGV');


            $phpExcel->getActiveSheet()->getStyle('O2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('O2:P2')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('O2:P2');
            $prestasi->setCellValue('O2', ' ADQUISICIONES GRAVADAS DESTINADAS A OPERACIONES NO GRAVADAS');

            $phpExcel->getActiveSheet()->getStyle('O3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('O3:O4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('O3:O4');
            $prestasi->setCellValue('O3', 'BASE IMPONIBLE');

            $phpExcel->getActiveSheet()->getStyle('P3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('P3:P4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('P3:P4');
            $prestasi->setCellValue('P3', 'IGV');

            $phpExcel->getActiveSheet()->getStyle('Q2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('Q2:Q4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('Q2:Q4');
            $prestasi->setCellValue('Q2', 'VALOR DE LAS ADQUISICIONES NO GRAVADAS');

            $phpExcel->getActiveSheet()->getStyle('R2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('R2:R4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('R2:R4');
            $prestasi->setCellValue('R2', 'ISC');

            $phpExcel->getActiveSheet()->getStyle('S2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('S2:S4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('S2:S4');
            $prestasi->setCellValue('S2', 'OTROS TRIBUTOS Y CARGOS');

            $phpExcel->getActiveSheet()->getStyle('T2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('T2:T4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('T2:T4');
            $prestasi->setCellValue('T2', 'IMPORTE TOTAL');

            $phpExcel->getActiveSheet()->getStyle('U2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('U2:U4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('U2:U4');
            $prestasi->setCellValue('U2', 'N° DE COMPROBANTE DE PAGO EMITIDO POR SUJETO NO DOMICILIADO (2)');

            $phpExcel->getActiveSheet()->getStyle('V2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('V2:W2')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('V2:W2');
            $prestasi->setCellValue('V2', 'CONSTANCIA DE DEPÓSITO DE DETRACCIÓN (3)');

            $phpExcel->getActiveSheet()->getStyle('V3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('V3:V4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('V3:V4');
            $prestasi->setCellValue('V3', 'NUMERO');

            $phpExcel->getActiveSheet()->getStyle('W3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('W3:W4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('W3:W4');
            $prestasi->setCellValue('W3', 'FECHA DE EMISION');

            $phpExcel->getActiveSheet()->getStyle('X2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('X2:X4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('X2:X4');
            $prestasi->setCellValue('X2', 'TIPO DE CAMBIO');

            $phpExcel->getActiveSheet()->getStyle('Y2')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('Y2:AB2')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('Y2:AB2');
            $prestasi->setCellValue('Y2', 'REFERENCIA DEL COMPROBANTE DE PAGO O DOCUMENTO ORIGINAL QUE SE MODIFICA');

            $phpExcel->getActiveSheet()->getStyle('Y3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('Y3:Y4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('Y3:Y4');
            $prestasi->setCellValue('Y3', 'FECHA');

            $phpExcel->getActiveSheet()->getStyle('Z3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('Z3:Z4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('Z3:Z4');
            $prestasi->setCellValue('Z3', 'TIPO (TABLA 10)');

            $phpExcel->getActiveSheet()->getStyle('AA3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('AA3:AA4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('AA3:AA4');
            $prestasi->setCellValue('AA3', 'SERIE');

            $phpExcel->getActiveSheet()->getStyle('AB3')->getAlignment()->setWrapText(true);
            $phpExcel->getActiveSheet()->getStyle('AB3:AB4')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->mergeCells('AB3:AB4');
            $prestasi->setCellValue('AB3', 'N° DEL COMPROBANTE DE PAGO O DOCUMENTO');
        }
        $lista = $this->ventas_model->registro_ventas($tipo_oper, $tipo_doc, $fecha1, $fecha2);

        $no = 0;
        $rowexcel = 4;
        $valor_venta = 0;
        $valor_igv = 0;
        $valor_total = 0;
        foreach ($lista as $indice => $valor) {
            $tipo = $valor->CPC_TipoDocumento;
            $tipo_persona = $valor->CLIC_TipoPersona;
            $flag = $valor->CPC_FlagEstado;
            $nombre = '';
            if ($flag == 1) {

                if ($tipo_doc != "F") {
                    $subtotal = number_format($valor->CPC_total / 1.18, 2);
                    $igv = number_format($subtotal * 0.18, 2);
                } else {
                    $igv = $valor->CPC_igv;
                    $subtotal = $valor->CPC_subtotal;
                }
                $total = $valor->CPC_total;
                $valor_venta +=$subtotal;
                $valor_igv +=$igv;
                $valor_total +=$total;


                if ($tipo_doc == 'F')
                    $nombre = 'Factura';
                else
                    $nombre = 'Boleta';
                if ($tipo_persona == '0') {
                    $doc = 'DNI';
                    $nombre_cliente = $valor->PERSC_Nombre . " " . $valor->PERSC_ApellidoPaterno . " " . $valor->PERSC_ApellidoMaterno;
                    $ruc = $valor->PERSC_Ruc;
                } else {
                    $doc = 'RUC';
                    $nombre_cliente = $valor->EMPRC_RazonSocial;
                    $ruc = $valor->EMPRC_Ruc;
                }
            } else {
                $nombre_cliente = "ANULADO";
                $ruc = "";
                $subtotal = "";
                $igv = "";
                $total = "";
                if ($tipo_doc == 'F')
                    $nombre = 'Factura';
                else
                    $nombre = 'Boleta';
            }

            $no++;
            $rowexcel++;

            if ($tipo_oper == 'V') {
                $prestasi->setCellValue('A' . $rowexcel, $no);
                $prestasi->setCellValue('B' . $rowexcel, $valor->CPC_Fecha);
                $prestasi->setCellValue('D' . $rowexcel, $nombre);
                $prestasi->setCellValue('E' . $rowexcel, (int) $valor->CPC_Serie);
                $prestasi->setCellValue('F' . $rowexcel, (int) $valor->CPC_Numero);
                $prestasi->setCellValue('G' . $rowexcel, $doc);
                $prestasi->setCellValue('H' . $rowexcel, $ruc);
                $prestasi->setCellValue('I' . $rowexcel, $nombre_cliente);
                $prestasi->setCellValue('O' . $rowexcel, $igv);
                $prestasi->setCellValue('Q' . $rowexcel, $total);
            } else {
                $prestasi->setCellValue('A' . $rowexcel, $no);
                $prestasi->setCellValue('B' . $rowexcel, $valor->CPC_Fecha);
                $prestasi->setCellValue('D' . $rowexcel, $nombre);
                $prestasi->setCellValue('E' . $rowexcel, (int) $valor->CPC_Serie);
                $prestasi->setCellValue('G' . $rowexcel, (int) $valor->CPC_Numero);
                $prestasi->setCellValue('H' . $rowexcel, $doc);
                $prestasi->setCellValue('I' . $rowexcel, $ruc);
                $prestasi->setCellValue('J' . $rowexcel, $nombre_cliente);
                $prestasi->setCellValue('P' . $rowexcel, $igv);
                $prestasi->setCellValue('T' . $rowexcel, $total);
            }
        }

        $prestasi->setTitle('ReportE');
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"Report.xls\"");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
        $objWriter->save("php://output");
    }

    public function registro_ventas_excel2($tipo_oper, $tipo_doc = "F", $fecha1, $fecha2) {
        if ($tipo_oper == 'V') {
            $titulo_personal = 'Cliente';
            if ($tipo_doc == "F")
                $titulo = "REGISTRO DE  VENTAS FACTURAS";
            if ($tipo_doc == "B")
                $titulo = "REPORTE DE  VENTAS BOLETAS";
            if ($tipo_doc == "N")
                $titulo = "REPORTE DE  VENTAS COMPROBANTES";
        }

        else {
            $titulo_personal = 'Proveedor';
            if ($tipo_doc == "F")
                $titulo = "REGISTRO DE  COMPRAS FACTURAS";
            if ($tipo_doc == "B")
                $titulo = "REPORTE DE  COMPRAS BOLETAS";
            if ($tipo_doc == "N")
                $titulo = "REPORTE DE  COMPRAS COMPROBANTES";
        }
        $this->load->library("PHPExcel");

        $phpExcel = new PHPExcel();
        $prestasi = $phpExcel->setActiveSheetIndex(0);
        //merger
        $phpExcel->getActiveSheet()->mergeCells('A1:J1');
        //manage row hight
        $phpExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
        //style alignment
        $styleArray = array(
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        $phpExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $phpExcel->getActiveSheet()->getStyle('A1:J1')->applyFromArray($styleArray);
        //border
        $styleArray1 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        //background
        $styleArray12 = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => 'FFEC8B',
                ),
            ),
        );
        //freeepane
        $phpExcel->getActiveSheet()->freezePane('A3');
        //coloum width
        $phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6.1);
        $phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $phpExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $phpExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $prestasi->setCellValue('A1', $titulo);
        $phpExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($styleArray);
        $phpExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($styleArray1);
        $phpExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($styleArray12);
        $prestasi->setCellValue('A2', 'No');
        $prestasi->setCellValue('B2', 'Fecha');
        $prestasi->setCellValue('C2', 'Tipo');
        $prestasi->setCellValue('D2', 'Serie');
        $prestasi->setCellValue('E2', 'Numero');
        $prestasi->setCellValue('F2', $titulo_personal);
        $prestasi->setCellValue('G2', 'Ruc');
        $prestasi->setCellValue('H2', 'Valor Venta');
        $prestasi->setCellValue('I2', 'I.G.V');
        $prestasi->setCellValue('J2', 'Importe Total');



        $lista = $this->ventas_model->registro_ventas($tipo_oper, $tipo_doc, $fecha1, $fecha2);

        $no = 0;
        $rowexcel = 2;
        $valor_venta = 0;
        $valor_igv = 0;
        $valor_total = 0;
        foreach ($lista as $indice => $valor) {
            $tipo = $valor->CPC_TipoDocumento;
            $tipo_persona = $valor->CLIC_TipoPersona;
            $flag = $valor->CPC_FlagEstado;
            $nombre = '';
            if ($flag == 1) {

                if ($tipo_doc != "F") {
                    $subtotal = number_format($valor->CPC_total / 1.18, 2);
                    $igv = number_format($subtotal * 0.18, 2);
                } else {
                    $igv = $valor->CPC_igv;
                    $subtotal = $valor->CPC_subtotal;
                }
                $total = $valor->CPC_total;
                $valor_venta +=$subtotal;
                $valor_igv +=$igv;
                $valor_total +=$total;


                if ($tipo_doc == 'F')
                    $nombre = 'Factura';
                else
                    $nombre = 'Boleta';
                if ($tipo_persona == '0') {
                    $nombre_cliente = $valor->PERSC_Nombre . " " . $valor->PERSC_ApellidoPaterno . " " . $valor->PERSC_ApellidoMaterno;
                    $ruc = $valor->PERSC_Ruc;
                } else {
                    $nombre_cliente = $valor->EMPRC_RazonSocial;
                    $ruc = $valor->EMPRC_Ruc;
                }
            } else {
                $nombre_cliente = "ANULADO";
                $ruc = "";
                $subtotal = "";
                $igv = "";
                $total = "";
                if ($tipo_doc == 'F')
                    $nombre = 'Factura';
                else
                    $nombre = 'Boleta';
            }

            $no++;
            $rowexcel++;

            $prestasi->setCellValue('A' . $rowexcel, $no);
            $prestasi->setCellValue('B' . $rowexcel, $valor->CPC_Fecha);
            $prestasi->setCellValue('C' . $rowexcel, $nombre);
            $prestasi->setCellValue('D' . $rowexcel, $valor->CPC_Serie);
            $prestasi->setCellValue('E' . $rowexcel, $valor->CPC_Numero);
            $prestasi->setCellValue('F' . $rowexcel, $nombre_cliente);
            $prestasi->setCellValue('G' . $rowexcel, $ruc);
            $prestasi->setCellValue('H' . $rowexcel, $subtotal);
            $prestasi->setCellValue('I' . $rowexcel, $igv);
            $prestasi->setCellValue('J' . $rowexcel, $total);
        }

        $prestasi->setTitle('ReportE');
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"Report.xls\"");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
        $objWriter->save("php://output");
    }

    public function ganancia() {
        $this->load->library('layout', 'layout');
        $lista = '';
        $total_soles = '';
        $total_dolares = '';
        $resumen_suma = '';
        $resumen_suma_d = '';
        $resumen_cantidad = '';
        $resumen_fpago = '';
        $producto = $this->input->post('producto');
        $f_ini = $this->input->post('fecha_inicio') != '' ? $this->input->post('fecha_inicio') : '01/' . date('m/Y');
        $f_fin = $this->input->post('fecha_fin') != '' ? $this->input->post('fecha_fin') : date('d/m/Y');
        $moneda = $this->input->post('moneda') != '' ? $this->input->post('moneda') : '2';

        $comp_select = array();
        $lista_companias = $this->compania_model->listar_establecimiento($this->somevar['empresa']);
        foreach ($lista_companias as $key => $compania) {
            if (count($_POST) > 0) {
                if ($this->input->post('COMPANIA_' . $compania->COMPP_Codigo) == '1') {
                    $comp_select[] = $compania->COMPP_Codigo;
                    $lista_companias[$key]->checked = true;
                }
                else
                    $lista_companias[$key]->checked = false;
            }else {
                $comp_select[] = $compania->COMPP_Codigo;
                $lista_companias[$key]->checked = true;
            }
        }

        $total_costo = 0;
        $total_venta = 0;
        $total_util = 0;
        $total_porc_util = 0;
        $lista_ganancia = $this->comprobantedetalle_model->reporte_ganancia($producto, human_to_mysql($f_ini), human_to_mysql($f_fin), $comp_select);
        $lista = array();
        $resumen_compania = array();
        foreach ($lista_ganancia as $value) {
            $fecha = mysql_to_human($value->CPC_Fecha);
            $establec = $value->EESTABC_Descripcion;
            $nombre_producto = $value->PROD_Nombre;
            $cantidad = $value->CPDEC_Cantidad;
            $simbolo_moneda = $value->MONED_Simbolo;
            $pcosto = $value->CPDEC_Costo;
            $pventa = $value->CPDEC_Pu_ConIgv;
            $costo = $pcosto * $value->CPDEC_Cantidad;
            $venta = $pventa * $value->CPDEC_Cantidad;
            $total_costo+=$costo;
            $total_venta+=$venta;
            $utilidad = $venta - $costo;
            $porc_util = $costo != 0 ? ($utilidad / $costo) * 100 : 0;
            $resumen_compania[$value->COMPP_Codigo] = array('costo' => isset($resumen_compania[$value->COMPP_Codigo]['costo']) ? $resumen_compania[$value->COMPP_Codigo]['costo'] + $costo : $costo,
                'venta' => isset($resumen_compania[$value->COMPP_Codigo]['venta']) ? $resumen_compania[$value->COMPP_Codigo]['venta'] + $venta : $venta
            );
            $lista[] = array($fecha, $establec, $nombre_producto, $cantidad, $simbolo_moneda, number_format($pcosto, 2), number_format($pventa, 2), number_format($costo, 2), number_format($venta, 2), number_format($utilidad, 2), round($porc_util));
        }

        $total_util = $total_venta - $total_costo;
        $total_porc_util = $total_costo != 0 ? ($total_util / $total_costo) * 100 : 0;

        /* Resumen por compania */
        $t_resumen_costo = 0;
        $t_resumen_venta = 0;
        foreach ($lista_companias as $key => $compania) {
            if (isset($resumen_compania[$compania->COMPP_Codigo])) {
                $st_costo = $resumen_compania[$compania->COMPP_Codigo]['costo'];
                $st_venta = $resumen_compania[$compania->COMPP_Codigo]['venta'];
                $resumen_compania[$compania->COMPP_Codigo]['costo'] = $resumen_compania[$compania->COMPP_Codigo]['costo'] > 0 ? number_format($resumen_compania[$compania->COMPP_Codigo]['costo'], 2) : 0;
                $resumen_compania[$compania->COMPP_Codigo]['venta'] = $resumen_compania[$compania->COMPP_Codigo]['venta'] > 0 ? number_format($resumen_compania[$compania->COMPP_Codigo]['venta'], 2) : 0;
            } else {
                $resumen_compania[$compania->COMPP_Codigo]['costo'] = $st_costo = 0;
                $resumen_compania[$compania->COMPP_Codigo]['venta'] = $st_venta = 0;
            }
            $resumen_compania[$compania->COMPP_Codigo]['util'] = $st_venta - $st_costo;
            $resumen_compania[$compania->COMPP_Codigo]['porc'] = round($st_costo != 0 ? (($st_venta - $st_costo) / $st_costo) * 100 : 0, 2);
            $t_resumen_costo+=$st_costo;
            $t_resumen_venta+=$st_venta;
        }
        $t_resumen_util = $t_resumen_venta - $t_resumen_costo;
        $t_resumen_porc = $t_resumen_costo != 0 ? ($t_resumen_util / $t_resumen_costo) * 100 : 0;

        $data['producto'] = $producto;
        $data['codproducto'] = $this->input->post('codproducto');
        $data['nombre_producto'] = $this->input->post('nombre_producto');
        $data['f_ini'] = $f_ini;
        $data['f_fin'] = $f_fin;
        $data['TODOS'] = $this->input->post('TODOS') == '1' ? true : false;
        $data['lista_companias'] = $lista_companias;
        $data['cboMoneda'] = form_dropdown("moneda", $this->moneda_model->seleccionar(), $moneda, " class='comboMedio' id='moneda' style='width:150px'");
        $data['lista'] = $lista;
        $data['total_costo'] = number_format($total_costo, 2);
        $data['total_venta'] = number_format($total_venta, 2);
        $data['total_util'] = number_format($total_util, 2);
        $data['total_porc_util'] = round($total_porc_util, 2);
        $data['resumen_compania'] = $resumen_compania;
        $data['t_resumen_costo'] = number_format($t_resumen_costo, 2);
        $data['t_resumen_venta'] = number_format($t_resumen_venta, 2);
        $data['t_resumen_util'] = number_format($t_resumen_util, 2);
        $data['t_resumen_porc'] = round($t_resumen_porc, 2);
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('reportes/ganancia', $data);
    }

    public function estado_cuenta() {
        $this->load->library('layout', 'layout');

        $total_soles = '';
        $total_dolares = '';
        $resumen_suma = '';
        $resumen_suma_d = '';
        $resumen_cantidad = '';
        $resumen_fpago = '';
        $cliente = $this->input->post('cliente');
        $proveedor = $this->input->post('proveedor');
        $moneda = $this->input->post('moneda') != '' ? $this->input->post('moneda') : '2';
        $f_ini = $this->input->post('fecha_inicio') != '' ? $this->input->post('fecha_inicio') : '01/' . date('m/Y');
        $f_fin = $this->input->post('fecha_fin') != '' ? $this->input->post('fecha_fin') : date('d/m/Y');
        $lista_moneda = $this->moneda_model->obtener($moneda);
        $moneda_simbolo = $lista_moneda[0]->MONED_Simbolo;
        $total_saldo = 0;
        $lista = array();
        $lista_ultimos = array();
        if ($cliente != '' || $proveedor != '') {
            $listado_cuentas = $this->cuentas_model->buscar(($cliente != '' ? '1' : '2'), ($cliente != '' ? $cliente : $proveedor), array('V', 'A', 'C'), human_to_mysql($f_ini), human_to_mysql($f_fin));
            foreach ($listado_cuentas as $value) {
                $fecha = mysql_to_human($value->CUE_FechaOper);
                $tipo_docu = $value->CPC_TipoDocumento == 'F' ? 'FAC' : 'B';
                $numero = $value->CPC_Serie . '-' . $value->CPC_Numero;
                $simbolo_moneda = $value->MONED_Simbolo;
                $monto = $value->CUE_Monto;
                $monto = cambiar_moneda($monto, $value->CPC_TDC, $value->MONED_Codigo, $moneda);

                $listado_pago = $this->cuentaspago_model->listar($value->CUE_Codigo);
                $lista_pago = array();
                if(count($listado_pago)>0){
	                foreach ($listado_pago as $pago){
	                    $lista_pago[] = array(mysql_to_human($pago->PAGC_FechaOper), $pago->MONED_Simbolo, number_format($pago->CPAGC_Monto, 2), $this->pago_model->obtener_forma_pago($pago->PAGC_FormaPago), $pago->PAGC_Obs);
	                }
                
                }
                $saldo = $monto - $this->pago_model->sumar_pagos($listado_pago, $moneda);
                $total_saldo+=$saldo;
                $estado = $value->CUE_FlagEstadoPago == 'C' ? 'CANC' : 'ACT';
                $lista[] = array($fecha, $tipo_docu, $numero, $simbolo_moneda, number_format($monto, 2), $lista_pago, number_format($saldo, 2), $estado);
            }
            $listado_pago = $this->pago_model->listar_ultimos(($cliente != '' ? '1' : '2'), ($cliente != '' ? $cliente : $proveedor), 10);
            $lista_utlimos = array();
            foreach ($listado_pago as $pago) {
                $lista_ultimos[] = array(mysql_to_human($pago->PAGC_FechaOper), $pago->MONED_Simbolo, number_format($pago->PAGC_Monto, 2), $this->pago_model->obtener_forma_pago($pago->PAGC_FormaPago), $pago->PAGC_Obs);
            }
        }



        $data['cliente'] = $cliente;
        $data['ruc_cliente'] = $this->input->post('ruc_cliente');
        $data['nombre_cliente'] = $this->input->post('nombre_cliente');
        $data['proveedor'] = $proveedor;
        $data['ruc_proveedor'] = $this->input->post('ruc_proveedor');
        $data['nombre_proveedor'] = $this->input->post('nombre_proveedor');
        $data['moneda_simbolo'] = $moneda_simbolo;
        $data['cboMoneda'] = form_dropdown("moneda", $this->moneda_model->seleccionar(), $moneda, " class='comboMedio' id='moneda' style='width:150px'");
        $data['f_ini'] = $f_ini;
        $data['f_fin'] = $f_fin;
        $data['lista'] = $lista;
        $data['lista_ultimos'] = $lista_ultimos;
        $data['total_saldo'] = number_format($total_saldo, 2);
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('reportes/estado_cuenta', $data);
    } 
    public function descargarExcel($fechaini, $fechafin){
        $resultado = $this->ventas_model->ventas_por_dia($fechaini, $fechafin);
      
        require_once 'system/application/libraries/PHPExcel/IOFactory.php';
        // Se crea el objeto PHPExcel
        $objPHPExcel = new PHPExcel();

        // Se asignan las propiedades del libro
        $objPHPExcel->getProperties()->setCreator("Codedrinks") //Autor
                             ->setLastModifiedBy("Codedrinks") //Ultimo usuario que lo modificó
                             ->setTitle("Reporte de venta por dia")
                             ->setSubject("Reporte de venta por dia")
                             ->setDescription("Reporte")
                             ->setKeywords("reporte venta diario")
                             ->setCategory("Reporte excel");

        $tituloReporte = "Reporte de venta por dia";
        $titulosColumnas = array('FECHA', 'NRO FACTURA', 'VENTA S/.', 'VENTA US$.');
        
        $objPHPExcel->setActiveSheetIndex(0)
                    ->mergeCells('A1:D1');
                        
        // Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1',  $tituloReporte)
                    ->setCellValue('A3',  $titulosColumnas[0])
                    ->setCellValue('B3',  $titulosColumnas[1])
                    ->setCellValue('C3',  $titulosColumnas[2])
                    ->setCellValue('D3',  $titulosColumnas[3]);
            
        //Se agregan los datos de los alumnos
                  //  $resultado = array("hola","como","estas","bien");
        $i = 4;
        $tota_dolares = 0;
        $tota_soles = 0;
        foreach ($resultado as $value) {
            $numero = $value['SERIE'] ."-". $value['NUMERO'];
            if( $value['MONED_Codigo']==2 ){
            $soles = "0.00";
            $dolares = $value['VENTAS'];
            
            $tota_dolares = $tota_dolares + $dolares;
            }else{
            $soles = $value['VENTAS'];
            $dolares = "0.00";   
            
            $tota_soles = $tota_soles + $soles;
            }
             $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i,  $value['FECHA'])
                    ->setCellValue('B'.$i,  $numero)
                    ->setCellValue('C'.$i,  $soles)
                    ->setCellValue('D'.$i,  $dolares);
                    $i++;
        }
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B'.$i, "TOTAL")
                    ->setCellValue('C'.$i, $tota_soles)
                    ->setCellValue('D'.$i, $tota_dolares);
                    
        
        $estiloTituloReporte = array(
            'font' => array(
                'name'      => 'Verdana',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' =>16,
                    'color'     => array(
                        'rgb' => 'FFFFFF'
                    )
            ),
            'fill' => array(
                'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('argb' => 'FF220835')
            ),
           
            'alignment' =>  array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation'   => 0,
                    'wrap'          => TRUE
            )
        );

        $estiloTituloColumnas = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => true,                          
                'color'     => array(
                    'rgb' => 'FFFFFF'
                )
            ),
            'fill'  => array(
                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
               /* 'rotation'   => 90,
                'startcolor' => array(
                    'rgb' => 'c47cf2'
                ),
                'endcolor'   => array(
                    'argb' => 'FF431a5d'
                )*/
                'color' => array('argb' => '999999')
            ),
         
            'alignment' =>  array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'          => TRUE
            ));
            
     /*   $estiloInformacion = new PHPExcel_Style();
        $estiloInformacion->applyFromArray(
            array(
                'font' => array(
                'name'      => 'Arial',               
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill'  => array(
                'type'      => PHPExcel_Style_Fill::FILL_NONE//,
               // 'color'     => array('argb' => 'FFFFFF')
            ),
             'borders' => array(
                'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_SOLID ,
                    'color' => array(
                        'rgb' => '3a2a47'
                    )
                )             
            )
           
        )); */
       $estilo_total = new PHPExcel_Style();
        $estilo_total->applyFromArray(
            array(
                'font' => array(
                'name'      => 'Arial',               
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill'  => array(
                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                'color'     => array('argb' => 'ABEBC6')
            ),
            'borders' => array(
                'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE// ,
                   /* 'color' => array(
                        'rgb' => '3a2a47'
                    )*/ 
                )            
            )
        ));
         
        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($estiloTituloReporte);
        $objPHPExcel->getActiveSheet()->getStyle('A3:D3')->applyFromArray($estiloTituloColumnas);       
       // $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:D".($i-1));
        $objPHPExcel->getActiveSheet()->setSharedStyle($estilo_total, "A$i:D$i");        

        for($i = 'A'; $i <= 'D'; $i++){
            $objPHPExcel->setActiveSheetIndex(0)            
                ->getColumnDimension($i)->setAutoSize(TRUE);
        }
        
        // Se asigna el nombre a la hoja
        $objPHPExcel->getActiveSheet()->setTitle('Reporte Diario');

        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $objPHPExcel->setActiveSheetIndex(0);
        // Inmovilizar paneles 
        //$objPHPExcel->getActiveSheet(0)->freezePane('A4');
        $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

        // Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporteventadia.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;                     
    }
}