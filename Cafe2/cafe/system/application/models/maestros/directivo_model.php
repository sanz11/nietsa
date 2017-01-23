<?php

class Directivo_model extends Model {

    var $somevar;

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar['hoy'] = mdate("%Y-%m-%d %h:%i:%s", time());
    }

    public function lista_cumpleanios($fechaHoy) {
        $this->db->select('cji_directivo.DIREP_Codigo,cji_persona.PERSC_FechaNac,
                            cji_persona.PERSC_Nombre,cji_persona.PERSC_ApellidoPaterno,
                            cji_cargo.CARGC_Descripcion,cji_directivo.DIREC_Imagen')
                ->from('cji_directivo')
                ->join('cji_persona', 'cji_directivo.PERSP_Codigo=cji_persona.PERSP_Codigo')
                ->join('cji_cargo', 'cji_directivo.CARGP_Codigo=cji_cargo.CARGP_Codigo')
                ->where('cji_directivo.DIREC_FlagEstado', 1)
                ->where('DATE_FORMAT(cji_persona.PERSC_FechaNac,"%m-%d")', $fechaHoy);
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function listar_vendedores($empresa, $cargo = "") {
        $where = array("cji_directivo.DIREC_FlagEstado" => 1, 'cji_directivo.EMPRP_Codigo' => $empresa);
        if ($cargo != '')
            $where['CARGP_Codigo'] = $cargo;
        $query = $this->db->order_by('`cji_directivo`.PERSP_Codigo')
                ->join('cji_persona', 'cji_persona.PERSP_Codigo = cji_directivo.PERSP_Codigo', 'left')
                ->where_not_in('DIREP_Codigo', '0')->where($where)
                ->select('cji_directivo.DIREP_Codigo,cji_persona.PERSP_Codigo,cji_persona.PERSC_Nombre,cji_persona.PERSC_ApellidoPaterno,cji_persona.PERSC_ApellidoMaterno,cji_persona.PERSC_NumeroDocIdentidad')
                ->from('cji_directivo')
                ->get();
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function lista_vendedores2($empresa = '', $cargo = '', $number_items = '', $offset = '') {
        $sql = "
            select
            dir.DIREP_Codigo DIREP_Codigo,
            dir.EMPRP_Codigo EMPRP_Codigo,
            dir.PERSP_Codigo PERSP_Codigo,
            dir.CARGP_Codigo CARGP_Codigo,
            dir.DIREC_FechaInicio Inicio,
            dir.DIREC_FechaFin Fin,
            dir.DIREC_NroContrato Nro_Contrato,
            emp.EMPRC_RazonSocial empresa,
            per.PERSC_Nombre nombre,
            per.PERSC_ApellidoPaterno paterno,
            per.PERSC_ApellidoMaterno materno,
            per.PERSC_NumeroDocIdentidad dni,
            car.CARGC_Descripcion cargo
            from cji_directivo as dir
            inner join cji_empresa as emp on dir.EMPRP_Codigo=emp.EMPRP_Codigo
            inner join cji_persona as per on dir.PERSP_Codigo=per.PERSP_Codigo
            inner join cji_cargo as car on dir.CARGP_Codigo=car.CARGP_Codigo
            where dir.DIREC_FlagEstado=1 
            and dir.DIREP_Codigo!=0 ";
        if ($empresa != '' && $empresa != '0') {
            $sql.=" and dir.EMPRP_Codigo=" . 2 . " ";
        }
        if ($cargo != '' && $cargo != '0') {
            $sql.=" and dir.CARGP_Codigo=" . $cargo . " ";
        }
        $sql.=" order by nombre";

        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function listar_combodirectivo($empresa) {
        $sql = "SELECT 
            CONCAT(cji_persona.PERSC_Nombre,'-' , cji_persona.PERSC_ApellidoPaterno , ' ', cji_persona.PERSC_ApellidoMaterno,'_',cji_directivo.PERSP_Codigo) AS NOMBRE_VAL,
            CONCAT(cji_persona.PERSC_Nombre,' ' , cji_persona.PERSC_ApellidoPaterno , ' ', cji_persona.PERSC_ApellidoMaterno) AS NOMBRE
            FROM cji_directivo
            INNER JOIN cji_persona
                ON cji_directivo.PERSP_Codigo=cji_persona.PERSP_Codigo
            WHERE cji_directivo.EMPRP_Codigo=$empresa AND  cji_directivo.DIREC_FlagEstado=1";

        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }
    
//     public function combo_directivos($number_items = '', $offset = '') {
//     	$where = array("USUA_FlagEstado" => "1");
//     	$query = $this->db->where($where)->join('cji_persona', 'cji_persona.PERSP_Codigo=cji_usuario.PERSP_Codigo')->order_by('cji_persona.PERSC_Nombre, cji_persona.PERSC_ApellidoPaterno, cji_persona.PERSC_ApellidoMaterno')->get('cji_usuario', $number_items, $offset);
//     	if ($query->num_rows > 0) {
//     		foreach ($query->result() as $fila) {
//     			$data[] = $fila;
//     		}
//     		return $data;
//     	}
//     }
    
    public function combo_directivos($number_items = '', $offset = '') {
    	$sql="select   directivo.DIREP_Codigo,PERSC_Nombre ,PERSC_ApellidoMaterno,PERSC_ApellidoPaterno   from cji_directivo directivo inner join cji_persona persona
on directivo.PERSP_Codigo = persona.PERSP_Codigo GROUP BY
PERSC_Nombre , PERSC_ApellidoMaterno, PERSC_ApellidoPaterno  and DIREC_FlagEstado = 1  ";
    	$query = $this->db->query($sql);
    	if ($query->num_rows > 0) {
    		foreach ($query->result() as $fila) {
    			$data[] = $fila;
    		}
    		return $data;
    	}
    }
    
/*
    public function listar_directivo($empresa, $cargo = '') {
        $where = array('cji_usuario_compania.ROL_Codigo' => 1,
            'cji_usuario_compania.COMPP_Codigo' => $this->somevar ['compania'],
            'cji_directivo.DIREC_FlagEstado' => 1,
            'cji_usuario.USUA_FlagEstado' => 1
        );
        $query = $this->db->order_by('cji_directivo.PERSP_Codigo')
                ->join('cji_persona', 'cji_persona.PERSP_Codigo=cji_directivo.PERSP_Codigo')
                ->join('cji_usuario', 'cji_usuario.PERSP_Codigo=cji_persona.PERSP_Codigo')
                ->join('cji_usuario_compania', 'cji_usuario_compania.USUA_Codigo=cji_usuario.USUA_Codigo')
                ->where($where)
                ->select('cji_directivo.DIREP_Codigo,cji_persona.PERSP_Codigo,cji_persona.PERSC_Nombre,cji_persona.PERSC_ApellidoPaterno,cji_persona.PERSC_ApellidoMaterno')
                ->from('cji_directivo')
                ->get();
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }*/
	
	
	
	  public function listar_directivo($empresa, $cargo = '') {
        $where = array(
		'cji_directivo.EMPRP_Codigo' => $empresa,
            'cji_cargo.COMPP_Codigo' => $this->somevar ['compania'],
            'cji_directivo.DIREC_FlagEstado' => 1,
            'cji_cargo.CARGC_Descripcion' => 'VENDEDOR'
			

			
        );
        $query = $this->db->order_by('cji_directivo.PERSP_Codigo')
		
                ->join('cji_persona', 'cji_persona.PERSP_Codigo=cji_directivo.PERSP_Codigo')
                ->join('cji_cargo', 'cji_directivo.CARGP_Codigo=cji_cargo.CARGP_Codigo')
                
                ->where($where)
                ->select('cji_directivo.DIREP_Codigo,cji_persona.PERSP_Codigo,cji_persona.PERSC_Nombre,cji_persona.PERSC_ApellidoPaterno,cji_persona.PERSC_ApellidoMaterno')
                ->from('cji_directivo')
                ->get();
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }
	

    function obtener_directivo($directivo) {
        $where = array('DIREP_Codigo' => $directivo);
        $query = $this->db
                ->join('cji_persona', 'cji_persona.PERSP_Codigo = cji_directivo.PERSP_Codigo', 'left')
                ->where($where)
                ->select('cji_directivo.*, cji_persona.PERSC_ApellidoPaterno, cji_persona.PERSC_ApellidoMaterno, cji_persona.PERSC_Nombre')
                ->get('cji_directivo');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    function buscar_directivo($empresa, $persona) {
        $where = array('EMPRP_Codigo' => $empresa, 'PERSP_Codigo' => $persona);
        $query = $this->db->where($where)->get('cji_directivo');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function listar_directivos2($empresa = '', $cargo = '', $number_items = '', $offset = '') {
        $sql = "
            select
            dir.DIREP_Codigo DIREP_Codigo,
            dir.EMPRP_Codigo EMPRP_Codigo,
            dir.PERSP_Codigo PERSP_Codigo,
            dir.CARGP_Codigo CARGP_Codigo,
            dir.DIREC_FechaInicio Inicio,
            dir.DIREC_FechaFin Fin,
            dir.DIREC_NroContrato Nro_Contrato,
            emp.EMPRC_RazonSocial empresa,
            per.PERSC_Nombre nombre,
            per.PERSC_ApellidoPaterno paterno,
            per.PERSC_ApellidoMaterno materno,
            per.PERSC_NumeroDocIdentidad dni,
            car.CARGC_Descripcion cargo
            from cji_directivo as dir
            inner join cji_empresa as emp on dir.EMPRP_Codigo=emp.EMPRP_Codigo
            inner join cji_persona as per on dir.PERSP_Codigo=per.PERSP_Codigo
            inner join cji_cargo as car on dir.CARGP_Codigo=car.CARGP_Codigo
            where dir.DIREC_FlagEstado=1 
            and dir.DIREP_Codigo!=0 ";
        if ($empresa != '' && $empresa != '0') {
            $sql.=" and dir.EMPRP_Codigo=" . $empresa . " ";
        }
        if ($cargo != '' && $cargo != '0') {
            $sql.=" and dir.CARGP_Codigo=" . $cargo . " ";
        }
        $sql.=" order by nombre";

        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

//A_listar directivos 2
    public function buscar_directivo2($filter, $number_items = '', $offset = '') {
        $where = '';
        $where_empr = '';
        $where_pers = '';

        if (isset($filter->numdoc) && $filter->numdoc != "")
            $where_pers.=' and (per.PERSC_NumeroDocIdentidad like "' . $filter->numdoc . '") ';
        if (isset($filter->nombre) && $filter->nombre != "")
            $where_pers.=' and (per.PERSC_Nombre like "%' . $filter->nombre . '%") ';
        if (isset($filter->empresa) && $filter->empresa != "" && $filter->empresa != "0")
            $where_pers.=' and (dir.EMPRP_Codigo = "' . $filter->empresa . '") ';

        if ($number_items == "" && $offset == "") {
            $limit = "";
        } else {
            $limit = "limit $offset,$number_items";
        }
        $compania = $this->somevar['compania'];

        $sql = "
                    select
                    dir.DIREP_Codigo DIREP_Codigo,
                    dir.EMPRP_Codigo EMPRP_Codigo,
                    dir.PERSP_Codigo PERSP_Codigo,
                    dir.CARGP_Codigo CARGP_Codigo,
                    dir.DIREC_FechaInicio Inicio,
                    dir.DIREC_FechaFin Fin,
                    dir.DIREC_NroContrato Nro_Contrato,
                    emp.EMPRC_RazonSocial empresa,
                    per.PERSC_Nombre nombre,
                    per.PERSC_ApellidoPaterno paterno,
                    per.PERSC_ApellidoMaterno materno,
                    per.PERSC_NumeroDocIdentidad dni,
                    car.CARGC_Descripcion cargo
                    from cji_directivo as dir
                    inner join cji_empresa as emp on dir.EMPRP_Codigo=emp.EMPRP_Codigo
                    inner join cji_persona as per on dir.PERSP_Codigo=per.PERSP_Codigo
                    inner join cji_cargo as car on dir.CARGP_Codigo=car.CARGP_Codigo
                    where dir.DIREC_FlagEstado=1
                    and dir.DIREP_Codigo!=0 " . $where . " " . $where_pers . "
                    order by nombre
                    " . $limit . "
                    ";
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function obtener_empresa($idCompania) {

        $query = $this->db->where('COMPP_Codigo', $idCompania)->select('EMPRP_Codigo')->get('cji_compania');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function insertar_datosDirectivo($empresa, $persona, $finicio, $ffin, $cargo, $contrato, $imagen) {
        $compania = $this->somevar['compania'];

        /* if ($fcontrato == '' || $contrato == '0')
          $forma_pago = NULL; */
        $data = array(
            "EMPRP_Codigo" => $empresa,
            "PERSP_Codigo" => $persona,
            "CARGP_Codigo" => $cargo,
            "DIREC_Imagen" => $imagen,
            "DIREC_FechaInicio" => $finicio,
            "DIREC_FechaFin" => $ffin,
            "DIREC_NroContrato" => $contrato
        );
        $this->db->insert("cji_directivo", $data);
        $directivo = $this->db->insert_id();

//$this->insertar_directivo_compania($directivo);
    }

    public function insertar_directivo_compania($directivo) {
        $data = array(
            "DIREP_Codigo" => $directivo,
            "COMPP_Codigo" => $this->somevar['compania'],
        );
        $this->db->insert("cji_directivocompania", $data);
    }

    public function eliminar_directivo($directivo) {
        $data = array("DIREC_FlagEstado" => '0');
        $where = array("DIREP_Codigo" => $directivo);
        $this->db->where($where);
        $this->db->update('cji_directivo', $data);
    }

    public function modificar_datosDirectivo($directivo, $empresa, $personacod, $cargo, $fecini, $fecfin, $contrato, $imagen) {
//$user     =  $this->somevar ['user'] ;
        date_default_timezone_set('America/Lima');
        $Fec = date("Y-m-d");
        $time = date("H:i:s");
        $modified = $Fec . " " . $time;
        if ($imagen == '') {
            $data = array(
                "EMPRP_Codigo" => $empresa,
                "PERSP_Codigo" => $personacod,
                "CARGP_Codigo" => $cargo,
                "DIREC_FechaInicio" => $fecini,
                "DIREC_FechaFin" => $fecfin,
                "DIREC_NroContrato" => $contrato,
                "DIREC_FechaModificacion" => $modified
            );
        } else {
            $data = array(
                "EMPRP_Codigo" => $empresa,
                "PERSP_Codigo" => $personacod,
                "CARGP_Codigo" => $cargo,
                "DIREC_Imagen" => $imagen,
                "DIREC_FechaInicio" => $fecini,
                "DIREC_FechaFin" => $fecfin,
                "DIREC_NroContrato" => $contrato,
                "DIREC_FechaModificacion" => $modified
            );
        }
        $where = array("DIREP_Codigo" => $directivo);
        $this->db->where($where);
        $this->db->update('cji_directivo', $data);
    }
    
    
    
    
    ////stv
    public function obtener_directivo_xusu($usuopt='') {
        
        $where="";
        if($usuopt!=""){
            $where.=" and cji_usuario.USUA_Codigo='$usuopt' ";
        }

        $query = $this->db->query("select cji_directivo.DIREP_Codigo,cji_usuario.USUA_Codigo from cji_usuario,cji_directivo,cji_usuario_compania
where cji_usuario.PERSP_Codigo=cji_directivo.PERSP_Codigo and cji_usuario_compania.USUA_Codigo=cji_usuario.USUA_Codigo and USUA_FlagEstado=1 
and cji_usuario_compania.COMPP_Codigo='".$this->somevar ['compania']."' $where ");
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }
    ///
    
    public function autocompleteDirectivo($keyword){
    	try {
    		$sql = "select * from cji_directivo dir inner join cji_persona per 
					on dir.PERSP_Codigo = per.PERSP_Codigo
					where PERSC_Nombre LIKE '%" . $keyword . "%' and DIREC_FlagEstado = 1 ";
    
    		$query = $this->db->query($sql);
    		if ($query->num_rows > 0) {
    			foreach ($query->result() as $fila) {
    				$data[] = $fila;
    			}
    			return $data;
    		}
    
    	} catch (Exception $e) {
    		 
    	}
    }

}

//FIN CLASE
?>