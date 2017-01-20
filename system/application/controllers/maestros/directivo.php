<?php

class Directivo extends Controller {

    Public function __construct() {
        parent::Controller();
        $this->load->helper('date');
        $this->load->model('maestros/compania_model');
        $this->load->model('maestros/empresa_model');
        $this->load->model('maestros/persona_model');
        $this->load->model('maestros/directivo_model');
        $this->load->model('maestros/cargo_model');
        $this->load->model('maestros/area_model');
        $this->load->model('maestros/tipoestablecimiento_model');
        $this->load->model('maestros/nacionalidad_model');
        $this->load->model('maestros/tipodocumento_model');
        $this->load->model('maestros/tipocodigo_model');
        $this->load->model('maestros/estadocivil_model');
        $this->load->model('maestros/ubigeo_model');
        $this->load->model('maestros/formapago_model');
        $this->load->model('maestros/sectorcomercial_model');
        $this->load->model('ventas/tipocliente_model');
         $this->load->model('ventas/cliente_model');
        $this->load->helper('json');
        $this->load->library('html');
        $this->load->library('table');
        $this->load->library('layout', 'layout');
        $this->load->library('pagination');
    }

    public function index() {
        $this->layout->view('seguridad/inicio');
    }

    public function directivos($j = 0) {
        $data['codigo'] = "";
        $data['numdoc'] = "";
        $data['personacod'] = "";
        $data['nombre'] = "";
        $data['cargo'] = "";
        $data['fecini'] = "";
        $data['fecfin'] = "";
        $data['contrato'] = "";
        $data['titulo_tabla'] = "RELACIÓN DE EMPLEADOS";
        $data['registros'] = count($this->directivo_model->lista_vendedores2("1"));
        $data['action'] = base_url() . "index.php/maestros/directivo/buscar_directivos";
        $conf['base_url'] = site_url('maestros/directivo/directivos/');
        $conf['total_rows'] = $data['registros'];
        $conf['per_page'] = 50;
        $conf['num_links'] = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $data['cbo_empresa'] = $this->seleccionar_empresa("1");
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $listado_directivos = $this->directivo_model->lista_vendedores2("1");
        $item = $j + 1;
        $lista = array();
        if (count($listado_directivos) > 0) {
            foreach ($listado_directivos as $indice => $valor) {
                $codigo = $valor->DIREP_Codigo;
                $numdoc = $valor->dni;
                $nombres = $valor->nombre . " " . $valor->paterno . " " . $valor->materno;
                $empresa = $valor->empresa;
                $cargo = $valor->cargo;
                $inicio = mysql_to_human($valor->Inicio);
                $fin = mysql_to_human($valor->Fin);
                $contrato = $valor->Nro_Contrato;
                $editar = "<a href='javascript:;' onclick='editar_directivo(" . $codigo . ")'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver = "<a href='javascript:;' onclick='ver_directivo(" . $codigo . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Ver'></a>";
                $eliminar = "<a href='javascript:;' onclick='eliminar_directivo(" . $codigo . ")'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";

                $usua = $valor->USUA_Codigo;
               if($usua != "0"){
                $usuarioNom=$this->cliente_model->getUsuarioNombre($usua);
                    $nomusuario="";
                    if($usuarioNom[0]->ROL_Codigo==0){
                     $nomusuario= $usuarioNom[0]->USUA_usuario;
                        }else{
                     $explorar= explode(" ",$usuarioNom[0]->PERSC_Nombre);
                           
                        $nomusuario= strtolower($explorar[0]);
                    }
                }else{
                    $nomusuario="";
                }

                $lista[] = array($item, $numdoc, $nombres, $empresa, $cargo, $contrato, $inicio, $fin, $editar, $ver, $eliminar, $nomusuario);
                $item++;
            }
        }
        $data['lista'] = $lista;
        $this->layout->view("maestros/directivo_index", $data);
    }

    public function buscar_directivos($j = '0') {
        $numdoc = $this->input->post('txtNumDoc');
        $nombre = $this->input->post('txtNombre');
        $empresa = $this->input->post('cboEmpresa');

        $filter = new stdClass();
        $filter->numdoc = $numdoc;
        $filter->nombre = $nombre;
        $filter->empresa = $empresa;

        $data['numdoc'] = $numdoc;
        $data['nombre'] = $nombre;
        $data['cbo_empresa'] = $this->seleccionar_empresa($empresa);
        $data['titulo_tabla'] = "RESULTADO DE BÚSQUEDA DE EMPLEADOS";

        $data['registros'] = count($this->directivo_model->buscar_directivo2($filter));
        $data['action'] = base_url() . "index.php/maestros/directivo/buscar_directivos";
        $conf['base_url'] = site_url('maestros/directivo/buscar_directivos/');
        $conf['total_rows'] = $data['registros'];
        $conf['per_page'] = 50;
        $conf['num_links'] = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $listado_directivos = $this->directivo_model->buscar_directivo2($filter, $conf['per_page'], $j);
        $item = $j + 1;
        $lista = array();
        if (count($listado_directivos) > 0) {
            foreach ($listado_directivos as $indice => $valor) {
                $codigo = $valor->DIREP_Codigo;
                $numdoc = $valor->dni;
                $nombres = $valor->nombre . " " . $valor->paterno . " " . $valor->materno;
                $empresa = $valor->empresa;
                $cargo = $valor->cargo;
                $inicio = $valor->Inicio;
                $fin = $valor->Fin;
                $contrato = $valor->Nro_Contrato;
                $editar = "<a href='#' onclick='editar_directivo(" . $codigo . ")'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver = "<a href='#' onclick='ver_directivo(" . $codigo . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                $eliminar = "<a href='#' onclick='eliminar_directivo(" . $codigo . ")'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";

                 $usua = $valor->USUA_Codigo;
               if($usua != "0"){
                $usuarioNom=$this->cliente_model->getUsuarioNombre($usua);
                    $nomusuario="";
                    if($usuarioNom[0]->ROL_Codigo==0){
                     $nomusuario= $usuarioNom[0]->USUA_usuario;
                        }else{
                     $explorar= explode(" ",$usuarioNom[0]->PERSC_Nombre);
                           
                        $nomusuario= strtolower($explorar[0]);
                    }
                }else{
                    $nomusuario="";
                }
                $lista[] = array($item, $numdoc, $nombres, $empresa, $cargo, $contrato, $inicio, $fin, $editar, $ver, $eliminar,$nomusuario);
                $item++;
            }
        }
        $data['lista'] = $lista;
        $this->layout->view("maestros/directivo_index", $data);
    }

