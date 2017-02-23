<?php




class Configuracionimpresion extends Controller{
    public function __construct()
    {
        parent::Controller();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('util');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->model('maestros/documento_model_ac');
        $this->load->model('maestros/documento_sentencia_model');
        $this->load->model('maestros/companiaconfiguracion_model');
        $this->load->model('maestros/companiaconfidocumento_model');
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['user'] = $this->session->userdata('user');

        
        
    }
    public function index(){
        
        $this->layout->view('seguridad/inicio');
    }
    
    public function configuracion_index($j=0){
        $this->load->library('layout','layout');
        $codigoCompania=$this->session->userdata('compania');
        $data['titulo_tabla'] = "TIPO DE DOCUMENTO";
        $data['registros'] = count($this->documento_model_ac->listar($codigoCompania));
        $data['titulo_configuracion'] = "CONFIGURACION IMPRESION"; 
        $data['action'] = base_url() . "index.php/maestros/configuracionimpresion/configuracion_index";

        $listado_directivos = $this->documento_model_ac->listar($codigoCompania);
        $item = $j + 1;
        $lista = array();
        if (count($listado_directivos) > 0) {
            foreach ($listado_directivos as $indice => $valor) {
                $codigo = $valor->DOCUP_Codigo;
                $numdoc = $valor->DOCUC_Descripcion;

                $editar = "<a href='javascript:;' onclick='editar_configuracionimpersion(" . $codigo . ")'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[] = array($item, $numdoc, $editar);
                $item++;
            }
        }
        $data['lista'] = $lista;
        $this->layout->view('maestros/configuracionimpresion_index',$data);
    }
    
