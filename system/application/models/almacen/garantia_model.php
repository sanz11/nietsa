<?php
class Garantia_Model extends Model
{
    protected $_name = "cji_garantia";
    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function seleccionar()
    {
        $arreglo = array('0'=>':: Seleccione ::');
        if(count($this->listar())>0){
            foreach($this->listar() as $indice=>$valor)
            { 
                $indice1   = $valor->MARCP_Codigo;
                $valor1    = $valor->MARCC_Descripcion;
                $arreglo[$indice1] = $valor1;
            }
        }
        return $arreglo;
    }
     public function listar($number_items='',$offset='')
     {
         $this->db->select('cji_garantia.GARAN_Codigo,cji_garantia.CLIP_Codigo,
             cji_garantia.GARAN_Descripcion
            ,cji_garantia.GARAN_DescripcionFalla,cji_garantia.GARAN_FechaRegistro,
            cji_producto.PROD_Nombre,cji_garantia.GARAN_Estado,cji_empresa.EMPRC_RazonSocial');
          $this->db->from('cji_garantia');
          $this->db->join('cji_producto','cji_producto.PROD_Codigo=cji_garantia.PROD_Codigo');
          $this->db->join('cji_cliente','cji_cliente.CLIP_Codigo =cji_garantia.CLIP_Codigo');
           $this->db->join('cji_empresa','cji_empresa.EMPRP_Codigo=cji_cliente.EMPRP_Codigo');
          //$this->db->like('cji_contrato.CONTR_Descripcion',$descripcion);
          $this->db->order_by('cji_garantia.GARAN_FechaRegistro', 'asc');
		  $this->db->limit($number_items,$offset);
		  $query = $this->db->get();
          if($query->num_rows>0){
             return $query->result();
          } 
        
     }	 
     public function obtener($id)
     {
         $this->db->select('cji_garantia.GARAN_Codigo,cji_garantia.CLIP_Codigo,
             cji_garantia.GARAN_Descripcion
            ,cji_garantia.GARAN_DescripcionFalla,cji_garantia.CPP_Codigo,
            cji_garantia.GARAN_Nombrecontacto,cji_garantia.GARAN_Nextel,cji_garantia.GARAN_Telefono,
            cji_garantia.GARAN_Celular,cji_garantia.GARAN_Email,cji_garantia.GARAN_DescripcionAccesorios,cji_garantia.GARAN_FechaRegistro,
            GARAN_Comentario,cji_producto.PROD_Nombre,cji_garantia.GARAN_Estado,cji_empresa.EMPRC_RazonSocial');
          $this->db->from('cji_garantia');
          $where = array("GARAN_Codigo"=>$id);
          $this->db->join('cji_producto','cji_producto.PROD_Codigo=cji_garantia.PROD_Codigo');
          $this->db->join('cji_cliente','cji_cliente.CLIP_Codigo =cji_garantia.CLIP_Codigo');
           $this->db->join('cji_empresa','cji_empresa.EMPRP_Codigo=cji_cliente.EMPRP_Codigo');
          //$this->db->like('cji_contrato.CONTR_Descripcion',$descripcion);
         // $this->db->order_by('cji_garantia.GARAN_FechaRegistro', 'asc');
         // $this->db->limit($number_items,$offset);
              $query = $this->db->get();
             return $query->result();
         
         
         
     }
    public function insertar(stdClass $filter = null)
    {
        $this->db->insert($this->_name,(array)$filter);
        $id = $this->db->insert_id();
        return $id;
    }
    public function modificar($id,$filter)
    {
        $this->db->where("MARCP_Codigo",$id);
        $this->db->update($this->_name,(array)$filter);
    }
    public function eliminar($id)
    {
        $this->db->delete($this->_name, array('GARAN_Codigo' => $id));
    }
    public function buscar($filter,$number_items='',$offset='')
    {  
        $this->db->select('cji_garantia.GARAN_Codigo,cji_garantia.CLIP_Codigo,
             cji_garantia.GARAN_Descripcion,  
            ,cji_garantia.GARAN_DescripcionFalla,cji_garantia.GARAN_FechaRegistro,
            cji_producto.PROD_Nombre,cji_garantia.GARAN_Estado');
          $this->db->from('cji_garantia');
          $this->db->join('cji_producto','cji_producto.PROD_Codigo=cji_garantia.PROD_Codigo');
          $this->db->like('GARAN_Descripcion',$filter->GARAN_Descripcion,'right');
          $this->db->order_by('cji_garantia.GARAN_FechaRegistro', 'asc');
		  $this->db->limit($number_items,$offset);
		  $query = $this->db->get();
          if($query->num_rows>0){
             return $query->result();
          } 
        
       
    }
    public function buscar_por_nombre($filter)
    {
        $where = array("GRAN_FlagEstado"=>1,"GARAN_Codigo !="=>0);
        $this->db->where($where);
        if(isset($filter->GARAN_Descripcion) && $filter->GARAN_Descripcion!='')
            $this->db->where('GARAN_Descripcion',$filter->GARAN_Descripcion);
        $query = $this->db->get($this->_name,$number_items,$offset);
        if($query->num_rows>0){
                return $query->result();
        }
    }
}
?>