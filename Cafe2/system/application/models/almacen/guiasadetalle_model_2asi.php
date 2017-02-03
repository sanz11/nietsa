<?php
class Guiasadetalle_Model extends Model
{
    protected $_name = "cji_guiasadetalle";
    public function  __construct()
    {
      parent::__construct();
      $this->load->database();
      $this->load->model('maestros/compania_model');
      $this->load->model('almacen/serie_model');
      $this->load->model('almacen/seriemov_model');
      $this->load->model('almacen/kardex_model');
      $this->load->model('almacen/lote_model');
      $this->load->model('almacen/almacenproducto_model');
      $this->load->model('almacen/almaprolote_model');
      $this->load->model('almacen/productounidad_model');
      $this->somevar['compania'] = $this->session->userdata('compania');
    }
    public function listar($number_items='',$offset='')
    {
        $where = array("GUIASADETC_FlagEstado"=>1);
        $query = $this->db->order_by('GUIASADETP_Codigo')->where($where)->get('cji_guiasadetalle',$number_items,$offset);
        if($query->num_rows>0){
                return $query->result();
        }
    }
    public function obtener($id)
    {
        $where = array("GUIASADETP_Codigo"=>$id);
        $query = $this->db->where($where)->get('cji_guiasadetalle');
        if($query->num_rows>0){
          return $query->row();
        }
    }
     public function obtener2($guiarem_id)
     {
        $where = array("GUIASAP_Codigo"=>$guiarem_id);
        $query = $this->db->where($where)->get('cji_guiasadetalle');
        if($query->num_rows>0){
          return $query->result();
        }
     }
    public function insertar(stdClass $filter = null){
		
        $this->db->insert("cji_guiasadetalle", (array) $filter);
        $guia_id = $filter->GUIASAP_Codigo;
        $producto_id = $filter->PRODCTOP_Codigo;
        $umedida_id = $filter->UNDMED_Codigo;
        $cantidad = $filter->GUIASADETC_Cantidad;
        $costo = $filter->GUIASADETC_Costo;
        $guia = $this->guiasa_model->obtener($guia_id);
        $fecha = $guia->GUIASAC_FechaRegistro;
        $motivo_mov = $guia->TIPOMOVP_Codigo;
        $almacen_id = $guia->ALMAP_Codigo;
        ////stv
        $factorprin=0;
        ///////
        $productoundad = $this->productounidad_model->obtener($producto_id, $umedida_id);
        if ($productoundad) {
            $flagPrincipal = $productoundad->PRODUNIC_flagPrincipal;
            $factor = $productoundad->PRODUNIC_Factor;

            if ($flagPrincipal == 0) {

                if($factor>0){
                ///stv
                
//                $unidadprin = $this->productounidad_model->obtenerprincipal($producto_id);
//                if(count($unidadprin>0)){
//                $factorprin=$unidadprin->PRODUNIC_Factor;
//                }
                ////

                //////stv
//                $cantidad = ($cantidad * $factor)/$factorprin;
                ////////


                //taba asi
                $cantidad = $cantidad / $factor;
                if(strpos($cantidad,".")==true){
                  $cantidad=round($cantidad,3);  
                }
                ///

                }

            }
        }
        /* Relaciono la guiasa con las series */
        if ($filter->GUIASADETC_GenInd == "I") {
            $arrserie = array();
            $serie_id = array();
            if (isset($_SESSION['serie'][$producto_id]) && is_array($_SESSION['serie'][$producto_id])) {
                foreach ($_SESSION['serie'][$producto_id] as $value) {
                    $serie_id[] = $value;
                    $filter5 = new stdClass();
                    $filter5->SERIP_Codigo = $value;
                    $filter5->SERMOVP_TipoMov = '2';
                    $filter5->GUIASAP_Codigo = $guia_id;
                    $this->seriemov_model->insertar($filter5);
                }
            }
        }
        /* Saco en el almacen */
        $almacenproducto_id = $this->almacenproducto_model->disminuir($almacen_id, $producto_id, $cantidad, $costo);

        /* Saco series del almacen si fuese necesario */
        if ($filter->GUIASADETC_GenInd == "I") {
            foreach ($serie_id as $value2) {
                $this->almacenproductoserie_model->eliminar2($value2);
            }
        }
        /*         * *****************Inserto en el kardex************ */
        $datos_compania = $this->compania_model->obtener($this->somevar['compania']);
        $tipo_valorizacion = $datos_compania[0]->COMPC_TipoValorizacion;
        if ($tipo_valorizacion == 0)//FIFO
            $lotes = $this->almaprolote_model->listarFIFO($almacenproducto_id);
        elseif ($tipo_valorizacion == 1)//LIFO
            $lotes = $this->almaprolote_model->listarLIFO($almacenproducto_id);
        $qlotes = count($lotes);
        $cantidad1 = $cantidad;
        if (count($lotes) > 0) {
            foreach ($lotes as $indice => $value) {
                $almacenprodlote_id = $value->ALMALOTP_Codigo;
                $almacenproducto_id = $value->ALMPROD_Codigo;
                $lote_id = $value->LOTP_Codigo;
                $anterior = $value->ALMALOTC_Cantidad;
                $costo_anterior = $value->ALMALOTC_Costo;
                if ($cantidad1 >= $anterior) {
                    if ($qlotes == $indice + 1) {
                        $cantidad_total = $cantidad1;
                        $kecho = 1;
                    } else {
                        $cantidad_total = $anterior;
                        $cantidad1 = $cantidad1 - $anterior;
                        $kecho = 0;
                    }
                } else {
                    $cantidad_total = $cantidad1;
                    $kecho = 1;
                }
                //Saco cantidad del lote
                // $this->lote_model->disminuir($lote_id,$cantidad_total); // LUIS 05/12/2012: La cantidad original del lote debería mantenerse, la cantidad actual solo la debe controlar la tabla almaprolote
                $this->firephp->fb($almacenproducto_id, $lote_id, $cantidad_total, 'ultimo');
                $this->almaprolote_model->disminuir2($almacenproducto_id, $lote_id, $cantidad_total);
                if ($cantidad_total != 0) {
                    $filter2 = new stdClass();
                    $filter2->PROD_Codigo = $producto_id;
                    $filter2->DOCUP_Codigo = 6;
                    $filter2->TIPOMOVP_Codigo = $motivo_mov;
                    $filter2->KARDC_CodigoDoc = $guia_id;
                    $filter2->KARD_Fecha = $fecha;
                    $filter2->KARDC_Cantidad = $cantidad_total;
                    $filter2->KARDC_Costo = $costo_anterior;
                    $filter2->KARDC_CostoPromedio = $costo;
                    $filter2->LOTP_Codigo = $lote_id;
                    $this->kardex_model->insertar(6, $filter2);
                    if ($kecho == 1)
                        break;
                }
            }
        }
        //30072013 el kardek se mueve si necesidad de que tenga un lote
        else {
            $filter2 = new stdClass();
            $filter2->PROD_Codigo = $producto_id;
            $filter2->DOCUP_Codigo = 6;
            $filter2->TIPOMOVP_Codigo = $motivo_mov;
            $filter2->KARDC_CodigoDoc = $guia_id;
            $filter2->KARD_Fecha = $fecha;
            $filter2->KARDC_Cantidad = $cantidad_total;
            $filter2->KARDC_Costo = $costo_anterior;
            $filter2->KARDC_CostoPromedio = $costo;
            $filter2->LOTP_Codigo = $lote_id;
            $this->kardex_model->insertar(6, $filter2);
        }
        //fin 30072013
    }
	