    public function configuracionimpersion_editar($codigoDocumento)
    {
        $this->load->library('layout','layout');
        $codigoCompania=$this->session->userdata('compania');
        $data["titulo_configuracioneditar"] = "CONFIGURACION DETALLES DOCUMENTO";
        /**obtenemos detalle  de companiaConfiguracio**/
        $datosCompaniaConfiguracion=$this->companiaconfiguracion_model->obtener($codigoCompania);
        $comp_confi=$datosCompaniaConfiguracion[0]->COMPCONFIP_Codigo;
        $datosCompaniaConfiguracionDoc=$this->companiaconfidocumento_model->obtener($comp_confi, $codigoDocumento);
        $data['posicionGeneralX'] = $datosCompaniaConfiguracionDoc[0]->COMPCONFIDOCP_PosicionGeneralX;
        $data['posicionGeneralY'] = $datosCompaniaConfiguracionDoc[0]->COMPCONFIDOCP_PosicionGeneralY;
        $data['imagenDocumento']  = $datosCompaniaConfiguracionDoc[0]->COMPCONFIDOCP_Imagen;
        $codigoCompConfDoc=$datosCompaniaConfiguracionDoc[0]->COMPCONFIDOCP_Codigo;
        $data['codigoCompConfDoc']=$codigoCompConfDoc;
        
        /**fin**/
        
        $datos_configuracionimpre = $this->documento_model_ac->obtener_configuracion($codigoDocumento,$codigoCompania);
        $datos_configuracionimpredesafult=$this->documento_model_ac->obtener_configuracion_default($codigoDocumento,$codigoCompania);

        $lista_detalles = array();
        
        /**listado alineamiento**/
        $listadoAlineamiento=array();
        $objetoAl=new stdClass();
        $objetoAl->nombre="LEFT";
        $objetoAl->valor="L";
        $listadoAlineamiento[]=$objetoAl;
        
        $objetoAl=new stdClass();
        $objetoAl->nombre="CENTER";
        $objetoAl->valor="C";
        $listadoAlineamiento[]=$objetoAl;
        
        $objetoAl=new stdClass();
        $objetoAl->nombre="RIGHT";
        $objetoAl->valor="R";
        $listadoAlineamiento[]=$objetoAl;
        
        $objetoAl=new stdClass();
        $objetoAl->nombre="JUSTIFICATION";
        $objetoAl->valor="J";
        $listadoAlineamiento[]=$objetoAl;
        $data['listadoAlineamiento']=$listadoAlineamiento;
        /**fin listado**/
        if ($datos_configuracionimpre) {
            
            foreach ($datos_configuracionimpre as $valor) {

                $compadocumenitem_codigo = $valor->COMPADOCUITEM_Codigo;
                $compacofidocum = $valor->COMPCONFIDOCP_Codigo;
                $documento_codigo = $valor->DOCUP_Codigo;
                $tipo_docu = $valor->DOCUC_Descripcion;
                $item_nom = $valor->COMPADOCUITEM_Nombre;
                $docuitem_wid = $valor->COMPADOCUITEM_Width;
                $docuitem_hei = $valor->COMPADOCUITEM_Height;
                $activacion=$valor->COMPADOCUITEM_Activacion;
                $docuitem_posix = $valor->COMPADOCUITEM_PosicionX;
                $docuitem_posiy = $valor->COMPADOCUITEM_PosicionY;
                $docuitem_tamletra = $valor->COMPADOCUITEM_TamanioLetra;
                $docuitem_tipoletra = $valor->COMPADOCUITEM_TipoLetra;
                $variable = $valor ->COMPADOCUITEM_Variable;
                $perteneceGrupo= $valor->COMPADOCUITEM_VGrupo;
                $alineamiento= $valor->COMPADOCUITEM_Alineamiento;
                
                $objeto = new stdClass();
                $objeto->COMPADOCUITEM_Codigo = $compadocumenitem_codigo;
                $objeto->COMPCONFIDOCP_Codigo = $compacofidocum;
                $objeto->DOCUP_Codigo = $documento_codigo;
                $objeto->DOCUC_Descripcion = $tipo_docu;
                $objeto->ITEM_Nombre = $item_nom;
                $objeto->DOCUITEM_Width = $docuitem_wid;
                $objeto->DOCUITEM_Height = $docuitem_hei;
                $objeto->COMPADOCUITEM_Activacion =$activacion;
                $objeto->DOCUITEM_PosicionX = $docuitem_posix;
                $objeto->DOCUITEM_PosicionY = $docuitem_posiy;
                $objeto->DOCUITEM_TamanioLetra = $docuitem_tamletra;
                $objeto->DOCUITEM_TipoLetra = $docuitem_tipoletra;
                $objeto->DOCUITEM_Variable =$variable;
                $objeto->COMPADOCUITEM_VGrupo =$perteneceGrupo;
                $objeto->COMPADOCUITEM_Alineamiento =$alineamiento;
                $lista[] = $objeto;
                
            }
        }
        else{
            if ($datos_configuracionimpredesafult) {
                foreach ($datos_configuracionimpredesafult as $indice => $valor) {

                $compadocumenitem_codigo = "";
                $compacofidocum = "";
                $documento_codigo = $valor->DOCUP_Codigo;
                $tipo_docu = $valor ->DOCUC_Descripcion;
                $item_nom = $valor ->ITEM_Nombre;
                $docuitem_wid = $valor ->DOCUITEM_Width;
                $docuitem_hei = $valor ->DOCUITEM_Height;
                $docuitem_posix = $valor ->DOCUITEM_PosicionX;
                $docuitem_posiy = $valor ->DOCUITEM_PosicionY;
                $docuitem_tamletra = $valor ->DOCUITEM_TamanioLetra;
                $docuitem_tipoletra = $valor ->DOCUITEM_TipoLetra;
                $variable = $valor ->DOCUITEM_Variable;
                
                $objeto = new stdClass();
                $objeto->COMPADOCUITEM_Codigo = $compadocumenitem_codigo;
                $objeto->COMPCONFIDOCP_Codigo = $compacofidocum;
                $objeto->DOCUP_Codigo = $documento_codigo;
                $objeto->DOCUC_Descripcion = $tipo_docu;
                $objeto->ITEM_Nombre = $item_nom;
                $objeto->DOCUITEM_Width = $docuitem_wid;
                $objeto->DOCUITEM_Height = $docuitem_hei;
                $objeto->DOCUITEM_PosicionX = $docuitem_posix;
                $objeto->DOCUITEM_PosicionY = $docuitem_posiy;
                $objeto->DOCUITEM_TamanioLetra = $docuitem_tamletra;
                $objeto->DOCUITEM_TipoLetra = $docuitem_tipoletra;
                $objeto->DOCUITEM_Variable =$variable;
                $lista[] = $objeto;
                }
            }
        }


        /**obtenemos sentencias guardadas**/
        $datosDocumentoSentencia=$this->documento_sentencia_model->buscar($codigoCompConfDoc);
        if(count($datosDocumentoSentencia)>0){
            $listaSentencia = array();
            foreach ($datosDocumentoSentencia as $indice=>$valor){
                $tipo=$valor->DOCSENT_Tipo;
                $codigoRelacion=$valor->DOCSENT_CodigoRelacion;
                $variableRelacion=$valor->DOCSENT_VariableCodigoRelacion;
                $sentencia=$valor->DOCSENT_Select;
                $sentenciaGrupo=$valor->DOCSENT_VariableGrupo;
                
                /**indice principal***/
                if($tipo==1){
                    $data['sentenciaPrincipal']=$sentencia;
                }else{
                    
                    $objeto = new stdClass();
                    $objeto->tipo=$tipo;
                    $objeto->codigoRelacion=$codigoRelacion;
                    $objeto->variableRelacion=$variableRelacion;
                    $objeto->sentencia=$sentencia;
                    $objeto->sentenciaGrupo=$sentenciaGrupo;
                    $listaSentencia[] = $objeto;
                    $data['listaSentencia'] = $listaSentencia;
                }
                
                
                
                
            }           
        }
        
        
        
        
        /**fin de sentencias**/
        
        
        
        $data['formulario'] = "fmrModificarImpresion";
        $data['url_action'] = base_url() . "index.php/maestros/configuracionimpresion/configuracionimpresion_insertar";
        $data['lista'] = $lista;
        $this->layout->view('maestros/configuracionimpresion_editar',$data);
         
    }
    
