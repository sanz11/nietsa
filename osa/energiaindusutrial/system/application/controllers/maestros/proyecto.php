<?php
class Proyecto extends Controller{
    public function __construct(){
            parent::Controller();
    $this->load->helper('form');
    $this->load->helper('date');
    $this->load->model('maestros/proyecto_model');
    $this->load->model('maestros/directivo_model');
    $this->load->model('maestros/compania_model');
    $this->load->model('maestros/persona_model');
    $this->load->model('ventas/cliente_model');
    $this->load->library('html');
    $this->load->library('pagination');
    $this->load->library('layout','layout');
    $this->somevar ['compania'] = $this->session->userdata('compania');
    $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
    }
    
    public function index()
    {
       $this->layout->view('seguridad/inicio');	
    }
    
    
    public function proyectos($j=0){
        $data['nombres']       = "";
        $data['descripcion']    = "";
        $data['encargado']  = "";
        $data['titulo_tabla']  = "RELACIÃ“N DE PROYECTOS";
        $data['registros'] =  count($this->proyecto_model->listar_proyectos());
        $data['action'] = base_url()."index.php/maestros/proyecto/buscar_proyectos";
        $conf['base_url'] = site_url('maestros/proyecto/buscar_proyectos/');
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
        $listado_proyectos = $this->proyecto_model->listar_proyectos($conf['per_page'],$j);
        $item        = $j+1;
        $lista           = array();
        if(count($listado_proyectos)>0){
             foreach($listado_proyectos as $indice=>$valor){
             	$codigo        = $valor->PROYP_Codigo;
                $nombre        = $valor->PROYC_Nombre;
                $descripcion   = $valor->PROYC_Descripcion;
                $directivo     = $valor->DIREP_Codigo;
              if($directivo!=0){
                 $temp          = $this->directivo_model-> obtener_directivo($directivo);
                 $persona       = $temp[0]->PERSP_Codigo;
                 $temp2         = $this->persona_model->obtener_datosPersona($persona);
                 $encargado     = $temp2[0]->PERSC_Nombre;
              }else{
                 $encargado="";
              }
                                    
                 $editar         = "<a href='javascript:;' onclick='editar_proyecto(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                 $ver            = "<a href='javascript:;' onclick='ver_proyecto(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Ver'></a>";
                 $eliminar       = "<a href='javascript:;' onclick='eliminar_proyecto(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";
                 $lista[]        = array($item,$nombre,$descripcion,$encargado,$editar,$ver,$eliminar);
                 $item++;
               }
           }
        $data['lista'] = $lista;
        $this->layout->view("maestros/proyecto_index",$data);
    }
   
   
   