	public function insertar_dsnot(stdClass $filter = null){
		
        $this->db->insert("cji_guiasadetalle",(array)$filter);
        $guia_id     = $filter->GUIASAP_Codigo;
        $producto_id = $filter->PRODCTOP_Codigo;
        $umedida_id  = $filter->UNDMED_Codigo;
        $cantidad    = $filter->GUIASADETC_Cantidad;
        $costo       = $filter->GUIASADETC_Costo;
        $guia        = $this->guiasa_model->obtener($guia_id);
        $fecha       = $guia->GUIASAC_FechaRegistro;
        $motivo_mov  = $guia->TIPOMOVP_Codigo;
        $almacen_id  = $guia->ALMAP_Codigo;
		
        $productoundad = $this->productounidad_model->obtener($producto_id,$umedida_id);
        if($productoundad){
            $flagPrincipal = $productoundad->PRODUNIC_flagPrincipal;
            $factor        = $productoundad->PRODUNIC_Factor;
            if($flagPrincipal==0){
                $cantidad = $cantidad/$factor;
            }
        }
        /*Relaciono la guiasa con las series*/
        if($filter->GUIASADETC_GenInd=="I"){
            $arrserie = array();
            $serie_id = array();
            if(isset($_SESSION['serie'][$producto_id]) && is_array($_SESSION['serie'][$producto_id])){
                foreach($_SESSION['serie'][$producto_id] as $value){
                   $serie_id[] = $value;
                   $filter5=new stdClass();
                   $filter5->SERIP_Codigo=$value;
                   $filter5->SERMOVP_TipoMov='2';
                   $filter5->GUIASAP_Codigo=$guia_id;
                   $this->seriemov_model->insertar($filter5);
                }
            }
        }
        /*Saco en el almacen*/
        $almacenproducto_id = $this->almacenproducto_model->aumentar($almacen_id,$producto_id,$cantidad,$costo);
		
        /*Saco series del almacen si fuese necesario*/
        if($filter->GUIASADETC_GenInd=="I"){
            foreach($serie_id as $value2){
                $this->almacenproductoserie_model->eliminar2($value2);
            }
        }
        /*******************Inserto en el kardex*************/
        $datos_compania     = $this->compania_model->obtener($this->somevar['compania']);
        $tipo_valorizacion  = $datos_compania[0]->COMPC_TipoValorizacion;
        if($tipo_valorizacion==0)//FIFO
            $lotes       = $this->almaprolote_model->listarFIFO($almacenproducto_id);
        elseif($tipo_valorizacion==1)//LIFO
            $lotes       = $this->almaprolote_model->listarLIFO($almacenproducto_id);
        $qlotes    = count($lotes);
        $cantidad1 = $cantidad;
        if(count($lotes)>0){
            foreach ($lotes as $indice=>$value){
                $almacenprodlote_id = $value->ALMALOTP_Codigo;
                $almacenproducto_id = $value->ALMPROD_Codigo;
                $lote_id            = $value->LOTP_Codigo;
                $anterior           = $value->ALMALOTC_Cantidad;
                $costo_anterior     = $value->ALMALOTC_Costo;
                if($cantidad1>=$anterior){
                    if($qlotes==$indice+1){
                       $cantidad_total = $cantidad1;
                       $kecho=1;
                    }
                    else{
                       $cantidad_total = $anterior;
                       $cantidad1      = $cantidad1 - $anterior;
                       $kecho=0;
                    }
                }
                else{
                    $cantidad_total = $cantidad1;
                    $kecho=1;
                }
                //Saco cantidad del lote
               // $this->lote_model->disminuir($lote_id,$cantidad_total); // LUIS 05/12/2012: La cantidad original del lote debería mantenerse, la cantidad actual solo la debe controlar la tabla almaprolote
                $this->almaprolote_model->aumentar($almacenproducto_id,$lote_id,$cantidad_total,'');
                if($cantidad_total!=0){
                    $filter2     = new stdClass();
                    $filter2->PROD_Codigo          = $producto_id;
                    $filter2->DOCUP_Codigo         = 6;
                    $filter2->TIPOMOVP_Codigo      = $motivo_mov;
                    $filter2->KARDC_CodigoDoc      = $guia_id;
                    $filter2->KARD_Fecha           = $fecha;
                    $filter2->KARDC_Cantidad       = $cantidad_total;
                    $filter2->KARDC_Costo          = $costo_anterior;
                    $filter2->KARDC_CostoPromedio  = $costo;
                    $filter2->LOTP_Codigo          = $lote_id;
                    $this->kardex_model->insertar_dsnto(6,$filter2);
                    if($kecho==1) break;
                }
            }
        }
    }
	
