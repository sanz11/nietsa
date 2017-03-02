<?php
class Pedido_model extends Model{
    var $somevar;
  function __construct()
        {
            parent::__construct();
            $this->load->database();
            $this->load->helper('date');
            $this->load->model('mantenimiento_model');
            $this->somevar ['compania'] = $this->session->userdata('compania');
            $this->somevar ['usuario']    = $this->session->userdata('user');
            $this->somevar['hoy']              = mdate("%Y-%m-%d %h:%i:%s",time());
  }
  
  public function seleccionar()
  {
      $arreglo = array(''=>':: Seleccione ::');
      $lista = $this->listar_pedidos();
      if(count($lista)>0){
          foreach($lista as $indice=>$valor)
          {   $indice1   = $valor->PEDIP_Codigo;
              $valor1    = $valor->PEDIC_Numero." ".$valor->PEDIC_Observacion." [".$valor->PEDIC_Tipo.']';                
              $arreglo[$indice1] = $valor1;
          }
      }
      return $arreglo;
  }
  
  public function seleccionar_finalizados()
  {
      $arreglo = array(''=>':: Seleccione ::');
      $lista = $this->listar_pedidos_finalizados();
      if(count($lista)>0){
          foreach($lista as $indice=>$valor)
          {   $indice1   = $valor->PEDIP_Codigo;
              $valor1    = $valor->PEDIC_Numero." ".$valor->PEDIC_Observacion." [".$valor->PEDIC_Tipo.']';                
              $arreglo[$indice1] = $valor1;
          }
      }
      return $arreglo;
  }
  
  function listar_pedidos($number_items='',$offset=''){
            $compania = $this->somevar['compania'];
    $this->db->select('*');
        $this->db->from('cji_pedido',$number_items,$offset);
        $this->db->join('cji_centrocosto','cji_pedido.CENCOST_Codigo = cji_centrocosto.CENCOSP_Codigo','left');
        $this->db->where('cji_pedido.COMPP_Codigo',$compania);
        $this->db->where('PEDIC_FlagEstado',1);
        $query = $this->db->get();
        if($query->num_rows>0){
      foreach($query->result() as $fila){
        $data[] = $fila;
      }
      return $data;
        }     

  }
  
  function listar_pedidos_todos($number_items='',$offset='')
        {
            $compania = $this->somevar['compania'];
            
/*      
      $where = array("COMPP_Codigo"=>$compania,"PEDIC_FlagEstado"=>"1");
            $query = $this->db->order_by('PEDIC_Numero','desc')->where($where)->get('cji_pedido',$number_items,$offset)
      ->join('cji_centrocosto','cji_pedido.CENCOSP_Codigo = cji_centrocosto.CENCOSP_Codigo','left');
            if($query->num_rows>0){
                foreach($query->result() as $fila){
                    $data[] = $fila;
                }
                return $data;
            }
      
      
*/      
      
      
    $this->db->select('*');
        $this->db->from('cji_pedido',$number_items,$offset);
        $this->db->join('cji_centrocosto','cji_pedido.CENCOST_Codigo = cji_centrocosto.CENCOSP_Codigo','left');
        $this->db->where('cji_pedido.COMPP_Codigo',$compania);
        $query = $this->db->get();
        if($query->num_rows>0){
      foreach($query->result() as $fila){
        $data[] = $fila;
      }
      return $data;
        }     

  }
  
  function listar_pedidos_finalizados($number_items='',$offset='')
        {
          
    $compania = $this->somevar['compania'];
      
    $this->db->select('*');
        $this->db->from('cji_pedido',$number_items,$offset);
        $this->db->join('cji_centrocosto','cji_pedido.CENCOST_Codigo = cji_centrocosto.CENCOSP_Codigo','left');
        $this->db->where('cji_pedido.COMPP_Codigo',$compania);
        $this->db->where('PEDIC_FlagEstado',0);
        $query = $this->db->get();
        if($query->num_rows>0){
      foreach($query->result() as $fila){
        $data[] = $fila;
      }
      return $data;
        }     

  }
  
  function listar_proveedores_pedido($pedido){
    $this->db->select('*');
        $this->db->from('cji_presupuesto');
        $this->db->join('cji_proveedor','cji_presupuesto.PROVP_Codigo = cji_proveedor.PROVP_Codigo','left');
        $this->db->join('cji_formapago','cji_formapago.FORPAP_Codigo = cji_presupuesto.FORPAP_Codigo','left');
        $this->db->join('cji_empresa','cji_proveedor.EMPRP_Codigo = cji_empresa.EMPRP_Codigo','left');
        $this->db->where('CPC_TipoOperacion','C');
        $this->db->where('PEDIP_Codigo  ',$pedido);
        $this->db->order_by('PEDIP_Codigo','RANDOM');
    $this->db->limit('3');
        $query = $this->db->get();
        if($query->num_rows>0){
      foreach($query->result() as $fila){
        $data[] = $fila;
      }
      return $data;
        } 
  }
  
