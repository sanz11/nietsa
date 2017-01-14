<?php
class Comercial extends Controller{
    public function __construct()
    {
        parent::Controller();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->model('maestros/comercial_model');
    }
    public function index(){
        $this->load->library('layout','layout');
        $this->layout->view('seguridad/inicio');
    }
    public function comerciales($j='0'){
        $this->load->library('layout','layout');
        $data['txtComercial']   = "";
        $data['registros']  = count($this->comercial_model->listar_comerciales());
        $conf['base_url']   = site_url('maestros/comercial/comerciales/');
        $conf['total_rows'] = $data['registros'];
        $conf['per_page']   = 10;
        $conf['num_links']  = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link']  = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $offset             = (int)$this->uri->segment(4);
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $listado_comerciales     = $this->comercial_model->listar_comerciales($conf['per_page'],$offset);
        $item               = $j+1;
        $lista                = array();
        if(count($listado_comerciales)>0){
             foreach($listado_comerciales as $indice=>$valor){
                 $codigo         = $valor->SECCOMP_Codigo;
                 $editar         = "<a href='#' onclick='editar_comercial(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                 $ver            = "<a href='#' onclick='ver_comercial(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                 $eliminar       = "<a href='#' onclick='eliminar_comercial(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                 $lista[]        = array($item++,$valor->SECCOMC_Descripcion,$editar,$ver,$eliminar);
             }
        }
        $data['action']          = base_url()."index.php/maestros/Comercial/buscar_comerciales";
        $data['titulo_tabla']    = "RELACI&Oacute;N de COMERCIALES";
        $data['titulo_busqueda'] = "BUSCAR COMERCIAL";
        $data['lista']      = $lista;
        $data['oculto']     = form_hidden(array('base_url'=>base_url()));
        $this->layout->view('maestros/comercial_index',$data);
    }
    public function nuevo_comercial(){
            $this->load->library('layout','layout');
            $modo      = "";
            $accion    = "";
            $modo      = "insertar";
            $codigo    = "";
            $data['form_open']  = form_open(base_url().'index.php/maestros/comercial/insertar_comercial',array("name"=>"frmComercial","id"=>"frmComercial"));
            $data['form_close'] = form_close();
            $lblComercial  = form_label('NOMBRE DEL COMERCIAL','nombre');
            $txtComercial  = form_input(array('name'=>'nombre','id'=>'nombre','value'=>'','maxlength'=>'30','class'=>'cajaMedia'));
            $oculto    = form_hidden(array('accion'=>$accion,'codigo'=>$codigo,'modo'=>$modo,'base_url'=>base_url()));
            $data['titulo']     = "REGISTRAR COMERCIAL";
            $data['formulario'] = "frmProveedor";
            $data['campos']     = array($lblComercial);
            $data['valores']    = array($txtComercial);
            $data['oculto']     = $oculto;
            $data['onload']     = "onload=\"$('#nombre').focus();\"";
            $this->layout->view('maestros/comercial_nuevo',$data);
    }
    public function insertar_comercial(){
            $this->form_validation->set_rules('nombre','Nombre de comercial','required');
            if($this->form_validation->run() == FALSE){
                    $this->nuevo_comercial();
            }
            else{
                    $nombre = $this->input->post('nombre');
                    $this->comercial_model->insertar_comercial($nombre);
                    $this->comerciales();
            }
    }
    public function editar_comercial($codigo){
        $this->load->library('layout','layout');
        $accion       = "";
        $modo         = "modificar";
        $datos_comercial  = $this->comercial_model->obtener_comercial($codigo);
        $nombre_comercial = $datos_comercial[0]->SECCOMC_Descripcion;
        $data['form_open']  = form_open(base_url().'index.php/maestros/comercial/modificar_comercial',array("name"=>"frmComercial","id"=>"frmComercial"));
        $data['form_close'] = form_close();
        $lblComercial    = form_label('NOMBRE DEL COMERCIAL','nombre');
        $txtComercial    = form_input(array('name'=>'nombre','id'=>'nombre','value'=>$nombre_comercial,'maxlength'=>'30','class'=>'cajaMedia'));
        $oculto       = form_hidden(array('accion'=>$accion,'codigo'=>$codigo,'modo'=>$modo,'base_url'=>base_url()));
        $data['titulo']     = "EDITAR COMERCIALES";
        $data['formulario'] = "frmProveedor";
        $data['campos']     = array($lblComercial);
        $data['valores']    = array($txtComercial);
        $data['oculto']     = $oculto;
        $data['onload']     = "onload=\"$('#nombre').select();$('#nombre').focus();\"";
        $this->layout->view('maestros/comercial_nuevo',$data);
    }
    public function modificar_comercial(){
        $this->form_validation->set_rules('nombre','Nombre de comercial','required');
        if($this->form_validation->run() == FALSE){
                $this->nuevo_comercial();
        }
        else{
                $comercial  = $this->input->post('codigo');
                $nombre = $this->input->post('nombre');
                $this->cargo_model->modificar_comercial($cargo,$nombre);
                $this->comerciales();
        }
    }
    public function eliminar_comercial(){
        $comercial = $this->input->post('comercial');
        $this->comercial_model->eliminar_comercial($comercial);
    }
    public function ver_comercial($codigo)
    {
        $this->load->library('layout','layout');
        $data['datos_comercial'] = $this->comercial_model->obtener_comercial($codigo);
        $data['titulo']      = "VER COMERCIAL";
        $data['oculto']      = form_hidden(array('base_url'=>base_url()));
        $this->layout->view('maestros/comercial_ver',$data);
    }
    public function buscar_comerciales($j='0')
    {
        $this->load->library('layout','layout');
        $nombre_comercial       = $this->input->post('txtComercial');
        $filter=new stdClass();
        $filter->nombre_comercial = $nombre_comercial;
        $data['txtComercial']   = $nombre_comercial;
        $data['registros']  = count($this->comercial_model->buscar_comerciales($filter));
        $conf['base_url']   = site_url('maestros/comercial/buscar_comerciales/');
        $conf['per_page']   = 10;
        $conf['num_links']  = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link']  = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $conf['total_rows'] = $data['registros'];
        $offset             = (int)$this->uri->segment(4);
        //echo $conf['per_page'].' - '.$offset;
        $listado_comerciales     = $this->comercial_model->buscar_comerciales($filter,$conf['per_page'],$offset);
        //echo '<br/>'.count($listado_cargos);
        $item               = $j+1;
        $lista              = array();
        if(count($listado_comerciales)>0){
            foreach($listado_comerciales as $indice=>$valor){
                $codigo         = $valor->SECCOMP_Codigo;
                $editar         = "<a href='#' onclick='editar_comercial(".$codigo.")' target='_parent'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver            = "<a href='#' onclick='ver_comercial(".$codigo.")' target='_parent'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                $eliminar       = "<a href='#' onclick='eliminar_comercial(".$codigo.")' target='_parent'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[]        = array($item++,$valor->SECCOMC_Descripcion,$editar,$ver,$eliminar);
            }
        }
        $data['action']          = base_url()."index.php/maestros/Comercial/buscar_comerciales";
        $data['titulo_tabla']    = "RESULTADO DE BUSQUEDA de COMERCIALES";
        $data['titulo_busqueda'] = "BUSCAR COMERCIAL";
        $data['lista']      = $lista;
        $data['oculto']     = form_hidden(array('base_url'=>base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('maestros/comercial_index',$data);
    }
    public function tabla_comercial($lista){
            $tab_comercial  = '<table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">';
            $tab_comercial .= '<tr class="cabeceraTabla">';
            $tab_comercial .= '<td width="5%">ITEM</td>';
            $tab_comercial .= '<td width="60%">NOMBRES DE COMERCIALES</td>';
            $tab_comercial .= '<td width="5%">&nbsp;</td>';
            $tab_comercial .= '<td width="5%">&nbsp;</td>';
            $tab_comercial.= '<td width="6%">&nbsp;</td>';
            $tab_comercial .= '</tr>';
            if(count($lista)>0){
                    foreach($lista as $indice=>$valor){
                            $class = $indice%2==0?'itemParTabla':'itemImparTabla';
                            $tab_comercial .= '<tr class="'.$class.'">';
                            $tab_comercial .= '<td><div align="center">'.$valor[0].'</div></td>';
                            $tab_comercial .= '<td><div align="left">'.$valor[1].'</div></td>';
                            $tab_comercial.= '<td><div align="center">'.$valor[2].'</div></td>';
                            $tab_comercial .= '<td><div align="center">'.$valor[3].'</div></td>';
                            $tab_comercial .= '<td><div align="center">'.$valor[4].'</div></td>';
                            $tab_comercial.= '</tr>';
                    }
            }
            else{
                    $tab_comercial.= '<table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">';
                    $tab_comercial .= '<tbody>';
                    $tab_comercial .= '<tr>';
                    $tab_comercial .= '<td width="100%" class="mensaje">No hay ning&uacute;n registro que cumpla con los criterios de b&uacute;squeda</td>';
                    $tab_comercial .= '</tr>';
                    $tab_comercial .= '</tbody>';
                    $tab_comercial .= '</table>';
            }
            $tab_comercial.= '</table>';
            return $tab_comercial;
    }
  public function listar_comerciales(){
            $listado_comerciales = $this->comercial_model->listar_comerciales();
            $resultado = json_encode($listado_comerciales);
            $data['listado_comerciales'] =$resultado;
            $this->load->view('maestros/listado_comerciales',$data);
    }
    public function registro_comerciales_pdf() {
      
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
        $this->cezpdf->ezText('<b>LISTADO COMERCIAL</b>', 14, array("leading" => 0, 'left' => 185));
        $this->cezpdf->ezText('', '', array("leading" => 10));


        /* Datos del cliente */


//        /* Listado de detalles */

        $db_data = array();


        $compania=  $this->session->userdata('compania');
        $objecargos=  $this->Global_model->get_where('cji_sectorcomercial',array('SECCOMC_FlagEstado'=>1,'COMPP_Codigo'=>$compania),0);
        //$lista = array();
        
           if (count($objecargos) > 0) {
            foreach ($objecargos as $indice => $valor) {
                $codigo = $valor->SECCMP_Codigo;
                $descripcion = $valor->SECCOMC_Descripcion;
                
                       
                $db_data[] = array(
                    'cols1' => $indice + 1,
                    'cols2' => $descripcion
                );
            }
        } 
        


        $col_names = array(
            'cols1' => '<b>ITEM</b>',
            'cols2' => '<b>DESCRIPCION</b>'
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
                'cols2' => array('width' => 245, 'justification' => 'left'),
                'cols3' => array('width' => 245, 'justification' => 'left')
            )
        ));


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => $codificacion . '.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        ob_end_clean();

        $this->cezpdf->ezStream($cabecera);
    }
}
?>