<?php
ini_set('error_reporting', 1);
class Producto_model extends model
{

    var $somevar;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('almacen/productounidad_model');
        $this->load->model('almacen/familia_model');
        $this->load->model('almacen/atributo_model');
        $this->load->model('almacen/productoproveedor_model');
        $this->load->model('almacen/productoprecio_model');
        $this->load->model('maestros/companiaconfiguracion_model');
        $this->load->model('maestros/compania_model');
        $this->load->model('almacen/serie_model');
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['idcompania'] = $this->session->userdata('idcompania');
    }

    public function obtenerProductos($keyword, $flag, $compania)
    {
        $query = $this->db->select('pro.*')
            ->from('cji_productocompania proc')
            ->join('cji_producto pro', 'pro.PROD_Codigo = proc.PROD_Codigo', 'LEFT')
            ->join('cji_marca ma', 'ma.MARCP_Codigo = pro.MARCP_Codigo', 'LEFT')
            ->where('pro.PROD_FlagEstado', '1')
            ->where('pro.PROD_FlagBienServicio', $flag)
            ->where('proc.COMPP_Codigo', $compania)
            ->like('pro.PROD_CodigoUsuario', $keyword)
            ->or_like('pro.PROD_Nombre', $keyword)
            ->group_by('proc.PROD_Codigo')
            ->order_by('pro.PROD_Nombre')
            ->limit(50)
            ->get();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    public function listar_producto_stockmin()
    {


        $sql = "SELECT `cji_almacenproducto`.`COMPP_Codigo`, `cji_producto`.`PROD_CodigoInterno` , `cji_producto`.`PROD_CodigoUsuario` ,`cji_producto`.`PROD_Nombre` , 
			`cji_almacenproducto`.`ALMPROD_Stock` , cji_producto.PROD_StockMinimo,
			`cji_almacenproducto`.ALMAC_Codigo
			FROM `cji_productocompania`
			JOIN `cji_producto` ON `cji_producto`.`PROD_Codigo`=`cji_productocompania`.`PROD_Codigo` 
            JOIN `cji_almacenproducto` ON `cji_almacenproducto`.`PROD_Codigo` = `cji_productocompania`.`PROD_Codigo`
            WHERE `PROD_FlagBienServicio` = 'B' 
            AND `PROD_FlagEstado` = 1 
            AND cji_producto.PROD_StockMinimo > cji_almacenproducto.ALMPROD_Stock
            AND `cji_productocompania`.`COMPP_Codigo` IN ('" . $this->session->userdata('idcompania') . "')";

        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function seleccionar()
    {
        $arreglo = array('' => ":: Seleccione ::");
        $listar = $this->listar_productos("1");
        foreach ($listar as $indice => $valor) {
            $indice1 = $valor->PROD_Codigo;
            $valor1 = $valor->PROD_Nombre;
            $arreglo[$indice1] = $valor1;
        }
        return $arreglo;
    }

    public function listar_prod($flagBS, $tipo, $opcion = "", $orden = "1", $number_items = "", $offset = "")
    {
        $this->db->limit($number_items, $offset);
        $query = $this->db->get('cji_producto');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function buscar_prod($codigo, $nombre, $familia, $marca, $flagBS, $number_items = "", $offset = "")
    {


        if ($codigo != '') {
            $this->db->where('PROD_CodigoUsuario', $codigo);
        }
        if ($nombre != '') {
            $this->db->like('PROD_Nombre', $nombre);
        }
        if ($familia != '') {
            $this->db->where('FAMI_Codigo', $familia);
        }
        if ($marca != '') {
            $this->db->where('MARCP_Codigo', $marca);
        }
        $this->db->select('cji_producto.PROD_Codigo,cji_producto.PROD_CodigoInterno,cji_producto.PROD_Nombre,
            cji_producto.TIPPROD_Codigo,cji_producto.FAMI_Codigo,cji_producto.PROD_Modelo,cji_producto.PROD_FlagEstado,
            cji_producto.PROD_FlagActivo');
        $this->db->from(cji_productocompania);

        $this->db->limit($number_items, $offset);
        $query = $this->db->get('cji_producto');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function insertar_establecimiento(stdClass $filter = null)
    {

        $this->db->insert("cji_productocompania", (array)$filter);
    }

    public function validar_establecimiento($codigo)
    {

        $this->db->where('PROD_Codigo	', $codigo);
        $query = $this->db->get('cji_productocompania');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function listar_productos($flagBS, $tipo = '1', $opcion = "", $orden = "1", $number_items = "", $offset = "")
    {
        $compania = $this->somevar['compania'];
        //$names = $this->companiaconfiguracion_model->listar('3');
        $arr = array();

        switch ($tipo) {
            case 1://Todos
                $where = array("PROD_FlagEstado" => 1);
                break;
            case 2://Por tipo de producto
                $where = array("PROD_FlagEstado" => 1, "TIPPROD_Codigo" => $opcion);
                break;
            case 3://Por familia
                $where = array("PROD_FlagEstado" => 1, "FAMI_Codigo" => $opcion);
                break;
            case 4://Por proveedor
                $where = array("PROD_FlagEstado" => 1, "cji_producto.PROVP_Codigo" => $opcion);
                break;
            case 5://Por unidad de medida
                $where = array("PROD_FlagEstado" => 1, "UNDMED_Codigo" => $opcion);
                break;
        }
        switch ($orden) {
            case 1://Por nombre
                $orden = "PROD_Nombre";
                break;
            case 2://Por codigo
                $orden = "PROD_Codigo";
                break;
        }
        $query = $this->db->select('cji_producto.*')
            ->join('cji_producto', 'cji_producto.PROD_Codigo=cji_productocompania.PROD_Codigo')
            ->where('PROD_FlagBienServicio', $flagBS)
            ->where($where)
            ->where_in('cji_productocompania.COMPP_Codigo', $compania)
            ->order_by($orden)
            ->get('cji_productocompania', $number_items, $offset);
//        };
//}
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }else{
            return array();
        }
    }

    public function productos_activos($filter, $number_items = "", $offset = "")
    {
        $compania = $this->somevar['compania'];
        $this->db->select('cji_producto.*');
        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo=cji_productocompania.PROD_Codigo');
        $this->db->join('cji_marca', 'cji_marca.MARCP_Codigo = cji_producto.MARCP_Codigo', 'inner');
        $this->db->join('cji_familia', 'cji_familia.FAMI_Codigo = cji_producto.FAMI_Codigo', 'inner');
        if (isset($filter->tipo) && $filter->tipo != "")
            $this->db->where('cji_producto.TIPPROD_Codigo', $filter->tipo);
        if (isset($filter->codigo) && $filter->codigo != "")
            $this->db->like('cji_producto.PROD_CodigoUsuario', $filter->codigo);
        if (isset($filter->nombre) && $filter->nombre != "")
            $this->db->like('cji_producto.PROD_Nombre', $filter->nombre, 'both');
        if (isset($filter->familia) && $filter->familia != "")
            $this->db->like('cji_familia.FAMI_Descripcion', $filter->familia, 'both');
        if (isset($filter->marca) && $filter->marca != "")
            $this->db->like('cji_marca.MARCC_Descripcion', $filter->marca, 'both');
        $this->db->where('cji_producto.PROD_FlagBienServicio', 'B');
        $this->db->where('cji_producto.PROD_FlagActivo', '1');
        $this->db->where('cji_producto.PROD_FlagEstado', '1');
        $this->db->where_in('cji_productocompania.COMPP_Codigo', $compania);
        $this->db->order_by('cji_producto.PROD_Nombre');
        $query = $this->db->get('cji_productocompania', $number_items, $offset);
        if($query->num_rows > 0){
            return $query->result();
        }else{
            return NULL;
        }
    }

    public function productos_no_activos($flagBS = 'B', $number_items = "", $offset = "", $filter = null)
    {
        $compania = $this->somevar['compania'];
        $this->db->select('cji_producto.*');
        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo=cji_productocompania.PROD_Codigo');
        $this->db->join('cji_marca', 'cji_marca.MARCP_Codigo = cji_producto.MARCP_Codigo', 'inner');
        $this->db->join('cji_familia', 'cji_familia.FAMI_Codigo = cji_producto.FAMI_Codigo', 'inner');
        if (isset($filter->tipo) && $filter->tipo != "")
            $this->db->where('cji_producto.TIPPROD_Codigo', $filter->tipo);
        if (isset($filter->codigo) && $filter->codigo != "")
            $this->db->like('cji_producto.PROD_CodigoUsuario', $filter->codigo);
        if (isset($filter->nombre) && $filter->nombre != "")
            $this->db->like('cji_producto.PROD_Nombre', $filter->nombre, 'both');
        if (isset($filter->familia) && $filter->familia != "")
            $this->db->like('cji_familia.FAMI_Descripcion', $filter->familia, 'both');
        if (isset($filter->marca) && $filter->marca != "")
            $this->db->like('cji_marca.MARCC_Descripcion', $filter->marca, 'both');
        $this->db->where('cji_producto.PROD_FlagBienServicio', $flagBS);
        $this->db->where('cji_producto.PROD_FlagActivo', '0');
        $this->db->where('cji_producto.PROD_FlagEstado', '0');
        $this->db->where_in('cji_productocompania.COMPP_Codigo', $compania);
        $this->db->order_by('cji_producto.PROD_Nombre');
        $query = $this->db->get('cji_productocompania', $number_items, $offset);
        if($query->num_rows > 0){
            return $query->result();
        }else{
            return NULL;
        }
    }

    public function cambiarEstado($data, $codProducto){
        $this->db->where('PROD_Codigo', $codProducto);
        $valor = $this->db->update('cji_producto', $data);
        return $valor;
    }

    public function listar_productos_inventariados($flagBS, $number_items = "", $offset = "")
    {
        $compania = $this->somevar['compania'];
        $this->db->select('p.*');
        $this->db->join('cji_inventariodetalle invd', 'invd.PROD_Codigo=p.PROD_Codigo ', 'left');
        $this->db->join('cji_inventario inv', 'inv.INVE_Codigo = invd.INVE_Codigo', 'inner');
        $this->db->where('p.PROD_FlagBienServicio ', $flagBS);
        $this->db->where('p.PROD_FlagEstado', 1);
        $this->db->where('inv.COMPP_Codigo', $compania);
        $this->db->where('inv.INVE_FlagEstado', 1);
        $this->db->order_by('p.PROD_FechaRegistro', 'ASC');
        $query = $this->db->get('cji_producto p', $number_items, $offset);

        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    public function listar_productos_no_inventariados($flagBS = 'B', $number_items = "", $offset = "")
    {
        $compania = $this->somevar['compania'];
        $sql = "SELECT pro.*
FROM cji_producto pro
WHERE pro.PROD_Codigo not in (
  SELECT p.PROD_Codigo
  FROM cji_producto p RIGHT JOIN cji_inventariodetalle invd ON invd.PROD_Codigo=p.PROD_Codigo
    INNER JOIN cji_inventario inv ON inv.INVE_Codigo = invd.INVE_Codigo
  WHERE p.PROD_FlagBienServicio  = '".$flagBS."'
        AND p.PROD_FlagEstado = 1
        AND inv.COMPP_Codigo = ".$compania."
        AND inv.INVE_FlagEstado = 1
)
and pro.PROD_FlagActivo = 1 and pro.PROD_FlagEstado = 1 order by pro.PROD_FechaRegistro ";

        if($number_items != "" && $offset != ""){
            $sql .= "ASC LIMIT ".$offset.",". $number_items;
        }

        $query = $this->db->query($sql);

        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    public function obtenerSerieProducto($codigo)
    {
//$this->db->select('cji_serie.SERIC_Numero,cji_serie.SERIP_Codigo')->join('cji_almacenproductoserie','cji_almacenproductoserie.SERIP_Codigo=cji_serie.SERIP_Codigo');
        $this->db->select('cji_serie.SERIC_Numero')->join('cji_almacenproductoserie', 'cji_almacenproductoserie.SERIP_Codigo=cji_serie.SERIP_Codigo');
        $this->db->where('cji_serie.PROD_Codigo', $codigo)->where('cji_almacenproductoserie.ALMPROD_Codigo', 1)->from('cji_serie');
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function modificar_producto2($producto, $nombre_producto, $codigo_interno, $stock_producto, $precio_producto, $presentacion_producto, $marca_producto, $CodigUsu='')
    {
        $data = array(
//"TIPPROD_Codigo" => $tipo_producto,
            "PROD_Nombre" => strtoupper($nombre_producto),
            //"PROD_Modelo" => strtoupper($modelo),
            "PROD_Stock" => $stock_producto,
            "PROD_Presentacion" => $presentacion_producto,
            "USUA_Codigo" => $CodigUsu
        );
        $this->db->where('PROD_Codigo', $producto);
        $this->db->update("cji_producto", $data);

        if ($stock_producto > 0) {

//$hay_almacen = $this->almacenproducto_model->obtener(1,$producto);
            $where = array("ALMAC_Codigo" => 1, "PROD_Codigo" => $producto, "COMPP_Codigo" => $this->somevar['compania']);
            $query = $this->db->order_by('ALMAC_Codigo')->where($where)->get('cji_almacenproducto');
//if($query->num_rows>0){
            $hay_almacen = $query->row();
//}
            $filter = new stdClass();
            if (count($hay_almacen) > 0) {
//se actualiza si ya tiene almacen
                $filter->ALMAC_Codigo = 1; //$almacen_id;
                $filter->PROD_Codigo = $producto;
                $filter->COMPP_Codigo = $this->somevar['compania'];
                $filter->ALMPROD_Stock = $stock_producto;
                $filter->ALMPROD_CostoPromedio = $precio_producto;
                $this->db->where("PROD_Codigo", $producto);
                $this->db->update("cji_almacenproducto", (array)$filter);
            } else {
//se inserta si es nuevo almacen
                $filter->ALMAC_Codigo = 1; //$almacen_id;
                $filter->PROD_Codigo = $producto;
                $filter->COMPP_Codigo = $this->somevar['compania'];
                $filter->ALMPROD_Stock = $stock_producto;
                $filter->ALMPROD_CostoPromedio = $precio_producto;
//$this->db->where("ALMPROD_Codigo",$almacenprod_id);
                $this->db->insert("cji_almacenproducto", (array)$filter);
            }
        }

        if ($precio_producto != "") {
//$precio = "";
            $prodprecio = $this->productoprecio_model->obtenerprecioA($producto, $this->somevar['compania']);
            if (count($prodprecio) > 0) {
                $DateUpdate = date("Y/m/d H:i:s");
                $this->db->where("PRODPREP_Codigo", $prodprecio[0]->PRODPREP_Codigo);
                $this->db->update('cji_productoprecio', array("PRODPREC_Precio" => $precio_producto, "PRODPREC_FechaModificacion" => $DateUpdate));
//$precio = number_format ($prodprecio[0]->PRODPREC_Precio, 2);
            } else {
                $produnip = $this->productounidad_model->obtener($producto, 7);
                $data2 = array(
                    "PROD_Codigo" => $producto,
                    "TIPCLIP_Codigo" => 3,
                    "EESTABP_Codigo" => $this->somevar['establec'],
                    "MONED_Codigo" => 1,
                    "PRODUNIP_Codigo" => $produnip->PRODUNIP_Codigo,
                    "PRODPREC_Precio" => $precio_producto
                );
                $this->db->insert("cji_productoprecio", $data2);
            }
        }
    }

    public function listar_productos_general($flagBS, $number_items = "", $offset = "", $producto_busca = '', $comp_select = null)
    {
        $compania = $this->somevar['compania'];
        $idcompania = $this->somevar['idcompania'];
        if (isset($producto_busca) && $producto_busca != '') {
            $this->db->where('PROD_Codigo', $producto_busca);
        }

        /* if(isset($comp_select) && $comp_select!=null){
          $this->db->where_in('COMPP_Codigo',$comp_select);
          } */
        $query = $this->db
            ->where('cji_producto.PROD_FlagBienServicio', $flagBS)
            ->where('cji_producto.PROD_FlagEstado', '1')
            //->join('cji_almacenproducto','cji_producto.PROD_Codigo=cji_almacenproducto.PROD_Codigo','left')
            //->where_not_in('cji_producto.PROD_Codigo', 0)
            ->order_by('cji_producto.PROD_Nombre')
            ->get('cji_producto', $number_items, $offset);
//}
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function buscar_productos($filter, $number_items = "", $offset = "")
    {

        $compania = $this->somevar['compania'];


        $this->db->select('cji_producto.*')
            ->join('cji_producto', 'cji_producto.PROD_Codigo = cji_productocompania.PROD_Codigo ', 'left')
            ->join('cji_familia', 'cji_familia.FAMI_Codigo = cji_producto.FAMI_Codigo ', 'left')
            ->join('cji_marca', 'cji_marca.MARCP_Codigo = cji_producto.MARCP_Codigo ', 'left')
            ->where('cji_productocompania.COMPP_Codigo', $compania)
            ->where('PROD_FlagEstado', 1)
            ->where('PROD_FlagBienServicio', $filter->flagBS)
            ->order_by('cji_producto.PROD_Nombre');

        if (isset($filter->tipo) && $filter->tipo != "")
            $this->db->where('cji_producto.TIPPROD_Codigo', $filter->tipo);

        if (isset($filter->codigo) && $filter->codigo != "")
            $this->db->where('cji_producto.PROD_CodigoUsuario', $filter->codigo);
        if (isset($filter->nombre) && $filter->nombre != "")
            $this->db->like('cji_producto.PROD_Nombre', $filter->nombre, 'both');
        if (isset($filter->familia) && $filter->familia != "")
            $this->db->like('cji_familia.FAMI_Descripcion', $filter->familia, 'both');
        if (isset($filter->marca) && $filter->marca != "")
            $this->db->like('cji_marca.MARCC_Descripcion', $filter->marca, 'both');

        $query = $this->db->get('cji_productocompania', $number_items, $offset);

        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function buscarProductoIndex($filter, $number_items = "", $offset = "",$flagBS="B"){
         $compania = $this->somevar['compania'];


        $this->db->select('cji_producto.*')
            ->join('cji_producto', 'cji_producto.PROD_Codigo = cji_productocompania.PROD_Codigo ', 'left')
            ->join('cji_familia', 'cji_familia.FAMI_Codigo = cji_producto.FAMI_Codigo ', 'left')
            ->join('cji_marca', 'cji_marca.MARCP_Codigo = cji_producto.MARCP_Codigo ', 'left')
            ->where('cji_productocompania.COMPP_Codigo', $compania)
            ->where('PROD_FlagEstado', 1)
            ->where('PROD_FlagBienServicio', $flagBS)
            ->order_by('cji_producto.PROD_Nombre');

        if (isset($filter->tipo) && $filter->tipo != "")
            $this->db->where('cji_producto.TIPPROD_Codigo', $filter->tipo);

        if (isset($filter->codigo) && $filter->codigo != "")
            $this->db->like('cji_producto.PROD_CodigoUsuario', $filter->codigo);
        if (isset($filter->nombre) && $filter->nombre != "")
            $this->db->like('cji_producto.PROD_Nombre', $filter->nombre, 'both');
        if (isset($filter->familia) && $filter->familia != "")
            $this->db->like('cji_familia.FAMI_Descripcion', $filter->familia, 'both');
        if (isset($filter->marca) && $filter->marca != "")
            $this->db->like('cji_marca.MARCC_Descripcion', $filter->marca, 'both');
        if(isset($filter->nombredos) && $filter->nombredos != ""){
            $textox=$filter->nombredos;
            $datos=split("\-",$textox);
            $this->db->like('cji_producto.PROD_Nombre',$datos[0],'both');
            $this->db->like('cji_producto.PROD_Nombre',$datos[1],'both');
        }

        $query = $this->db->get('cji_productocompania', $number_items, $offset);

        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }

    }
    public function buscar_productos1($filter, $number_items = "", $offset = "")
    {
        if ($filter->nombre != "") {
            $a_filter = new stdClass();
            $a_filter->codigo = $filter->nombre;
            $a_filter->flagBS = $filter->flagBS;

            $data = $this->buscar_productos_general($a_filter);
        }
        //var_dump($data);

        $compania = $this->somevar['compania'];

        $this->db->select('cji_producto.*, cji_productocompania.COMPP_Codigo');
        $this->db->join('cji_producto', 'cji_producto.PROD_Codigo = cji_productocompania.PROD_Codigo ', 'left');
        $this->db->join('cji_familia', 'cji_familia.FAMI_Codigo = cji_producto.FAMI_Codigo ', 'left');


        $this->db->where('cji_productocompania.COMPP_Codigo', $compania);
        $this->db->where('PROD_FlagEstado', 1);
        $this->db->where('PROD_FlagActivo', 1);
        $this->db->where('PROD_FlagBienServicio', $filter->flagBS);


        if ($filter->nombre != "") {

            if ($data) {
                $this->db->like('cji_producto.PROD_CodigoUsuario', $filter->nombre);
            } else
                $this->db->or_like('cji_producto.PROD_Nombre', $filter->nombre, 'both');
        }

        $this->db->order_by('cji_producto.PROD_Nombre');

        $query = $this->db->get('cji_productocompania', $number_items, $offset);
        // var_dump($this->db->last_query());

        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data1[] = $fila;
            }
            return $data1;
        }
    }

    /* public function registrar_publicacion_web(stdClass $filter = null)
      {
      $this->db->insert("impacto_publicacion",(array)$filter);
      } */

    public function buscar_productos_general($filter, $number_items = "", $offset = "")
    {
        $this->db->select('cji_producto.*')
            ->join('cji_familia', 'cji_familia.FAMI_Codigo = cji_producto.FAMI_Codigo ', 'left')
            ->join('cji_marca', 'cji_marca.MARCP_Codigo = cji_producto.MARCP_Codigo ', 'left')
            ->where('PROD_FlagEstado', 1)
            ->where_not_in('PROD_Codigo', 0)
            ->where('PROD_FlagBienServicio', $filter->flagBS)
            ->order_by('cji_producto.PROD_Nombre');

        if (isset($filter->codigo) && $filter->codigo != "")
            $this->db->where('cji_producto.PROD_CodigoUsuario', $filter->codigo);
        if (isset($filter->nombre) && $filter->nombre != "")
            $this->db->like('cji_producto.PROD_Nombre', $filter->nombre, 'both');
        if (isset($filter->familia) && $filter->familia != "")
            $this->db->like('cji_familia.FAMI_Codigo', $filter->familia, 'both');
        if (isset($filter->marca) && $filter->marca != "")
            $this->db->like('cji_marca.MARCC_Descripcion', $filter->marca, 'both');
        $query = $this->db->get('cji_producto', $number_items, $offset);

        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function buscar_productos_serie($serie, $number_items = "", $offset = "")
    {
        $compania = $this->somevar['compania'];

        $limit = $number_items == "" && $offset == "" ? $limit = "" : $limit = "limit $offset,$number_items";
        $sql = "SELECT p.*, s.SERIC_Numero FROM cji_almacenproducto ap 
                    INNER JOIN cji_producto p ON ap.PROD_Codigo=ap.PROD_Codigo
                    INNER JOIN cji_almacenproductoserie aps ON aps.ALMPROD_Codigo=ap.ALMPROD_Codigo
                    INNER JOIN cji_serie s ON s.SERIP_Codigo=aps.SERIP_Codigo
                    WHERE ap.ALMAC_Codigo=" . $compania . " AND s.SERIC_Numero LIKE '%" . $serie . "%' 
                    " . $limit;
        $query = $this->db->query($sql);

        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function obtener_stock($producto, $establec = '', $almacen = '')
    {
        $where = array('ap.PROD_Codigo' => $producto);
        if ($establec != '') {
            $where['c.EESTABP_Codigo'] = $establec;
        }
        if ($almacen != '') {
            $where['ap.ALMAC_Codigo'] = $almacen;
        }
        $query = $this->db->where($where)
            ->join('cji_almacen a', 'a.ALMAP_Codigo=ap.ALMAC_Codigo')
            ->join('cji_compania c', 'c.COMPP_Codigo=a.COMPP_Codigo')
            ->get('cji_almacenproducto ap');
        $stock = 0;
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
                $stock += $fila->ALMPROD_Stock;
            }
        }
        return $stock;
    }

    public function obtener_precio($producto, $establec = '', $almacen = '')
    {
        $where = array('ap.PROD_Codigo' => $producto);
        if ($establec != '') {
            $where['c.EESTABP_Codigo'] = $establec;
        }
        if ($almacen != '') {
            $where['ap.ALMAC_Codigo'] = $almacen;
        }
        $query = $this->db->where($where)
            ->join('cji_almacen a', 'a.ALMAP_Codigo=ap.ALMAC_Codigo')
            ->join('cji_compania c', 'c.COMPP_Codigo=a.COMPP_Codigo')
            ->get('cji_almacenproducto ap');
        $stock = 0;
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
                $stock += $fila->ALMPROD_CostoPromedio;
            }
        }
        return $stock;
    }

    public function insertar_carga(stdClass $filter = null)
    {
        $this->db->insert("impacto_documento", (array)$filter);
    }

    public function listar_productos_atributos($producto)
    {
        $query = $this->db->where('PROD_Codigo', $producto)->get('cji_productoatributo');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function listar_producto_unidades($producto, $unidad = '')
    {
        $where = array("PROD_Codigo" => $producto, "PRODUNIC_flagEstado" => 1);
        if ($unidad != '')
            $where['UNDMED_Codigo'] = $unidad;
        $query = $this->db->where($where)->order_by('PRODUNIP_Codigo')->get('cji_productounidad');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        } else
            return array();
    }

    public function obtener_producto($producto)
    {

        $query = $this->db->where('PROD_Codigo', $producto)->join('cji_marca','cji_producto.MARCP_Codigo = cji_marca.MARCP_Codigo','INNER')->get('cji_producto');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

//Publicacion Web
    public function obtener_producto_impacto($producto)
    {
        $query = $this->db->where('PROD_Codigo', $producto)->get('impacto_publicacion');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function registrar_publicacion_web(stdClass $filter = null)
    {
        $this->db->insert("impacto_publicacion", (array)$filter);
    }

    public function modificar_publicacion_web($imppub_codigo, stdClass $filter = null)
    {


        $this->db->where("IMPPUB_Codigo", $imppub_codigo);
        $this->db->update("impacto_publicacion", (array)$filter);
    }

//Fin de la Publicacion Web
    public function obtener_producto_x_nombre($nombre_producto)
    {
        $where = array('PROD_Nombre' => $nombre_producto);
        $query = $this->db->where($where)->get('cji_producto');
        return $query->result();
    }

    public function obtener_producto_x_codigo_usuario($codigo_usuario)
    {
        $where = array('PROD_CodigoUsuario' => $codigo_usuario);
        $query = $this->db->where($where)->get('cji_producto');
        return $query->result();
    }


    ///stv
    public function obtener_producto_x_codigo_original($codigo_original)
    {
        $where = array('PROD_CodigoOriginal' => $codigo_original);
        $query = $this->db->where($where)->get('cji_producto');
        return $query->result();
    }

    ////


    public function obtener_producto_x_modelo($modelo_producto, $producto)
    {
        $this->db->select('cji_producto.*');
        if ($producto == "") {
            $this->db->where('PROD_Modelo', $modelo_producto);
        } else {
            $this->db->where('PROD_Modelo', $modelo_producto);
            $this->db->where_not_in('PROD_Codigo', $producto);
        }
        $query = $this->db->get('cji_producto');
        return $query->result();
    }

    public function obtener_producto_x_codigo($flagBS, $codigo_interno)
    {
        $query = $this->db->where('PROD_FlagBienServicio', $flagBS)->where('PROD_CodigoInterno', $codigo_interno)->get('cji_producto');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function obtener_producto_atributos($producto, $atributo)
    {
        $query = $this->db->where(array("ATRIB_Codigo" => $atributo, "PROD_Codigo" => $producto))->get("cji_productoatributo");
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function obtener_producto_unidad($producto)
    {
        $where = array("PROD_Codigo" => $producto, "PRODUNIC_flagPrincipal" => 1, "PRODUNIC_flagEstado" => 1);
        $query = $this->db->order_by('PRODUNIC_flagPrincipal', 'desc')->where($where)->get('cji_productounidad');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function insertar_producto($familia, $tipo_producto, $nombre_producto, $descripcion_breve, $comentario, $codigo_interno, $imagen, $fabricante, $linea, $marca, $pdf, $modelo, $presentacion, $geneindi, $padre, $codigo_usuario, $nombrecorto_producto, $flagBS, $stock_min, $codigo_original,$CodigUsu)
    {
        if ($fabricante == '' || $fabricante == '0')
            $fabricante = NULL;
        if ($marca == '' || $marca == '0')
            $marca = NULL;
        if ($linea == '' || $linea == '0')
            $linea = NULL;
        $nombrecorto_producto = $nombrecorto_producto != '' ? strtoupper($nombrecorto_producto) : NULL;
        $descripcion_breve = $descripcion_breve != '' ? strtoupper($descripcion_breve) : NULL;
        $comentario = $comentario != '' ? strtoupper($comentario) : NULL;
        $presentacion = $presentacion != '' ? strtoupper($presentacion) : NULL;
        if ($codigo_usuario == '')
            $codigo_usuario = NULL;
        if ($familia == '' || $familia == '0')
            $familia = NULL;
        if ($codigo_interno == '' || $codigo_interno == '0')
            $codigo_interno = NULL;
        if ($tipo_producto == '' || $tipo_producto == '0')
            $tipo_producto = NULL;
        if ($geneindi == '' || $geneindi == '0')
            $geneindi = NULL;
        if ($padre == '' || $padre == '0')
            $padre = NULL;

        $data = array(
            "FAMI_Codigo" => $familia,
            "TIPPROD_Codigo" => $tipo_producto,
            "PROD_Nombre" => strtoupper($nombre_producto),
            "PROD_NombreCorto" => $nombrecorto_producto,
            "PROD_DescripcionBreve" => $descripcion_breve,
            "PROD_Comentario" => $comentario,
            "PROD_CodigoInterno" => $codigo_interno,
            "PROD_Imagen" => $imagen,
            "PROD_EspecificacionPDF" => $pdf,
            "FABRIP_Codigo" => $fabricante,
            "LINP_Codigo" => $linea,
            "MARCP_Codigo" => $marca,
            "PROD_Modelo" => $modelo,
            "PROD_Presentacion" => $presentacion,
            "PROD_GenericoIndividual" => $geneindi,
            "PROD_PadreCodigo" => $padre,
            "PROD_CodigoUsuario" => $codigo_usuario,
            "PROD_CodigoOriginal" => $codigo_original,
            "PROD_FlagBienServicio" => $flagBS,
            "PROD_StockMinimo" => $stock_min,
            "USUA_Codigo" => $CodigUsu
        );
        $this->db->insert("cji_producto", $data);
        return $this->db->insert_id();
    }

    public function insertar_producto_unidad($unidad_medida, $producto, $factor, $flagPrincipal)
    {
        $data = array(
            "UNDMED_Codigo" => $unidad_medida,
            "PROD_Codigo" => $producto,
            "PRODUNIC_Factor" => $factor,
            "PRODUNIC_flagPrincipal" => $flagPrincipal
        );
        $this->db->insert("cji_productounidad", $data);
        return $this->db->insert_id();
    }
    //$factorprin
    /*  public function insertar_producto_total($proveedor, $familia, $tipo_producto, $nombre_producto, $descripcion_breve, $comentario, $unidad_medida, $factor, $flagPrincipal, $atributo, $nombre_atributo, $codigo_familia, $fabricante, $linea, $marca, $imagen, $pdf, $modelo, $presentacion, $geneindi, $padre = '', $codigo_usuario = '', $nombrecorto_producto = '', $flagBS = 'B', $stock_min = 0,$factorprin,$codigo_original) {
          $codigo_interno = '';
          if ($familia != '') {
              $datos_familia = $this->familia_model->obtener_familia($familia);
              $numero = $datos_familia[0]->FAMI_Numeracion;
              $numero2 = $numero + 1;
              $codigo_interno = $codigo_familia . str_pad($numero2, 3, "0", STR_PAD_LEFT);

              $this->familia_model->modificar_familia_numeracion($familia, $numero2);
          }

          $producto = $this->insertar_producto($familia, $tipo_producto, $nombre_producto, $descripcion_breve, $comentario, $codigo_interno, $imagen, $fabricante, $linea, $marca, $pdf, $modelo, $presentacion, $geneindi, $padre, $codigo_usuario, $nombrecorto_producto, $flagBS, $stock_min,$codigo_original);

          //$this->insertar_producto_compania($producto);
          //$comp = $this->compania_model->listar();
          //foreach($comp as $indice=>$fila){
              $this->insertar_producto_compania2($producto,$this->session->userdata('compania'));
          //}

  //Inserta unidad de medida en productos
          if (is_array($unidad_medida) > 0) {
              foreach ($unidad_medida as $indice => $valor) {
                  $umedida = $unidad_medida[$indice];
                  ///stv
                  if($indice==0 && $factorprin!="" || $factorprin!=0){
  //                $factor[$indice]=$factorprin;
  //                $fact = $factor[$indice];
                    $fact=$factorprin;
                  }else{
                  ///
                  $fact = $factor[$indice];
                  ///stv
                  }
                  ////
                  $flagP = $flagPrincipal[$indice];
                  $this->insertar_producto_unidad($umedida, $producto, $fact, $flagP);
              }
          }

          ////aumentado stv
          //Inserta unidad de medida en servicios
          if ($flagBS=='S') {
                  $umedida = '4';
                  $fact='1';
                  $flagP = '1';
                  $this->insertar_producto_unidad($umedida, $producto, $fact, $flagP);
          }*/
    /////////

    public function insertar_producto_total($proveedor, $familia, $tipo_producto, $nombre_producto, $descripcion_breve, $comentario, $unidad_medida, $factor, $flagPrincipal, $atributo, $nombre_atributo, $codigo_familia, $fabricante, $linea, $marca, $imagen, $pdf, $modelo, $presentacion, $geneindi, $padre = '', $codigo_usuario = '', $nombrecorto_producto = '', $flagBS = 'B', $stock_min = 0, $factorprin, $codigo_original,$CodigUsu)
    {
        $codigo_interno = '';
        if ($familia != '') {
            $datos_familia = $this->familia_model->obtener_familia($familia);
            $numero = $datos_familia[0]->FAMI_Numeracion;
            $numero2 = $numero + 1;
            $codigo_interno = $codigo_familia . str_pad($numero2, 3, "0", STR_PAD_LEFT);

            $this->familia_model->modificar_familia_numeracion($familia, $numero2);
        }

        $producto = $this->insertar_producto($familia, $tipo_producto, $nombre_producto, $descripcion_breve, $comentario, $codigo_interno, $imagen, $fabricante, $linea, $marca, $pdf, $modelo, $presentacion, $geneindi, $padre, $codigo_usuario, $nombrecorto_producto, $flagBS, $stock_min, $codigo_original,$CodigUsu);

        //$this->insertar_producto_compania($producto);
        $comp = $this->compania_model->listar();
        foreach ($comp as $indice => $fila) {
            $this->insertar_producto_compania2($producto, $fila->COMPP_Codigo);
        }
        //Inserta unidad de medida en productos
        if (is_array($unidad_medida) > 0) {
            foreach ($unidad_medida as $indice => $valor) {
                $umedida = $unidad_medida[$indice];
                ///stv
                if ($indice == 0 && $factorprin != "" || $factorprin != 0) {
//                $factor[$indice]=$factorprin;
//                $fact = $factor[$indice];
                    $fact = $factorprin;
                } else {
                    ///
                    $fact = $factor[$indice];
                    ///stv
                }
                ////
                $flagP = $flagPrincipal[$indice];
                $this->insertar_producto_unidad($umedida, $producto, $fact, $flagP);
            }
        }

        ////aumentado stv
        //Inserta unidad de medida en servicios
        if ($flagBS == 'S') {
            $umedida = '4';
            $fact = '1';
            $flagP = '1';
            $this->insertar_producto_unidad($umedida, $producto, $fact, $flagP);
        }


//Inserta atributos
        if (is_array($atributo) > 0) {
            foreach ($atributo as $indice => $valor) {
                $attrib = $atributo[$indice];
                $valor_attrib = $nombre_atributo[$indice];
                $datos_attrib = $this->atributo_model->obtener_atributo($attrib);
                $tipo_attrib = $datos_attrib[0]->ATRIB_TipoAtributo;
                $this->insertar_producto_atributos($producto, $attrib, $tipo_attrib, $valor_attrib);
            }
        }
//Inserta proveedores
        if (is_array($proveedor) > 0) {
            foreach ($proveedor as $indice => $valor) {
                $prov = $valor;
                $filter = new stdClass();
                $filter->PROVP_Codigo = $prov;
                $filter->PROD_Codigo = $producto;
                $this->productoproveedor_model->insertar($filter);
            }
        }

        return $producto;
    }

    public function insertar_producto_compania($producto)
    {
        $data = array(
            "PROD_Codigo" => $producto,
            "COMPP_Codigo" => $this->somevar['compania'],
        );
        $this->db->insert("cji_productocompania", $data);
    }

    public function insertar_producto_compania2($producto, $compania)
    {
        $data = array(
            "PROD_Codigo" => $producto,
            "COMPP_Codigo" => $compania
        );
        $this->db->insert("cji_productocompania", $data);
    }

    /* public function insertar_producto_compania2($producto, $compania) {
         $data = array(
             "PROD_Codigo" => $producto,
             "COMPP_Codigo" => $compania,
         );
         $this->db->insert("cji_productocompania", $data);
     }*/

    public function obtener_producto_compania($producto, $compania)
    {


        $where = array("PROD_Codigo" => $producto, "COMPP_Codigo" => $compania);
        $query = $this->db->where($where)->get('cji_productocompania');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function insertar_producto_atributos($producto, $atributo, $tipo, $valor)
    {

        switch ($tipo) {
            case 1://Numerico
                $valorNumerico = $valor == '' ? '0' : $valor;
                $valorDate = "0000-00-00 00:00:00";
                $valorString = "";
                break;
            case 2://Date
                $valorNumerico = "0";
                $valorDate = $valor;
                $valorString = "";
                break;
            case 3://Strind
                $valorNumerico = "0";
                $valorDate = "0000-00-00 00:00:00";
                $valorString = $valor;
                break;
        }
        $data = array(
            "PROD_Codigo" => $producto,
            "ATRIB_Codigo" => $atributo,
            "PRODATRIB_Numerico" => $valorNumerico,
            "PRODATRIB_Date" => $valorDate,
            "PRODATRIB_String" => $valorString
        );
        $this->db->insert("cji_productoatributo", $data);
    }

    public function modificar_producto($producto, $familia, $tipo_producto, $nombre_producto, $descripcion_breve, $comentario, $codigo_interno, $imagen, $activo, $fabricante, $linea, $marca, $pdf, $modelo, $presentacion, $geneindi, $padre, $codigo_usuario, $nombrecorto_producto, $stock_min, $codigo_original,$CodigUsu='')
    {
        if ($fabricante == '' || $fabricante == '0')
            $fabricante = NULL;
        if ($linea == '' || $linea == '0')
            $linea = NULL;
        $nombrecorto_producto = $nombrecorto_producto != '' ? strtoupper($nombrecorto_producto) : NULL;
        $descripcion_breve = $descripcion_breve != '' ? strtoupper($descripcion_breve) : NULL;
        $comentario = $comentario != '' ? strtoupper($comentario) : NULL;
        $presentacion = $presentacion != '' ? strtoupper($presentacion) : NULL;
        if ($codigo_usuario == '')
            $codigo_usuario = NULL;
        if ($familia == '' || $familia == '0')
            $familia = NULL;
        if ($codigo_interno == '' || $codigo_interno == '0')
            $codigo_interno = NULL;
        if ($tipo_producto == '' || $tipo_producto == '0')
            $tipo_producto = NULL;
        if ($geneindi == '' || $geneindi == '0')
            $geneindi = NULL;
        if ($padre == '' || $padre == '0')
            $padre = NULL;

        $data = array(
            "FAMI_Codigo" => $familia,
            "TIPPROD_Codigo" => $tipo_producto,
            "PROD_Nombre" => strtoupper($nombre_producto),
            "PROD_NombreCorto" => $nombrecorto_producto,
            "PROD_DescripcionBreve" => $descripcion_breve,
            "PROD_Comentario" => $comentario,
            "PROD_CodigoInterno" => $codigo_interno,
            "PROD_Imagen" => $imagen,
            "PROD_EspecificacionPDF" => $pdf,
            "PROD_Modelo" => $modelo,
            "PROD_Presentacion" => $presentacion,
            "PROD_GenericoIndividual" => $geneindi,
            "PROD_FlagActivo" => $activo,
            "FABRIP_Codigo" => $fabricante,
            "LINP_Codigo" => $linea,
            "MARCP_Codigo" => $marca,
            "PROD_PadreCodigo" => $padre,
            "PROD_CodigoUsuario" => $codigo_usuario,
            "PROD_CodigoOriginal" => $codigo_original,
            "PROD_StockMinimo" => $stock_min,
            "USUA_Codigo" => $CodigUsu
        );
        if ($imagen == '')
            unset($data['PROD_Imagen']);
        if ($pdf == '')
            unset($data['PROD_EspecificacionPDF']);
        $this->db->where('PROD_Codigo', $producto);
        $this->db->update("cji_producto", $data);
    }

    public function modificar_producto_unidad($produnidad, $unidad_medida, $producto, $factor, $flagPrincipal)
    {
        $data = array(
            "UNDMED_Codigo" => $unidad_medida,
            "PROD_Codigo" => $producto,
            "PRODUNIC_Factor" => $factor,
            "PRODUNIC_flagPrincipal" => $flagPrincipal
        );
        $this->db->where("PRODUNIP_Codigo", $produnidad);
        $this->db->update("cji_productounidad", $data);
    }

    //$factorprin
    public function modificar_producto_total($producto, $proveedor, $familia, $tipo_producto, $nombre_producto, $descripcion_breve, $comentario, $codigo_interno, $unidad_medida, $factor, $flagPrincipal, $atributo, $tipo_atributo, $nombre_atributo, $produnidad, $imagen, $activo, $fabricante, $linea, $marca, $pdf, $modelo, $presentacion, $geneindi, $padre = '', $codigo_usuario = '', $nombrecorto_producto = '', $stock_min = 0, $factorprin, $codigo_original,$CodigUsu)
    {
        $temp = explode(".", $codigo_interno);
        if ($familia != '' && $temp[count($temp) - 1] == '') {
            $pos = strrpos($codigo_interno, '.');
            $datos_familia = $this->familia_model->obtener_familia($familia);
            $numero = $datos_familia[0]->FAMI_Numeracion;
            $numero2 = $numero + 1;
            $codigo_interno = $datos_familia[0]->FAMI_CodigoInterno . '.' . str_pad($numero2, 3, "0", STR_PAD_LEFT);

            $this->familia_model->modificar_familia_numeracion($familia, $numero2);
        }

        $this->modificar_producto($producto, $familia, $tipo_producto, $nombre_producto, $descripcion_breve, $comentario, $codigo_interno, $imagen, $activo, $fabricante, $linea, $marca, $pdf, $modelo, $presentacion, $geneindi, $padre, $codigo_usuario, $nombrecorto_producto, $stock_min, $codigo_original,$CodigUsu);

        if (is_array($unidad_medida)) {
            foreach ($unidad_medida as $indice => $valor) {
                $umedida = $unidad_medida[$indice];

                ///stv
                if ($indice == 0 && ($factorprin != '' || $factorprin != 0)) {
//                $factor[0]=$factorprin;
                    $fact = $factorprin;//$factor[0];  // var_dump($fact);
                } else {
                    ///
                    $fact = $factor[$indice];
                    ///stv
                }
                ////                
                $flagP = $flagPrincipal[$indice];
                $punidad = $produnidad[$indice];
                if ($punidad != '') {
                    if ($umedida != '' && $umedida != '0')
                        $this->modificar_producto_unidad($punidad, $umedida, $producto, $fact, $flagP);
                    else {
                        $filter = new stdClass();
                        $filter->PROD_Codigo = $producto;
                        $filter->PRODUNIP_Codigo = $punidad;
                        $this->productoprecio_model->eliminar_varios($filter);

                        $this->eliminar_producto_unidades($punidad);
                    }
                } else {
                    if ($umedida != '' && $umedida != '0')
                        $this->insertar_producto_unidad($umedida, $producto, $fact, $flagP);
                }
            }
        }
//Modificar nombre_atributo
        $this->eliminar_producto_atributos($producto);
        if (is_array($nombre_atributo) > 0) {
            foreach ($nombre_atributo as $indice => $valor) {
                $attrib = $atributo[$indice];
                $t_attrib = $tipo_atributo[$indice];
                $v_attrib = $nombre_atributo[$indice];
                $data_prod_atr = $this->buscar_producto_atributo($producto, $attrib);
                if (count($data_prod_atr) > 0)
                    $this->modificar_producto_atributos($producto, $attrib, $t_attrib, $v_attrib);
                else
                    $this->insertar_producto_atributos($producto, $attrib, $t_attrib, $v_attrib);
            }
        }
//Modificar proveedor
        $this->productoproveedor_model->eliminar_proveedores($producto);
        if (is_array($proveedor) > 0) {
            foreach ($proveedor as $indice => $valor) {
                $prov = $valor;
                $filter = new stdClass();
                $filter->PROVP_Codigo = $prov;
                $filter->PROD_Codigo = $producto;
                $this->productoproveedor_model->insertar($filter);
            }
        }
    }

    public function modificar_stock($producto_id, $stock)
    {
        $this->db->where("PROD_Codigo", $producto_id);
        $this->db->update('cji_producto', array("PROD_Stock" => $stock));
    }

    public function modificar_ultCosto($producto_id, $costo)
    {
        $this->db->where("PROD_Codigo", $producto_id);
        $this->db->update('cji_producto', array("PROD_UltimoCosto" => $costo));
    }

    public function modificar_costoPromedio($producto_id, $costo)
    {
        $this->db->where("PROD_Codigo", $producto_id);
        $this->db->update('cji_producto', array("PROD_CostoPromedio" => $costo));
    }

    public function modificar_producto_atributos($producto, $atributo, $tipo, $valor)
    {
        switch ($tipo) {
            case 1://Numerico
                $valorNumerico = $valor;
                $valorDate = "0000-00-00 00:00:00";
                $valorString = "";
                break;
            case 2://Date
                $valorNumerico = "0";
                $valorDate = $valor;
                $valorString = "";
                break;
            case 3://Strind
                $valorNumerico = "0";
                $valorDate = "0000-00-00 00:00:00";
                $valorString = $valor;
                break;
        }

        $fechaModificacion = date('Y-m-d H:i:s');

        $where = array("PROD_Codigo" => $producto, "ATRIB_Codigo" => $atributo);
        $data = array("PRODATRIB_Numerico" => $valorNumerico, "PRODATRIB_Date" => $valorDate, "PRODATRIB_String" => $valorString, "PRODATRIB_FechaModificacion" => $fechaModificacion);
        $this->db->where($where);
        $this->db->update("cji_productoatributo", $data);
    }

    public function eliminar_producto_total($producto)
    {
        /* $this->eliminar_producto_proveedor($producto);

          $filter=new stdClass();
          $filter->PROD_Codigo=$producto;
          $this->productoprecio_model->eliminar_varios($filter);

          $this->eliminar_producto_unidades_total($producto);
          $this->eliminar_producto_atributos($producto);
          $this->eliminar_producto($producto); */

        $where = array("PROD_Codigo" => $producto, "COMPP_Codigo" => $this->somevar['compania']);
        $this->db->delete('cji_productocompania', $where);
    }

    public function eliminar_producto($producto)
    {
        $where = array("PROD_Codigo" => $producto);
        $this->db->delete('cji_producto', $where);
    }

    public function eliminar_producto_atributos($producto)
    {
        $where = array("PROD_Codigo" => $producto);

        /* No borrar atributo Precio de Costo para ferremax */
        if (FORMATO_IMPRESION == 4)
            $where = array("PROD_Codigo" => $producto, "ATRIB_Codigo !=" => 14);

        $this->db->delete('cji_productoatributo', $where);
    }

    public function eliminar_producto_proveedor($producto)
    {
        $where = array("PROD_Codigo" => $producto);
        $this->db->delete('cji_productoproveedor', $where);
    }

    public function eliminar_producto_unidades($productounidad)
    {

        $where = array("PRODUNIP_Codigo " => $productounidad);
        $this->db->delete('cji_productounidad', $where);
    }

    public function eliminar_producto_unidades_total($producto)
    {
        $where = array("PROD_Codigo" => $producto);
        $this->db->delete('cji_productounidad', $where);
    }

    public function buscar_producto_atributo($producto, $atributo)
    {
        $where = array("PROD_Codigo" => $producto, "ATRIB_Codigo" => $atributo, "PRODATRIB_FlagEstado" => 1);
        $query = $this->db->where($where)->get('cji_productoatributo');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function obtener_marca_modelo_por_producto($producto)
    {
        $sql = "SELECT * FROM cji_producto p INNER JOIN cji_marca m ON p.MARCP_Codigo = m.MARCP_Codigo WHERE p.PROD_Codigo =" . $producto . "";
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        return array();
    }


    ///aumentado stv

    public function obtener_maxcodigousu()
    {
        $sql = "select max(PROD_CodigoUsuario) as PROD_CodigoUsuario from cji_producto ";
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    ////

    ////
    public function listar_productos_pdf($flagBS, $tipo, $opcion = "", $orden = "1", $number_items = "", $offset = "", $nombre = "")
    {
        $compania = $this->somevar['compania'];
        /* $names = $this->companiaconfiguracion_model->listar('3');
         $arr = array();

 //print_r($arr);exit;
         switch ($tipo) {
             case 1://Todos
                 $where = array("PROD_FlagEstado" => 1);
                 break;
             case 2://Por tipo de producto
                 $where = array("PROD_FlagEstado" => 1, "TIPPROD_Codigo" => $opcion);
                 break;
             case 3://Por familia
                 $where = array("PROD_FlagEstado" => 1, "FAMI_Codigo" => $opcion);
                 break;
             case 4://Por proveedor
                 $where = array("PROD_FlagEstado" => 1, "cji_producto.PROVP_Codigo" => $opcion);
                 break;
             case 5://Por unidad de medida
                 $where = array("PROD_FlagEstado" => 1, "UNDMED_Codigo" => $opcion);
                 break;
         }
         switch ($orden) {
             case 1://Por nombre
                 $orden = "PROD_Nombre";
                 break;
             case 2://Por codigo
                 $orden = "PROD_Codigo";
                 break;
         }
          */


        $sql = "SELECT * from cji_producto p,cji_productocompania pc where p.PROD_Codigo=pc.PROD_Codigo
		and p.PROD_FlagEstado=1 and p.PROD_FlagBienServicio='" . $flagBS . "' and pc.COMPP_Codigo='" . $compania . "'
		and PROD_Nombre like '" . $nombre . "%' order by 1 asc ";

        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    ////
    public function listar_producto_sinInventario($filter = null, $number_items = "", $offset = "")
    {
        $this->db->select('p.* , pc.COMPP_Codigo');
        $this->db->join('cji_productocompania pc', 'pc.PROD_Codigo=p.PROD_Codigo', 'left');
        $this->db->join('cji_inventariodetalle invd', 'invd.PROD_Codigo=p.PROD_Codigo ', 'left');
        $this->db->where('p.PROD_FlagBienServicio ', 'B');
        $this->db->where('p.PROD_FlagEstado', 1);
        $this->db->where('pc.COMPP_Codigo', $this->session->userdata('compania'));
        $this->db->where('invd.PROD_Codigo is NULL');
        $this->db->orderby('p.PROD_FechaRegistro , p.PROD_Nombre', 'ASC');
        $query = $this->db->get('cji_producto p', $number_items, $offset);

        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        } else {
            return;
        }
    }

    public function listar_producto_enInventarioNull($filter = null, $number_items = "", $offset = "")
    {


        $this->db->select('p.* , pc.COMPP_Codigo');
        $this->db->join('cji_productocompania pc', 'pc.PROD_Codigo=p.PROD_Codigo', 'left');
        $this->db->join('cji_inventariodetalle invd', 'invd.PROD_Codigo=p.PROD_Codigo ', 'left');
        $this->db->where('p.PROD_FlagBienServicio ', 'B');
        $this->db->where('invd.INVD_FlagActivacion', 0);
        $this->db->where('p.PROD_FlagEstado', 1);
        $this->db->where('pc.COMPP_Codigo', $this->session->userdata('compania'));
        $this->db->orderby('p.PROD_Nombre', 'ASC');
        $query = $this->db->get('cji_producto p', $number_items, $offset);

        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        } else {
            return;
        }
    }


    public function listar_familia_pdf($flagBS,$codigo,$nombre)
    {
        $compania = $this->somevar['compania'];

        if($nombre=="--" & $codigo=="--"){
             $sql = "SELECT * from cji_familia f where  f.FAMI_FlagBienServicio='" . $flagBS . "' order by 1 asc "; 
        }else if($codigo !="--" && $nombre =="--"){
                $sql = "SELECT * from cji_familia f where  f.FAMI_FlagBienServicio='" . $flagBS . "' AND  f.FAMI_CodigoInterno LIKE '%".$codigo."%' order by 1 asc "; 
        }else if($nombre !="--" && $codigo == "--"){
                $sql = "SELECT * from cji_familia f where  f.FAMI_FlagBienServicio='" . $flagBS . "' AND  f.FAMI_Descripcion LIKE '%".$nombre."%' order by 1 asc "; 
        }else{
            $sql = "SELECT * from cji_familia f where  f.FAMI_FlagBienServicio='" . $flagBS . "' AND f.FAMI_Descripcion LIKE '%".$nombre."%' AND  f.FAMI_CodigoInterno LIKE '%".$codigo."%' order by 1 asc "; 
        }
       

       

        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function buscar_x_codigo($keyword, $flag, $compania){
        $query = $this->db->select('DISTINCT(cji_producto.PROD_Codigo), cji_producto.*')
                ->from('cji_productocompania')
                ->join('cji_producto','cji_producto.PROD_Codigo = cji_productocompania.PROD_Codigo', 'inner')
                ->where('cji_producto.PROD_FlagActivo', '1')
                ->where('cji_producto.PROD_FlagEstado', '1')
                ->where('cji_productocompania.COMPP_Codigo', $compania)
                ->where('cji_producto.PROD_FlagBienServicio', $flag)
                ->join('cji_marca', 'cji_marca.MARCP_Codigo = cji_producto.MARCP_Codigo', 'left')
                ->like('cji_producto.PROD_CodigoInterno', $keyword)
                ->or_like('cji_producto.PROD_CodigoUsuario', $keyword)
                ->order_by('cji_producto.PROD_Nombre')
                ->limit(50)
                ->get();
        if($query->num_rows > 0){
            return $query->result();
        }else{
            return NULL;
        }
    }

    public function cargarProductos_autocompletado($term, $flag, $compania, $almacen)
    {
        $query = $this->db->select('pro.*, alp.ALMPROD_Stock, alp.ALMPROD_CostoPromedio')
                        ->from('cji_almacen al')
                        ->join('cji_almacenproducto alp', 'alp.ALMAC_Codigo = al.ALMAP_Codigo', 'inner')
                        ->join('cji_producto pro', 'pro.PROD_Codigo = alp.PROD_Codigo', 'inner')
                        ->where('alp.ALMAC_Codigo', $almacen)
                        ->where('alp.COMPP_Codigo', $compania)
                        ->where('pro.PROD_FlagBienServicio', $flag)
                        ->where('pro.PROD_FlagActivo', '1')
                        ->where('pro.PROD_FlagEstado', '1')
                        ->like('pro.PROD_Nombre', $term)
                        ->order_by('pro.PROD_Nombre')
                        ->limit(10)
                        ->get();
        if($query->num_rows > 0){
            return $query->result();
        }else{
            return NULL;
        }
    }


    public function listar_morosos($filter = null, $number_items = "", $offset = "") {
        $this->db->select("cp.CPC_Serie,
                       cp.CPC_Numero,                        
                       (CASE c.CLIC_TipoPersona 
                       WHEN 1 THEN e.EMPRC_RazonSocial 
                       ELSE CONCAT((pe.PERSC_Nombre) , (''), (pe.PERSC_ApellidoPaterno), (''), (pe.PERSC_ApellidoMaterno)) end) nombre,              
                       m.MONED_Simbolo,
                       cp.CPC_total")
                ->join('cji_moneda m', 'm.MONED_Codigo=cp.MONED_Codigo', 'left')
                ->join("cji_cuentas cu", "cu.CUE_CodDocumento=cp.CPP_Codigo AND(cu.CUE_FlagEstadoPago = 'V' OR cu.CUE_FlagEstadoPago = 'A')","left")
                ->join("cji_cliente c", "c.CLIP_Codigo=cp.CLIP_Codigo AND c.CLIC_FlagEstado = '1'", 'left')
                ->join('cji_persona pe','pe.PERSP_Codigo=c.PERSP_Codigo','left')
                ->join('cji_empresa e','e.EMPRP_Codigo=c.EMPRP_Codigo','left')
                ->order_by('cp.CPC_Fecha','ASC')
                ->group_by('cp.CPP_Codigo')
                ->where('DATEDIFF(now(),cp.CPC_FechaRegistro)>',30)                
                ->where('cp.CPC_TipoOperacion',"V")
                ->where('cp.CPC_TipoDocumento',"F");
             
        $query = $this->db->get('cji_comprobante cp', $number_items, $offset);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
        else
            return;
    } 


}





?>