   public function nuevo_proyecto(){
  
 	   $data['modo']  = "insertar"; 	   
 	   $objeto = new stdClass();
       $objeto->id     = "";
       $objeto->idDire     = "";
	   $objeto->nombres     = "";
       $objeto->descripcion    = "";
       $objeto->fechai     = form_input(array("name"=>"fechai","id"=>"fechai","class"=>"cajaPequena","readonly"=>"readonly","maxlength"=>"10","value"=>""));
       $objeto->fechaf     = form_input(array("name"=>"fechaf","id"=>"fechaf","class"=>"cajaPequena","readonly"=>"readonly","maxlength"=>"10","value"=>""));
       $data['url_action'] = base_url() . "index.php/maestros/proyecto/insertar_proyecto";
       $data['descripcionDireccion'] = "";
       $data['referenciaDireccion'] = "";
       $data['cordenadaY'] = "";
       $data['cordenadaX'] = "";
       $data['cboDepartamento']  = $this->seleccionar_departamento('15');
       $data['cboProvincia']  = $this->seleccionar_provincia('15','01');
       $data['cboDistrito']  = $this->seleccionar_distritos('15','01');
 	   $data['datos'] = $objeto;
 	   $data['titulo'] = "REGISTRAR PROYECTO";
// 	   $data['listado_proyectos']  = array();
	   $data['nombreProyecto'] = "";
	   $data['descpProyecto'] = "";
	   $data['detalle_direccion'] = array();
	   $data['fechai'] = form_input(array("name"=>"fechai","id"=>"fechai","class"=>"cajaPequena","readonly"=>"readonly","maxlength"=>"10","value"=>""));
	   $data['fechaf'] = form_input(array("name"=>"fechaf","id"=>"fechaf","class"=>"cajaPequena","readonly"=>"readonly","maxlength"=>"10","value"=>""));
	   $data['cbo_clientes'] = $this->OPTION_generador($this->cliente_model->listar_cliente(), 'CLIP_Codigo', 'nombre', '');
	   $data['direProyecto'] = "";
	   $this->load->view("maestros/proyecto_nuevo",$data);
	}
 
 	
 	public function insertar_proyecto(){
				/** INSERTAR DATOS DEL PROYECTO **/
 				$nombreProyecto = $this ->input -> post('nombreProyecto');
 				$descpProyecto  = $this ->input -> post('descpProyecto');
 				$fechai         = $this ->input -> post('fechai');
 				$fechaf         = $this ->input -> post('fechaf');
 				$cbo_clientes   = $this ->input -> post('cbo_clientes');
 				$proyecto = $this->proyecto_model->insertar_datosProyecto($nombreProyecto,$descpProyecto,$fechai,$fechaf,$cbo_clientes);
                
                /** INSERTAR DATOS DE DIRECCIÓN **/
 				$direccionCodigo  = $this ->input -> post('direccionCodigo');
                $descripcionDireccion  = $this ->input -> post('descripcionDireccion');
                $referenciaDireccion   = $this ->input -> post('referenciaDireccion');
                $cboDepartamento   = $this->input->post('cboDepartamentoD');
                $cboProvincia      = $this->input->post('cboProvinciaD');
                $cboDistrito       = $this->input->post('cboDistritoD');
                $cordenadaY     = $this->input->post('cordenadaY');
                $cordenadaX     = $this->input->post('cordenadaX');
                $direaccion 		= $this->input->post('direaccion');
                
                if(is_array($direccionCodigo)){
                	foreach ($direccionCodigo as $indice => $valor){
                		if($valor != $direccionCodigo){
                			$filter = new stdClass();
                			$filter ->DIRECC_Descrip = $descripcionDireccion[$indice];
                			$filter ->DIRECC_Referen = $referenciaDireccion[$indice];
                			$ubigeo_domicilio = $cboDepartamento[$indice].$cboProvincia[$indice].$cboDistrito[$indice];
                			$filter ->UBIGP_Domicilio = $ubigeo_domicilio;
                			$filter ->PROYP_Codigo = $proyecto;
                			$filter ->DIRECC_Mapa = $cordenadaX[$indice];
                			$filter ->DIRECC_StreetView = $cordenadaY[$indice];
                			if ($direaccion[$indice] != 'e') {
                				$this->proyecto_model->insertar_direccion($filter);
                			}
                		}
                	}
                }               
                $this->proyectos();
           }
 	
 	
 	public function editar_proyecto($proyecto){
                       $compania=$this->somevar ['compania'];
                       $temp =$this->compania_model->obtener_compania($compania);
                       $empresa=$temp[0]->EMPRP_Codigo;
                       
                       $lista_directivos= $this->directivo_model->listar_directivo($empresa);

                       $data['modo']	 = "modificar";
                       $data['id']	  	 = $this->input->post('id');
		       		   $datos_proyecto   = $this->proyecto_model->obtener_datosProyecto($proyecto);
		       		   $nombreProyecto   = $datos_proyecto[0]->PROYC_Nombre;
		       		   $descpProyecto    = $datos_proyecto[0]->PROYC_Descripcion;
                       $fechai           = $datos_proyecto[0]->PROYC_FechaInicio;
                       $fechaf           = $datos_proyecto[0]->PROYC_FechaFin;
                       
                       /* OBTENER DATOS DE DIRECCIÓN */
                       $datos_direccion  	  = $this->proyecto_model->obtener_direccion($proyecto);
                       $detalle_direccion 	  = $this->listar_detalle($proyecto);                

                        $data['nombreProyecto']   = $nombreProyecto;
						$data['descpProyecto']    = $descpProyecto;
						$data['cbo_clientes'] 	  = $this->OPTION_generador($this->cliente_model->listar_cliente(), 'CLIP_Codigo', 'nombre',  $datos_proyecto[0] -> EMPRP_Codigo);
						$data['fechai']           = form_input(array("name"=>"fechai","id"=>"fechai","class"=>"cajaPequena","readonly"=>"readonly","maxlength"=>"10","value"=>$fechai));
						$data['fechaf']           = form_input(array("name"=>"fechaf","id"=>"fechaf","class"=>"cajaPequena","readonly"=>"readonly","maxlength"=>"10","value"=>$fechaf));
                        $oculto               	  = form_hidden(array('accion'=>"",'codigo'=>$proyecto,'modo'=>"modificar",'base_url'=>base_url()));
		   		        $data['oculto']           = $oculto;
		   		        
		   		        
		   		        /* MOSTRAR DATOS DE DIRECCIÓN */

		   		        $data['descripcionDireccion']  = "";
		   		        $data['referenciaDireccion']   = "";   		        
		   		        $data['cboDepartamento'] 	   = $this->seleccionar_departamento("");
		   		        $data['cboProvincia'] 		   = $this->seleccionar_provincia("", "");
		   		        $data['cboDistrito'] 		   = $this->seleccionar_distritos("", "", "");
		   		        $data['cordenadaY']			   = "";
		   		        $data['cordenadaX']			   = "";
		   		        
		   		        $data['detalle_direccion']     = $detalle_direccion;
		   		        
		   		        
		   		        
		   		        if($detalle_direccion!=null && count($detalle_direccion)>0){
		   		        	foreach ($detalle_direccion as $key=>$valor){
			   		        	$ubigeo_domicilio=$valor->UBIGP_Domicilio;
			   		        	$datosDepartamentoD=$this->ubigeo_model->obtener_ubigeo_dpto($ubigeo_domicilio);
			   		        	$nombreDepartamentoD='NO DEFINIDO';
			   		        	if(count($datosDepartamentoD)>0)
			   		        		$nombreDepartamentoD=$datosDepartamentoD[0]->UBIGC_Descripcion;
			   		        		
			   		        	$datosProvinciaD=$this->ubigeo_model->obtener_ubigeo_prov($ubigeo_domicilio);
			   		        	$nombreProvinciaD='NO DEFINIDO';
			   		        	if(count($datosProvinciaD)>0)
			   		        		$nombreProvinciaD=$datosProvinciaD[0]->UBIGC_Descripcion;
			   		        	
			   		        	$datosDistritoD=$this->ubigeo_model->obtener_ubigeo_dist($ubigeo_domicilio);
			   		        	$nombreDistritoD='NO DEFINIDO';
			   		        	if(count($datosDistritoD)>0)
			   		        		$nombreDistritoD=$datosDistritoD[0]->UBIGC_Descripcion;
			   		        	
			   		        		
			   		        	$data['nombreDepartamentoD'][]	=$nombreDepartamentoD;
			   		        	$data['nombreProvinciaD'][] 	=$nombreProvinciaD;
			   		        	$data['nombreDistritoD'][] 		=$nombreDistritoD;
		   		        	}
		   		        }
		   		        
                        $objeto                 = new stdClass();
                        $objeto->id             = $datos_proyecto[0]->PROYP_Codigo;
                        $objeto->nombres        = $datos_proyecto[0]->PROYC_Nombre;
                        $objeto->descripcion    = $datos_proyecto[0]->PROYC_Descripcion;
                        $objeto->cbo_clientes   = $datos_proyecto[0]->EMPRP_Codigo;
                        $objeto->fechai         = $datos_proyecto[0]->PROYC_FechaInicio;
                        $objeto->fechaf         = $datos_proyecto[0]->PROYC_FechaFin;
                        $data['datos']    		= $objeto;
                        $data['titulo']  		= "EDITAR PROYECTO ::: ";
	                	$this->load->view("maestros/proyecto_nuevo",$data);
	        }