    public function modificar($id,$filter){
        $this->db->where("GUIASADETP_Codigo",$id);
        $this->db->update("cji_guiasadetalle",(array)$filter);
    }
    public function eliminar($id)
    {
        $this->db->delete('cji_guiasadetalle', array('GUIASADETP_Codigo' => $id));
    }
     public function eliminar2($id)
     {
         /*Elimino registros del kardex */
         $datos_guia   = $this->guiasa_model->obtener($id);
         $almacen_id   = $datos_guia->ALMAP_Codigo;
         $datos_kardex = $this->kardex_model->obtener('6',$id);
         if(count($datos_kardex)>0){
             foreach($datos_kardex as $value){
                 $lote_id     = $value->LOTP_Codigo;
                 $cantidad    = $value->KARDC_Cantidad;
                 $producto_id = $value->PROD_Codigo;
                 $costo       = $value->KARDC_Costo;
                 $datos_almacenproducto = $this->almacenproducto_model->obtener($almacen_id,$producto_id);
                 $almacenproducto_id    = $datos_almacenproducto->ALMPROD_Codigo;
                 $this->almaprolote_model->aumentar($almacenproducto_id,$lote_id,$cantidad,$costo);
                 $this->kardex_model->eliminar2('6',$id,$producto_id);
                 //$this->lote_model->aumentar($lote_id,$cantidad); // LUIS 05/12/2012: La cantidad original del lote debería mantenerse, la cantidad actual solo la debe controlar la tabla almaprolote
             }
         }
         /*Aumento stock del almacen
          * Aumento almacenproductoserie si fuera el caso
          */
         
         $lista = $this->obtener2($id);
         if(count($lista)>0){
             foreach($lista as $value){
                $producto_id = $value->PRODCTOP_Codigo;
                $cantidad    = $value->GUIASADETC_Cantidad;
                $costo       = $value->GUIASADETC_Costo;
                $this->almacenproducto_model->aumentar($almacen_id,$producto_id,$cantidad,$costo);
                
                $datos_almacenproducto = $this->almacenproducto_model->obtener($almacen_id,$producto_id);
                $almacenproducto_id    = $datos_almacenproducto->ALMPROD_Codigo;
                
                $lista_series=$this->serie_model->listar_x_codigodoc($producto_id, '2', $id);
                if(count($lista_series)>0){
                    foreach($lista_series as $serie){
                        $this->almacenproductoserie_model->insertar($almacenproducto_id,$serie->SERIP_Codigo);
                        $this->seriemov_model->eliminar($serie->SERMOVP_Codigo);  //Elimino el movimiento de la salida de la serie, pero ya no la serie, pues se supone hay un movimiento de ingreso que justifica su existencia
                    }
                }
             }
         }
         /*Elimino registros del detalle*/
         $this->db->delete('cji_guiasadetalle', array('GUIASAP_Codigo' => $id));
     }
}
?>