    public function nuevo_directivo() {
        $data['cbo_cargo'] = $this->seleccionar_cargo();
        $data['cbo_empresa'] = $this->seleccionar_empresa("1");
        //$data['cbo_Cargo']              = $this->OPTION_generador($this->cargo_model->listar_cargos(), 'CARGP_Codigo', 'CARGC_Descripcion', ''); //12: Al contado
        $data['cbo_dpto'] = $this->seleccionar_departamento('15');
        $data['cbo_prov'] = $this->seleccionar_provincia('15', '01');
        $data['cbo_dist'] = $this->seleccionar_distritos('15', '01');
        $data['cbo_estadoCivil'] = $this->seleccionar_estadoCivil('');
        $data['cbo_nacionalidad'] = $this->seleccionar_nacionalidad('193');
        $data['cbo_nacimiento'] = $this->seleccionar_distritos('15', '01', '01');
        $data['cbo_sectorComercial'] = $this->OPTION_generador($this->sectorcomercial_model->listar(), 'SECCOMP_Codigo', 'SECCOMC_Descripcion', '');
        $data['cboFormaPago'] = $this->OPTION_generador($this->formapago_model->listar(), 'FORPAP_Codigo', 'FORPAC_Descripcion', ''); //12: Al contado
        $data['tipocodigo'] = $this->seleccionar_tipocodigo('1');
        $data['display'] = "";
        $data['display_datosEmpresa'] = "display:none;";
        $data['display_datosDirectivo'] = "";
        $data['nombres'] = "";
        $data['paterno'] = "";
        $data['materno'] = "";
        $data['fecnac'] = "";
        $data['imagen'] = "";
        $data['numero_documento'] = "";
        $data['personacod'] = "";
        $data['ruc'] = "";
        $data['sexo'] = "";
        $data['tipo_documento'] = $this->seleccionar_tipodocumento('1');
        $data['tipo_persona'] = "0";
        $data['id'] = "";
        $data['modo'] = "insertar";
        $data['fecini'] = mysql_to_human(mdate("%Y-%m-%d ", time()));
        $data['fecfin'] = mysql_to_human(mdate("%Y-%m-%d ", time()));
        $data['contrato'] = "";
        $objeto = new stdClass();
        $objeto->id = "";
        $objeto->personacod = "";
        $objeto->tipo = "";
        $objeto->ruc = "";
        $objeto->nombre = "";
        $objeto->telefono = "";
        $objeto->movil = "";
        $objeto->fax = "";
        $objeto->web = "";
        $objeto->email = "";
        $objeto->direccion = "";
        $objeto->ctactesoles = "";
        $objeto->ctactedolares = "";
        $data['datos'] = $objeto;
        $data['titulo'] = "REGISTRAR EMPLEADO";
        $data['listado_empresaSucursal'] = array();
        $data['listado_empresaContactos'] = array();
        $data['cboNacimiento'] = "000000";
        $data['cboNacimientovalue'] = "";
        $this->load->view("maestros/directivo_nuevo", $data);
    }