	public function ver_proyecto($proyecto)
	        {
	        	 
	        	$datos   = $this->proyecto_model->obtener_datosProyecto($proyecto);
	        	$data['nombres']             = $datos[0]->PROYC_Nombre;
	        	$data['descripcion']         = $datos[0]->PROYC_Descripcion;
	        	$data['encargado']           = $datos[0]->DIREP_Codigo;
	        	$data['datos']  = $datos;
	        	$data['titulo'] = "VER PROYECTO";
	        	$this->load->view('maestros/proyecto_ver',$data);
	        }
  	
  	public function modificar_proyecto(){
		
        $codigo             = $this->input->post('proyecto');
        $nombreProyecto     = $this->input->post('nombreProyecto');
        $descpProyecto      = $this->input->post('descpProyecto');
        $cbo_clientes       = $this->input->post('cbo_clientes');
		$fechai             = $this->input->post('fechai');
		$fechaf             = $this->input->post('fechaf');	
		$this->proyecto_model->modificar_datosProyecto($codigo,$nombreProyecto,$descpProyecto,$cbo_clientes,$fechai,$fechaf);
		
		$direccionCodigo 	  = $this->input->post('direccionCodigo');
		$descripcionDireccion = $this->input->post('descripcionDireccion');	
		$referenciaDireccion  = $this->input->post('referenciaDireccion');
		
		$cboDepartamento      = $this->input->post('cboDepartamentoD');
		$cboProvincia         = $this->input->post('cboProvinciaD');
		$cboDistrito          = $this->input->post('cboDistritoD');
		$cordenadaX 		  = $this->input->post('cordenadaX');	
		$cordenadaY           = $this->input->post('cordenadaY');
		$direaccion 		  = $this->input->post('direaccion');
		  if (is_array($direccionCodigo) > 0) {
			foreach ($direccionCodigo as $indice => $valor) {
				$detalle_accion = $direaccion[$indice];
				$filter = new stdClass();
				$filter->DIRECC_Descrip   = $descripcionDireccion[$indice];
				$filter->DIRECC_Referen   = $referenciaDireccion[$indice];
				$ubigeo_domicilio = $cboDepartamento[$indice].$cboProvincia[$indice].$cboDistrito[$indice];
				$filter ->UBIGP_Domicilio = $ubigeo_domicilio;
				$filter->DIRECC_Mapa   	  = $cordenadaX[$indice];
				$filter->DIRECC_StreetView  = $cordenadaY[$indice];
				$filter->PROYP_Codigo 	  = $codigo;
				
				if ($detalle_accion == 'n') {
					$this->proyecto_model->insertar_direccion($filter);
				} elseif ($detalle_accion == 'm') {
					$this->proyecto_model->modificar_direccion($valor, $filter);
				} elseif ($detalle_accion == 'e') {
					$this->proyecto_model->eliminar_direccion($valor);
				}
					
			}
		}
		
	}

  


   	
   	public function buscar_proyectos($j='0'){
        $filter = new stdClass();
        $filter->PROYC_Nombre = $this->input->post('nombres');
        $data['nombres']      = $filter->PROYC_Nombre;
        $data['titulo_tabla']    = "RESULTADO DE BÃšSQUEDA DE PROYECTOS";
        $data['registros']  = count($this->proyecto_model->buscar_proyectos($filter));
        $data['action'] = base_url()."index.php/maestros/proyecto/buscar_proyectos";
        $conf['base_url'] = site_url('maestros/proyecto/buscar_proyectos/');
        $conf['total_rows'] = $data['registros'];
        $conf['per_page']   = 10;
        $conf['num_links']  = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link']  = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $listado_proyectos = $this->proyecto_model->buscar_proyectos($filter, $conf['per_page'],$j);
        $item            = $j+1;
        $lista           = array();
                    if(count($listado_proyectos)>0){
                            foreach($listado_proyectos as $indice=>$valor){
                                    $proyecto       = $valor->PROYP_Codigo;
                                    $nombres        = $valor->PROYC_Nombre;
                                    $descripcion    = $valor->PROYC_Descripcion;
                                    $encargado      = $valor->DIREP_Codigo;
                                    $editar         = "<a href='#' onclick='editar_proyecto(".$proyecto.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                                    $ver            = "<a href='#' onclick='ver_proyecto(".$proyecto.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                                    $eliminar       = "<a href='#' onclick='eliminar_proyecto(".$proyecto.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                                    $lista[]        = array($item,$nombres,$descripcion,$encargado,$editar,$ver,$eliminar);
                                    $item++;
                            }
                    }
        $data['lista'] = $lista;
        $this->layout->view("maestros/proyecto_index",$data);

    }

    
    public function eliminar_proyecto(){
		$proyecto = $this->input->post('proyecto');
		$this->proyecto_model->eliminar_proyecto($proyecto);
	}

	
	/*Agregado*/
	
