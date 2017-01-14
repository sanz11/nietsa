<?php
class Tipocambio extends Controller{
    public function __construct()
    {
        parent::Controller();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->model('maestros/tipocambio_model');
        $this->load->model('maestros/moneda_model');
        $this->somevar['compania'] = $this->session->userdata('compania');
    }
    public function index(){
            $this->load->library('layout','layout'); 
            $this->layout->view('seguridad/inicio');	
    }
    public function listar($j='0')
    {
        $this->load->library('layout', 'layout');
        $data['registros']  = count($this->tipocambio_model->listar());
        $conf['base_url']   = site_url('maestros/tipocambio/listar/');
        $conf['total_rows'] = $data['registros'];
        $conf['per_page']   = 15;
        $conf['num_links']  = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link']  = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $offset             = (int)$this->uri->segment(4);
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $listado            = $this->tipocambio_model->listar('', $conf['per_page'],$offset);
        $item               = $j+1;
        $lista              = array();
        $listado_moneda =$this->moneda_model->listar();
        if(count($listado)>0){
            
            foreach($listado as $indice=>$valor)
            {   $codigo = $valor->TIPCAMP_Codigo;
                $fecha = $valor->TIPCAMC_Fecha;
                
                $valores_tipocam=array();
                foreach($listado_moneda as $reg){
                    if($reg->MONED_Codigo!=1){
                        $filter=new stdClass();
                        $filter->TIPCAMC_MonedaDestino=$reg->MONED_Codigo;
                        $filter->TIPCAMC_Fecha=$fecha;
                        $temp=$this->tipocambio_model->buscar($filter);
                        if(count($temp)>0)
                            $valores_tipocam[]=$temp[0]->TIPCAMC_FactorConversion;                        
                        else
                            $valores_tipocam[]='';
                    }
                }
                $ver            = "<a href='#' onclick='ver_tipocambio(".str_replace('-', '',$fecha).")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Ver'></a>";
                $modificar      = "<a href='#' onclick='modificar_tipocambio(".str_replace('-', '',$fecha).")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[]        = array($item++,$fecha,$valores_tipocam,$ver,$modificar);
            }
        }
        $data['listado_moneda']   = $listado_moneda;
        $data['lista']           = $lista;
        $data['titulo_busqueda'] = "BUSCAR TIPO DE CAMBIO";
        $data['fecha']  	 = form_input(array("name"=>"fecha","id"=>"fecha","class"=>"cajaPequena","readonly"=>"readonly","maxlength"=>"10","value"=>""));
        $data['form_open']       = form_open(base_url().'index.php/maestros/tipocambio/buscar',array("name"=>"form_busquedaTipoCambio","id"=>"form_busquedaTipoCambio"));
        $data['form_close']      = form_close();
        $data['titulo_tabla']    = "Relaci&oacute;n DE TIPO DE CAMBIOS";
        $data['oculto']          = form_hidden(array('base_url'=>base_url()));	
        $this->layout->view('maestros/tipocambio_index',$data);
			
    }
    public function nuevo($ventana=false)
    {
        $this->load->library('layout', 'layout');
        $data['lista_monedas']=$this->moneda_model->listar();

        $data['titulo']     = "REGISTRAR TIPO DE CAMBIO DEL DIA : ".date('d/m/Y');
        $data['form_open']  = form_open(base_url().'index.php/maestros/tipocambio/grabar',array("name"=>"frmTipoCambio","id"=>"frmTipoCambio"));
        $data['form_close'] = form_close();
        $data['oculto']     = form_hidden(array('base_url'=>base_url()));
        if($ventana==false)
            $this->layout->view('maestros/tipocambio_nuevo',$data);
        else
            $this->load->view('maestros/tipocambio_ventana_configura',$data);
        
    }