    public function insertar_directivo() {
        if ($this->input->post('tipo_persona') == '0') {
            if ($this->input->post('tipo_documento') == '1' && $this->input->post('numero_documento') != '' && strlen($this->input->post('numero_documento')) != 8)
                exit('{"result":"error", "campo":"numero_documento", "msg": "Valor inválido"}');
            if ($this->input->post('nombres') == '')
                exit('{"result":"error", "campo":"nombres"}');
            if ($this->input->post('paterno') == '')
                exit('{"result":"error", "campo":"paterno"}');
        }else {
            if ($this->input->post('ruc') == '')
                exit('{"result":"error", "campo":"ruc"}');
            if ($this->input->post('cboTipoCodigo') == '1' && $this->input->post('ruc') != '' && strlen($this->input->post('ruc')) != 11)
                exit('{"result":"error", "campo":"ruc", "msg": "Valor inválido"}');
            if ($this->input->post('razon_social') == '')
                exit('{"result":"error","campo":"razon_social"}');
        }

        $nombre_sucursal = array();
        $nombre_contacto = array();
        $personacod = $this->input->post('personacod');
        $empresa_persona = $this->input->post('empresa_persona');
        $tipo_persona = $this->input->post('tipo_persona');
        $tipocodigo = $this->input->post('cboTipoCodigo');
        $ruc = $this->input->post('ruc');
        $razon_social = $this->input->post('razon_social');
        $telefono = $this->input->post('telefono');
        $movil = $this->input->post('movil');
        $fax = $this->input->post('fax');
        $email = $this->input->post('email');
        $web = $this->input->post('web');
        $direccion = $this->input->post('direccion');
        $departamento = $this->input->post('cboDepartamento');
        $provincia = $this->input->post('cboProvincia');
        $distrito = $this->input->post('cboDistrito');
        $categoria = $this->input->post('categoria');
        $sector_comercial = $this->input->post('sector_comercial');
        $forma_pago = $this->input->post('forma_pago');
        $ctactesoles = $this->input->post('ctactesoles');
        $ctactedolares = $this->input->post('ctactedolares');
        $ubigeo_domicilio = $departamento . $provincia . $distrito;

        //Datos exclusivos de la persona
        $nombres = $this->input->post('nombres');
        $paterno = $this->input->post('paterno');
        $materno = $this->input->post('materno');
        $tipo_documento = $this->input->post('tipo_documento');
        $numero_documento = $this->input->post('numero_documento');
        $fechanac = $this->input->post('fechanac');
        $ubigeo_nacimiento = $this->input->post('cboNacimiento') == '' ? '000000' : $this->input->post('cboNacimiento');
        $sexo = $this->input->post('cboSexo');
        $estado_civil = $this->input->post('cboEstadoCivil');
        $nacionalidad = $this->input->post('cboNacionalidad');
        $ruc_persona = $this->input->post('ruc_persona');

        //DIRECTIVO DATOS
        $finicio = human_to_mysql($this->input->post('fechai'));
        $ffin = human_to_mysql($this->input->post('fechaf'));
        $cargo = $this->input->post('cboCargo');
        //$empresad = $this->input->post('cboEmpresa');
        $contrato = $this->input->post('contrato');
        $compania = $this->input->post('empresa_persona');
        $idCompania = $this->input->post('idCompania');

        $idempresa = $this->directivo_model->obtener_empresa($idCompania);
        $empresad = $idempresa[0]->EMPRP_Codigo;
        //var_dump($idempresa[0]->EMPRP_Codigo);
        //echo "<br/>";
        // var_dump($idCompania);
        // exit();
        /* Array de variables */
        $nombre_sucursal = $this->input->post('nombreSucursal');
        $direccion_sucursal = $this->input->post('direccionSucursal');
        $tipo_establecimiento = $this->input->post('tipoEstablecimiento');
        $arrayDpto = $this->input->post('dptoSucursal');
        $arrayProv = $this->input->post('provSucursal');
        $arrayDist = $this->input->post('distSucursal');
        $persona_contacto = $this->input->post('contactoPersona');
        $nombre_contacto = $this->input->post('contactoNombre');
        $area_contacto = $this->input->post('contactoArea');
        $cargo_contacto = $this->input->post('cargo_encargado');
        $telefono_contacto = $this->input->post('contactoTelefono');
        $email_contacto = $this->input->post('contactoEmail');

        if ($arrayDpto != '' && $arrayProv != '' && $arrayDist != '') {
            $ubigeo_sucursal = $this->html->array_ubigeo($arrayDpto, $arrayProv, $arrayDist);
        }/*
          if($tipo_persona==1){//Empresa
          $persona = 0;
          if($empresa_persona!='' && $empresa_persona!='0'){
          $empresa=$empresa_persona;
          $this->empresa_model->modificar_datosEmpresa($empresa,$tipocodigo, $ruc,$razon_social,$telefono,$movil,$fax,$web,$email,$sector_comercial,$ctactesoles,$ctactedolares);
          }
          else
          $empresa = $this->empresa_model->insertar_datosEmpresa($tipocodigo, $ruc,$razon_social,$telefono,$fax,$web,$movil,$email,$sector_comercial,$ctactesoles,$ctactedolares);

          $this->empresa_model->insertar_sucursalEmpresaPrincipal('1',$empresa,$ubigeo_domicilio,'PRINCIPAL',$direccion);//Direccion Principal
          $cliente=$this->cliente_model->insertar_datosCliente($empresa,$persona,$tipo_persona, $categoria, $forma_pago);
          //Insertar Establecimientos
          if($nombre_sucursal!=''){
          foreach($nombre_sucursal as $indice=>$valor){
          if($nombre_sucursal[$indice]!='' && $direccion_sucursal!='' && $tipo_establecimiento[$indice]!=''){
          $ubigeo_s = strlen($ubigeo_sucursal[$indice])<6?"000000":$ubigeo_sucursal[$indice];
          $this->empresa_model->insertar_sucursalEmpresa($tipo_establecimiento[$indice],$empresa,$ubigeo_s,$nombre_sucursal[$indice],$direccion_sucursal[$indice]);
          exit($ubigeo_s);
          }
          }
          }
          //Insertar contactos empresa
          if($nombre_contacto!=''){
          foreach($nombre_contacto as $indice=>$valor){
          if($nombre_contacto[$indice]!=''){
          $pers_contacto = $persona_contacto[$indice];
          $nom_contacto  = $nombre_contacto[$indice];
          $car_contacto  = $cargo_contacto[$indice];
          $ar_contacto   = $area_contacto[$indice];
          $arrTelConctacto = explode("/",$telefono_contacto[$indice]);
          switch(count($arrTelConctacto)){
          case 2:
          $tel_contacto  = $arrTelConctacto[0];
          $mov_contacto  = $arrTelConctacto[1];
          break;
          case 1:
          $tel_contacto  = $arrTelConctacto[0];
          $mov_contacto  = "";
          break;
          case 0:
          $tel_contacto  = "";
          $mov_contacto  = "";
          break;
          }
          $e_contacto    = $email_contacto[$indice];
          if($pers_contacto==''){$pers_contacto = $this->persona_model->insertar_datosPersona('000000','000000','1','193',$nom_contacto,'','','','1');}//Inserto persona
          $directivo = $this->empresa_model->insertar_directivoEmpresa($empresa,$pers_contacto,$car_contacto);
          $this->empresa_model->insertar_areaEmpresa($ar_contacto,$empresa,$directivo,'::OBSERVACION::');
          $this->empresa_model->insertar_contactoEmpresa($empresa,'::OBSERVACION:',$tel_contacto,$mov_contacto,$e_contacto,$pers_contacto);
          }
          }
          }
          } */
        $config['upload_path'] = 'images/';
        $config['allowed_types'] = 'jpg|gif|png';
        $config['max_size'] = '5120';
        $config['max_width'] = '0';
        $config['max_height'] = '0';

        $imagen = $this->input->post('foto');
        $this->load->library('upload', $config);
        //print_r($_FILES);
        if (!$this->upload->do_upload('foto')) {
            $error = '';
            $imagen = "";
        } else {

            $data1 = $this->upload->data();

            $imagen = $data1['file_name'];
        }
        if ($tipo_persona == 0) {//Persona                
            $empresa = 0;
            if ($personacod != '' && $personacod != '0') {
                $persona = $personacod;
                $this->persona_model->modificar_datosPersona($persona, $ubigeo_nacimiento, $ubigeo_domicilio, $estado_civil, $nacionalidad, $nombres, $paterno, $materno, $ruc_persona, $tipo_documento, $numero_documento, $direccion, $telefono, $movil, $email, $direccion, $sexo, $fax, $web, $fechanac);
                //$this->persona_model->modificar_datosPersona($persona,$ubigeo_nacimiento,$ubigeo_domicilio,$estado_civil,$nacionalidad,$nombres,$paterno,$materno,$ruc_persona,$tipo_documento,$numero_documento,$direccion,$telefono,$movil,$email,$domicilio,$sexo,$fax,$web);
            } else {
                //echo "Entro ok";
                //var_dump($fechanac);
                $persona = $this->persona_model->insertar_datosPersona($ubigeo_nacimiento, $ubigeo_domicilio, $estado_civil, $nacionalidad, $nombres, $paterno, $materno, $ruc_persona, $tipo_documento, $numero_documento, $direccion, $telefono, $movil, $email, $direccion, $sexo, $fax, $web, $fechanac);
                //$persona = $this->persona_model->insertar_datosPersona($ubigeo_nacimiento,$ubigeo_domicilio,$estado_civil,$nacionalidad,$nombres,$paterno,$materno,$ruc_persona,$tipo_documento,$numero_documento,$direccion,$telefono,$movil,$email,$direccion,$sexo,$web,$ctactesoles,$ctactedolares);                    
            }
            //exit();
            //$cliente=$this->directivo_model->insertar_datosDirectivo($empresa,$persona,$tipo_persona, $categoria, $forma_pago);
            $USUACodi= $this->session->userdata('user');     
            $directivo = $this->directivo_model->insertar_datosDirectivo($empresad, $persona, $finicio, $ffin, $cargo, $contrato, $imagen,$USUACodi);
        }

        $this->directivos();
    }
    public function registro_directivo_pdf ($documento='', $nombre='')
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
        $this->cezpdf->ezText('<b>LISTADO EMPLEADOS</b>', 14, array("leading" => 0, 'left' => 185));
        $this->cezpdf->ezText('', '', array("leading" => 10));


