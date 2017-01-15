<?php
class Empresa extends Controller{
    public function __construct(){
            parent::Controller();
    $this->load->model('maestros/empresa_model'); 
	$this->load->model('maestros/compania_model');
    $this->load->model('almacen/almacen_model');
    $this->load->model('maestros/persona_model'); 
    $this->load->model('maestros/tipoestablecimiento_model');
    $this->load->model('maestros/ubigeo_model');
    $this->load->model('maestros/directivo_model');
    $this->load->model('maestros/cargo_model');
    $this->load->model('maestros/area_model');
    $this->load->model('maestros/estadocivil_model');
    $this->load->model('maestros/nacionalidad_model');
    $this->load->model('maestros/tipocodigo_model');
    $this->load->model('maestros/tipodocumento_model');
    $this->load->model('maestros/sectorcomercial_model');
    $this->load->model('maestros/formapago_model');
    $this->load->model('compras/proveedor_model');
    $this->load->library('html');
    $this->load->library('pagination');	
    $this->load->library('layout','layout');
    }
    public function index()
    {
            $this->layout->view('seguridad/inicio');	
    }
    public function empresas($j=0){
        $data['numdoc']       = "";
        $data['nombre']    = "";
        $data['telefono']  = "";
        $data['titulo_tabla']    = "RELACIÓN DE EMPRESAS";

        $data['registros'] = count($this->empresa_model->listar_empresas());
        $data['action'] = base_url()."index.php/maestros/empresa/buscar_empresas";
        $conf['base_url'] = site_url('maestros/empresa/empresas/');
        $conf['total_rows'] = $data['registros'];
        $conf['per_page'] = 50;
        $conf['num_links']  = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link']  = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $listado_emepresas = $this->empresa_model->listar_empresas(null, $conf['per_page'],$j);
        $item            = $j+1;
        $lista           = array();
                    if(count($listado_emepresas)>0){
                            foreach($listado_emepresas as $indice=>$valor){
                                    $codigo         = $valor->EMPRP_Codigo;
                                    $ruc            = $valor->EMPRC_Ruc;
                                    $razon_social   = $valor->EMPRC_RazonSocial;
                                    $telefono       = $valor->EMPRC_Telefono;
                                    $movil          = $valor->EMPRC_Movil;
                                    $editar         = "<a href='javascript:;' onclick='editar_empresa(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                                    $ver            = "<a href='javascript:;' onclick='ver_empresa(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                                    $eliminar       = "<a href='javascript:;' onclick='eliminar_empresa(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                                    $lista[]        = array($item,$ruc,$razon_social,$telefono,$movil,$editar,$ver,$eliminar);
                                    $item++;
                            }
                    }
        $data['lista'] = $lista;
        $this->layout->view("maestros/empresa_index",$data);
    }
    public function nuevo_empresa(){
        $data['cbo_dpto']         = $this->OPTION_generador($this->ubigeo_model->listar_departamentos(), 'UBIGC_CodDpto', 'UBIGC_Descripcion','15', array('00','::Seleccione::'));
        $data['cbo_prov']         = $this->OPTION_generador($this->ubigeo_model->listar_provincias('15'), 'UBIGC_CodProv', 'UBIGC_Descripcion','01', array('00','::Seleccione::'));
        $data['cbo_dist']         = $this->OPTION_generador($this->ubigeo_model->listar_distritos('15', '01'), 'UBIGC_CodDist', 'UBIGC_Descripcion','00', array('00','::Seleccione::'));
        $data['cbo_estadoCivil']  = $this->OPTION_generador($this->estadocivil_model->listar_estadoCivil(), 'ESTCP_Codigo', 'ESTCC_Descripcion');
        $data['cbo_nacionalidad'] = $this->OPTION_generador($this->nacionalidad_model->listar_nacionalidad(), 'NACP_Codigo', 'NACC_Descripcion', '193');
        $data['cbo_nacimiento']   = $this->OPTION_generador($this->ubigeo_model->listar_distritos('15', '01'), 'UBIGC_CodDist', 'UBIGC_Descripcion','01', array('00','::Seleccione::'));
        $data['tipocodigo']       = $this->OPTION_generador($this->tipocodigo_model->listar_tipo_codigo(), 'TIPCOD_Codigo', 'TIPCOD_Inciales', '1');
        $data['cbo_sectorComercial'] = $this->OPTION_generador($this->sectorcomercial_model->listar(), 'SECCOMP_Codigo', 'SECCOMC_Descripcion', '');
        $data['cboFormaPago']     = $this->OPTION_generador($this->formapago_model->listar(), 'FORPAP_Codigo', 'FORPAC_Descripcion', ''); //12: Al contado
        $data['modo']             = "insertar";
        $objeto = new stdClass();
        $objeto->id       = "";
        $objeto->tipo     = "";
        $objeto->ruc      = "";
        $objeto->nombre   = "";
        $objeto->telefono = "";
        $objeto->movil    = "";
        $objeto->fax      = "";
        $objeto->web      = "";
        $objeto->email    = "";
        $objeto->direccion="";
        $objeto->ctactesoles="";
        $objeto->ctactedolares="";
        $data['datos'] = $objeto; 
        $data['titulo'] = "REGISTRAR EMPRESA";
        $data['listado_empresaSucursal']  = array();
        $data['listado_empresaContactos'] = array();
        $data['cboNacimiento'] = "000000";
        $data['cboNacimientovalue'] = "";
        $this->load->view("maestros/empresa_nuevo",$data);
    }

public function registro_empresa_pdf($flagbs = 'B', $documento='', $nombre='')
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
        $this->cezpdf->ezText('<b>LISTADO DE EMPRESAS</b>', 14, array("leading" => 0, 'left' => 185));
        $this->cezpdf->ezText('', '', array("leading" => 10));


        /* Datos del cliente */


//        /* Listado de detalles */

        $db_data = array();


        $listado_productos = $this->empresa_model->listar_empresa_pdf($flagbs,$documento,$nombre);
    
            if (count($listado_productos) > 0) {
                foreach ($listado_productos as $indice => $valor) {
                    $ruc = $valor->EMPRC_Ruc;
                    $nombre = $valor->EMPRC_RazonSocial;
                    $email = $valor->EMPRC_Email;
                     $telefono = $valor->EMPRC_Telefono;


                    $db_data[] = array(
                        'cols1' => $indice + 1,
                        'cols2' => $ruc,
                        'cols3' => $nombre,
                        'cols4' => $email,
                        'cols5' => $telefono
                    );
                }
            }

        


        $col_names = array(
            'cols1' => '<b>ITEM</b>',
            'cols2' => '<b>RUC / DNI</b>',
            'cols3' => '<b>NOMBRE O RAZÓN SOCIAL</b>',
            'cols4' => '<b>EMAIL</b>',
            'cols5' => '<b>TELÉFONO</b>'
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
                'cols3' => array('width' => 170, 'justification' => 'left'),
                 'cols4' => array('width' => 150, 'justification' => 'left'),
                'cols5' => array('width' => 55, 'justification' => 'left')
            )
        ));


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => $codificacion . '.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        ob_end_clean();

        $this->cezpdf->ezStream($cabecera);
    }

    public function insertar_empresa(){
        $nombre_sucursal = array();
        $nombre_contacto = array();
        $empresa_persona = $this->input->post('empresa_persona');
        $tipocodigo      = $this->input->post('cboTipoCodigo');
        $ruc             = $this->input->post('ruc');
        $razon_social    = $this->input->post('razon_social');	
        $sector_comercial= $this->input->post('sector_comercial');	
        $telefono        = $this->input->post('telefono');
        $movil           = $this->input->post('movil');
        $fax             = $this->input->post('fax');
        $email           = $this->input->post('email');
        $web             = $this->input->post('web');
        $direccion       = $this->input->post('direccion');
        $departamento    = $this->input->post('cboDepartamento');
        $provincia       = $this->input->post('cboProvincia');
        $distrito        = $this->input->post('cboDistrito');	
        $ctactesoles     = $this->input->post('ctactesoles');
        $ctactedolares   = $this->input->post('ctactedolares');
        $ubigeo_domicilio= $departamento.$provincia.$distrito;
        
        /*Array de variables*/
        $nombre_sucursal      = $this->input->post('nombreSucursal');
        $direccion_sucursal   = $this->input->post('direccionSucursal');
        $tipo_establecimiento = $this->input->post('tipoEstablecimiento');		
        $arrayDpto            = $this->input->post('dptoSucursal');
        $arrayProv            = $this->input->post('provSucursal');
        $arrayDist            = $this->input->post('distSucursal');
        $persona_contacto     = $this->input->post('contactoPersona');
        $nombre_contacto      = $this->input->post('contactoNombre');
        $area_contacto        = $this->input->post('contactoArea');
        $cargo_contacto       = $this->input->post('cargo_encargado');
        $telefono_contacto    = $this->input->post('contactoTelefono');
        $email_contacto       = $this->input->post('contactoEmail');
        if($arrayDpto!='' && $arrayProv!='' && $arrayDist!=''){
                $ubigeo_sucursal  = $this->html->array_ubigeo($arrayDpto,$arrayProv,$arrayDist);
        }
        
        $empresa = $this->empresa_model->insertar_datosEmpresa($tipocodigo, $ruc,$razon_social,$telefono,$fax,$web,$movil,$email, $sector_comercial, $ctactesoles, $ctactedolares);

        $this->empresa_model->insertar_sucursalEmpresaPrincipal('1',$empresa,$ubigeo_domicilio,'PRINCIPAL',$direccion);//Direccion Principal
        //Insertar Establecimientos
        if($nombre_sucursal!=''){
            foreach($nombre_sucursal as $indice=>$valor){
                if($nombre_sucursal[$indice]!='' && $direccion_sucursal!='' && $tipo_establecimiento[$indice]!=''){
                    $ubigeo_s = strlen($ubigeo_sucursal[$indice])<6?"000000":$ubigeo_sucursal[$indice];
                    $this->empresa_model->insertar_sucursalEmpresa($tipo_establecimiento[$indice],$empresa,$ubigeo_s,$nombre_sucursal[$indice],$direccion_sucursal[$indice]);
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

       
    }
    public function editar_empresa($empresa){

        $data['modo']	 = "modificar";
    
        $datos           = $this->empresa_model->obtener_datosEmpresa($empresa);
        $razon_social    = $datos[0]->EMPRC_RazonSocial;
        
        /**/
        $datos_empresaSucursal = $this->empresa_model->obtener_establecimientoEmpresa($empresa,'1');
        if(count($datos_empresaSucursal)>0){
            $direccion = $datos_empresaSucursal[0]->EESTAC_Direccion;
        }
        else{
            $direccion = "";
        }
        $id=$datos[0]->EMPRP_Codigo;
        $tipocodigo=$datos[0]->TIPCOD_Codigo;
        $sector_comercial=$datos[0]->SECCOMP_Codigo;

        $objeto                = new stdClass();
        $objeto->id            = $datos[0]->EMPRP_Codigo;
        $objeto->empresa       = $datos[0]->EMPRP_Codigo;
        $objeto->nombre        = $datos[0]->EMPRC_RazonSocial;
        $objeto->ruc           = $datos[0]->EMPRC_Ruc;
        $objeto->telefono      = $datos[0]->EMPRC_Telefono;
        $objeto->fax           = $datos[0]->EMPRC_Fax;
        $objeto->movil         = $datos[0]->EMPRC_Movil;
        $objeto->web           = $datos[0]->EMPRC_Web;
        $objeto->direccion     = $direccion;
        $objeto->email         = $datos[0]->EMPRC_Email;
        $objeto->ctactesoles   = $datos[0]->EMPRC_CtaCteSoles;
        $objeto->ctactedolares = $datos[0]->EMPRC_CtaCteDolares;
        $objeto->tipo          = "1";
        $objeto->dni           = "";
        $data['datos']    = $objeto;
        /*Mejorar esto*/
        $datos_empresaSucursal	   = $this->empresa_model->obtener_establecimientoEmpresa($empresa,'1');
        
        
        $listado_empresaSucursal      = $this->empresa_model->listar_sucursalesEmpresa($empresa,'0');
        $listado_empresaContactos     = $this->empresa_model->listar_contactosEmpresa($empresa);
                        
        if(count($datos_empresaSucursal)>0){
                $ubigeo_domicilio         = $datos_empresaSucursal[0]->UBIGP_Codigo;
                $dpto_domicilio           = substr($ubigeo_domicilio,0,2);
                $prov_domicilio           = substr($ubigeo_domicilio,2,2);
                $dist_domicilio           = substr($ubigeo_domicilio,4,2);	

        }
        else{
                $dpto_domicilio           = "15";
                $prov_domicilio           = "01";
                $dist_domicilio           = "";				
        }
        $data['listado_empresaContactos'] = $listado_empresaContactos;
        $data['listado_empresaSucursal']  = $listado_empresaSucursal;
        $data['tipocodigo']               = $this->OPTION_generador($this->tipocodigo_model->listar_tipo_codigo(), 'TIPCOD_Codigo', 'TIPCOD_Inciales', $tipocodigo);
        $data['cbo_sectorComercial']      = $this->OPTION_generador($this->sectorcomercial_model->listar(), 'SECCOMP_Codigo', 'SECCOMC_Descripcion', $sector_comercial);

        $data['cbo_dpto']         = $this->OPTION_generador($this->ubigeo_model->listar_departamentos(), 'UBIGC_CodDpto', 'UBIGC_Descripcion',$dpto_domicilio, array('00','::Seleccione::'));
        $data['cbo_prov']         = $this->OPTION_generador($this->ubigeo_model->listar_provincias($dpto_domicilio), 'UBIGC_CodProv', 'UBIGC_Descripcion',$prov_domicilio, array('00','::Seleccione::'));
        $data['cbo_dist']         = $this->OPTION_generador($this->ubigeo_model->listar_distritos($dpto_domicilio, $prov_domicilio), 'UBIGC_CodDist', 'UBIGC_Descripcion',$dist_domicilio, array('00','::Seleccione::'));
	
        $data['titulo']                   = "EDITAR EMPRESA ::: ".$razon_social;

        $this->load->view("maestros/empresa_nuevo",$data);
}
    public function modificar_empresa(){
        $empresa           = $this->input->post('empresa_persona');	

        $tipocodigo        = $this->input->post('cboTipoCodigo');
        $ruc               = $this->input->post('ruc');	
        $razon_social      = $this->input->post('razon_social');
        $sector_comercial  = $this->input->post('sector_comercial');
        $telefono          = $this->input->post('telefono');	
        $movil             = $this->input->post('movil');	
        $fax               = $this->input->post('fax');	
        $email             = $this->input->post('email');	
        $web               = $this->input->post('web');
        $ubigeo_nacimiento = $this->input->post('cboNacimiento');
        $ubigeo_domicilio  = $this->input->post('cboDepartamento').$this->input->post('cboProvincia').$this->input->post('cboDistrito');;
        $direccion         = $this->input->post('direccion');	
        $ctactesoles       = $this->input->post('ctactesoles');
        $ctactedolares     = $this->input->post('ctactedolares');
       
        $this->empresa_model->modificar_datosEmpresa($empresa,$tipocodigo, $ruc,$razon_social,$telefono,$movil,$fax,$web,$email, $sector_comercial, $ctactesoles, $ctactedolares);
        $this->empresa_model->modificar_sucursalEmpresaPrincipal($empresa,'1',$ubigeo_domicilio,'PRINCIPAL',$direccion);
    }
    public function eliminar_empresa(){
	$empresa = $this->input->post('empresa');	
        $this->empresa_model->eliminar_empresa_total($empresa);
    }
    public function ver_empresa($empresa)
    {
     
        $datos                = $this->empresa_model->obtener_datosEmpresa($empresa);
        $datos_sucurPrincipal = $this->empresa_model->obtener_establecimientosEmpresa_principal($empresa);
        $ubigeo_domicilio     = $datos_sucurPrincipal[0]->UBIGP_Codigo;
        $datos_ubigeoDom_dpto = $this->ubigeo_model->obtener_ubigeo_dpto($ubigeo_domicilio);
        $data['dpto']         = $datos_ubigeoDom_dpto[0]->UBIGC_Descripcion;
        $data['prov']         = $datos_ubigeoDom_dpto[0]->UBIGC_Descripcion;
        $data['dist']         = $datos_ubigeoDom_dpto[0]->UBIGC_Descripcion;
        $data['direccion']    = $datos_sucurPrincipal[0]->EESTAC_Direccion;
        $data['telefono']     = $datos[0]->EMPRC_Telefono;
        $data['movil']        = $datos[0]->EMPRC_Movil;
        $data['fax']          = $datos[0]->EMPRC_Fax;
        $data['email']        = $datos[0]->EMPRC_Email;
        $data['web']          = $datos[0]->EMPRC_Web;
        $data['datos']  = $datos;
        $data['titulo'] = "VER EMPRESA";
        $this->load->view('maestros/empresa_ver',$data);
    }
    public function buscar_empresas($j='0'){

        $filter = new stdClass();
        $filter->EMPRC_Ruc  = $this->input->post('txtNumDoc');;
        $filter->EMPRC_RazonSocial = $this->input->post('txtNombre');
        $filter->EMPRC_Telefono = $this->input->post('txtTelefono');

        $data['numdoc']    = $filter->EMPRC_Ruc;
        $data['nombre']    = $filter->EMPRC_RazonSocial;
        $data['telefono']  = $filter->EMPRC_Telefono;
        $data['titulo_tabla']    = "RESULTADO DE BÚSQUEDA DE EMPRESAS";

        $data['registros']  = count($this->empresa_model->buscar_empresas($filter));
        $data['action'] = base_url()."index.php/maestros/empresa/buscar_empresas";
        $conf['base_url'] = site_url('maestros/empresa/buscar_empresas/');
        $conf['total_rows'] = $data['registros'];
        $conf['per_page']   = 50;
        $conf['num_links']  = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link']  = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $listado_emepresas = $this->empresa_model->buscar_empresas($filter, $conf['per_page'],$j);
        $item            = $j+1;
        $lista           = array();
                    if(count($listado_emepresas)>0){
                            foreach($listado_emepresas as $indice=>$valor){
                                    $codigo         = $valor->EMPRP_Codigo;
                                    $ruc            = $valor->EMPRC_Ruc;
                                    $razon_social   = $valor->EMPRC_RazonSocial;
                                    $telefono       = $valor->EMPRC_Telefono;
                                    $movil          = $valor->EMPRC_Movil;
                                    $editar         = "<a href='#' onclick='editar_empresa(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                                    $ver            = "<a href='#' onclick='ver_empresa(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                                    $eliminar       = "<a href='#' onclick='eliminar_empresa(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                                    $lista[]        = array($item,$ruc,$razon_social,$telefono,$movil,$editar,$ver,$eliminar);
                                    $item++;
                            }
                    }
        $data['lista'] = $lista;
        $this->layout->view("maestros/empresa_index",$data);

    }
    public function insertar_contacto(){
        $empresa      = $this->input->post('empresa');
        $pers_contacto  = $this->input->post('persona_contacto');
        $nom_contacto   = $this->input->post('nombre_contacto');
        $car_contacto   = $this->input->post('cargo_contacto');
        $ar_contacto    = $this->input->post('area_contacto');
        $telef_contacto = $this->input->post('telefono_contacto');
        $e_contacto     = $this->input->post('email_contacto');
        if($nom_contacto!=''){
                $arrTelConctacto = explode("/",$telef_contacto);
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
                if($pers_contacto==''){$pers_contacto = $this->persona_model->insertar_datosPersona('000000','000000','1','193',$nom_contacto,'','','','1');}//Inserto persona
                $directivo = $this->empresa_model->insertar_directivoEmpresa($empresa,$pers_contacto,$car_contacto);
                $this->empresa_model->insertar_areaEmpresa($ar_contacto,$empresa,$directivo,'::OBSERVACION::');
                $this->empresa_model->insertar_contactoEmpresa($empresa,'::OBSERVACION:',$tel_contacto,$mov_contacto,$e_contacto,$pers_contacto);			
        }
        $tablaHTML = $this->TABLA_contactos('p',$empresa);
        echo $tablaHTML;
    }
	
	
    public function insertar_marca(){
        $empresa      = $this->input->post('empresa');
        $codigo  = $this->input->post('codigo');
        if($codigo!='' && $empresa !=''){
                $this->empresa_model->insertar_marcaEmpresa($empresa,$codigo);			
        }
        $tablaHTML = $this->TABLA_marcas('p',$empresa);
        echo $tablaHTML;
    }
	
	public function insertar_tipo(){
        $proveedor      = $this->input->post('proveedor');
        $codigo       = $this->input->post('codigo');
        if($codigo!='' && $proveedor !=''){
                $this->proveedor_model->insertar_tipoProveedor($proveedor,$codigo);			
        }
        $tablaHTML = $this->TABLA_tipos('p',$proveedor);
        echo $tablaHTML;
    }
    public function editar_contacto(){
        $empresa      = $this->input->post('empresa');
        $persona        = $this->input->post('persona');

        $tablaHTML = $this->TABLA_contactos('p',$empresa,$persona);
        echo $tablaHTML;
    }
    public function modificar_contacto(){
        $empresa        = $this->input->post('empresa');
        $pers_contacto  = $this->input->post('persona_contacto');
        $nom_contacto   = $this->input->post('nombre_contacto');
        $car_contacto   = $this->input->post('cargo_contacto');
        $ar_contacto    = $this->input->post('area_contacto');
        $telef_contacto = $this->input->post('telefono_contacto');
        $e_contacto     = $this->input->post('email_contacto');	
        $datos_directivo= $this->directivo_model->buscar_directivo($empresa,$pers_contacto);
        $directivo      = $datos_directivo[0]->DIREP_Codigo;
        if($nom_contacto!=''){
                $arrTelConctacto = explode("/",$telef_contacto);
                switch(count($arrTelConctacto)){
                        case 3:
                                $tel_contacto  = $arrTelConctacto[0];
                                $mov_contacto  = $arrTelConctacto[1];
                                $fax_contacto  = $arrTelConctacto[2];				
                                break;
                        case 2:
                                $tel_contacto  = $arrTelConctacto[0];
                                $mov_contacto  = $arrTelConctacto[1];
                                $fax_contacto  = "";
                                break;
                        case 1:
                                $tel_contacto  = $arrTelConctacto[0];
                                $mov_contacto  = "";	
                                $fax_contacto  = "";
                                break;
                        case 0:
                                $tel_contacto  = "";
                                $mov_contacto  = "";
                                $fax_contacto  = "";					
                                break;							
                }	
                $this->empresa_model->modificar_directivoEmpresa($empresa,$pers_contacto,$car_contacto);
                $this->empresa_model->modificar_areaEmpresa($empresa,$directivo,$ar_contacto,'::OPBSERVACION::');
                $this->empresa_model->modificar_contactoEmpresa($empresa,'::NINGUNA:',$pers_contacto,$tel_contacto,$mov_contacto,$fax_contacto,$e_contacto);
                $this->persona_model->modificar_datosPersona_nombres($pers_contacto,$nom_contacto,'','');
        }
        $tablaHTML = $this->TABLA_contactos('p',$empresa);
        echo $tablaHTML;		

    }
    public function eliminar_contacto(){
        $empresa         = $this->input->post('empresa');
        $persona         = $this->input->post('persona');

        $datos_directivo = $this->directivo_model->buscar_directivo($empresa,$persona);
        $directivo       = $datos_directivo[0]->DIREP_Codigo;
        $this->empresa_model->eliminar_empresarContacto($empresa,$persona,$directivo);
        $tablaHTML = $this->TABLA_contactos('p',$empresa);
        echo $tablaHTML;			
    }
    public function insertar_sucursal(){
        $empresa              = $this->input->post('empresa');
        $nombre_sucursal      = $this->input->post('nombre_sucursal');
        $direccion_sucursal   = $this->input->post('direccion_sucursal');
        $tipo_establecimiento = $this->input->post('tipo_establecimiento');
        $ubigeo_sucursal      = $this->input->post('ubigeo_sucursal');
        if($direccion_sucursal!=''){
            $ubigeo_s = strlen($ubigeo_sucursal)<6?"000000":$ubigeo_sucursal;
            $this->empresa_model->insertar_sucursalEmpresa($tipo_establecimiento,$empresa,$ubigeo_s,$nombre_sucursal,$direccion_sucursal);
        }
        $tablaHTML = $this->TABLA_sucursales($empresa);
        echo $tablaHTML;
    }
    public function editar_sucursal(){
        $empresa      = $this->input->post('empresa');
        $sucursal     = $this->input->post('sucursal');
        $tablaHTML = $this->TABLA_sucursales($empresa,$sucursal);
        echo $tablaHTML;
    }
    public function modificar_sucursal(){
        $empresa              = $this->input->post('empresa');
        $nombre_sucursal      = $this->input->post('nombre_sucursal');
        $direccion_sucursal   = $this->input->post('direccion_sucursal');
        $tipo_establecimiento = $this->input->post('tipo_establecimiento');
        $ubigeo_sucursal      = $this->input->post('ubigeo_sucursal');
        $sucursal_empresa     = $this->input->post('sucursal_empresa');
        if($direccion_sucursal!=''){
            $ubigeo_s = strlen($ubigeo_sucursal)<6?"000000":$ubigeo_sucursal;
            $this->empresa_model->modificar_sucursalEmpresa($sucursal_empresa,$tipo_establecimiento,$ubigeo_s,$nombre_sucursal,$direccion_sucursal);
        }
        $tablaHTML = $this->TABLA_sucursales($empresa);
        echo $tablaHTML;
    }
	//------------------------
    public function eliminar_sucursal(){
        $empresa       = $this->input->post('empresa');
        $sucursal      = $this->input->post('sucursal');
		 $cantalmacen=$this->almacen_model->buscar_x_establec($sucursal);
		 $cantcompania=$this->compania_model->obtener_x_establecimiento($sucursal);
		 
		
		
		  if(count($cantalmacen)>0){
		 $this->almacen_model->eliminar_x_establecimiento($sucursal);
		 } 
		 if(count($cantcompania)>0){
		 $this->compania_model->eliminar_compania_x_esta($sucursal);
		 }
		 $this->empresa_model->eliminar_sucursalEmpresa($sucursal);

		
	
        $tablaHTML = $this->TABLA_sucursales($empresa);
       echo $tablaHTML;  }
	//----------------------------
	
    public function TABLA_contactos($tipo,$empresa,$persona_select='', $pinta=0){
        $datos_contactoProveedor = $this->empresa_model->obtener_contactoEmpresa($empresa);

        $tabla='<table id="tablaContacto" width="98%" class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="0">
                <tr align="center" class="cab1" height="10px;">
                <td>Nro</td>
                <td>Nombre del Contacto</td>
                <td>Area</td>
                <td>Cargo</td>
                <td>Tel&eacute;fonos</td>
                <td>Email</td>
                <td>Borrar</td>
                <td>Editar</td>
                </tr>';

        $item = 1;
        if(count($datos_contactoProveedor)>0){
                foreach($datos_contactoProveedor as $valor){
                        $tabla.='<tr bgcolor="#ffffff">';
                        $persona         = $valor->ECONC_Persona;
                        $datos_persona   = $this->persona_model->obtener_datosPersona($persona);
                        $datos_directivo = $this->directivo_model->buscar_directivo($empresa,$persona);
                        $directivo       = $datos_directivo[0]->DIREP_Codigo;
                        $datos_emparea   = $this->empresa_model->obtener_areaEmpresa($empresa,$directivo);	
                        $area            = $datos_emparea[0]->AREAP_Codigo;
                        $cargo           = $datos_directivo[0]->CARGP_Codigo;
                        $datos_cargo     = $this->cargo_model->obtener_cargo($cargo);
                        $datos_area      = $this->area_model->obtener_area($area); 
                        if($persona==$persona_select){
                                $nombres   = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno;
                                $cbo_area  = $this->seleccionar_area($area);
                                $cbo_cargo = $this->seleccionar_cargo($cargo);
                                $telefono  = $valor->ECONC_Telefono.($valor->ECONC_Movil!=''?'/':'').$valor->ECONC_Movil;
                                $nombre_persona  = "<input type='hidden' name='contactoPersona[".$item."]' id='contactoPersona[".$item."]' class='cajaMedia' value='".$persona."'>";
                                $nombre_persona .= "<input type='text' name='contactoNombre[".$item."]' id='contactoNombre[".$item."]' class='cajaMedia' onfocus='ocultar_homonimos(".$item.");' value='".$nombres."'>";
                                $nombre_area    = "<select name='contactoArea[".$item."]' id='contactoArea[".$item."]' class='comboMedio' >".$cbo_area."</option></select>";
                                $cargo_persona  = "<select name='cargo_encargado[".$item."]' id='cargo_encargado[".$item."]' class='cajaMedia'>".$cbo_cargo."</select>";
                                $telefono       = "<input type='text' name='contactoTelefono[".$item."]' id='contactoTelefono[".$item."]' class='cajaPequena' value='".$telefono."'>";
                                $email          = "<input type='text' name='contactoEmail[".$item."]' id='contactoEmail[".$item."]' class='cajaPequena' value='".$valor->ECONC_Email."'>";
                                $eliminar       = "&nbsp;";
                                if($tipo=="c"){
                                        $editar         = "<a href='#' onclick='modificar_clienteContacto(".$item.");'><img src='".base_url()."images/save.gif' border='0'></a>";
                                }
                                elseif($tipo=="p"){
                                        $editar         = "<a href='#' onclick='modificar_contacto(".$item.");'><img src='".base_url()."images/save.gif' border='0'></a>";					
                                }
                        }
                        else{
                                $cargo_persona   = $datos_cargo[0]->CARGC_Descripcion;
                                $nombre_persona  = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno;
                                $nombre_area     = $datos_area[0]->AREAC_Descripcion;
                                $telefono        = $valor->ECONC_Telefono==''?'&nbsp;':$valor->ECONC_Telefono;
                                $email           = $valor->ECONC_Email==''?'&nbsp;':$valor->ECONC_Email;
                                if($tipo=='c'){
                                        $eliminar        = "<a href='#' onclick='eliminar_clienteContacto(".$persona.");'><img src='".base_url()."images/delete.gif' border='0'></a>";
                                        $editar          = "<div id='idEdit'><a href='#' onclick='editar_clienteContacto(".$persona.");'><img src='".base_url()."images/edit.gif' border='0'></a></div>";			
                                }
                                elseif($tipo=="p"){
                                        $eliminar        = "<a href='#' onclick='eliminar_contacto(".$persona.");'><img src='".base_url()."images/delete.gif' border='0'></a>";
                                        $editar          = "<div id='idEdit'><a href='#' onclick='editar_contacto(".$persona.");'><img src='".base_url()."images/edit.gif' border='0'></a>";					
                                }
                        }
                        $tabla.='<td>'.$item.'</td>';
                        $tabla.='<td>'.$nombre_persona.'</td>';
                        $tabla.='<td>'.$nombre_area.'</td>';
                        $tabla.='<td>'.$cargo_persona.'</td>';
                        $tabla.='<td>'.$telefono.'</td>';
                        $tabla.='<td>'.$email.'</td>';
                        $tabla.='<td>'.$eliminar.'</td>';
                        $tabla.='<td>'.$editar.'</td>';
                        $tabla.='</tr>';
                        $item++;
                }       
        }               
        $tabla.='</table>';
        if(count($datos_contactoProveedor)==0)
            $tabla.='<div id="msgRegistros" style="width:98%;text-align:center;height:20px;border:1px solid #000;">NO EXISTEN REGISTROS</div>';

        if($pinta=='1')
            echo $tabla;
        else
            return $tabla;
    }
	
	
    public function TABLA_tipos($tipo,$proveedor,$pinta=0){
        $datos_marcasProveedor = $this->empresa_model->obtener_tiposEmpresa($proveedor);

        $tabla='<table id="tablaTipo" width="98%" class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="1">
                <tr align="center" bgcolor="#BBBB20" height="10px;">
                <td>Nro</td>
                <td>Nombre del tipo de proveedor</td>
                <td>Borrar</td>
                <td>Editar</td>
                </tr>';

        $item = 1;
        if(count($datos_marcasProveedor)>0){
                foreach($datos_marcasProveedor as $valor){
                        $tabla.='<tr bgcolor="#ffffff">';
                        $nombre_marca  = $valor->FAMI_Descripcion;
                        $codigo   = $valor->FAMI_Codigo;
						$registro = $valor->EMPTIPOP_Codigo;
						$codigo  = "<input type='hidden' name='tipoCodigo[".$item."]' id='tipoCodigo[".$item."]' class='cajaMedia' value='".$codigo."'>";
						// $nombre_marca .= "<input type='text' name='contactoNombre[".$item."]' id='contactoNombre[".$item."]' class='cajaMedia' value='".$nombre_marca."'>";
						$editar  = "&nbsp;";
						$eliminar  = "<a href='#' onclick='eliminar_tipo(".$registro.");'><img src='".base_url()."images/delete.gif' border='0'></a>";
                        $tabla.='<td>'.$item.'</td>';
                        $tabla.='<td>'.$nombre_marca.'</td>';
                        $tabla.='<td>'.$eliminar.'</td>';
                        $tabla.='<td>'.$editar.'</td>';
                        $tabla.='</tr>';
                        $item++;
                }
        }               
        $tabla.='</table>';
        if(count($datos_marcasProveedor)==0)
            $tabla.='<div id="msgRegistros" style="width:98%;text-align:center;height:20px;border:1px solid #000;">NO EXISTEN REGISTROS</div>';

        if($pinta=='1')
            echo $tabla;
        else
            return $tabla;
    }
	
	
    public function TABLA_marcas($tipo,$empresa,$pinta=0){
        $datos_marcasProveedor = $this->empresa_model->obtener_marcasEmpresa($empresa);

        $tabla='<table id="tablaMarca" width="98%" class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="1">
                <tr align="center" bgcolor="#BBBB20" height="10px;">
                <td>Nro</td>
                <td>Nombre de la marca</td>
                <td>Borrar</td>
                <td>Editar</td>
                </tr>';

        $item = 1;
        if(count($datos_marcasProveedor)>0){
                foreach($datos_marcasProveedor as $valor){
                        $tabla.='<tr bgcolor="#ffffff">';
                        $nombre_marca  = $valor->MARCC_Descripcion;
                        $codigo   = $valor->MARCP_Codigo;
						$registro = $valor->EMPMARP_Codigo;
						$codigo  = "<input type='hidden' name='marcaCodigo[".$item."]' id='marcaCodigo[".$item."]' class='cajaMedia' value='".$codigo."'>";
						// $nombre_marca .= "<input type='text' name='contactoNombre[".$item."]' id='contactoNombre[".$item."]' class='cajaMedia' value='".$nombre_marca."'>";
						$editar  = "&nbsp;";
						$eliminar  = "<a href='#' onclick='eliminar_marca(".$registro.");'><img src='".base_url()."images/delete.gif' border='0'></a>";
                        $tabla.='<td>'.$item.'</td>';
                        $tabla.='<td>'.$nombre_marca.'</td>';
                        $tabla.='<td>'.$eliminar.'</td>';
                        $tabla.='<td>'.$editar.'</td>';
                        $tabla.='</tr>';
                        $item++;
                }
        }               
        $tabla.='</table>';
        if(count($datos_marcasProveedor)==0)
            $tabla.='<div id="msgRegistros" style="width:98%;text-align:center;height:20px;border:1px solid #000;">NO EXISTEN REGISTROS</div>';

        if($pinta=='1')
            echo $tabla;
        else
            return $tabla;
    }
	
    public function TABLA_sucursales($empresa,$sucursal_select='', $pinta=0){
        $datos_sucursalesProveedor = $this->empresa_model->listar_sucursalesEmpresa($empresa, '0');
        $tabla='<table id="tablaSucursal" width="98%" class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="0">
                <tr align="center" class="cab1" height="10px;">
                <td width="30">Nro</td>
                <td width="70">Nombre</td>
                <td width="120">Tipo Establecimiento</td>
                <td width="350">Direccion Sucursal (*)</td>
                <td width="200">Departamento / Provincia / Distrito</td>
                <td>Borrar</td>
                <td>Editar</td>
                </tr>';

        $item = 1;
        if(count($datos_sucursalesProveedor)>0){
                foreach($datos_sucursalesProveedor as $valor){
                        $tabla.='<tr bgcolor="#ffffff">';
                        $sucursal               = $valor->EESTABP_Codigo;
                        if($sucursal==$sucursal_select){
                            $ubigeo_domicilio         = $valor->UBIGP_Codigo;
                            $dpto_domicilio           = substr($ubigeo_domicilio,0,2);
                            $prov_domicilio           = substr($ubigeo_domicilio,2,2);
                            $dist_domicilio           = substr($ubigeo_domicilio,4,2);
                            $nombredistrito           = '';
                            if($ubigeo_domicilio!='000000' && $ubigeo_domicilio!=''){
                                $datos_ubigeo         = $this->ubigeo_model->obtener_ubigeo($ubigeo_domicilio);
                                if(count($datos_ubigeo)>0)
                                    $nombredistrito=$datos_ubigeo[0]->UBIGC_Descripcion;
                            }
                            $cbo_tipo = $this->seleccionar_tipoestablecimiento($valor->TESTP_Codigo);
                            $tabla.='<td>'.$item.'</td>';
                            $tabla.="<td align='left'>";
                            $tabla.="<input type='text' name='nombreSucursal[".$item."]' id='nombreSucursal[".$item."]' size='10' maxlength='150' class='cajaGeneral' value='".$valor->EESTABC_Descripcion ."'>";
                            $tabla.="</td>";
                            $tabla.="<td align='left'><select name='tipoEstablecimiento[".$item."]' id='tipoEstablecimiento[".$item."]' class='comboMedio' >".$cbo_tipo."</select></td>";
                            $tabla.="<td align='left'><input type='text' name='direccionSucursal[".$item."]' id='direccionSucursal[".$item."]' size='58' maxlength='200' class='cajaGeneral' value='".$valor->EESTAC_Direccion ."'></td>";
                            $tabla.="<td align='left'>";
                            $tabla.="<input type='hidden' name='empresaSucursal[".$item."]' id='empresaSucursal[".$item."]' class='cajaMedia' value='".$sucursal."'>";
                            $tabla.="<input type='hidden' name='dptoSucursal[".$item."]' id='dptoSucursal[".$item."]' class='cajaGrande' value='".$dpto_domicilio."'>";
                            $tabla.="<input type='hidden' name='provSucursal[".$item."]' id='provSucursal[".$item."]' class='cajaGrande' value='".$prov_domicilio."'>";
                            $tabla.="<input type='hidden' name='distSucursal[".$item."]' id='distSucursal[".$item."]' class='cajaGrande' value='".$dist_domicilio."'>";
                            $tabla.="<input type='text' name='distritoSucursal[".$item."]' id='distritoSucursal[".$item."]' size='24' class='cajaGeneral cajaSoloLectura' readonly='readonly' value='".$nombredistrito."'/> ";
                            $tabla.="<a href='javascript:;' onclick='abrir_formulario_ubigeo_sucursal(".$item.");'><image src='".base_url()."images/ver.png' border='0'></a>";
                            $tabla.="</td>";
                            $tabla.="<td align='center'>&nbsp;</td>";
                            $tabla.="<td align='center'><a href='javascript:;' onclick='modificar_sucursal(".$item.");'><img src='".base_url()."images/save.gif' border='0'></a></td>";                                   
                        }
                        else{                                        
                            $tipo_establecimiento   = $valor->TESTP_Codigo;
                            $ubigeo                 = $valor->UBIGP_Codigo;
                            $nombre_establecimiento = "";
                            if($tipo_establecimiento!=''){
                                $datos_establecimiento  = $this->tipoestablecimiento_model->obtener_tipoEstablecimiento($tipo_establecimiento);
                                if(count($datos_establecimiento)>0)
                                    $nombre_establecimiento = $datos_establecimiento[0]->TESTC_Descripcion;
                            }
                            $nombre_distrito='';
                            if($ubigeo!='000000' && $ubigeo!=''){
                                $datos_ubigeo           = $this->ubigeo_model->obtener_ubigeo($ubigeo);
                                if(count($datos_ubigeo)>0)
                                    $nombre_distrito        = $datos_ubigeo[0]->UBIGC_Descripcion;
                            }
                            $sucursal               = $valor->EESTABP_Codigo;
                            $descripcion = $valor->EESTABC_Descripcion;
                            $direccion   = $valor->EESTAC_Direccion;
                            $eliminar    = "<a href='#' onclick='eliminar_sucursal(".$sucursal.");'><img src='".base_url()."images/delete.gif' border='0'></a>";
                            $editar      = "<a href='#' onclick='editar_sucursal(".$sucursal.");'><img src='".base_url()."images/edit.gif' border='0'>";

                            $tabla.='<td>'.$item.'</td>';
                            $tabla.='<td>'.$descripcion.'</td>';
                            $tabla.='<td>'.$nombre_establecimiento.'</td>';
                            $tabla.='<td>'.$direccion.'</td>';
                            $tabla.='<td>'.$nombre_distrito.'</td>';
                            $tabla.='<td align="center">'.$eliminar.'</td>';
                            $tabla.='<td align="center">'.$editar.'</td>';
                        }
                        $tabla.='</tr>';
                        $item++;
                }
        }

        $tabla.='</table>';
        if(count($datos_sucursalesProveedor)==0)
            $tabla.='<div id="msgRegistros2" style="width:98%;text-align:center;height:20px;border:1px solid #000;">NO EXISTEN REGISTROS</div>';
        if($pinta=='1')
            echo $tabla;
        else
            return $tabla;
    }
    public function JSON_busca_empresa_xruc($tipo, $numero){
        $datos_empresa  = $this->empresa_model->busca_xnumeroDoc($tipo, $numero);  //Esta funcion me devuelde el registro de la empresa
        $resultado          = '[]';
        if(count($datos_empresa)>0){
            $datos_empresaSucursal = $this->empresa_model->obtener_establecimientoEmpresa($datos_empresa[0]->EMPRP_Codigo,'1');
            $dpto_domicilio     = "15";
            $prov_domicilio     = "01";
            $dist_domicilio     = "00";				
            if(count($datos_empresaSucursal)>0){
                $ubigeo_domicilio         = $datos_empresaSucursal[0]->UBIGP_Codigo;
                $dpto_domicilio           = substr($ubigeo_domicilio,0,2);
                $prov_domicilio           = substr($ubigeo_domicilio,2,2);
                $dist_domicilio           = substr($ubigeo_domicilio,4,2);	
            }

            $resultado   = '[{"codigo":"'.$datos_empresa[0]->EMPRP_Codigo.
                            '","cod_cliente":"'.$datos_empresa[0]->CLIP_Codigo.
                            '","razon_social":"'.$datos_empresa[0]->EMPRC_RazonSocial.
                            '","departamento":"'.$dpto_domicilio.
                            '","provincia":"'.$prov_domicilio.
                            '","distrito":"'.$dist_domicilio.
                            '","direccion":"'.$datos_empresaSucursal[0]->EESTAC_Direccion.
                            '","telefono":"'.$datos_empresa[0]->EMPRC_Telefono.
                            '","movil":"'.$datos_empresa[0]->EMPRC_Movil.
                            '","fax":"'.$datos_empresa[0]->EMPRC_Fax.
                            '","correo":"'.$datos_empresa[0]->EMPRC_Email.
                            '","paginaweb":"'.$datos_empresa[0]->EMPRC_Web.
                            '","sector_comercial":"'.$datos_empresa[0]->SECCOMP_Codigo.
                            '","ctactesoles":"'.$datos_empresa[0]->EMPRC_CtaCteSoles.
                            '","ctactedolares":"'.$datos_empresa[0]->EMPRC_CtaCteDolares.'"}]';
        }
        echo $resultado;
    }
    public function JSON_busca_empresa_proveedor_xruc($tipo, $numero){
        $datos_empresa  = $this->empresa_model->proveedor_busca_xnumeroDoc($tipo, $numero);  //Esta funcion me devuelde el registro de la empresa
        $resultado          = '[]';
        if(count($datos_empresa)>0){
            $datos_empresaSucursal = $this->empresa_model->obtener_establecimientoEmpresa($datos_empresa[0]->EMPRP_Codigo,'1');
            $dpto_domicilio     = "15";
            $prov_domicilio     = "01";
            $dist_domicilio     = "00";             
            if(count($datos_empresaSucursal)>0){
                $ubigeo_domicilio         = $datos_empresaSucursal[0]->UBIGP_Codigo;
                $dpto_domicilio           = substr($ubigeo_domicilio,0,2);
                $prov_domicilio           = substr($ubigeo_domicilio,2,2);
                $dist_domicilio           = substr($ubigeo_domicilio,4,2);  
            }

            $resultado   = '[{"codigo":"'.$datos_empresa[0]->EMPRP_Codigo.
                            '","cod_proveedor":"'.$datos_empresa[0]->PROVP_Codigo.
                            '","razon_social":"'.$datos_empresa[0]->EMPRC_RazonSocial.
                            '","departamento":"'.$dpto_domicilio.
                            '","provincia":"'.$prov_domicilio.
                            '","distrito":"'.$dist_domicilio.
                            '","direccion":"'.$datos_empresaSucursal[0]->EESTAC_Direccion.
                            '","telefono":"'.$datos_empresa[0]->EMPRC_Telefono.
                            '","movil":"'.$datos_empresa[0]->EMPRC_Movil.
                            '","fax":"'.$datos_empresa[0]->EMPRC_Fax.
                            '","correo":"'.$datos_empresa[0]->EMPRC_Email.
                            '","paginaweb":"'.$datos_empresa[0]->EMPRC_Web.
                            '","sector_comercial":"'.$datos_empresa[0]->SECCOMP_Codigo.
                            '","ctactesoles":"'.$datos_empresa[0]->EMPRC_CtaCteSoles.
                            '","ctactedolares":"'.$datos_empresa[0]->EMPRC_CtaCteDolares.'"}]';
        }
        echo $resultado;
    }
    public function seleccionar_area($indSel=''){
        $array_area = $this->area_model->listar_areas();
        $arreglo = array();
        foreach($array_area as $indice=>$valor){
                $indice1   = $valor->AREAP_Codigo;
                $valor1    = $valor->AREAC_Descripcion;
                $arreglo[$indice1] = $valor1;
        }
        $resultado = $this->html->optionHTML($arreglo,$indSel,array('0','::Seleccione::'));
        return $resultado;	
    }
    public function seleccionar_cargo($indSel=''){
        $array_area = $this->cargo_model->listar_cargos();
        $arreglo = array();
        foreach($array_area as $indice=>$valor){
                $indice1   = $valor->CARGP_Codigo;
                $valor1    = $valor->CARGC_Descripcion;
                $arreglo[$indice1] = $valor1;
        }
        $resultado = $this->html->optionHTML($arreglo,$indSel,array('0','::Seleccione::'));
        return $resultado;		
    }
    public function seleccionar_tipoestablecimiento($indDefault=''){
        $array_dist = $this->tipoestablecimiento_model->listar_tiposEstablecimiento();
        $arreglo = array();
        if(count($array_dist)>0){
                foreach($array_dist as $indice=>$valor){
                        $indice1   = $valor->TESTP_Codigo;
                        $valor1    = $valor->TESTC_Descripcion;
                        $arreglo[$indice1] = $valor1;
                }
        }
        $resultado = $this->html->optionHTML($arreglo,$indDefault,array('0','::Seleccione::'));
        return $resultado;
    }

    public function JSON_listar_contactos($empresa){
        $resultado = array();
        $listado_contactosEmpresa = $this->empresa_model->listar_contactosEmpresa($empresa);
        if(count($listado_contactosEmpresa)>0){
                foreach($listado_contactosEmpresa as $indice => $valor){
                    $persona         = $valor->ECONC_Persona;
                    $datos_persona   = $this->persona_model->obtener_datosPersona($persona);
                    $nombres_persona = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno." ".$datos_persona[0]->PERSC_ApellidoMaterno." ";
                    $datos_directivo = $this->directivo_model->buscar_directivo($empresa,$persona);
                    $directivo       = $datos_directivo[0]->DIREP_Codigo;
                    $cargo           = $datos_directivo[0]->CARGP_Codigo;
                    $datos_areaEmpresa = $this->empresa_model->obtener_areaEmpresa($empresa,$directivo);
                    $datos_cargo     = $this->cargo_model->obtener_cargo($cargo);
                    $nombre_cargo    = $datos_cargo[0]->CARGC_Descripcion;
                    $area            = $datos_areaEmpresa[0]->AREAP_Codigo;
                    $nombre_area     = '';
                    if($area!='0' && $area!=''){
                        $datos_area      = $this->area_model->obtener_area($area);
                        if(count($datos_area)>0)
                            $nombre_area     = $datos_area[0]->AREAC_Descripcion;
                    }
                    
                    $objeto = new stdClass();
                    $objeto->area            = $area;
                    $objeto->nombre_area     = $nombre_area;
                    $objeto->empresa         = $valor->EMPRP_Codigo;
                    $objeto->personacontacto = $valor->PERSP_Contacto;
                    $objeto->descripcion     = $valor->ECONC_Descripcion;
                    $objeto->telefono        = $valor->ECONC_Telefono==''?'&nbsp;':$valor->ECONC_Telefono;
                    $objeto->movil           = $valor->ECONC_Movil;
                    $objeto->fax             = $valor->ECONC_Fax;
                    $objeto->email           = $valor->ECONC_Email==''?'&nbsp;':$valor->ECONC_Email;
                    $objeto->persona         = $valor->ECONC_Persona;
                    $objeto->emprcontacto    = $valor->ECONP_Contacto;
                    $objeto->nombre_persona  = $nombres_persona;
                    $objeto->tipo_contacto   = $valor->ECONC_TipoContacto;
                    $objeto->nombre_cargo    = $nombre_cargo;
                    $resultado[]             = $objeto;
                }
        }
        echo json_encode($resultado);
    }
    public function JSON_listar_sucursales($empresa){
        $listado_sucursalesEmpresa = $this->empresa_model->listar_sucursalesEmpresa($empresa);
        echo json_encode($listado_sucursalesEmpresa);
    }
    public function JSON_listar_personal($empresa, $cargo){
        $lista_personal=$this->directivo_model->listar_directivo($empresa, $cargo);
        echo json_encode($lista_personal);
    }
    public function JSON_listar_sucursalesEmpresa(){
        $datos_compania = $this->compania_model->obtener_compania($this->session->userdata('compania'));
        if(count($datos_compania)>0){
            $lista_mis_sucursales=$this->empresa_model->listar_sucursalesEmpresa($datos_compania[0]->EMPRP_Codigo);
            foreach($lista_mis_sucursales as $key => $reg){
                $reg->distrito     = "";
                $reg->provincia    = "";
                $reg->departamento = "";
                if($reg->UBIGP_Codigo!='' && $reg->UBIGP_Codigo!='000000'){
                    $datos_ubigeo_dist = $this->ubigeo_model->obtener_ubigeo_dist($reg->UBIGP_Codigo);
                    $datos_ubigeo_prov = $this->ubigeo_model->obtener_ubigeo_prov($reg->UBIGP_Codigo);
                    $datos_ubigeo_dep  = $this->ubigeo_model->obtener_ubigeo_dpto($reg->UBIGP_Codigo);
                    if(count($datos_ubigeo_dist)>0)
                        $reg->distrito     = $datos_ubigeo_dist[0]->UBIGC_Descripcion;
                    if(count($datos_ubigeo_prov)>0)
                        $reg->provincia    = $datos_ubigeo_prov[0]->UBIGC_Descripcion;
                    if(count($datos_ubigeo_dep)>0)
                        $reg->departamento = $datos_ubigeo_dep[0]->UBIGC_Descripcion;
                }
                $lista_mis_sucursales[$key]=$reg;
            }
        }
        $result[]=array('Tipo'=>'1', 'Titulo'=>'MIS ESTABLECIMIENTOS');
        foreach($lista_mis_sucursales as $reg)
            $result[]=array('Tipo'=>'2','EESTAC_Direccion'=>$reg->EESTAC_Direccion, 'UBIGP_Codigo'=>$reg->UBIGP_Codigo, 'departamento'=>$reg->departamento, 'provincia'=>$reg->provincia, 'distrito'=>$reg->distrito);
        
        
        echo json_encode($result);
    }
}       
?>