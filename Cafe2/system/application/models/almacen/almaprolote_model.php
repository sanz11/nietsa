<?php
class Almaprolote_Model extends Model
{
    protected $_name = "cji_almaprolote";
    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('maestros/compania_model');
        $this->load->model('almacen/lote_model');
        $this->somevar['compania'] = $this->session->userdata('compania');
    }
    public function listarFIFO($almacenproducto_id)//lotes
    {
        $where = array("ALMPROD_Codigo"=>$almacenproducto_id,"COMPP_Codigo"=>$this->session->userdata('compania'));
        $query = $this->db->where($where)->order_by("ALMALOTP_Codigo")->get('cji_almaprolote');
        if($query->num_rows>0){
           return $query->result();
        }
    }
    public function listarLIFO($almacenproducto_id)//lotes
    {
        $where = array("ALMPROD_Codigo"=>$almacenproducto_id,"COMPP_Codigo"=>$this->session->userdata('compania'));
        $query = $this->db->where($where)->order_by("ALMALOTP_Codigo","desc")->get('cji_almaprolote');
        if($query->num_rows>0){
           return $query->result();
        }
    }
    public function obtener($almacenproducto_id,$lote_id)
    {
        $where = array("ALMPROD_Codigo"=>$almacenproducto_id,"COMPP_Codigo"=>$this->somevar['compania'],"LOTP_Codigo"=>$lote_id);
        $query = $this->db->where($where)->get('cji_almaprolote');
        if($query->num_rows>0){
          return $query->result();
        }
    }
    public function aumentar($almacenproducto_id,$lote_id,$cantidad,$costo)
    {
        $filter                    = new stdClass();
        $filter->COMPP_Codigo      = $this->somevar['compania'];
        $filter->ALMPROD_Codigo    = $almacenproducto_id;
        $filter->LOTP_Codigo       = $lote_id;
        $stock                     = $this->obtener($almacenproducto_id,$lote_id);
        if(count($stock)>0){//Esto corresponde a una devolucion de mercaderias.
            unset($filter->COMPP_Codigo);
            unset($filter->ALMPROD_Codigo);
            unset($filter->LOTP_Codigo);
            $cantidad_anterior         = $stock[0]->ALMALOTC_Cantidad;
            $almacenprodlote_id        = $stock[0]->ALMALOTP_Codigo;
            $filter->ALMALOTC_Cantidad = $cantidad_anterior + $cantidad;
            $filter->ALMALOTC_Costo    = $costo;
            $this->db->where("ALMALOTP_Codigo",$almacenprodlote_id);
            $this->db->update("cji_almaprolote",(array)$filter);
        }
        else{
            $filter->ALMALOTC_Cantidad = $cantidad;
            $filter->ALMALOTC_Costo    = $costo;
            $this->db->insert("cji_almaprolote",(array)$filter);
        }
    }
    public function disminuir($almacenproducto_id,$cantidad)
    {
        $datos_compania    = $this->compania_model->obtener($this->somevar['compania']);
        $tipo_valorizacion = $datos_compania[0]->COMPC_TipoValorizacion;
        if($tipo_valorizacion==0)//FIFO
            $lotes       = $this->listarFIFO($almacenproducto_id);
        elseif($tipo_valorizacion==1)
            $lotes       = $this->listarLIFO($almacenproducto_id);
        $qlotes = count($lotes);
        if(count($lotes)>0){
            foreach ($lotes as $indice=>$value){
                $almacenprodlote_id = $value[$indice]->ALMALOTP_Codigo;
                $almacenproducto_id = $value[$indice]->ALMPROD_Codigo;
                $lote_id            = $value[$indice]->LOTP_Codigo;
                $anterior           = $value[$indice]->ALMALOTC_Cantidad;
                $costo_anterior     = $value[$indice]->ALMALOTC_Costo;
                if($anterior>0){
                    if($cantidad>=$anterior){
                        if($qlotes>$indice+1){
                            $cantidad = $cantidad - $anterior;
                            $this->db->where("ALMALOTP_Codigo",$almacenprodlote_id);
                            $this->db->delete("cji_almaprolote");
                        }
                        else{
                            $cantidad_total = $anterior - $cantidad;
                            $filter  = new stdClass();
                            $filter->ALMALOTC_Cantidad = $cantidad_total;
                            $filter->ALMALOTC_Costo    = $costo_anterior;
                            $this->db->where("ALMALOTP_Codigo",$almacenprodlote_id);
                            $this->db->update("cji_almaprolote",(array)$filter);
                        }
                    }
                    else{
                        $cantidad_total     = $anterior - $cantidad;
                        $filter  = new stdClass();
                        $filter->ALMALOTC_Cantidad = $cantidad_total;
                        $filter->ALMALOTC_Costo    = $costo_anterior;
                        $this->db->where("ALMALOTP_Codigo",$almacenprodlote_id);
                        $this->db->update("cji_almaprolote",(array)$filter);
                        break;
                    }
                }
                else{
                    if($qlotes==$indice+1){
                        $cantidad_total     = $anterior - $cantidad;
                        $filter  = new stdClass();
                        $filter->ALMALOTC_Cantidad = $cantidad_total;
                        $filter->ALMALOTC_Costo    = $costo_anterior;
                        $this->db->where("ALMALOTP_Codigo",$almacenprodlote_id);
                        $this->db->update("cji_almaprolote",(array)$filter);
                    }
                }
            }
        }
    }
    public function disminuir2($almacenproducto_id,$lote_id,$cantidad)
    {
        $datos_almacenproducto = $this->obtener($almacenproducto_id,$lote_id);
        $almacenprolote_id = $datos_almacenproducto[0]->ALMALOTP_Codigo;
        $cantidad_inicial  = $datos_almacenproducto[0]->ALMALOTC_Cantidad;
        $filter = new stdClass();
        $filter->ALMALOTC_Cantidad = $cantidad_inicial-$cantidad;
        $this->db->where("ALMALOTP_Codigo",$almacenprolote_id);
        $this->db->update("cji_almaprolote",(array)$filter);
    }
    public function eliminar($almacenproducto_id,$lote_id)
    {
        $this->db->delete('cji_almaprolote', array('ALMPROD_Codigo' => $almacenproducto_id,'LOTP_Codigo' => $lote_id));
    }
}
?>