        /* Datos del cliente */


//        /* Listado de detalles */

        $db_data = array();


        $listado_directivo = $this->directivo_model->listar_directivo_pdf($documento,$nombre);
    
            if (count($listado_directivo) > 0) {
                foreach ($listado_directivo as $indice => $valor) {
                    $dni = $valor->dni;
                    $nombre = $valor->nombre." ".$valor->paterno." ".$valor->materno;
                    $empresa = $valor->empresa;
                    $cargo = $valor->cargo;
                    $contrato = $valor->Nro_Contrato;
                    $inicio = $valor->Inicio;
                    $fin = $valor->Fin;


                    $db_data[] = array(
                        'cols1' => $indice + 1,
                        'cols2' => $dni,
                        'cols3' => $nombre,
                        'cols4' => $empresa,
                        'cols5' => $cargo,
                        'cols6' => $contrato,
                        'cols7' => $inicio,
                        'cols8' => $fin

                    );
                }
            }

        


        $col_names = array(
            'cols1' => '<b>ITEM</b>',
            'cols2' => '<b>DNI</b>',
            'cols3' => '<b>NOMBRE</b>',
            'cols4' => '<b>EMPRESA</b>',
            'cols5' => '<b>CARGO</b>',
            'cols6' => '<b>CONTRATO</b>',
            'cols7' => '<b>FECH. INICIO</b>',
            'cols8' => '<b>FECH. FIN</b>'
        );