	public function JSON_listar_proyecto($cliente){

    $lista_todos=array();
     $datoCliente = $this->cliente_model->obtener($cliente);


    $listado_proyectos = $this->proyecto_model->listar_proyetos_cliente($datoCliente ->empresa);
      foreach ($listado_proyectos as $key => $datos_proyecto) {

            $objeto = new stdClass();
            $objeto->PROYP_Codigo = $datos_proyecto->PROYP_Codigo;;
            $objeto->nombre = $datos_proyecto->PROYC_Nombre;;
            $objeto->descripcion = $datos_proyecto->PROYC_Descripcion;;
            $lista_detalles[] = $objeto;
            
        }
         $resultado[] = array('Tipo' => '1', 'Titulo' => 'Los establecimientos de mi cliente');
            $resultado = json_encode($lista_detalles);

        echo  $resultado;
	}
	
	public function JSON_listar_departamento()
	{
		echo json_encode($this->ubigeo_model->listar_depa($depa));
	}
	
	
	public function seleccionar_departamento($indDefault=''){
		$array_dpto = $this->ubigeo_model->listar_departamentos();
		$arreglo = array();
		if(count($array_dpto)>0){
			foreach($array_dpto as $indice=>$valor){
				$indice1   = $valor->UBIGC_CodDpto;
				$valor1    = $valor->UBIGC_Descripcion;
				$arreglo[$indice1] = $valor1;
			}
		}
		$resultado = $this->html->optionHTML($arreglo,$indDefault,array('00','::Seleccione::'));
		return $resultado;
	}