	public function editar($fecha){
		$this->load->library('layout', 'layout');
        
        if(strlen($fecha)!=8)
            show_error('La fecha enviada es incorrecta.');

        $fecha=substr($fecha,0,4).'-'.substr($fecha,4,2).'-'.substr($fecha,6,2);
    
        $lista_monedas=$this->moneda_model->listar();
        $data['lista_monedas']=$lista_monedas;
        $valores=array();

        foreach($lista_monedas as $reg){
            if($reg->MONED_Codigo!=1){
                $filter=new stdClass();
                $filter->TIPCAMC_Fecha=$fecha;
                $filter->TIPCAMC_MonedaDestino =$reg->MONED_Codigo;
                $temp=$this->tipocambio_model->buscar($filter);
                if(count($temp)>0)
                    $valores[$reg->MONED_Codigo]=$temp[0]->TIPCAMC_FactorConversion;
                else
                    $valores[$reg->MONED_Codigo]='';
            }
        }
		
        $data['valores']=$valores;
        $data['fecha']=$fecha;
        $data['titulo']= "MODIFICAR TIPO DE CAMBIO DEL DIA : ".substr($fecha,8,2).'/'.substr($fecha,5,2).'/'.substr($fecha,0,4);
        $data['oculto']=form_hidden(array('base_url'=>base_url()));	
        $this->layout->view("maestros/tipocambio_nuevo", $data);
		
    }
	
	










/*
    public function grabar1(){
       
    $diasfaltantes = $this->input->post("dfalt");
	
	if($diasfaltantes==0){
		$tipocambios  = $this->input->post("tipocambio");
        $monedas = $this->input->post("moneda");
        $moneda_origen = $this->input->post("moneda_origen");
        $fecha = $this->input->post("fecha");
        $filter = new stdClass();
        $filter->TIPCAMC_Fecha = $fecha;
        $this->tipocambio_model->eliminar_varios($filter);
        foreach($tipocambios as $item=>$tipocambio){
            if($tipocambio!=''){
                $filter = new stdClass();
                $filter->TIPCAMC_MonedaOrigen  = $moneda_origen;
                $filter->TIPCAMC_MonedaDestino = $monedas[$item];
                $filter->TIPCAMC_Fecha = $fecha;
                $filter->TIPCAMC_FactorConversion = $tipocambio;
                $filter->COMPP_Codigo = $this->somevar['compania'];

                $this->tipocambio_model->insertar($filter);
            }
        }
	}else{
	for($i=1;$i<$diasfaltantes;$i++){
						$fecha = date('Y-m-j');
						$nuevafecha = strtotime ( '-'.$i.'day' , strtotime ( $fecha ) ) ;
						$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
				$filter = new stdClass();
                $filter->TIPCAMC_MonedaOrigen  = 1 ;
                $filter->TIPCAMC_MonedaDestino = 2;
                $filter->TIPCAMC_Fecha = $nuevafecha;
                $filter->TIPCAMC_FactorConversion = '';
                $filter->COMPP_Codigo = $this->somevar['compania'];
                $this->tipocambio_model->insertar($filter);	
	
	}
		$tipocambios  = $this->input->post("tipocambio");
        $monedas = $this->input->post("moneda");
        $moneda_origen = $this->input->post("moneda_origen");
        $fecha = $this->input->post("fecha");
        $filter = new stdClass();
        $filter->TIPCAMC_Fecha = $fecha;
        $this->tipocambio_model->eliminar_varios($filter);
        foreach($tipocambios as $item=>$tipocambio){
            if($tipocambio!=''){
                $filter = new stdClass();
                $filter->TIPCAMC_MonedaOrigen  = $moneda_origen;
                $filter->TIPCAMC_MonedaDestino = $monedas[$item];
                $filter->TIPCAMC_Fecha = $fecha;
                $filter->TIPCAMC_FactorConversion = $tipocambio;
                $filter->COMPP_Codigo = $this->somevar['compania'];

                $this->tipocambio_model->insertar($filter);
            }
        }
	
	}
		
		
		
		
    }*/


