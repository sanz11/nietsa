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
  
  public function seleccionar(){
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
  public function selecionarPedido(){

  }////
 public function UpdatEstado($pedido,$P){
  $data = array('PEDIC_FlagEstado' => 1,'PEDI_Estado' =>$P);
  $this->db->where("PEDIP_Codigo",$pedido);
  $this->db->update("cji_pedido",$data);
}
public function updatePedido($pedido){
  $data = array('PEDIC_FlagEstado' => 1,'PEDI_Estado' =>'4');
  $this->db->where("PEDIP_Codigo",$pedido);
  $this->db->update("cji_pedido",$data);
}
public function finalisar_pedido($pedido){
   $data = array('PEDIC_FlagCotizado' => '1');
  $this->db->where("PEDIP_Codigo",$pedido);
  $this->db->update("cji_pedido",$data);
}
public function updateSolicitudCotizacion($pedido){
   $data = array('PRESUP_Estado' =>'4');
  $this->db->where("PRESUP_Codigo",$pedido);
  $this->db->update("cji_presupuesto",$data);
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

  function listar_pedidos2($number_items='',$offset=''){
        $compania = $this->somevar['compania'];
        $this->db->select('*');
        $this->db->from('cji_pedido',$number_items,$offset);
        $this->db->join('cji_centrocosto','cji_pedido.CENCOST_Codigo = cji_centrocosto.CENCOSP_Codigo','left');
        $this->db->where('cji_pedido.COMPP_Codigo',$compania);
        $this->db->where('PEDIC_FlagEstado','1');
        $this->db->where('PEDI_Estado','1');
        $this->db->or_where('PEDI_Estado','2');
        $this->db->or_where('PEDI_Estado','4');
        $this->db->where_not_in('PEDI_Estado','3');
        $this->db->where('PEDIC_FlagCotizado','0');
        $query = $this->db->get();
        if($query->num_rows>0){
      foreach($query->result() as $fila){
        $data[] = $fila;
      }
      return $data;
        }     

  }
  public function getPedigoCliente($codigo){
    $this->db->select('*');
    $this->db->where('CLIP_Codigo',$codigo);
    $this->db->where_not_in('PEDI_Estado','0');  
    $this->db->where_not_in('PEDIC_FlagCotizado','1');  
    $this->db->where_not_in('PEDI_Estado','3');  
    $query = $this->db->get('cji_pedido');
    if($query->num_rows()>0){
      foreach($query->result() as $fila){
        $data[] = $fila;
      }
      return $data;
    }  
  }
  public function verificarSiYaSeCompleto($codi){
        $this->db->select('cp.PRESUP_Codigo,cp.PRESUC_FlagEstado,
          cp.PRESUP_Estado,p.PEDIP_Codigo');
        $this->db->join('cji_presupuesto cp','cp.PEDIP_Codigo=p.PEDIP_Codigo');
        $this->db->where('cp.CPC_TipoOperacion ','S');       
        //$this->db->where('cp.PEDIP_Codigo',$codi);
        $query = $this->db->get('cji_presupuesto p');
        if($query->num_rows>0){
         foreach($query->result() as $fila){
        $data[] = $fila;
      }
      return $data;
        } 
  }

  function listar_pedidos($number_items='',$offset=''){
            $compania = $this->somevar['compania'];
        $this->db->select('*');
        $this->db->from('cji_pedido',$number_items,$offset);
        $this->db->join('cji_centrocosto','cji_pedido.CENCOST_Codigo = cji_centrocosto.CENCOSP_Codigo','left');
        $this->db->where('cji_pedido.COMPP_Codigo',$compania);
        $this->db->where('PEDIC_FlagEstado','2');

        $this->db->or_where('PEDIC_FlagEstado','1');//COMETAR
        $this->db->where_not_in('PEDIC_FlagCotizado','1');
        $this->db->where_not_in('PEDI_Estado','3');
        $query = $this->db->get();
        if($query->num_rows>0){
      foreach($query->result() as $fila){
        $data[] = $fila;
      }
      return $data;
        }     

  } 
  function listar_pedidos_todos($number_items='',$offset='',$filter='')
        {
            $compania = $this->somevar['compania'];
		
		/*inner JOIN cji_moneda m ON m.MONED_Codigo=p.MONED_Codigo */
		
		 $sql = " SELECT p.*,CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) as nombre,PROYC_Nombre,MONED_Simbolo
		 from cji_pedido p
        inner join cji_cliente cl on cl.CLIP_Codigo = p.CLIP_Codigo
        inner join cji_persona pe on pe.PERSP_Codigo = cl.PERSP_Codigo
		inner join cji_proyecto pr on pr.PROYP_Codigo = p.PROYP_Codigo
		inner JOIN cji_moneda m ON m.MONED_Codigo = p.MONED_Codigo 
		WHERE p.COMPP_Codigo='".$compania."'
		
        UNION 
		SELECT p.* ,EMPRC_RazonSocial as nombre,PROYC_Nombre,MONED_Simbolo
		from cji_pedido p
        inner join cji_cliente cl on cl.CLIP_Codigo = p.CLIP_Codigo
        inner join cji_empresa es on es.EMPRP_Codigo = cl.EMPRP_Codigo
		inner join cji_proyecto pr on pr.PROYP_Codigo = p.PROYP_Codigo
		inner JOIN cji_moneda m ON m.MONED_Codigo = p.MONED_Codigo 
		WHERE p.COMPP_Codigo='".$compania."'";

      $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        return array();
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
public function listar_proveedores_pedido2($pedido){
  //en esta ocacion solo traera las empresas no las persosnas asi que a esperar
 $sql= 'SELECT * FROM cji_presupuesto p
JOIN cji_proveedor pr on pr.PROVP_Codigo=p.PROVP_Codigo
JOIN cji_empresa e on pr.EMPRP_Codigo = e.EMPRP_Codigo
WHERE CPC_TipoOperacion="C" AND PEDIP_Codigo ='.$pedido.' ORDER BY PRESUP_Codigo DESC';
 $query = $this->db->query($sql);
 if($query->num_rows()>0){
      foreach($query->result() as $fila){
        $data[] = $fila;
      }
      return $data;
        }
}
  function buscar_producto_proveedor_pedido($producto,$unidad,$proveedor,$pedido){
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
  function cliente_codigo_pedido($pedido){
    $this->db->select('CLIP_Codigo,PEDIP_Codigo');
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
    if($query->num_rows()>0){
      foreach($query->result() as $fila){
        $data[] = $fila;
      }
      return $data;
    }
    }
  public function getPedigoCodigo($pedido){
    $this->db->select('PEDIP_Codigo');
    $where = array("PEDIP_Codigo"  => $pedido,"PEDIC_FlagEstado" => "1");
    $query = $this->db->where($where)->get('cji_pedido');
    if($query->num_rows()>0){
      foreach($query->result() as $fila){
        $data[] = $fila;
      }
      return $data;
    }
   } 
  function insertar_pedido($centro_costo,$numero_documento,$nombre_pedido,$tipo_pedido,$tipo_documento,$num_refe,$observacion, $cliente, $fecha, $hora, $contacto){
      $compania = $this->somevar['compania'];
      $usuario =  $this->somevar['usuario'];
  
  // $fecha = date('Y-m-d h:i:s');
      $data = array(
        'PEDIC_Numero' => $numero_documento,
        'CENCOST_Codigo' => $centro_costo,
        'USUA_Codigo' => $usuario,
        'USUA_Responsable' => $usuario,
        'CLIP_Codigo'=> $cliente,
        'ECONP_Contacto' => $contacto,
        'PEDIC_Observacion' => $nombre_pedido,
        'PEDIC_FechaRegistro' => $fecha." ".$hora,
        'COMPP_Codigo' => $compania,
        'DOCUP_Codigo' => $tipo_documento,
        'PEDIC_NumRefe' => $num_refe,
        'PEDIC_Tipo' => $tipo_pedido,
        'PEDIC_Observacion_otro' => $observacion,
        'PEDIC_FlagEstado' => 2
      );
      $this->db->insert("cji_pedido",$data);
    return $this->db->insert_id();
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
    public function traerNumeroDoc(){

         $this->db->select_max('PEDIC_Numero');
        $query = $this->db->get('cji_pedido');   

         foreach($query->result() as $fila){
        $data[] = $fila;
      }
      return $data;
    }
	public function traerSerieDoc(){

         $this->db->select_max('PEDIC_Serie');
        $query = $this->db->get('cji_pedido');   

         foreach($query->result() as $fila){
        $data[] = $fila;
      }
      return $data;
    }
}
?>