<?php
class Productoprecio2_Model extends Model
{
    protected $_name = "cji_productoprecio2";
    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario']  = $this->session->userdata('user');
    }
    public function seleccionar($producto, $moneda=2)
    {
        $arreglo = array(''=>':: Seleccione ::');
        $lista = $this->listar($producto, $moneda=2);
        if(count($lista)>0){
            foreach($lista as $indice=>$valor)
            {   $indice1   = $valor->PRODPREP2_Codigo;
                $valor1    = $valor->MONED_Simbolo.' '.$valor->PRODPREC2_Precio;
                $arreglo[$indice1] = $valor1;
            }
        }
        return $arreglo;
    } 
    public function listar($producto, $moneda=2)
    {
        $where = array("PROD_Codigo"=>$producto, 'COMPP_Codigo'=>$this->somevar['compania'], 'MONED_Codigo'=>$moneda, 'PRODPREC2_FlagEstado'=>'1');
        $query = $this->db->where($where)->order_by('PRODPREP2_Tipo')->join('cji_moneda m', 'm.MONED_Codigo=p.MONED_Codigo')->select('p.*, m.MONED_Simbolo')->get('cji_productoprecio2 p');
        if($query->num_rows>0){
            return $query->result();
        }
        else
            return array();
    }
    
     
    public function insertar(stdClass $filter = null)
    {
        $this->db->insert("cji_guiatransdetalle",(array)$filter);
    }
  
}
?>