        $this->cezpdf->ezTable($db_data, $col_names, '', array(
            'width' => 650,
            'showLines' => 1,
            'shaded' => 1,
            'showHeadings' => 1,
            'xPos' => 'center',
            'fontSize' => 7,
            'cols' => array(
                'cols1' => array('width' => 30, 'justification' => 'center'),
                'cols2' => array('width' => 45, 'justification' => 'center'),
                'cols3' => array('width' => 80, 'justification' => 'left'),
                'cols4' => array('width' => 100, 'justification' => 'center'),
                'cols5' => array('width' => 50, 'justification' => 'center'),
                'cols6' => array('width' =>50, 'justification' => 'left'),
                'cols7' => array('width' => 50, 'justification' => 'center'),
                'cols8' => array('width' => 50, 'justification' => 'center')
            )
        ));


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => $codificacion . '.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        ob_end_clean();

        $this->cezpdf->ezStream($cabecera);
    }


    //A_Editar
    public function editar_directivo($id) {
        $data['id'] = $id;
        $data['modo'] = "modificar";
        $datos = $this->directivo_model->obtener_directivo($id);
        $tipo_persona = "0"; //$datos[0]->CLIC_TipoPersona;
        $persona = $datos[0]->PERSP_Codigo;
        $data['personacod'] = $datos[0]->PERSP_Codigo;
        $data['fecini'] = mysql_to_human($datos[0]->DIREC_FechaInicio);
        $data['fecfin'] = mysql_to_human($datos[0]->DIREC_FechaFin);
        $data['cbo_cargo'] = $this->seleccionar_cargo($datos[0]->CARGP_Codigo);
        $data['cbo_empresa'] = $this->seleccionar_empresa($datos[0]->EMPRP_Codigo);
        $data['contrato'] = $datos[0]->DIREC_NroContrato;
        $data['imagen'] = $datos[0]->DIREC_Imagen;
        //var_dump((array)$datos[0]->DIREC_Imagen);
        $data['modo'] = "modificar";
        $data['display'] = "style='display: none'";
        $data['tipo_persona'] = $tipo_persona;

        //$data['cbo_categoria'] = $this->seleccionar_categoria($datos[0]->TIPCLIP_Codigo);
        //$data['cboFormaPago']  = $this->OPTION_generador($this->formapago_model->listar(), 'FORPAP_Codigo', 'FORPAC_Descripcion', $datos[0]->FORPAP_Codigo);
        if ($tipo_persona == 0) {//Persona
            $datos_persona = $this->persona_model->obtener_datosPersona($persona);
            $ubigeo_domicilio = $datos_persona[0]->UBIGP_Domicilio;
            $ubigeo_nacimiento = $datos_persona[0]->UBIGP_LugarNacimiento;
            $nacionalidad = $datos_persona[0]->NACP_Nacionalidad;
            $estado_civil = $datos_persona[0]->ESTCP_EstadoCivil;
            $fec_nac = $datos_persona[0]->PERSC_FechaNac;
            $dpto_domicilio = substr($ubigeo_domicilio, 0, 2);
            $prov_domicilio = substr($ubigeo_domicilio, 2, 2);
            $dist_domicilio = substr($ubigeo_domicilio, 4, 2);
            $dpto_nacimiento = substr($ubigeo_nacimiento, 0, 2);
            $prov_nacimiento = substr($ubigeo_nacimiento, 2, 2);
            $dist_nacimiento = substr($ubigeo_nacimiento, 4, 2);
            $data['nombres'] = $datos_persona[0]->PERSC_Nombre;
            $data['paterno'] = $datos_persona[0]->PERSC_ApellidoPaterno;
            $data['materno'] = $datos_persona[0]->PERSC_ApellidoMaterno;
            $data['tipo_documento'] = $this->seleccionar_tipodocumento($datos_persona[0]->PERSC_TipoDocIdentidad);
            $data['numero_documento'] = $datos_persona[0]->PERSC_NumeroDocIdentidad;
            $data['fecnac'] = $fec_nac;
            $data['ruc'] = $datos_persona[0]->PERSC_Ruc;
            $data['sexo'] = $datos_persona[0]->PERSC_Sexo;
            $data['cbo_estadoCivil'] = $this->seleccionar_estadoCivil($estado_civil);
            $data['cbo_nacionalidad'] = $this->seleccionar_nacionalidad($nacionalidad);
            $data['fecnac'] = $datos_persona[0]->PERSC_FechaNac;
            //var_dump((array)$datos_persona[0]->PERSC_FechaNac);
            $data['cboNacimiento'] = $ubigeo_nacimiento;
            $nombre_persona = $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno . " " . $datos_persona[0]->PERSC_Nombre;
            $datos_nacimiento = $this->ubigeo_model->obtener_ubigeo($ubigeo_nacimiento);
            $data['cboNacimientovalue'] = $ubigeo_nacimiento == '000000' ? '' : $datos_nacimiento[0]->UBIGC_Descripcion;
            $data['cbo_dpto'] = $this->seleccionar_departamento($dpto_domicilio);
            $data['cbo_prov'] = $this->seleccionar_provincia($dpto_domicilio, $prov_domicilio);
            $data['cbo_dist'] = $this->seleccionar_distritos($dpto_domicilio, $prov_domicilio, $dist_domicilio);
            $data['direccion'] = $datos_persona[0]->PERSC_Direccion;

            /* Mejorar esto */
            $objeto = new stdClass();
            $objeto->id = $datos_persona[0]->PERSP_Codigo;
            $objeto->personacod = $data['personacod'];
            $objeto->persona = $datos_persona[0]->PERSP_Codigo;
            $objeto->empresa = 0;
            $objeto->nombre = $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno . " " . $datos_persona[0]->PERSC_Nombre;
            $objeto->ruc = $datos_persona[0]->PERSC_Ruc;
            $objeto->telefono = $datos_persona[0]->PERSC_Telefono;
            $objeto->fax = $datos_persona[0]->PERSC_Fax;
            $objeto->movil = $datos_persona[0]->PERSC_Movil;
            $objeto->web = $datos_persona[0]->PERSC_Web;
            $objeto->direccion = $datos_persona[0]->PERSC_Direccion;
            $objeto->email = $datos_persona[0]->PERSC_Email;
            $objeto->ctactesoles = $datos_persona[0]->PERSC_CtaCteSoles;
            $objeto->ctactedolares = $datos_persona[0]->PERSC_CtaCteDolares;
            $objeto->dni = $datos_persona[0]->PERSC_NumeroDocIdentidad;
            $objeto->tipo = "0";
            $objeto->fecini = $data['fecini'];
            $objeto->fecfin = $data['fecfin'];
            $objeto->cargo = $data['cbo_cargo'];
            $objeto->contrato = $data['contrato'];
            $data['datos'] = $objeto;
            /**/
            $data['display_datosEmpresa'] = "display:none;";
            $data['display_datosDirectivo'] = "";
            $data['titulo'] = "EDITAR EMPLEADO ::: " . $nombre_persona;
        }
        $this->load->view("maestros/directivo_nuevo", $data);
    }

    public function modificar_directivo() {

        $directivo = $this->input->post('id');

        //$empresa = $this->input->post('cboCompania');
        $personacod = $this->input->post('personacod');
        $cargo = $this->input->post('cboCargo');
        $fecini = human_to_mysql($this->input->post('fechai'));
        $fecfin = human_to_mysql($this->input->post('fechaf'));
        $contrato = $this->input->post('contrato');

        //INICIO

        $empresa_persona = $this->input->post('empresa_persona');
        $tipo_persona = $this->input->post('tipo_persona');
        $tipocodigo = $this->input->post('cboTipoCodigo');
        $ruc = $this->input->post('ruc');
        $razon_social = $this->input->post('razon_social');
        $telefono = $this->input->post('telefono');
        $movil = $this->input->post('movil');
        $fax = $this->input->post('fax');
        $email = $this->input->post('email');
        $web = $this->input->post('web');
        $direccion = $this->input->post('direccion');
        $departamento = $this->input->post('cboDepartamento');
        $provincia = $this->input->post('cboProvincia');
        $distrito = $this->input->post('cboDistrito');
        $categoria = $this->input->post('categoria');
        $sector_comercial = $this->input->post('sector_comercial');
        $forma_pago = $this->input->post('forma_pago');
        $ctactesoles = $this->input->post('ctactesoles');
        $ctactedolares = $this->input->post('ctactedolares');
        $ubigeo_domicilio = $departamento . $provincia . $distrito;
        
        $idCompania = $this->input->post('idCompania');
        $idempresa = $this->directivo_model->obtener_empresa($idCompania);
        $empresa = $idempresa[0]->EMPRP_Codigo;
        
        //Datos exclusivos de la persona
        $nombres = $this->input->post('nombres');
        $paterno = $this->input->post('paterno');
        $materno = $this->input->post('materno');
        $tipo_documento = $this->input->post('tipo_documento');
        $numero_documento = $this->input->post('numero_documento');
        $ubigeo_nacimiento = $this->input->post('cboNacimiento') == '' ? '000000' : $this->input->post('cboNacimiento');
        $sexo = $this->input->post('cboSexo');
        $estado_civil = $this->input->post('cboEstadoCivil');
        $nacionalidad = $this->input->post('cboNacionalidad');
        $ruc_persona = $this->input->post('ruc_persona');
        $fecnac = $this->input->post('fechanac');
        //var_dump($fecnac);
        //DIRECTIVO DATOS
        $finicio = human_to_mysql($this->input->post('fechai'));
        $ffin = human_to_mysql($this->input->post('fechaf'));
        $cargo = $this->input->post('cboCargo');
        //$empresad = $this->input->post('cboEmpresa');
        $contrato = $this->input->post('contrato');

        //FIN
        $config['upload_path'] = 'images/';
        $config['allowed_types'] = 'jpg|gif|png';
        $config['max_size'] = '5120';
        $config['max_width'] = '0';
        $config['max_height'] = '0';


        $imagen = $this->input->post('foto');

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto')) {
            $error = '';
            $imagen = "";
        } else {


            $data1 = $this->upload->data();

            $imagen = $data1['file_name'];
        }
        
        if ($tipo_persona == 0) {//Persona
            if ($personacod != '' && $personacod != '0') {
                $persona = $personacod;
                $this->persona_model->modificar_datosPersona($persona, $ubigeo_nacimiento, $ubigeo_domicilio, $estado_civil, $nacionalidad, $nombres, $paterno, $materno, $ruc_persona, $tipo_documento, $numero_documento, $direccion, $telefono, $movil, $email, $direccion, $sexo, $fax, $web, $fecnac);
            } else {
                $persona = $this->persona_model->insertar_datosPersona($ubigeo_nacimiento, $ubigeo_domicilio, $estado_civil, $nacionalidad, $nombres, $paterno, $materno, $ruc_persona, $tipo_documento, $numero_documento, $direccion, $telefono, $movil, $email, $direccion, $sexo, $web, $fecnac);
            }
            $USUACodi= $this->session->userdata('user');
            $this->directivo_model->modificar_datosDirectivo($directivo, $empresa, $personacod, $cargo, $fecini, $fecfin, $contrato, $imagen,$USUACodi);
        }

        $this->directivos();
    }

    //A_Ver_directivo
    public function ver_directivo($directivo) {
        $datosD = $this->directivo_model->obtener_directivo($directivo);
        $persona = $datosD[0]->PERSP_Codigo;
        $data['personacod'] = $datosD[0]->PERSP_Codigo;
        $data['fecini'] = mysql_to_human($datosD[0]->DIREC_FechaInicio);
        $data['fecfin'] = mysql_to_human($datosD[0]->DIREC_FechaFin);

        $datosC = $this->cargo_model->obtener_cargo($datosD[0]->CARGP_Codigo);
        $data['cbo_cargo'] = $datosC[0]->CARGC_Descripcion;
        $datosE = $this->empresa_model->obtener_datosEmpresa($datosD[0]->EMPRP_Codigo);
        $data['cbo_empresa'] = $datosE[0]->EMPRC_RazonSocial;
        $data['contrato'] = $datosD[0]->DIREC_NroContrato;

        $datos = $this->persona_model->obtener_datosPersona($persona);
        $tipo_doc = $datos[0]->PERSC_TipoDocIdentidad;
        $estado_civil = $datos[0]->ESTCP_EstadoCivil;
        $nacionalidad = $datos[0]->NACP_Nacionalidad;
        $nacimiento = $datos[0]->UBIGP_LugarNacimiento;
        $sexo = $datos[0]->PERSC_Sexo;
        $ubigeo_domicilio = $datos[0]->UBIGP_Domicilio;
        $datos_nacionalidad = $this->nacionalidad_model->obtener_nacionalidad($nacionalidad);
        $datos_nacimiento = $this->ubigeo_model->obtener_ubigeo($nacimiento);
        $datos_ubigeoDom_dpto = $this->ubigeo_model->obtener_ubigeo_dpto($ubigeo_domicilio);
        $datos_ubigeoDom_prov = $this->ubigeo_model->obtener_ubigeo_prov($ubigeo_domicilio);
        $datos_ubigeoDom_dist = $this->ubigeo_model->obtener_ubigeo($ubigeo_domicilio);
        $datos_doc = $this->tipodocumento_model->obtener_tipoDocumento($tipo_doc);
        $datos_estado_civil = $this->estadocivil_model->obtener_estadoCivil($estado_civil);
        $data['nacionalidad'] = $datos_nacionalidad[0]->NACC_Descripcion;
        $data['nacimiento'] = $datos_nacimiento[0]->UBIGC_Descripcion;
        $data['tipo_doc'] = $datos_doc[0]->TIPOCC_Inciales;
        $data['estado_civil'] = $datos_estado_civil[0]->ESTCC_Descripcion;
        $data['sexo'] = $sexo == 0 ? 'MASCULINO' : 'FEMENINO';
        $data['telefono'] = $datos[0]->PERSC_Telefono;
        $data['movil'] = $datos[0]->PERSC_Movil;
        $data['fax'] = $datos[0]->PERSC_Fax;
        $data['email'] = $datos[0]->PERSC_Email;
        $data['web'] = $datos[0]->PERSC_Web;
        $data['direccion'] = $datos[0]->PERSC_Direccion;
        $data['dpto'] = $datos_ubigeoDom_dpto[0]->UBIGC_Descripcion;
        $data['prov'] = $datos_ubigeoDom_prov[0]->UBIGC_Descripcion;
        $data['dist'] = $datos_ubigeoDom_dist[0]->UBIGC_Descripcion;

        $data['datos'] = $datos;
        $data['titulo'] = "VER EMPLEADO";

        $this->load->view('maestros/directivo_ver', $data);
    }

    public function eliminar_directivo() {
        $directivo = $this->input->post('directivo');
        $this->directivo_model->eliminar_directivo($directivo);
    }

    public function seleccionar_cargo($indDefault = '') {
        $array_dist = $this->cargo_model->listar_cargos();

        $arreglo = array();
        if (count($array_dist) > 0) {
            foreach ($array_dist as $indice => $valor) {
                $indice1 = $valor->CARGP_Codigo;
                $valor1 = $valor->CARGC_Descripcion;
                $arreglo[$indice1] = $valor1;
            }
        }
        $resultado = $this->html->optionHTML($arreglo, $indDefault, array('0', '::Seleccione::'));
        return $resultado;
    }

    public function seleccionar_empresa($indDefault = '') {
        $array_dist = $this->empresa_model->listar_empresas();

        $arreglo = array();
        if (count($array_dist) > 0) {
            foreach ($array_dist as $indice => $valor) {
                $indice1 = $valor->EMPRP_Codigo;
                $valor1 = $valor->EMPRC_RazonSocial;
                $arreglo[$indice1] = $valor1;
            }
        }
        $resultado = $this->html->optionHTML($arreglo, $indDefault, array('0', '::Seleccione::'));
        return $resultado;
    }

    public function seleccionar_departamento($indDefault = '') {
        $array_dpto = $this->ubigeo_model->listar_departamentos();
        $arreglo = array();
        if (count($array_dpto) > 0) {
            foreach ($array_dpto as $indice => $valor) {
                $indice1 = $valor->UBIGC_CodDpto;
                $valor1 = $valor->UBIGC_Descripcion;
                $arreglo[$indice1] = $valor1;
            }
        }
        $resultado = $this->html->optionHTML($arreglo, $indDefault, array('00', '::Seleccione::'));
        return $resultado;
    }

    public function seleccionar_provincia($departamento, $indDefault = '') {
        $array_prov = $this->ubigeo_model->listar_provincias($departamento);
        $arreglo = array();
        if (count($array_prov) > 0) {
            foreach ($array_prov as $indice => $valor) {
                $indice1 = $valor->UBIGC_CodProv;
                $valor1 = $valor->UBIGC_Descripcion;
                $arreglo[$indice1] = $valor1;
            }
        }
        $resultado = $this->html->optionHTML($arreglo, $indDefault, array('00', '::Seleccione::'));
        return $resultado;
    }

    public function seleccionar_distritos($departamento, $provincia, $indDefault = '') {
        $array_dist = $this->ubigeo_model->listar_distritos($departamento, $provincia);
        $arreglo = array();
        if (count($array_dist) > 0) {
            foreach ($array_dist as $indice => $valor) {
                $indice1 = $valor->UBIGC_CodDist;
                $valor1 = $valor->UBIGC_Descripcion;
                $arreglo[$indice1] = $valor1;
            }
        }
        $resultado = $this->html->optionHTML($arreglo, $indDefault, array('00', '::Seleccione::'));
        return $resultado;
    }

    public function seleccionar_estadoCivil($indSel) {
        $array_dist = $this->estadocivil_model->listar_estadoCivil();
        $arreglo = array();
        foreach ($array_dist as $indice => $valor) {
            $indice1 = $valor->ESTCP_Codigo;
            $valor1 = $valor->ESTCC_Descripcion;
            $arreglo[$indice1] = $valor1;
        }
        $resultado = $this->html->optionHTML($arreglo, $indSel, array('0', '::Seleccione::'));
        return $resultado;
    }

    public function seleccionar_nacionalidad($indSel = '') {
        $array_dist = $this->nacionalidad_model->listar_nacionalidad();
        $arreglo = array();
        foreach ($array_dist as $indice => $valor) {
            $indice1 = $valor->NACP_Codigo;
            $valor1 = $valor->NACC_Descripcion;
            $arreglo[$indice1] = $valor1;
        }
        $resultado = $this->html->optionHTML($arreglo, $indSel, array('', '::Seleccione::'));
        return $resultado;
    }

    public function seleccionar_tipodocumento($indDefault = '') {
        $array_dist = $this->tipodocumento_model->listar_tipo_documento();
        $arreglo = array();
        if (count($array_dist) > 0) {
            foreach ($array_dist as $indice => $valor) {
                $indice1 = $valor->TIPDOCP_Codigo;
                $valor1 = $valor->TIPOCC_Inciales;
                $arreglo[$indice1] = $valor1;
            }
        }
        $resultado = $this->html->optionHTML($arreglo, $indDefault, array('0', '::Seleccione::'));
        return $resultado;
    }

    public function seleccionar_tipocodigo($indDefault = '') {
        $array_dist = $this->tipocodigo_model->listar_tipo_codigo();
        $arreglo = array();
        if (count($array_dist) > 0) {
            foreach ($array_dist as $indice => $valor) {
                $indice1 = $valor->TIPCOD_Codigo;
                $valor1 = $valor->TIPCOD_Inciales;
                $arreglo[$indice1] = $valor1;
            }
        }
        $resultado = $this->html->optionHTML($arreglo, $indDefault, array('0', '::Seleccione::'));
        return $resultado;
    }

    function JSON_buscar_directivo($numdoc) {
        $datos_empresa = $this->empresa_model->obtener_datosEmpresa2($numdoc);
        $datos_persona = $this->persona_model->obtener_datosPersona2($numdoc);
        $resultado = '[{"CLIP_Codigo":"0","EMPRC_Ruc":"","EMPRC_RazonSocial":""}]';
        if (count($datos_empresa) > 0) {
            $empresa = $datos_empresa[0]->EMPRP_Codigo;
            $razon_social = $datos_empresa[0]->EMPRC_RazonSocial;
            $datosCliente = $this->cliente_model->obtener_datosCliente2($empresa);
            if (count($datosCliente) > 0) {
                $cliente = $datosCliente[0]->CLIP_Codigo;
                $resultado = '[{"CLIP_Codigo":"' . $cliente . '","EMPRC_Ruc":"' . $numdoc . '","EMPRC_RazonSocial":"' . $razon_social . '"}]';
            }
        } elseif (count($datos_persona) > 0) {
            $persona = $datos_persona[0]->PERSP_Codigo;
            $nombres = $datos_persona[0]->PERSC_Nombre . " " . $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno;
            $datosCliente = $this->cliente_model->obtener_datosCliente3($persona);
            if (count($datosCliente) > 0) {
                $cliente = $datosCliente[0]->CLIP_Codigo;
                $resultado = '[{"CLIP_Codigo":"' . $cliente . '","EMPRC_Ruc":"' . $numdoc . '","EMPRC_RazonSocial":"' . $nombres . '"}]';
            }
        }
        echo $resultado;
    }

}

?>