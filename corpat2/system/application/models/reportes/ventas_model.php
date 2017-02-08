<?php
class Ventas_Model extends Model
{

  public function __construct()
  {
      parent::__construct();
      $this->load->database();
      $this->load->helper('date');
      $this->somevar ['compania'] = $this->session->userdata('compania');
      $this->somevar ['usuario']  = $this->session->userdata('usuario');
      $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
  }
  
  public function ventas_por_vendedor_resumen($inicio,$fin)
  {
	  //SELECT SUM( IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total)) as VENTAS, p.PERSC_Nombre as NOMBRE, p.PERSC_ApellidoPaterno as PATERNO 
    $sql = "
	SELECT SUM( IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total)) as VENTAS, p.PERSC_Nombre as NOMBRE, p.PERSC_ApellidoPaterno as PATERNO ,p.PERSP_Codigo as Code
	FROM cji_persona p 
	LEFT JOIN cji_comprobante c ON c.CPC_Vendedor = p.PERSP_Codigo
	WHERE c.CPC_Fecha BETWEEN DATE('$inicio') AND DATE('$fin') GROUP BY Code ORDER BY 1 ASC
	
	";
    $query = $this->db->query($sql);
	
    
    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
    return $data;
  }
  
  public function ventas_por_vendedor_mensual($inicio,$fin)
  {
    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
    
    if($anioFin > $anioInicio)
    {
      $sql = " SELECT 
      p.PERSC_Nombre as NOMBRE,
      p.PERSC_ApellidoPaterno as PATERNO,
      ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
          for($i = 1; $i <= intval($mesFin); $i++)
          {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as m$j$i,";
          }
        }else if($j==$anioInicio){
          for($i = intval($mesInicio); $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as m$j$i,";
          }
        }else{
          for($i = 1; $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as m$j$i,";
          }
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      
      $sql.= "
      FROM cji_usuario u
      LEFT JOIN cji_comprobante c ON c.USUA_Codigo = u.USUA_Codigo 
      JOIN cji_persona p ON u.PERSP_Codigo = p.PERSP_Codigo 
      WHERE YEAR(c.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin'
      GROUP BY c.USUA_Codigo";
    
    }elseif($anioFin == $anioInicio){
      $sql = " SELECT 
      p.PERSC_Nombre as NOMBRE,
      p.PERSC_ApellidoPaterno as PATERNO,
      ";
      if($mesInicio == $mesFin)
      {
        $sql .= "SUM(IF(MONTH(CPC_Fecha)=".intval($mesInicio).",IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as m$anioFin".intval($mesInicio)."";
      }else{
        for($i = intval($mesInicio); $i <= intval($mesFin); $i++)
        {
          $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i,IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as m$anioFin$i,";
        }
        $sql = substr($sql,0,strlen($sql)-1);
      }
      
      $sql.= "
      FROM cji_usuario u
      LEFT JOIN cji_comprobante c ON c.USUA_Codigo = u.USUA_Codigo 
      LEFT JOIN cji_persona p ON u.PERSP_Codigo = p.PERSP_Codigo 
      WHERE YEAR(c.CPC_Fecha) = '$anioInicio'
      GROUP BY c.USUA_Codigo";
    }

    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
	
	return $data;
  }
  
  public function ventas_por_vendedor_anual($inicio,$fin)
  {
    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
    
    if($anioFin > $anioInicio)
    {
    
      $sql = " SELECT 
      p.PERSC_Nombre as NOMBRE,
      p.PERSC_ApellidoPaterno as PATERNO,
      ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
            $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as y$j,";
        }else{
            $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as y$j,";
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      
      $sql.= "
      FROM cji_usuario u
      LEFT JOIN cji_comprobante c ON c.USUA_Codigo = u.USUA_Codigo 
      JOIN cji_persona p ON u.PERSP_Codigo = p.PERSP_Codigo 
      WHERE YEAR(c.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin'
      GROUP BY c.USUA_Codigo";
    
    }elseif($anioFin == $anioInicio){
    
      $sql = " SELECT 
      p.PERSC_Nombre as NOMBRE,
      p.PERSC_ApellidoPaterno as PATERNO,
      ";
      $sql .= "SUM(IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total)) as y$anioFin ";
      $sql.= "
      FROM cji_usuario u
      LEFT JOIN cji_comprobante c ON c.USUA_Codigo = u.USUA_Codigo 
      LEFT JOIN cji_persona p ON u.PERSP_Codigo = p.PERSP_Codigo 
      WHERE YEAR(c.CPC_Fecha) = '$anioInicio'
      GROUP BY c.USUA_Codigo";
    }
	
    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
	
	return $data;
  }
  
  
  
  public function ventas_por_marca_resumen($inicio,$fin)
  {
    $sql = "SELECT 
    m.MARCC_Descripcion AS NOMBRE,
    SUM( IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total) ) AS VENTAS
    FROM cji_comprobantedetalle cd
    JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
    JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
    JOIN cji_marca m ON p.MARCP_Codigo = m.MARCP_Codigo
    WHERE c.CPC_Fecha BETWEEN DATE('$inicio') AND DATE('$fin') GROUP BY p.MARCP_Codigo";
    $query = $this->db->query($sql);
    
    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
    return $data;
  }
  
  public function ventas_por_marca_mensual($inicio,$fin)
  {
    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
    
    if($anioFin > $anioInicio)
    {
      $sql = "SELECT 
      m.MARCC_Descripcion AS NOMBRE,
      ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
          for($i = 1; $i <= intval($mesFin); $i++)
          {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$j$i,";
          }
        }else if($j==$anioInicio){
          for($i = intval($mesInicio); $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$j$i,";
          }
        }else{
          for($i = 1; $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$j$i,";
          }
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      
      $sql.= "
      FROM cji_comprobantedetalle cd
      JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
      JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
      JOIN cji_marca m ON p.MARCP_Codigo = m.MARCP_Codigo
      WHERE YEAR(c.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin'
      GROUP BY p.MARCP_Codigo";
    
    }elseif($anioFin == $anioInicio){
      $sql = "SELECT 
      m.MARCC_Descripcion AS NOMBRE,
      ";
      if($mesInicio == $mesFin)
      {
        $sql .= "SUM(IF(MONTH(CPC_Fecha)=".intval($mesInicio).",IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$anioFin".intval($mesInicio)."";
      }else{
        for($i = intval($mesInicio); $i <= intval($mesFin); $i++)
        {
          $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$anioFin$i,";
        }
        $sql = substr($sql,0,strlen($sql)-1);
      }
      
      $sql.= "
      FROM cji_comprobantedetalle cd
      JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
      JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
      JOIN cji_marca m ON p.MARCP_Codigo = m.MARCP_Codigo
      WHERE YEAR(c.CPC_Fecha) = '$anioInicio'
      GROUP BY p.MARCP_Codigo";
    }

    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
	
	return $data;
  }
  
  public function ventas_por_marca_anual($inicio,$fin)
  {
    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
    
    if($anioFin > $anioInicio)
    {
    
      $sql = "SELECT 
      m.MARCC_Descripcion AS NOMBRE,
      ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
            $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as y$j,";
        }else{
            $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as y$j,";
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      
      $sql.= "
      FROM cji_comprobantedetalle cd
      JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
      JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
      JOIN cji_marca m ON p.MARCP_Codigo = m.MARCP_Codigo
      WHERE YEAR(c.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin'
      GROUP BY p.MARCP_Codigo";
    
    }elseif($anioFin == $anioInicio){
    
      $sql = "SELECT 
      m.MARCC_Descripcion AS NOMBRE,
      ";
      $sql .= "SUM(IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total)) as y$anioFin ";
      $sql.= "
      FROM cji_comprobantedetalle cd
      JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
      JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
      JOIN cji_marca m ON p.MARCP_Codigo = m.MARCP_Codigo
      WHERE YEAR(c.CPC_Fecha) = '$anioInicio'
      GROUP BY p.MARCP_Codigo";
    }
	
    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
	
	return $data;
  }
  
  
  /* FAMILIAS */

  
  public function ventas_por_familia_resumen($inicio,$fin)
  {
    $sql = "SELECT 
    f.FAMI_Descripcion AS NOMBRE,
    SUM( IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total) ) AS VENTAS
    FROM cji_comprobantedetalle cd
    JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
    JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
    JOIN cji_familia f ON p.FAMI_Codigo	 = f.FAMI_Codigo 
    WHERE c.CPC_Fecha BETWEEN DATE('$inicio') AND DATE('$fin') GROUP BY p.FAMI_Codigo";
    $query = $this->db->query($sql);
    
    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
    return $data;
  }
  
  public function ventas_por_familia_mensual($inicio,$fin)
  {
    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
    
    if($anioFin > $anioInicio)
    {
      $sql = "SELECT 
       f.FAMI_Descripcion AS NOMBRE,
      ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
          for($i = 1; $i <= intval($mesFin); $i++)
          {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$j$i,";
          }
        }else if($j==$anioInicio){
          for($i = intval($mesInicio); $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$j$i,";
          }
        }else{
          for($i = 1; $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$j$i,";
          }
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      
      $sql.= "
      FROM cji_comprobantedetalle cd
      JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
      JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
      JOIN cji_familia f ON p.FAMI_Codigo	 = f.FAMI_Codigo 
      WHERE YEAR(c.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin'
      GROUP BY p.FAMI_Codigo";
    
    }elseif($anioFin == $anioInicio){
      $sql = "SELECT 
      f.FAMI_Descripcion AS NOMBRE,
      ";
      if($mesInicio == $mesFin)
      {
        $sql .= "SUM(IF(MONTH(CPC_Fecha)=".intval($mesInicio).",IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$anioFin".intval($mesInicio)."";
      }else{
        for($i = intval($mesInicio); $i <= intval($mesFin); $i++)
        {
          $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$anioFin$i,";
        }
        $sql = substr($sql,0,strlen($sql)-1);
      }
      
      $sql.= "
      FROM cji_comprobantedetalle cd
      JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
      JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
      JOIN cji_familia f ON p.FAMI_Codigo	 = f.FAMI_Codigo 
      WHERE YEAR(c.CPC_Fecha) = '$anioInicio'
      GROUP BY p.FAMI_Codigo";
    }

    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
	
	return $data;
  }
  
  public function ventas_por_familia_anual($inicio,$fin)
  {
    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
    
    if($anioFin > $anioInicio)
    {
    
      $sql = "SELECT 
      f.FAMI_Descripcion AS NOMBRE,
      ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
            $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as y$j,";
        }else{
            $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as y$j,";
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      
      $sql.= "
      FROM cji_comprobantedetalle cd
      JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
      JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
      JOIN cji_familia f ON p.FAMI_Codigo	 = f.FAMI_Codigo 
      WHERE YEAR(c.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin'
      GROUP BY p.FAMI_Codigo";
    
    }elseif($anioFin == $anioInicio){
    
      $sql = "SELECT 
      f.FAMI_Descripcion AS NOMBRE,
      ";
      $sql .= "SUM(IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total)) as y$anioFin ";
      $sql.= "
      FROM cji_comprobantedetalle cd
      JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
      JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
      JOIN cji_familia f ON p.FAMI_Codigo	 = f.FAMI_Codigo 
      WHERE YEAR(c.CPC_Fecha) = '$anioInicio'
      GROUP BY p.FAMI_Codigo";
    }
	
    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
	
	return $data;
  }
  
  public function ventas_por_dia($inicio,$fin)
  {
    $sql = "
    SELECT c.CPC_Fecha as FECHA,c.CPC_Serie AS SERIE,c.CPC_Numero AS NUMERO,CPC_TipoOperacion,
    CPC_Total  AS VENTAS,c.CPC_TipoDocumento AS TIPO , c.CPP_Codigo as CODIGO , c.CPC_TDC , c.MONED_Codigo
    FROM cji_comprobante c
    WHERE CPC_Fecha BETWEEN DATE('$inicio') AND DATE('$fin') AND CPC_TipoOperacion='V'
    ORDER BY CPC_Fecha ASC
    ";
    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
	
    return $data;
  }
  
  public function producto_stock()
  {
    $sql = "SELECT DISTINCT P.PROD_Nombre, DATE_FORMAT(C.CPDEC_FechaRegistro,'%m-%d-%Y') as fecha, DATEDIFF( CURDATE( ) , C.CPDEC_FechaRegistro ) AS dias
        FROM  `cji_comprobantedetalle` C
        INNER JOIN cji_producto P ON P.PROD_Codigo = C.PROD_Codigo
        INNER JOIN (
        SELECT CPDEC_Descripcion, MAX( CPDEC_FechaRegistro ) AS MaxDateTime
        FROM cji_comprobantedetalle
        GROUP BY CPDEC_Descripcion
        )CD ON C.CPDEC_Descripcion = CD.CPDEC_Descripcion
        AND C.CPDEC_FechaRegistro = CD.MaxDateTime
        where DATEDIFF( CURDATE( ) , C.CPDEC_FechaRegistro ) >=15 AND P.PROD_FlagBienServicio = 'B' 
        ORDER BY dias ASC limit 150";
    
    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result() as $result)
      {
        $data[] = $result;
      }
    }
	
    return $data;
  }
  
  
   public function ventas_diarios($tipo,$hoy)
  {
      $compania = $this->somevar['compania'];
      $this->db->select('cji_comprobante.CPC_Fecha,cji_comprobante.CPC_FlagEstado,cji_comprobante.CPC_TipoDocumento,cji_comprobante.CPC_Serie,cji_comprobante.CPC_Numero,
      cji_empresa.EMPRC_RazonSocial,cji_empresa.EMPRC_Ruc,cji_persona.PERSC_Nombre,cji_persona.PERSC_ApellidoPaterno,
      cji_persona.PERSC_ApellidoMaterno,  cji_persona.PERSC_Ruc,cji_comprobante.CPC_subtotal,cji_comprobante.CPC_igv,
      cji_comprobante.CPC_total,cji_cliente.CLIC_TipoPersona,cji_moneda.MONED_Simbolo,cji_moneda.MONED_Codigo');
      $this->db->join('cji_cliente','cji_cliente.CLIP_Codigo=cji_comprobante.CLIP_Codigo','left');
      $this->db->join('cji_persona','cji_persona.PERSP_Codigo=cji_cliente.PERSP_Codigo','left');
      $this->db->join('cji_empresa','cji_empresa.EMPRP_Codigo=cji_cliente.EMPRP_Codigo','left');
	   $this->db->join('cji_moneda','cji_moneda.MONED_Codigo=cji_comprobante.MONED_Codigo','left');
      $this->db->from('cji_comprobante');
      $this->db->where('cji_comprobante.COMPP_Codigo',$compania);
	  $this->db->where('cji_comprobante.CPC_Fecha',$hoy);
       $this->db->where('cji_comprobante.CPC_TipoDocumento',$tipo);
      $this->db->where('cji_comprobante.CPC_TipoOperacion','V');
      
      $this->db->order_by('cji_comprobante.CPC_Numero','asc');
      
     $query= $this->db->get();
    

     if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
     }
  }
   public function registro_ventas($tipo_oper,$tipo,$fecha1, $fecha2)
  {
      $compania = $this->somevar['compania'];
      $this->db->select('cji_comprobante.CPC_Fecha,cji_comprobante.CPC_FlagEstado,cji_comprobante.CPC_TipoDocumento,cji_comprobante.CPC_Serie,cji_comprobante.CPC_Numero,
      cji_empresa.EMPRC_RazonSocial,cji_empresa.EMPRC_Ruc,cji_persona.PERSC_Nombre,cji_persona.PERSC_ApellidoPaterno,
      cji_persona.PERSC_ApellidoMaterno,  cji_persona.PERSC_Ruc,cji_comprobante.CPC_subtotal,cji_comprobante.CPC_igv,
      cji_comprobante.CPC_total,cji_cliente.CLIC_TipoPersona,cji_proveedor.PROVC_TipoPersona,cji_moneda.MONED_Simbolo,cji_moneda.MONED_Codigo');

      $this->db->join('cji_cliente','cji_cliente.CLIP_Codigo=cji_comprobante.CLIP_Codigo','left');
	  $this->db->join('cji_proveedor','cji_proveedor.PROVP_Codigo=cji_comprobante.PROVP_Codigo','left');
	  $this->db->join('cji_moneda','cji_moneda.MONED_Codigo=cji_comprobante.MONED_Codigo','left');
      if($tipo_oper=='V'){
	  $this->db->join('cji_persona','cji_persona.PERSP_Codigo=cji_cliente.PERSP_Codigo','left');
	   $this->db->join('cji_empresa','cji_empresa.EMPRP_Codigo=cji_cliente.EMPRP_Codigo','left');
	  
	  }else{
	  $this->db->join('cji_persona','cji_persona.PERSP_Codigo=cji_proveedor.PERSP_Codigo','left');
	  $this->db->join('cji_empresa','cji_empresa.EMPRP_Codigo=cji_proveedor.EMPRP_Codigo','left');
	  }
	  
	  
      $this->db->from('cji_comprobante');

      $this->db->where('cji_comprobante.COMPP_Codigo',$compania);
	    $this->db->where('cji_comprobante.CPC_TipoOperacion',$tipo_oper);
	    $this->db->where('cji_comprobante.CPC_Fecha >=',$fecha1);
	    $this->db->where('cji_comprobante.CPC_Fecha <=',$fecha2);
      $this->db->where('cji_comprobante.CPC_TipoDocumento',$tipo);
    
      $this->db->order_by('cji_comprobante.CPC_Numero','asc');
      
     $query= $this->db->get();
    

     if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
     }
  }

  
  
   public function ventas_por_producto_resumen($inicio,$fin)
  {
    $sql = "SELECT p.PROD_CodigoUsuario as codigo, SUM(cd.CPDEC_Cantidad) as cantidad,
    p.PROD_Nombre AS NOMBRE,p.PROD_Comentario as comentario,
    SUM( IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total) ) AS VENTAS
    FROM cji_comprobantedetalle cd
    JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo and c.COMPP_Codigo=".$this->somevar ['compania']."
	
    JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
    WHERE c.CPC_FlagEstado=1 and c.CPC_Fecha BETWEEN DATE('$inicio') AND DATE('$fin') and c.CPC_TipoOperacion = 'V'
	GROUP BY p.PROD_Codigo";
    $query = $this->db->query($sql);
    
    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
    return $data;
  }
  
  public function ventas_por_producto_mensual($inicio,$fin)
  {
    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
    
    if($anioFin > $anioInicio)
    {
      $sql = "SELECT p.PROD_CodigoUsuario as codigo, SUM(cd.CPDEC_Cantidad) as cantidad,
       p.PROD_Nombre AS NOMBRE,
      ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
          for($i = 1; $i <= intval($mesFin); $i++)
          {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$j$i,";
          }
        }else if($j==$anioInicio){
          for($i = intval($mesInicio); $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$j$i,";
          }
        }else{
          for($i = 1; $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$j$i,";
          }
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      
      $sql.= " p.PROD_Comentario as comentario
      FROM cji_comprobantedetalle cd
     JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo and c.COMPP_Codigo=".$this->somevar ['compania']." JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
      WHERE c.CPC_FlagEstado=1 and YEAR(c.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' and and c.CPC_TipoOperacion = 'V'
      GROUP BY p.PROD_Nombre";
    
    }elseif($anioFin == $anioInicio){
      $sql = "SELECT p.PROD_CodigoUsuario as codigo, SUM(cd.CPDEC_Cantidad) as cantidad,
       p.PROD_Nombre AS NOMBRE,
      ";
      if($mesInicio == $mesFin)
      {
        $sql .= "SUM(IF(MONTH(CPC_Fecha)=".intval($mesInicio).",IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$anioFin".intval($mesInicio)."";
      }else{
        for($i = intval($mesInicio); $i <= intval($mesFin); $i++)
        {
          $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$anioFin$i,";
        }
        $sql = substr($sql,0,strlen($sql)-1);
      }
      
      $sql.= " , p.PROD_Comentario as comentario
      FROM cji_comprobantedetalle cd
      JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo and c.COMPP_Codigo=".$this->somevar ['compania']."
      JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
     
      WHERE c.CPC_FlagEstado=1 and YEAR(c.CPC_Fecha) = '$anioInicio' and c.CPC_TipoOperacion = 'V'
      GROUP BY p.PROD_Nombre";
    }

    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
	
	return $data;
  }
  
  public function ventas_por_producto_anual($inicio,$fin)
  {
    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
    
    if($anioFin > $anioInicio)
    {
    
      $sql = "SELECT p.PROD_CodigoUsuario as codigo, SUM(cd.CPDEC_Cantidad) as cantidad,
      p.PROD_Nombre AS NOMBRE,
      ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
            $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as y$j,";
        }else{
            $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as y$j,";
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      
      $sql.= "  p.PROD_Comentario as comentario
      FROM cji_comprobantedetalle cd
   JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo and c.COMPP_Codigo=".$this->somevar ['compania']."
      JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
      WHERE c.CPC_FlagEstado=1 and YEAR(c.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' and c.CPC_TipoOperacion = 'V'
      GROUP BY  p.PROD_Nombre";
    
    }elseif($anioFin == $anioInicio){
    
      $sql = "SELECT p.PROD_CodigoUsuario as codigo, SUM(cd.CPDEC_Cantidad) as cantidad,
      p.PROD_Nombre AS NOMBRE,
      ";
      $sql .= "SUM(IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total)) as y$anioFin ";
      $sql.= "  , p.PROD_Comentario as comentario
      FROM cji_comprobantedetalle cd
     JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo and c.COMPP_Codigo=".$this->somevar ['compania']."
      JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
      WHERE c.CPC_FlagEstado=1 and  YEAR(c.CPC_Fecha) = '$anioInicio' and c.CPC_TipoOperacion = 'V'
      GROUP BY  p.PROD_Nombre";
    }
	
    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
	
	return $data;
  }
  
  
  
  
  
  }
?>