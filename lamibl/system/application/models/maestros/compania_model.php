<?php

class Compania_model extends Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->load->model('maestros/empresa_model');
        $this->load->model('maestros/emprestablecimiento_model');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario'] = $this->session->userdata('usuario');
        $this->somevar['hoy'] = mdate("%Y-%m-%d %h:%i:%s", time());
    }

    public function listar_empresas() {
        $query = $this->db->select('cji_compania.EMPRP_Codigo')->where('COMPC_FlagEstado', '1')->group_by('EMPRP_Codigo')->from('cji_compania')->get();
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function listar_establecimiento($empresa) {
        $query = $this->db->where('cji_compania.EMPRP_Codigo', $empresa)
                ->join('cji_emprestablecimiento e', 'e.EESTABP_Codigo=cji_compania.EESTABP_Codigo')
                ->where('COMPC_FlagEstado', '1')
                ->select('cji_compania.*, e.EESTABC_Descripcion')
                ->get('cji_compania');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }else
            return array();
    }

    ////////////////////////////////////////////////
    public function valorizacion($fh_ini, $fh_fin, $comp_select, $producto_busca) {
        $sql = "SELECT Compania.EESTABC_Descripcion, e.Existencia, cp.CuotaxPagar, cc.CuotaxCobrar,Compania.COMPP_Codigo
                    FROM 
                    (
                        SELECT com.COMPP_Codigo,eest.EESTABC_Descripcion 
                        FROM cji_compania com 
                        INNER JOIN cji_emprestablecimiento eest 
                        ON eest.EESTABP_Codigo=com.EESTABP_Codigo 
                        WHERE com.COMPC_FlagEstado=1 AND com.EMPRP_Codigo=1
                    ) AS Compania

                    LEFT JOIN 
                    /************ Existencia en Almacen  ***************/
                    (
                        SELECT SUM(apro.ALMPROD_CostoPromedio * apro.ALMPROD_Stock)
                        AS Existencia, apro.COMPP_Codigo,apro.PROD_Codigo
                        FROM cji_almacenproducto apro
                        INNER JOIN cji_compania com
                        ON apro.COMPP_Codigo=com.COMPP_Codigo
                        WHERE apro.ALMPROD_Stock >0 
                        GROUP BY apro.COMPP_Codigo";
        if ($producto_busca != "") {
            $sql.=" AND apro.PROD_Codigo =$producto_busca";
        } 
        /* GROUP BY ALMAC_Codigo */
        $sql.=") AS e 
                    ON Compania.COMPP_Codigo = e.COMPP_Codigo

                    LEFT JOIN 
                    /************ Cuentas x Cobrar  ***************/
                    (
                        SELECT SUM( CUE_MONTO ) AS CuotaxCobrar, COMPP_Codigo
                        FROM cji_cuentas
                        WHERE CUE_TipoCuenta =1 
                            AND CUE_FlagEstado=1
                        GROUP BY COMPP_Codigo
                    ) AS cc 
                    ON e.COMPP_Codigo = cc.COMPP_Codigo

                    LEFT JOIN 
                    /************ Cuentas x Pagar  ***************/
                    (
                        SELECT SUM( CUE_MONTO ) AS CuotaxPagar, COMPP_Codigo
                        FROM cji_cuentas
                        WHERE CUE_TipoCuenta =2
                            AND CUE_FlagEstado=1
                        GROUP BY COMPP_Codigo
                    ) AS cp 
                    ON e.COMPP_Codigo = cp.COMPP_Codigo WHERE 1=1";

//        $this->db->select('Compania.EESTABC_Descripcion, e.Existencia, cp.CuotaxPagar, cc.CuotaxCobrar,Compania.COMPP_Codigo')
//                ->from('SELECT com.COMPP_Codigo,eest.EESTABC_Descripcion 
//                        FROM cji_compania com 
//                        INNER JOIN cji_emprestablecimiento eest 
//                        ON eest.EESTABP_Codigo=com.EESTABP_Codigo 
//                        WHERE com.COMPC_FlagEstado=1 AND com.EMPRP_Codigo=1 AS Compania')
//                ->join('SELECT SUM( ALMPROD_CostoPromedio * ALMPROD_Stock ) AS Existencia, COMPP_Codigo,PROD_Codigo
//                        FROM cji_almacenproducto
//                        WHERE ALMPROD_Stock >0
//                       /*GROUP BY ALMAC_Codigo*/ 
//                        AS e', 'Compania.COMPP_Codigo = e.COMPP_Codigo', 'left')
//                ->join(' SELECT SUM( CUE_MONTO ) AS CuotaxCobrar, COMPP_Codigo
//                        FROM cji_cuentas
//                        WHERE CUE_TipoCuenta =1
//                        /*GROUP BY COMPP_Codigo*/
//                        AS cc', 'e.COMPP_Codigo = cc.COMPP_Codigo', 'left'
//                )
//                ->join(' SELECT SUM( CUE_MONTO ) AS CuotaxPagar, COMPP_Codigo
//                        FROM cji_cuentas
//                        WHERE CUE_TipoCuenta =2
//                        /*GROUP BY COMPP_Codigo*/ 
//                        AS cp', 'e.COMPP_Codigo = cp.COMPP_Codigo', 'left');

        if ($producto_busca != '') {
            //$sql.=" AND e.PROD_Codigo=$producto_busca ";
            $sql.=" AND Compania.COMPP_Codigo IN (SELECT COMPP_Codigo FROM cji_almacenproducto WHERE PROD_Codigo=$producto_busca) ";
            //$this->db->where_in('Compania.COMPP_Codigo', "SELECT COMPP_Codigo FROM cji_almacenproducto WHERE PROD_Codigo=$producto_busca");
        }

        if (count($comp_select) > 0) {
            $array_compania = "";
            $i = 0;
            foreach ($comp_select as $key => $value) {
                if ($i > 0) {
                    $array_compania.=",";
                }
                $array_compania.=$value[0];
                $i++;
            }
            $sql.=" AND  Compania.COMPP_Codigo IN($array_compania) ";
            //$this->db->where_in('Compania.COMPP_Codigo', $array_compania);
        }

        $sql.=" GROUP BY Compania.COMPP_Codigo";
        //echo $sql;
        //$query = $this->db->get();
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }

        return array();
    }

    ///////////////////////////////////////////

    public function listar_companias_usuario() {

        $sql = "SELECT * FROM cji_usuario_compania uc JOIN cji_compania c ON uc.COMPP_Codigo = c.COMPP_Codigo WHERE USUA_Codigo = '" . $this->session->userdata('user') . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows > 1) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }

        return array();
    }

    public function obtener_compania($compania) {
        $where = array('COMPP_Codigo' => $compania);
        $query = $this->db->where($where)->get('cji_compania');
        if ($query->num_rows > 0) {
      
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function modificar_compania($compania, $logo) {
        $data = array("COMPC_Logo" => $logo);
        $this->db->where("COMPP_Codigo", $compania);
        $this->db->update('cji_compania', $data);
    }

    public function listar() {
        $query = $this->db->where('COMPC_FlagEstado', '1')->get('cji_compania');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function obtener($compania) {
        $where = array('COMPP_Codigo' => $compania);
        $query = $this->db->where($where)->get('cji_compania');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function modificar($compania, $logo, $tipo_valorizacion) {
        $data = array("COMPC_Logo" => $logo, "COMPC_TipoValorizacion" => $tipo_valorizacion);
        $this->db->where("COMPP_Codigo", $compania);
        $this->db->update('cji_compania', $data);
    }
//--------------------------------------------------------------------------
	public function eliminar_compania_x_esta($establecimiento){
	//$this->db->delete('cji_compania',array('EESTABP_Codigo' => $establecimiento));
	$data = array( 'COMPC_FlagEstado' => 0);
	$this->db->where('EESTABP_Codigo', $establecimiento);
	$this->db->update('cji_compania', $data); 
	 
	}
	
	public function obtener_x_establecimiento($establecimiento) {
        $where = array('EESTABP_Codigo' => $establecimiento);
        $query = $this->db->where($where)->get('cji_compania');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

//------------------------------------------------------------------------
	
    public function listar_compania() {
        /* $array_compania = $this->compania_model->listar_companias_usuario();
          $arreglo = array();
          $resultado = '';
          if(count($array_compania)>0){
          foreach($array_compania as $indice=>$valor){
          $compania   = $valor->COMPP_Codigo;
          $empresa          = $valor->EMPRP_Codigo;
          $datos_empresa   = $this->empresa_model->obtener_datosEmpresa($empresa);
          $razon_social         = $datos_empresa[0]->EMPRC_RazonSocial;
          $arreglo[$compania] = $razon_social;
          }
          $resultado = "<select onchange='cambiar_sesion();' name='cboCompania' id='cboCompania' class='comboMedio'>".$this->html->optionHTML($arreglo,$indSel,array('','::Seleccione::'))."</select>";
          }
          return $resultado; */

        $array_empresas = $this->compania_model->listar_empresas();
        $arreglo = array();
        foreach ($array_empresas as $indice => $valor) {
            $empresa = $valor->EMPRP_Codigo;
            $datos_empresa = $this->empresa_model->obtener_datosEmpresa($empresa);
            $razon_social = $datos_empresa[0]->EMPRC_RazonSocial;
            $arreglo[] = array('tipo' => '1', 'nombre' => $razon_social, 'compania' => '');

            $array_establecimiento = $this->compania_model->listar_establecimiento($empresa);
            foreach ($array_establecimiento as $indice => $valor) {
                $compania = $valor->COMPP_Codigo;
                $datos_establecimiento = $this->emprestablecimiento_model->obtener($valor->EESTABP_Codigo);
                $nombre_establecimiento = $datos_establecimiento[0]->EESTABC_Descripcion;
                $arreglo[] = array('tipo' => '2', 'nombre' => $nombre_establecimiento, 'compania' => $compania);
            }
        }
        return $arreglo;
    }

}

?>