 public function grabar(){
       
    $diasfaltantes = $this->input->post("dfalt");
	
	if($diasfaltantes==0){
		$tipocambios  = $this->input->post("tipocambio");
        $monedas = $this->input->post("moneda");
        $moneda_origen = $this->input->post("moneda_origen");
        $fecha = $this->input->post("fecha");
        $filter = new stdClass();
        $filter->TIPCAMC_Fecha = $fecha;
        $this->tipocambio_model->eliminar_varios($filter);
        foreach($tipocambios as $item=>$tipocambio){
            if($tipocambio!=''){
                $filter = new stdClass();
                $filter->TIPCAMC_MonedaOrigen  = $moneda_origen;
                $filter->TIPCAMC_MonedaDestino = $monedas[$item];
                $filter->TIPCAMC_Fecha = $fecha;
                $filter->TIPCAMC_FactorConversion = $tipocambio;
                $filter->COMPP_Codigo = $this->somevar['compania'];

                $this->tipocambio_model->insertar($filter);
            }
        }
	}else{
	for($i=1;$i<$diasfaltantes;$i++){
						$fecha = date('Y-m-j');
						$nuevafecha = strtotime ( '-'.$i.'day' , strtotime ( $fecha ) ) ;
						$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
				$filter = new stdClass();
                $filter->TIPCAMC_MonedaOrigen  = 1 ;
                $filter->TIPCAMC_MonedaDestino = 2;
                $filter->TIPCAMC_Fecha = $nuevafecha;
                $filter->TIPCAMC_FactorConversion = '';
                $filter->COMPP_Codigo = $this->somevar['compania'];
                $this->tipocambio_model->insertar($filter);	
	
	}
		$tipocambios  = $this->input->post("tipocambio");
        $monedas = $this->input->post("moneda");
        $moneda_origen = $this->input->post("moneda_origen");
        $fecha = $this->input->post("fecha");
        $filter = new stdClass();
        $filter->TIPCAMC_Fecha = $fecha;
        $this->tipocambio_model->eliminar_varios($filter);
        foreach($tipocambios as $item=>$tipocambio){
            if($tipocambio!=''){
                $filter = new stdClass();
                $filter->TIPCAMC_MonedaOrigen  = $moneda_origen;
                $filter->TIPCAMC_MonedaDestino = $monedas[$item];
                $filter->TIPCAMC_Fecha = $fecha;
                $filter->TIPCAMC_FactorConversion = $tipocambio;
                $filter->COMPP_Codigo = 6;

                $this->tipocambio_model->insertar($filter);
            }
        }
          foreach($tipocambios as $item=>$tipocambio){
            if($tipocambio!=''){
                $filter = new stdClass();
                $filter->TIPCAMC_MonedaOrigen  = $moneda_origen;
                $filter->TIPCAMC_MonedaDestino = $monedas[$item];
                $filter->TIPCAMC_Fecha = $fecha;
                $filter->TIPCAMC_FactorConversion = $tipocambio;
                $filter->COMPP_Codigo = 5;

                $this->tipocambio_model->insertar($filter);
            }
        }
	
         foreach($tipocambios as $item=>$tipocambio){
            if($tipocambio!=''){
                $filter = new stdClass();
                $filter->TIPCAMC_MonedaOrigen  = $moneda_origen;
                $filter->TIPCAMC_MonedaDestino = $monedas[$item];
                $filter->TIPCAMC_Fecha = $fecha;
                $filter->TIPCAMC_FactorConversion = $tipocambio;
                $filter->COMPP_Codigo = 2;

                $this->tipocambio_model->insertar($filter);
            }
        }
         foreach($tipocambios as $item=>$tipocambio){
            if($tipocambio!=''){
                $filter = new stdClass();
                $filter->TIPCAMC_MonedaOrigen  = $moneda_origen;
                $filter->TIPCAMC_MonedaDestino = $monedas[$item];
                $filter->TIPCAMC_Fecha = $fecha;
                $filter->TIPCAMC_FactorConversion = $tipocambio;
                $filter->COMPP_Codigo = 1;

                $this->tipocambio_model->insertar($filter);
            }
        }
        
	}
		
		
		
		
    }