    public function configuracionimpresion_insertar(){
        $this->load->library('layout','layout');

        $docuid = $this->input->post('documentoid');

        $compadocumenitem_codigo_array = $this->input->post('compadocumenitem_codigo');

        $compaconfi = $this->input->post('compaconfidocu');
        $item_nom = $this->input->post('item_nom');
        $tipo_docu = $this->input->post('tipo_docu');

        $campw = $this->input->post('campodo_width');
        $camph = $this->input->post('campodo_height');
        $posx = $this->input->post('campodo_posx');
        $posy = $this->input->post('campodo_posy');
        $taml = $this->input->post('campodo_tamletra');
        $tipol = $this->input->post('campodo_tipoletra');
        $variable = $this->input->post('variable');
        $perteneceGrupo = $this->input->post('grupo');
        $alineamiento= $this->input->post('alineamiento');
        $activacion= $this->input->post('activacion');
        
        if (is_array($docuid)) {
            foreach ($docuid as $indice => $value) {

            $compadocumenitem_codigo = $compadocumenitem_codigo_array[$indice];

            $filter = new stdClass();
            
            $filter->COMPADOCUITEM_UsuCrea = $this->session->userdata('nombre_persona');
            $filter->COMPADOCUITEM_FechaIng = date("Y-m-d H:i:s");

            $filter->COMPADOCUITEM_Descripcion = "";
            $filter->COMPADOCUITEM_Abreviatura = "";
            $filter->COMPADOCUITEM_Valor = "";
            $filter->COMPADOCUITEM_Estado = "1";
            $filter->COMPADOCUITEM_Variable = "";
            $filter->COMPADOCUITEM_Activacion = "";
            $filter->COMPADOCUITEM_UsuModi = "";
            $filter->COMPADOCUITEM_FechaModi = "";
            $filter->COMPADOCUITEM_Nombre = $item_nom[$indice];
            

            $filter->DOCUITEM_Codigo = $docuid[$indice];
            $filter->COMPCONFIDOCP_Codigo = $compaconfi[$indice];
            $filter->COMPADOCUITEM_Width = $campw[$indice];
            $filter->COMPADOCUITEM_Height = $camph[$indice];
            $filter->COMPADOCUITEM_Activacion= isset($activacion[$indice])?$activacion[$indice]:0;
            $filter->COMPADOCUITEM_PosicionX = $posx[$indice];
            $filter->COMPADOCUITEM_PosicionY = $posy[$indice];
            $filter->COMPADOCUITEM_TamanioLetra = $taml[$indice];
            $filter->COMPADOCUITEM_TipoLetra = $tipol[$indice];
            $filter->COMPADOCUITEM_Variable = $variable[$indice];
            $filter->COMPADOCUITEM_VGrupo = $perteneceGrupo[$indice];
            $filter->COMPADOCUITEM_Alineamiento =$alineamiento[$indice];
            
                if ($compadocumenitem_codigo!="" && $compadocumenitem_codigo!=NULL) {
                    $this->documento_model_ac->modificar_configuracion($filter,$compadocumenitem_codigo);
                }
                else{
                    $this->documento_model_ac->insertar_configuracion($filter);
                }
            }
            
            
            /**datos cabecera**/
            $codigoCompConfDoc= $this->input->post('codigoCompConfDoc');
            $posicionGeneralY= $this->input->post('posicionGeneralY');
            $posicionGeneralX = $this->input->post('posicionGeneralX');
           
            

            $imagen="";
            $config = array();
            $config['upload_path'] = 'images/documentos/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']      = '5120';
            $this->load->library('upload');
            $files = $_FILES;
            
            for($i=0; $i< count($_FILES['files']['name']); $i++){
                
                $_FILES['files']['name']= $files['files']['name'][$i];
                if( $_FILES['files']['name']!="")
                    {
                    $_FILES['files']['type']= $files['files']['type'][$i];
                    $_FILES['files']['tmp_name']= $files['files']['tmp_name'][$i];
                    $_FILES['files']['error']= $files['files']['error'][$i];
                    $_FILES['files']['size']= $files['files']['size'][$i];            
                    $this->upload->initialize($config);
                    $this->upload->do_upload('files');
                    $imagen=$_FILES['files']['name'];
                    
                    /**eliminamos la imagen anterior**/
                    $imagenAnteriorNombre= $this->input->post('imagenAnteriorNombre');
                    $file = 'images/documentos/' . $imagenAnteriorNombre;
                    unlink($file);
                }
            }
            
            $filter=new stdClass();
            $filter->COMPCONFIDOCP_PosicionGeneralX=$posicionGeneralX;
            $filter->COMPCONFIDOCP_PosicionGeneralY=$posicionGeneralY;
            if($imagen!=null && trim($imagen)!="")
                $filter->COMPCONFIDOCP_Imagen=$imagen;
            
            $this->companiaconfidocumento_model->modificar($codigoCompConfDoc,$filter);
            /**fin**/
            
            /**insertamos documento sentenia**/
            $sentencia=$this->input->post('sentencia');
            $tipoSentencia=$this->input->post('tipoSentencia');
            $vCodigoRelacionSentencia=$this->input->post('vCodigoRelacionSentencia');
            $codigoRelacionSentencia=$this->input->post('codigoRelacionSentencia');
            $sentenciaGrupo=$this->input->post('sentenciaGrupo');
            
            if(count($sentencia)>0 && trim($sentencia[0])!=""){
                $this->documento_sentencia_model->eliminar_configuracion($codigoCompConfDoc);
                foreach ($sentencia as $i=>$valor){
                    
                    if(trim($valor)!=""){
                        $valorTipoSentencia=$tipoSentencia[$i];
                        $valorCodigoRe=$codigoRelacionSentencia[$i];
                        $filterDS=new stdClass();
                        $filterDS->DOCSENT_Tipo=$valorTipoSentencia;
                        $filterDS->DOCSENT_Select=$valor;
                        $filterDS->DOCSENT_CodigoRelacion=$valorCodigoRe;
                        $filterDS->COMPCONFIDOCP_Codigo=$codigoCompConfDoc;
                        $filterDS->DOCSENT_VariableCodigoRelacion=$vCodigoRelacionSentencia[$i];
                        $filterDS->DOCSENT_VariableGrupo=$sentenciaGrupo[$i];
                        if($valorTipoSentencia==2){
                            if(trim($valorCodigoRe)!=""){
                                $this->documento_sentencia_model->insertar($filterDS);
                            }
                            
                        }else{
                            $this->documento_sentencia_model->insertar($filterDS);
                        }
                    }
                }
            
            }
            
            /**fin de insertar**/
        }
        redirect('maestros/configuracionimpresion/configuracion_index','refresh');
    }
   
    
    public function  verificarSentenciaVariable(){
        $sentencia = $this->input->post('sentenciaReal');
        $listaVariables=$this->documento_sentencia_model->validarSentecia($sentencia);
        $lista_detalles = array();
        if(count($listaVariables)>0){
            foreach ($listaVariables as $indice=>$valor){
                $objeto=new stdClass();
                $objeto->variableReal=$valor->name;
                $lista_detalles[] = $objeto;
            }
        }
        $resultado = json_encode($lista_detalles);
        echo $resultado;
    }
    
    
    
    
    
    /**metodo de impresion
     * @param int $CodigoPrincipal (relacionada con la variable principal)
     * @param int $imagen***/
    public function impresionDocumento($CodigoPrincipal,$codigoDocumento,$isImagen,$ventaCompra){
        $codigoCompania=$this->session->userdata('compania');
        /**obtenemos detalle  de companiaConfiguracio**/
        $datosCompaniaConfiguracion=$this->companiaconfiguracion_model->obtener($codigoCompania);
        $comp_confi=$datosCompaniaConfiguracion[0]->COMPCONFIP_Codigo;
        
        /***cabecaer documento**/
        $datosCompaniaConfiguracionDoc=$this->companiaconfidocumento_model->obtener($comp_confi, $codigoDocumento);
        $posicionGeneralX = $datosCompaniaConfiguracionDoc[0]->COMPCONFIDOCP_PosicionGeneralX;
        $posicionGeneralY = $datosCompaniaConfiguracionDoc[0]->COMPCONFIDOCP_PosicionGeneralY;
        if ($ventaCompra=="V") {
            $imagenDocumento =  $datosCompaniaConfiguracionDoc[0]->COMPCONFIDOCP_Imagen;
        } else {
            $imagenDocumento =  $datosCompaniaConfiguracionDoc[0]->COMPCONFIDOCP_ImagenCompra;
        }
        
        
        $codigoCompConfDoc=$datosCompaniaConfiguracionDoc[0]->COMPCONFIDOCP_Codigo;
        
         
        /**fin**/
        
        /***sentencia por documento**/
        $datosDocumentoSentencia=$this->documento_sentencia_model->buscar($codigoCompConfDoc);
        /**fin**/
        if(count($datosDocumentoSentencia)>0){
            $ListaDatosSentencia = array();
            $ListaDatosSentenciaGrupo= array();
            foreach ($datosDocumentoSentencia as $i=>$valor){
                $tipo=$valor->DOCSENT_Tipo;
                $codigoRelacion=$valor->DOCSENT_CodigoRelacion;
                $variableRelacion=$valor->DOCSENT_VariableCodigoRelacion;
                $sentencia=$valor->DOCSENT_Select;
                $grupoVariable=$valor->DOCSENT_VariableGrupo;
                if($tipo==1){
                    /**reemplazamos los valores para se ejecute la sentencia**/
                    $sentencia=str_replace($variableRelacion, $CodigoPrincipal, $sentencia);
                    //echo $sentencia;
                    /**ejecutamos la sentencia realizada**/
                    $datosSentencia=$this->documento_sentencia_model->ejecutarSentencia($sentencia);
                    $ListaDatosSentencia[]=$datosSentencia;
                }else{
                    $CodigoSecundario="";
                    /**buscamos la variable asociada a la principal y capturamos el codigo**/
                        foreach ($ListaDatosSentencia as $objeto){
                           // print_r($objeto);
                            foreach ($objeto as $valorVariable){
                                if(isset($valorVariable->$codigoRelacion)){
                                    $CodigoSecundario=$valorVariable->$codigoRelacion;
                                    break;
                                }
                            }
                        }
                    /**buscamos en principal y en los demas Datos si existe**/
                    $sentencia=str_replace($variableRelacion, $CodigoSecundario, $sentencia);
                    //echo "___________";                    echo $sentencia;
                    /**ejecutamos la sentencia realizada**/
                    $datosSentencia=$this->documento_sentencia_model->ejecutarSentencia($sentencia);
                    $ListaDatosSentencia[]=$datosSentencia;
                    
                    if(trim($grupoVariable)!=""){
                        $datosSentencia=$this->documento_sentencia_model->ejecutarSentencia($sentencia);
                        $ListaDatosSentenciaGrupo[$grupoVariable]=$datosSentencia;
                    }else{
                        $datosSentencia=$this->documento_sentencia_model->ejecutarSentencia($sentencia);
                        $ListaDatosSentencia[]=$datosSentencia;
                    }
                    
                }
            }
        }
        
        /**fin**
        /**detalles de impresionn**/
        $datos_configuracionimpre = $this->documento_model_ac->obtener_configuracion($codigoDocumento,$codigoCompania);
        $nombreArchivoIMG="images/documentos/".$imagenDocumento; 
        if(count($datos_configuracionimpre)>0 && file_exists($nombreArchivoIMG)){
            
            
            $this->load->library('fpdf/fpdf');
            $pdf = new FPDF('P','mm','A4');
            $pdf->AliasNbPages();
            $pdf->AddPage();
            /**tamaño de la imagen es de A4**/
            IF($isImagen==1)         
            $pdf->Image($nombreArchivoIMG, '0', '0','210','297','JPG');
            
            foreach ($datos_configuracionimpre as $key=>$valor){
            
                $item_nom = $valor->COMPADOCUITEM_Nombre;
                $docuitem_wid = $this->convertirMm($valor->COMPADOCUITEM_Width);
                $docuitem_hei =$this->convertirMm( $valor->COMPADOCUITEM_Height);
                $docuitem_posix =$this->convertirMm( $valor->COMPADOCUITEM_PosicionX);
                $docuitem_posiy =$this->convertirMm( $valor->COMPADOCUITEM_PosicionY);
                $docuitem_tamletra = $valor->COMPADOCUITEM_TamanioLetra;
                $docuitem_tipoletra = $valor->COMPADOCUITEM_TipoLetra;
                $variable = $valor->COMPADOCUITEM_Variable;
                $alineamiento=$valor->COMPADOCUITEM_Alineamiento;
                $activacion=$valor->COMPADOCUITEM_Activacion;
                //capturo la condicion de letra o numero
                $numeroEnLetra=$valor->COMPADOCUITEM_Convertiraletras;
                //**************************************
                $isListado= $valor->COMPADOCUITEM_Listado;
                $perteneceGrupo= $valor->COMPADOCUITEM_VGrupo;
                
                $valorVariableMostrar="";


                if($activacion!=1 && trim($activacion)!="1"){
                    /**verificamos si existe detallles **/
                    if(trim($perteneceGrupo)!="" && trim($perteneceGrupo)!="0"){
                        if(count($ListaDatosSentenciaGrupo)>0){
                            /**obtenemos datos de la lista detalle y lo pintamos**/
                            foreach ($ListaDatosSentenciaGrupo[$perteneceGrupo] as $valorArray){
                                if(isset($valorArray->$variable) && $valorArray->$variable!=null && trim($valorArray->$variable)!=""){
                                    $valorVariableMostrar=$valorArray->$variable;

                                    $pdf->SetFont('Arial', '', $docuitem_tamletra);
                                    $pdf->SetY($docuitem_posiy);
                                    $pdf->SetX($docuitem_posix);
                                    $pdf->MultiCell($docuitem_wid,$docuitem_hei, mb_strtoupper($valorVariableMostrar),0,$alineamiento);
                                    $docuitem_posiy=$docuitem_posiy+5;
                                }
                            }
                            
                        }
                    }else{
                        
                        foreach ($ListaDatosSentencia as $objeto){
                            if ($objeto!=NULL && count($objeto)>0 && isset($objeto)) {
                                foreach ($objeto AS $valorVariable){
                                    if(isset($valorVariable->$variable)){
                                        $valorVariableMostrar=$valorVariable->$variable;
                                        break;
                                    }
                                }
                            }
                            
                        }
                        if ($numeroEnLetra==1) {
                            $valorVariableMostrar='SON: '.num2letras(round($valorVariableMostrar, 2));
                        }
                        $pdf->SetFont('Arial', '', $docuitem_tamletra);
                        $pdf->SetY($docuitem_posiy);
                        $pdf->SetX($docuitem_posix);
                        $pdf->MultiCell($docuitem_wid,$docuitem_hei, mb_strtoupper($valorVariableMostrar),0,$alineamiento);
                        
                    }
                }
                
                
                
                
                
                
            }
            $archivo = "temporal/Impresion.pdf";
            $pdf->Output('I', $archivo);
            
        }
        else
        {
            echo "</br>No se puede mostrar el PDF ya que no se encontró el archivo que contiene la imagen, asegurese de haber cargado correctamente la imagen en: mantenimiento/configuracion impresión.</br>Si el inconveniente persiste comuniquese con el administrador.";
        }
        /***fin */
        
    }
    
    /**convertir de pixeles a mm para que se muestre en la impresion**/
    public function convertirMm($valor){
        return ($valor*0.264583);
    }
    
    
    
 
    
    
  
}
?>