  function buscar_producto_proveedor_pedido($producto,$unidad,$proveedor,$pedido)
  {
    if($producto != '' AND $unidad != '' AND $proveedor != '' AND $pedido!='')
    {
      $sql = 'SELECT * FROM cji_presupuestodetalle 
      JOIN cji_presupuesto USING(PRESUP_Codigo) 
      JOIN cji_unidadmedida USING (UNDMED_Codigo) 
      WHERE PEDIP_Codigo = '.$pedido.' AND PROD_Codigo = '.$producto.' AND UNDMED_Codigo = '.$unidad.' AND PROVP_Codigo='.$proveedor;
      $query = $this->db->query($sql);
      if($query->num_rows>0){
        foreach($query->result() as $fila){
          $data[] = $fila;
        }
        return $data;
      }
    }else{
      return array();
    }
  }
  
  function listar_total_productos_pedido($pedido){
    $sql = 'SELECT * FROM cji_presupuestodetalle 
        LEFT JOIN cji_producto ON cji_presupuestodetalle.PROD_Codigo = cji_producto.PROD_Codigo 
        JOIN cji_unidadmedida USING (UNDMED_Codigo) 
        WHERE PRESUP_Codigo IN 
        (SELECT PRESUP_Codigo FROM cji_presupuesto WHERE CPC_TipoOperacion="C" AND PEDIP_Codigo='.$pedido.')
        GROUP BY cji_presupuestodetalle.PROD_Codigo';

    $query = $this->db->query($sql);
    if($query->num_rows>0){
      foreach($query->result() as $fila){
        $data[] = $fila;
      }
      return $data;
    }
  }
  
    function obtener_pedido($pedido){
        $query = $this->db->where('PEDIP_Codigo',$pedido)->get('cji_pedido');
    if($query->num_rows>0){
      foreach($query->result() as $fila){
        $data[] = $fila;
      }
      return $data;
    }
    }
  
  function cerrar_pedido($pedido){
      $data = array(
        'PEDIC_FlagEstado' => 0
    );
      $this->db->where("PEDIP_Codigo",$pedido);
      $this->db->update("cji_pedido",$data);
  }
  
  
    function obtener_detalle_pedido($pedido){
         $where = array("PEDIP_Codigo"  => $pedido,"PEDIDETC_FlagEstado" => "1");
        $query = $this->db->where($where)->get('cji_pedido');
    if($query->num_rows>0){
      foreach($query->result() as $fila){
        $data[] = $fila;
      }
      return $data;
    }
    }
    function insertar_pedido($centro_costo,$numero_documento,$observacion,$tipo_pedido,$tipo_documento,$num_refe){
      $compania = $this->somevar['compania'];
      $usuario =  $this->somevar['usuario'];
      $fecha = date('Y-m-d h:i:s');
      $data = array(
        'PEDIC_Numero' => $numero_documento,
        'CENCOST_Codigo' => $centro_costo,
        'USUA_Codigo' => $usuario,
        'USUA_Responsable' => $usuario,
        'PEDIC_Observacion' => $observacion,
        'PEDIC_FechaRegistro' => $fecha,
        'COMPP_Codigo' => $compania,
        'DOCUP_Codigo' => $tipo_documento,
        'PEDIC_NumRefe' => $num_refe,
        'PEDIC_Tipo' => $tipo_pedido
      );
      $this->db->insert("cji_pedido",$data);
    return $this->db->insert_id();
    }
    function insertar_detalle_pedido(){

    }
    function modificar_pedido($pedido,$centro_costo,$numero_documento,$observacion,$tipo_pedido,$tipo_documento,$num_refe){
      $compania = $this->somevar['compania'];
      $usuario =  $this->somevar['usuario'];
      $fecha = date('Y-m-d h:i:s');
      $data = array(
        'PEDIC_Numero' => $numero_documento,
        'CENCOST_Codigo' => $centro_costo,
        'USUA_Codigo' => $usuario,
        'USUA_Responsable' => $usuario,
        'PEDIC_Observacion' => $observacion,
        'PEDIC_FechaModificacion' => $fecha,
        'COMPP_Codigo' => $compania,
    'DOCUP_Codigo' => $tipo_documento,
        'PEDIC_NumRefe' => $num_refe,
        'PEDIC_Tipo' => $tipo_pedido
      );
      $this->db->where("PEDIP_Codigo",$pedido);
      $this->db->update("cji_pedido",$data);
    }
    /*function eliminar_pedido($pedido){
    $data      = array("PEDIC_FlagEstado"=>'0');
    $where = array("PEDIP_Codigo"=>$pedido);
    $this->db->where($where);
    $this->db->update('cji_pedido',$data);
    $data      = array("PEDIDETC_FlagEstado"=>'0');
    $where = array("PEDIP_Codigo"=>$pedido);
    $this->db->where($where);
    $this->db->update('cji_pedidodetalle',$data);
    }*/
  function eliminar_pedido($pedido){
    $this->db->where('cji_pedido.PEDIP_Codigo', $pedido);
        $this->db->delete('cji_pedido');
    }
    function eliminar_producto_pedido($detalle_pedido){
    $data      = array("PEDIDETC_FlagEstado"=>'0');
    $where = array("PEDIDETP_Codigo"=>$detalle_pedido);
    $this->db->where($where);
    $this->db->update('cji_pedidodetalle',$data);
    }
}
?>