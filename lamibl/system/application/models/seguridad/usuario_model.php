<?php

class Usuario_model extends Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario'] = $this->session->userdata('usuario');
        $this->somevar['hoy'] = mdate("%Y-%m-%d %h:%i:%s", time());
    }

    public function usuario_saludo() {
        //var_dump($this->session->userdata('user'));
        $this->db->select('cji_persona.PERSC_Nombre,cji_persona.PERSC_ApellidoPaterno')
                ->from('cji_usuario')
                ->join('cji_persona', 'cji_usuario.PERSP_Codigo=cji_persona.PERSP_Codigo')
                ->where('cji_usuario.USUA_Codigo', $this->session->userdata('user'));
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }

            return $data;
        }
    }

    public function buscar_usuariopersona($idPersona) {
        $where = array("cji_usuario.PERSP_Codigo" => $idPersona);
        $query = $this->db->where($where)->get('cji_usuario');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }

            return $data;
        }
    }

    public function listar_vendedores($number_items = '', $offset = '') {
        $where = array("USUA_FlagEstado" => "1");
        $query = $this->db->where($where)
                ->join('cji_persona', 'cji_persona.PERSP_Codigo=cji_usuario.PERSP_Codigo')
                ->order_by('cji_persona.PERSC_Nombre, cji_persona.PERSC_ApellidoPaterno, cji_persona.PERSC_ApellidoMaterno')
                ->get('cji_usuario', $number_items, $offset);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function listar_usuarios($number_items = '', $offset = '') {
        $where = array("USUA_FlagEstado" => "1");
        $query = $this->db->where($where)->join('cji_persona', 'cji_persona.PERSP_Codigo=cji_usuario.PERSP_Codigo')->order_by('cji_persona.PERSC_Nombre, cji_persona.PERSC_ApellidoPaterno, cji_persona.PERSC_ApellidoMaterno')->get('cji_usuario', $number_items, $offset);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function obtener($usuario) {
        $this->db->select('*');
        $this->db->from('cji_usuario');
        $this->db->join('cji_persona', 'cji_persona.PERSP_Codigo=cji_usuario.PERSP_Codigo');
        $this->db->where('cji_usuario.USUA_Codigo', $usuario);
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            return $query->row();
        }
    }

    public function obtener2($usuario) {
        $this->db->select('*');
        $this->db->from('cji_usuario');
        $this->db->join('cji_persona', 'cji_persona.PERSP_Codigo=cji_usuario.PERSP_Codigo');
        $this->db->where('cji_usuario.USUA_Codigo', $usuario);
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function obtener_datosUsuario($user, $clave, $compania) {
        $where = array('USUA_usuario' => $user, 'USUA_Password' => $clave, 'USUA_FlagEstado' => '1');
        $query = $this->db->where($where)->get('cji_usuario');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function obtener_rolesUsuario($user, $compania/* , $establecimiento */) {
        $where = array('cji_usuario_compania.USUA_Codigo' => $user/* , 'COMPP_Codigo' => $establecimiento */, 'cji_usuario_compania.USUCOMC_Default' => '1');
        $query = $this->db->where($where)->join('cji_rol', 'cji_usuario_compania.ROL_Codigo=cji_rol.ROL_Codigo')->get('cji_usuario_compania');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function obtener_datosUsuarioLogin($user, $clave) {
        $where = array('USUA_usuario' => $user, 'USUA_Password' => $clave, 'USUA_FlagEstado' => '1');
        $query = $this->db->where($where)->get('cji_usuario');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function obtener_datosUsuario2($usuario) {
        $query = $this->db->where('USUA_Codigo', $usuario)->get('cji_usuario');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function insertar_usuario($persona, $usuario, $clave) {
        $data = array(
            "PERSP_Codigo" => $persona,
            "USUA_usuario" => $usuario,
            "USUA_Password" => md5($clave)
        );
        $this->db->insert("cji_usuario", $data);
        return $this->db->insert_id();
    }

    public function insertar_datosUsuario($txtNombres, $txtPaterno, $txtMaterno, $txtUsuario, $txtClave, $cboEstablecimiento, $cboRol, $default, $detaccion, $hid_Persona) {
        /* $this->persona_model->insertar_datosPersona("150101", "150101", "1", "193", $txtNombres, $txtPaterno, $txtMaterno, "11111111111", "1");
          $persona = $this->db->insert_id(); */
        $usuario = $this->insertar_usuario($hid_Persona, $txtUsuario, $txtClave);

        if (is_array($cboEstablecimiento)) {
            foreach ($cboEstablecimiento as $indice => $valor) {
                if ($detaccion[$indice] != 'e') {
                    $filter = new stdClass();
                    $filter->USUA_Codigo = $usuario;
                    $filter->COMPP_Codigo = $valor;
                    $filter->ROL_Codigo = $cboRol[$indice];
                    $filter->USUCOMC_Default = isset($default[$indice]) && $default[$indice] == '1' ? '1' : '0';
                    $this->usuario_compania_model->insertar($filter);
                }
            }
        }
    }

    public function modificar_datosUsuario($usuario, $rol, $establecimiento, $nombre_usuario, $nombres, $paterno, $materno) {
        $datos_usuario = $this->obtener_datosUsuario2($usuario);
        $persona = $datos_usuario[0]->PERSP_Codigo;
        $this->persona_model->modificar_datosPersona_nombres($persona, $nombres, $paterno, $materno);
        $this->modificar_usuario($usuario, $rol, $establecimiento, $nombre_usuario);
    }

    public function modificar_usuario($usuario, $rol, $establecimiento, $nombre_usuario) {
        $data = array("ROL_Codigo" => $rol,
            "EESTABP_Codigo" => $establecimiento,
            "USUA_usuario" => $nombre_usuario);
        $this->db->where('USUA_Codigo', $usuario);
        $this->db->update("cji_usuario", $data);
    }

    ///---------------------------------------------------------------
    /// modificar establecimiento y cargo
    public function modificar_datosUsuario22($usuario, $nombre_usuario, $nombres, $paterno, $materno) {
        $datos_usuario = $this->obtener_datosUsuario2($usuario);
        $persona = $datos_usuario[0]->PERSP_Codigo;
        $this->persona_model->modificar_datosPersona_nombres($persona, $nombres, $paterno, $materno);
        //$this->modificar_usuario($usuario,$rol,$establecimiento,$nombre_usuario);
        $this->modificar_usuario2($usuario, $nombre_usuario);
    }

    //--------------------------------------
    public function modificar_rolestauser($usuario, $rol, $establecimiento, $default) {

        //----ELIMINAR
        $cant_rol_esta = $this->buscar_usuariosrolesta($usuario);
        $cant_re = count($cant_rol_esta);

        //----INSERTAR
        if (is_array($establecimiento)) {

            $this->db->delete('cji_usuario_compania', array('USUA_Codigo' => $usuario));
            $ind_default = 0;
            $array_default = explode("_", $default);
            foreach ($establecimiento as $indice => $valor) {
                $filter = new stdClass();
                $filter->USUA_Codigo = $usuario;
                $filter->COMPP_Codigo = $valor;
                $filter->ROL_Codigo = $rol[$indice];
                //$filter->USUCOMC_Default = isset($default[$indice]) && $default[$indice] == '1' ? '1' : '0';
                if ($array_default[1] == $indice) {
                    $filter->USUCOMC_Default = 1;
                } else {
                    $filter->USUCOMC_Default = 0;
                }

                $this->usuario_compania_model->insertar($filter);
            }
        }
    }

    /*
      public function eliminar($usuario_compania){
      $this->db->delete('cji_usuario_compania',array('USUCOMP_Codigo' => $usuario_compania));
      }

     */

    ///-------------------------------------------------
    public function modificar_usuario2($usuario, $nombre_usuario) {
        $data = array("USUA_usuario" => $nombre_usuario);
        $this->db->where('USUA_Codigo', $usuario);
        $this->db->update("cji_usuario", $data);
    }

    public function modificar_usuarioClave($usuario, $clave) {
        $data = array("USUA_Password" => md5($clave));
        $this->db->where('USUA_Codigo', $usuario);
        $this->db->update("cji_usuario", $data);
    }

    public function eliminar_usuario($usuario) {
        $where = array("USUA_Codigo" => $usuario);
        $data = array("USUA_FlagEstado" => 0);
        $this->db->where($where);
        $this->db->update('cji_usuario', $data);
    }

    public function eliminar_rolestablecimiento($usuario) {
        $where = array("USUCOMP_Codigo" => $usuario);
        $this->db->delete('cji_usuario_compania', $where);
    }

    public function buscar_usuarios($filter, $number_items = '', $offset = '') {
        $wherenombres = "";
        $whereusuario = "";
        $whererol = "";
        if (isset($filter->nombres) && $filter->nombres != "") {
            $wherenombres = "and concat(c.PERSC_Nombre,' ',c.PERSC_ApellidoPaterno,' ',c.PERSC_ApellidoMaterno) like '%" . $filter->nombres . "%'";
        }
        if (isset($filter->usuario) && $filter->usuario != '') {
            $whereusuario = "and a.USUA_usuario like '%" . $filter->usuario . "%'";
        }
        if (isset($filter->rol) && $filter->rol != '') {
            $whererol = "and d.ROL_Descripcion like '" . $filter->rol . "%'";
        }
        $sql = "
                     select 
                     distinct a.USUA_Codigo,
                     a.PERSP_Codigo,
                     d.ROL_Codigo,
                     a.USUA_usuario
                     from cji_usuario as a
                     inner join cji_usuario_compania as b on a.USUA_Codigo=b.USUA_Codigo
                     inner join cji_persona as c on a.PERSP_Codigo=c.PERSP_Codigo
                     inner join cji_rol as d on b.ROL_Codigo=d.ROL_Codigo
                     where a.USUA_FlagEstado='1'
                     " . $wherenombres . "
                     " . $whereusuario . "
                      " . $whererol . "  GROUP BY b.USUA_Codigo ORDER BY  c.PERSC_Nombre "
        ;

        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function buscar_usuariosrolesta($filter) {

        $sql = "
                     select
                     a.USUA_Codigo,
                     b.COMPP_Codigo,
                      b.USUCOMP_Codigo,
                     a.PERSP_Codigo,
                     d.ROL_Codigo,
                     f.EESTABC_Descripcion,
                     d.ROL_Descripcion,
                     a.USUA_usuario
                     from cji_usuario as a
                     inner join cji_usuario_compania as b on a.USUA_Codigo=b.USUA_Codigo
                     inner join cji_persona as c on a.PERSP_Codigo=c.PERSP_Codigo
                     inner join cji_rol as d on b.ROL_Codigo=d.ROL_Codigo
                     inner join cji_compania as e on b.COMPP_Codigo=e.COMPP_Codigo
                     inner join cji_emprestablecimiento as f on e.EESTABP_Codigo=f.EESTABP_Codigo
                      where a.USUA_FlagEstado='1'
             
                     and a.USUA_Codigo = '" . $filter . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }
public function obtener_empresa_usuario($user, $compania) {
        $where = array('cji_usuario_compania.USUA_Codigo' => $user, 'cji_usuario_compania.USUCOMC_Default' => '1');
        $query = $this->db->select('*')->where($where)->join('cji_compania', 'cji_usuario_compania.COMPP_Codigo=cji_compania.COMPP_Codigo')->get('cji_usuario_compania');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }
    
    
    
}

?>