    public function eliminar()
    {
        $id = $this->input->post('almacen');
        $this->almacen_model->eliminar($id);
    }
    public function ver($fecha){   
	$this->load->library('layout', 'layout');
        
        if(strlen($fecha)!=8)
            show_error('La fecha enviada es incorrecta.');

        $fecha=substr($fecha,0,4).'-'.substr($fecha,4,2).'-'.substr($fecha,6,2);
    
        $lista_monedas=$this->moneda_model->listar();
        $data['lista_monedas']=$lista_monedas;
        $valores=array();

        foreach($lista_monedas as $reg){
            if($reg->MONED_Codigo!=1){
                $filter=new stdClass();
                $filter->TIPCAMC_Fecha=$fecha;
                $filter->TIPCAMC_MonedaDestino =$reg->MONED_Codigo;
                $temp=$this->tipocambio_model->buscar($filter);
                if(count($temp)>0)
                    $valores[$reg->MONED_Codigo]=$temp[0]->TIPCAMC_FactorConversion;
                else
                    $valores[$reg->MONED_Codigo]='';
            }
        }
        $data['valores']=$valores;
        $data['titulo']= "VER TIPO DE CAMBIO DEL DIA : ".substr($fecha,8,2).'/'.substr($fecha,5,2).'/'.substr($fecha,0,4);
        $data['oculto']=form_hidden(array('base_url'=>base_url()));	
        $this->layout->view("maestros/tipocambio_ver", $data);
    }
    public function buscar($j=0)
    {
        $this->load->library('layout','layout');
        $fecha                 = $this->input->post('fecha');
        $data['registros']      = count($this->tipocambio_model->listar($fecha));
        $conf['base_url']       = site_url('almacen/almacen/buscar/');
        $conf['per_page']       = 15;
        $conf['num_links']      = 3;
        $conf['first_link']     = "&lt;&lt;";
        $conf['last_link']      = "&gt;&gt;";
        $conf['total_rows']     = $data['registros'];
        $offset                 = (int)$this->uri->segment(4);
        $listado                = $this->tipocambio_model->listar($fecha,$conf['per_page'],$offset);
        $item                   = $j+1;
        $lista                  = array();
        $listado_moneda =$this->moneda_model->listar();
        if(count($listado)>0){
            
            foreach($listado as $indice=>$valor)
            {   $codigo = $valor->TIPCAMP_Codigo;
                $fecha = $valor->TIPCAMC_Fecha;
                
                $valores_tipocam=array();
                foreach($listado_moneda as $reg){
                    if($reg->MONED_Codigo!=1){
                        $filter=new stdClass();
                        $filter->TIPCAMC_MonedaDestino=$reg->MONED_Codigo;
                        $filter->TIPCAMC_Fecha=$fecha;
                        $temp=$this->tipocambio_model->buscar($filter);
                        if(count($temp)>0)
                            $valores_tipocam[]=$temp[0]->TIPCAMC_FactorConversion;                        
                        else
                            $valores_tipocam[]='';
                    }
                }
                $ver            = "<a href='#' onclick='ver_tipocambio(".str_replace('-', '',$fecha).")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                $modificar      = "<a href='#' onclick='modificar_tipocambio(".str_replace('-', '',$fecha).")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[]        = array($item++,$fecha,$valores_tipocam,$ver,$modificar);
            }
        }
        $data['titulo_tabla']    = "RESULTADO DE BUSQUEDA de TIPO DE CAMBIO DEL DIA";
        $data['titulo_busqueda'] = "BUSCAR TIPO DE CAMBIO";
        $data['fecha']  	 = form_input(array("name"=>"fecha","id"=>"fecha","class"=>"cajaPequena","readonly"=>"readonly","maxlength"=>"10","value"=>$fecha));
        $data['form_open']       = form_open(base_url().'index.php/maestros/tipocambio/buscar',array("name"=>"form_busquedaTipoCambio","id"=>"form_busquedaTipoCambio"));
        $data['form_close']      = form_close();
        $data['listado_moneda']   = $listado_moneda;
        $data['lista']           = $lista;
        $data['oculto']          = form_hidden(array('base_url'=>base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('maestros/tipocambio_index',$data);
    }
	
	function buscar_json(){
	 $fecha=explode('/',$this->input->post('fecha'));
	 $fecha=$fecha[2].'-'.$fecha[1].'-'.$fecha[0];
	 
	 $tdcfecha=$this->tipocambio_model->listar($fecha);
	if(count( $tdcfecha)>0){
	$codigo = $tdcfecha[0]->TIPCAMP_Codigo;
     $tdc = $tdcfecha[0]->TIPCAMC_FactorConversion;
	 echo $tdc;
	 }else{
				$filter = new stdClass();
                $filter->TIPCAMC_MonedaOrigen  = 1 ;
                $filter->TIPCAMC_MonedaDestino = 2;
                $filter->TIPCAMC_Fecha = $fecha;
                $filter->TIPCAMC_FactorConversion = '';
                $filter->COMPP_Codigo = $this->somevar['compania'];
                $this->tipocambio_model->insertar($filter);	
	 
	 echo '0';
	 }
	
	
	
	}
	
	
}
?>