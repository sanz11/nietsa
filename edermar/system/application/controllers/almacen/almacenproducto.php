<?php

class Almacenproducto extends controller {

    public function __construct() {
        parent::Controller();
        $this->load->model('almacen/almacenproductoserie_model');
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
                $lista[] = array($item++, $codigo_prod, $nombre_prod, $nombre_fab, $cantidad, $nombre_und, $costo_anterior, $cantidad_anterior * $costo_anterior, $kardex, $flagGenInd, $producto,$dato_almacen[0]->ALMAC_Descripcion,$almacen);
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
    



    /**INICO DE DESCARGA PARA EXCEL 2016 DICIEMBRE**/
    
    public function verReporteExcel()
    {
    	$this->load->library('PHPExcel');
    	$listadoAlmacen = $this->almacenproducto_model->listar();
    
    	$this->phpexcel->setActiveSheetIndex(0);
    	$this->phpexcel->getActiveSheet()->setTitle('Reporte');
    	$this->phpexcel->setActiveSheetIndex(0)->mergeCells('A3:C3')->setCellValue('A3', 'Nipon');
    	$this->phpexcel->setActiveSheetIndex(0)->mergeCells('A4:C4')->setCellValue('A4', 'Stock De Almacen');
    	$this->phpexcel->setActiveSheetIndex(0)->mergeCells('A5:G5')->setCellValue('A5', 'Cuadro de Resumen de Ordenes de Compra');
    	$this->phpexcel->getActiveSheet()->getStyle('A3:G7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    	$this->phpexcel->getActiveSheet()->getStyle('A3:G7')->getFill()->getStartColor()->setARGB('346099');
    	$tipoBorde = array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000'));
    	$this->phpexcel->getActiveSheet()->getStyle('A3:G7')->getBorders()->getTop()->applyFromArray($tipoBorde);
    	$this->phpexcel->getActiveSheet()->getStyle('A3:G7')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    	$TipoFont = array( 'font'  => array( 'bold'  => false, 'color' => array('rgb' => 'FFFFFF'), 'size'  => 11, 'name'  => 'Calibri'));
    	$TipoFont2 = array( 'font'  => array( 'bold'  => false, 'color' => array('rgb' => 'FFFFFF'), 'size'  => 14, 'name'  => 'Calibri'));
    	$style = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
    	$this->phpexcel->getActiveSheet()->getRowDimension('7')->setRowHeight(45);
    	$this->phpexcel->getActiveSheet()->getStyle('A3:G7')->applyFromArray($TipoFont);
    	$this->phpexcel->getActiveSheet()->getStyle("A5:G7")->applyFromArray($style);
    	$this->phpexcel->getActiveSheet()->getStyle('A5')->applyFromArray($TipoFont2);
    	$this->phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
    	$this->phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
    	$this->phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth('50');
    	$this->phpexcel->getActiveSheet()->getColumnDimension('D')->setWidth('15');
    	$this->phpexcel->getActiveSheet()->getColumnDimension('E')->setWidth('11.71');
    	$this->phpexcel->getActiveSheet()->getColumnDimension('F')->setWidth('18');
    	$this->phpexcel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
    
    	/**ALMACEN**/
    	$this->phpexcel->setActiveSheetIndex(0)
    	->setCellValue('F3', 'P�gina')
    	->setCellValue('F4', 'Fecha-Hora')
    	->setCellValue('G3', '')
    	->setCellValue('G4', date('d-m-Y H:m:s'))
    	->setCellValue('A7', 'N�')
    	->setCellValue('B7', 'Codigo Almacen')
    	->setCellValue('C7', 'Descripcion')
    	->setCellValue('D7', 'Fabricante')
    	->setCellValue('E7', 'Stock')
    	->setCellValue('F7', 'Unidad')
    	->setCellValue('G7', 'Almacen');
    
    
    
    
    
    
    	/**SERIE DE ALMACEN**/
    	$this->phpexcel->getActiveSheet()->getStyle('k7:N7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    	$this->phpexcel->getActiveSheet()->getStyle('k7:N7')->getFill()->getStartColor()->setARGB('346099');
    	$tipoBordeS = array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000'));
    	$this->phpexcel->getActiveSheet()->getStyle('K7:N7')->getBorders()->getTop()->applyFromArray($tipoBordeS);
    	$this->phpexcel->getActiveSheet()->getStyle('K7:N7')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    	$TipoFontS = array( 'font'  => array( 'bold'  => false, 'color' => array('rgb' => 'FFFFFF'), 'size'  => 11, 'name'  => 'Calibri'));
    	$TipoFont2S = array( 'font'  => array( 'bold'  => false, 'color' => array('rgb' => 'FFFFFF'), 'size'  => 14, 'name'  => 'Calibri'));
    	$styleS = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
    	$this->phpexcel->getActiveSheet()->getRowDimension('7')->setRowHeight(45);
    	$this->phpexcel->getActiveSheet()->getStyle('J7:N7')->applyFromArray($TipoFontS);
    	$this->phpexcel->getActiveSheet()->getStyle("J7:N7")->applyFromArray($styleS);
    	$this->phpexcel->getActiveSheet()->getStyle('J7')->applyFromArray($TipoFont2S);
    	$this->phpexcel->getActiveSheet()->getColumnDimension('K')->setWidth('5');
    	$this->phpexcel->getActiveSheet()->getColumnDimension('L')->setWidth('50');
    	$this->phpexcel->getActiveSheet()->getColumnDimension('M')->setWidth('20');
    	$this->phpexcel->getActiveSheet()->getColumnDimension('N')->setWidth('15');
    	 
    	$this->phpexcel->setActiveSheetIndex(0)
    	->setCellValue('k7', 'N�')
    	->setCellValue('L7', 'Descripcion Almacen')
    	->setCellValue('M7', 'Fecha De Registro')
    	->setCellValue('N7', 'Series');
    
    
    	$this->phpexcel->setActiveSheetIndex(0);
    	$numeroS = 0;
    	$numeroSerie = 0;
    	$CodigoUsuario = 0;
    	$lugar = 8;
    	$lugarSerie = 8;
    	$AlmacenDescripcion=0;
    	$stock=0;
    	$Almacen=0;
    	$listadoSeries = 0;
    
    	$SerieFechaRegistro=0;
    	$SerieNumero=0;
    	foreach($listadoAlmacen as $indice => $valor){
    
    		$numeroS+=1;
    		$AlmacenProductoCodigo=$valor->ALMPROD_Codigo;
    		$AlmacenDescripcion=$valor->PROD_Nombre;
    		$CodigoUsuario=$valor->PROD_CodigoUsuario;
    		//     		$serieSA=$valor->pedidoSerie;
    		$stock=$valor->ALMPROD_Stock;
    		//      		$unidad=$valor->UNDMED_Descripcion;
    		$Almacen=$valor->ALMAC_Descripcion;
    		$this->phpexcel->setActiveSheetIndex(0)
    		->setCellValue('A'.$lugar, $numeroS)
    		->setCellValue('B'.$lugar, $CodigoUsuario)
    		->setCellValue('C'.$lugar, $AlmacenDescripcion)
    		//     		->setCellValue('D'.$lugar, $fechaAprobacion)
    		->setCellValue('E'.$lugar, $stock)
    		//      		->setCellValue('F'.$lugar, $unidad)
    		->setCellValue('G'.$lugar, $Almacen);
    		$lugar+=1;
    
    		$listadoSeries = $this->almacenproductoserie_model->listar($AlmacenProductoCodigo);
    		//     		echo "<script>alert('Hola Listado Series : ".$listadoSeries."')</script>";
    
    		foreach($listadoSeries as $indice => $valor){
    
    
    			$numeroSerie+=1;
    			// 			   $cencosp=$valor->cencosp;
    			$SerieFechaRegistro= $valor->SERIC_FechaRegistro;
    			$SerieNumero=$valor->SERIC_Numero;
    
    			$this->phpexcel->setActiveSheetIndex(0)
    			->setCellValue('K'.$lugarSerie, $numeroSerie)
    			->setCellValue('L'.$lugarSerie, $AlmacenDescripcion)
    			->setCellValue('M'.$lugarSerie, $SerieFechaRegistro)
    			->setCellValue('N'.$lugarSerie, $SerieNumero);
    			$lugarSerie+=1;
    
    		}
    
    	}
    
    
    
    
    
    	$this->phpexcel->getActiveSheet()->getStyle('A8:G'.($lugar-1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//BORDE PARA LA LISTA DE ALAMCEN
    
    	$this->phpexcel->getActiveSheet()->getStyle('K8:G'.($lugar-1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//BORDE PARA LA TABLA SERIES DE ALAMCEN
    
    
    	$filename="reporte.xls"; //save our workbook as this file name
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename="reporte'.date('dmYHms').'.xlsx"');
    	header('Cache-Control: max-age=0');
    	$objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007');
    	$objWriter->save('php://output');
    }
    
    /**FIN DE DESCAR PARA EXCEL 2016 DICIEMBRE**/
    
    public function registro_producto_pdf($flagbs = 'B', $codigo='', $nombre='')
    {

        $this->load->library('cezpdf');
        $this->load->helper('pdf_helper');
        //prep_pdf();
        $this->cezpdf = new Cezpdf('a4');
        $datacreator = array(
            'Title' => 'Estadillo de ',
            'Name' => 'Estadillo de ',
            'Author' => 'Vicente Producciones',
            'Subject' => 'PDF con Tablas',
            'Creator' => 'info@vicenteproducciones.com',
            'Producer' => 'http://www.vicenteproducciones.com'
        );

        $this->cezpdf->addInfo($datacreator);
        $this->cezpdf->selectFont(APPPATH . 'libraries/fonts/Helvetica.afm');
        $delta = 20;

            

//        $this->cezpdf->ezText('', '', array("leading" => 100));
        $this->cezpdf->ezText('<b>LISTADO FAMILIA DE ARTICULOS</b>', 14, array("leading" => 0, 'left' => 185));
        $this->cezpdf->ezText('', '', array("leading" => 10));


        /* Datos del cliente */


//        /* Listado de detalles */

        $db_data = array();

        //LIMPIAR

       
        $filter = new stdClass();
        $filter->flagBS = 'B';
        $filter->codigo = $codigo;
        $filter->nombre = $nombre;
      
        $lista_producto = $this->producto_model->buscar_productos_general($filter);
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
        $data['lista'] = $lista;
       
        //FIN
            if(count($lista)>0){
                    foreach($lista as $indice=>$valor){
                    $codigo = $valor->FAMI_Codigo;
                    $codigo_interno = $valor->FAMI_CodigoInterno;
                    $descripcion = $valor->FAMI_Descripcion;


                    $db_data[] = array(
                        'cols1' => $indice + 1,
                        'cols2' => $codigo_interno,
                        'cols3' => $descripcion
                    );
                }
            }

        


        $col_names = array(
            'cols1' => '<b>ITEM</b>',
            'cols2' => '<b>CODIGO</b>',
            'cols3' => '<b>DESCRIPCION</b>'
        );

        $this->cezpdf->ezTable($db_data, $col_names, '', array(
            'width' => 525,
            'showLines' => 1,
            'shaded' => 1,
            'showHeadings' => 1,
            'xPos' => 'center',
            'fontSize' => 8,
            'cols' => array(
                'cols1' => array('width' => 30, 'justification' => 'center'),
                'cols2' => array('width' => 70, 'justification' => 'center'),
                'cols3' => array('width' => 245, 'justification' => 'left')
            )
        ));


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => $codificacion . '.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        ob_end_clean();

        $this->cezpdf->ezStream($cabecera);
    }

}

?>