	public function seleccionar_provincia($departamento,$indDefault=''){
	$array_prov = $this->ubigeo_model->listar_provincias($departamento);
	$arreglo = array();
	if(count($array_prov)>0){
		foreach($array_prov as $indice=>$valor){
			$indice1   = $valor->UBIGC_CodProv;
			$valor1    = $valor->UBIGC_Descripcion;
			$arreglo[$indice1] = $valor1;
		}
	}
	$resultado = $this->html->optionHTML($arreglo,$indDefault,array('00','::Seleccione::'));
	return $resultado;
}


	public function seleccionar_distritos($departamento,$provincia,$indDefault=''){
	$array_dist = $this->ubigeo_model->listar_distritos($departamento,$provincia);
	$arreglo = array();
	if(count($array_dist)>0){
		foreach($array_dist as $indice=>$valor){
			$indice1   = $valor->UBIGC_CodDist;
			$valor1    = $valor->UBIGC_Descripcion;
			$arreglo[$indice1] = $valor1;
		}
	}
	$resultado = $this->html->optionHTML($arreglo,$indDefault,array('00','::Seleccione::'));
	return $resultado;
}



	public function listar_detalle($proyecto)
	{
	$detalle = $this->proyecto_model->listar_detalle($proyecto);
	$lista_detalles = array();
	if (count($detalle) > 0) {
		foreach ($detalle as $indice => $valor) {
			$direccionCodigo 	  = $valor->DIRECC_Codigo;
			$descripcionDireccion = $valor->DIRECC_Descrip;
			$referenciaDireccion  = $valor->DIRECC_Referen;
			$ubigeo_domicilio 	  = $valor->UBIGP_Domicilio;			
			$cordenadaX 		  = $valor->DIRECC_Mapa;
			$cordenadaY 		  = $valor->DIRECC_StreetView;

			$objeto = new stdClass();
			$objeto->DIRECC_Codigo= $direccionCodigo;
			$objeto->DIRECC_Descrip = $descripcionDireccion;
			$objeto->DIRECC_Referen = $referenciaDireccion;
			$objeto ->UBIGP_Domicilio = $ubigeo_domicilio;		
			$objeto->DIRECC_Mapa = $cordenadaX;
			$objeto->DIRECC_StreetView = $cordenadaY;
			$lista_detalles[] = $objeto;
		}
	}
	return $lista_detalles;
}






}       
?>