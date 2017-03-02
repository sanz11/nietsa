<?php

class Usuario extends Controller
{

    public function __construct()
    {
        parent::Controller();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->model('almacen/guiatrans_model');
        $this->load->model('almacen/guiain_model');
        $this->load->model('almacen/guiarem_model');
        $this->load->model('maestros/persona_model');
        $this->load->model('ventas/comprobante_model');
        $this->load->model('seguridad/usuario_model');
        $this->load->model('seguridad/usuario_compania_model');
        $this->load->model('maestros/emprestablecimiento_model');
        $this->load->model('maestros/compania_model');
        $this->load->model('maestros/directivo_model');
        $this->load->model('seguridad/rol_model');
        $this->load->library('layout', 'layout');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['empresa'] = $this->session->userdata('empresa');
        $this->somevar['rol'] = $this->session->userdata('rol');
        
    }

    public function index()
    {
        $this->layout->view('seguridad/inicio');
    }

    public function usuarios($j = '0')
    {
        $data['txtNombres'] = "";
        $data['txtUsuario'] = "";
        $data['txtRol'] = "";
        $data['registros'] = count($this->usuario_model->listar_usuarios());
        $conf['base_url'] = site_url('seguridad/usuario/usuarios/');
        $conf['total_rows'] = $data['registros'];
        $conf['per_page'] = 10;
        $conf['num_links'] = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $conf['total_rows'] = $data['registros'];
        $offset = (int)$this->uri->segment(4);
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $listado_usuarios = $this->usuario_model->listar_usuarios($conf['per_page'], $offset);
        $item = $j + 1;
        $lista = array();
        if (count($listado_usuarios) > 0) {
            foreach ($listado_usuarios as $indice => $valor) {
                $listado_usuarios = $this->usuario_compania_model->listar_establecimiento($valor->USUA_Codigo, true);

                $codigo = $valor->USUA_Codigo;
                $persona = $valor->PERSP_Codigo;
                $rol = count($listado_usuarios) > 0 ? $listado_usuarios[0]->ROL_Codigo : '';

                $nombre_usuario = $valor->USUA_usuario;
                $datos_persona = $this->persona_model->obtener_datosPersona($persona);
                $datos_rol = $this->rol_model->obtener_rol($rol);
                $nombre_rol = count($datos_rol) > 0 ? $datos_rol[0]->ROL_Descripcion : '';
                $nombre_persona = $datos_persona[0]->PERSC_Nombre . " " . $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno;

                $editar = "<a href='#' onclick='editar_usuario(" . $codigo . ")'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver = "<a href='#' onclick='ver_usuario(" . $codigo . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Ver'></a>";
                $eliminar = "<a href='#' onclick='eliminar_usuario(" . $codigo . ")'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";
                $lista[] = array($item, $nombre_persona, $nombre_usuario, $nombre_rol, $editar, $ver, $eliminar);
                $item++;
            }
        }
        $data['action'] = base_url() . "index.php/seguridad/usuario/buscar_usuarios";
        $data['titulo_busqueda'] = "BUSCAR USUARIO";
        $data['titulo_tabla'] = "RELACI&Oacute;N de USUARIOS";
        $data['lista'] = $lista;
        $data['oculto'] = form_hidden(array('base_url' => base_url()));

        //
        $this->layout->view('seguridad/usuario_index', $data);
    }

    public function nuevo_usuario($rnombre = '', $rapellidoPaterno = '', $rapellidoMaterno = '', $rUsuario = '', $rClave = '', $rClave2 = '')
    {
        $datos_roles = $this->rol_model->listar_roles();
        $arreglo = array('' => '::Selecione::');
        foreach ($datos_roles as $indice => $valor) {
            $indice1 = $valor->ROL_Codigo;
            $valor1 = $valor->ROL_Descripcion;
            $arreglo[$indice1] = $valor1;
        }
        $compania = $this->somevar ['compania'];
        $temp = $this->compania_model->obtener_compania($compania);
        $empresa = $temp[0]->EMPRP_Codigo;

        $cboEstablecimiento = "<select id='cboEstablecimiento' name='cboEstablecimiento' class='comboMedio'>" . $this->OPTION_generador($this->compania_model->listar_establecimiento($this->somevar ['empresa']), 'COMPP_Codigo', 'EESTABC_Descripcion') . '</select>';
        $data['cboDirectivo'] = $this->OPTION_generador($this->directivo_model->listar_combodirectivo($empresa), 'NOMBRE_VAL', 'NOMBRE', "::Seleccione::");
        $lblNombres = form_label('NOMBRES *', 'nombres');
        $lblPaterno = form_label('APELLIDO PATERNO *', 'paterno');
        $lblMaterno = form_label('APELLIDO MATERNO', 'materno');
        $lblUsuario = form_label('USUARIO *', 'usuario');
        $lblClave = form_label('CLAVE *', 'clave');
        $lblClave2 = form_label('REPETIR CLAVE *', 'clave');
        $idPersona = "";
        $txtNombres = form_input(array('name' => 'txtNombres', 'id' => 'txtNombres', 'value' => '', 'maxlength' => '30', 'class' => 'cajaMedia', 'value' => $rnombre, 'readonly' => 'readonly'));
        $txtPaterno = form_input(array('name' => 'txtPaterno', 'id' => 'txtPaterno', 'value' => '', 'maxlength' => '30', 'class' => 'cajaMedia', 'value' => $rapellidoPaterno, 'readonly' => 'readonly'));
        $txtMaterno = form_input(array('name' => 'txtMaterno', 'id' => 'txtMaterno', 'value' => '', 'maxlength' => '30', 'class' => 'cajaMedia', 'value' => $rapellidoMaterno, 'readonly' => 'readonly'));
        $txtUsuario = form_input(array('name' => 'txtUsuario', 'id' => 'txtUsuario', 'value' => '', 'maxlength' => '30', 'class' => 'cajaPequena', 'value' => $rUsuario));
        $txtClave = form_password(array('name' => 'txtClave', 'id' => 'txtClave', 'value' => '', 'maxlength' => '30', 'class' => 'cajaPequena', 'value' => $rClave));
        $txtClave2 = form_password(array('name' => 'txtClave2', 'id' => 'txtClave2', 'value' => '', 'maxlength' => '30', 'class' => 'cajaPequena', 'value' => $rClave2));
        $oculto = form_hidden(array('accion' => "", 'codigo' => "", 'modo' => "insertar", 'base_url' => base_url()));
        $data['titulo'] = "REGISTRAR USUARIO";
        $data['idPersona'] = $idPersona;
        $data['formulario'] = "frmUsuario";
        $data['campos'] = array($lblNombres, $lblPaterno, $lblMaterno, $lblUsuario, $lblClave, $lblClave2);
        $data['valores'] = array($txtNombres, $txtPaterno, $txtMaterno, $txtUsuario, $txtClave, $txtClave2);
        $data['lista'] = array();
        $data['action'] = base_url() . "/index.php/seguridad/usuario/insertar_usuario";
        $data['oculto'] = $oculto;
        $data['onload'] = "onload=\"$('#txtNombres').focus();\"";
        $this->layout->view('seguridad/usuario_nuevo', $data);
    }

    public function buscar_usuario()
    {
        $idPersona = "";
        $this->load->library('layout', 'layout');
        $idPersona = $this->input->post('idpersona');
        //$idPersona=$_POST['idPersona'];
        $data = $this->usuario_model->buscar_usuariopersona($idPersona);
        if (count($data) > 0) {
            echo "1_|_";
        } else {
            echo "2_|_";
        }
        //echo $idPersona;
        //var_dump($idPersona);
    }

    public function insertar_usuario()
    {
        $idPersona = $this->input->post('idPersona');
        $rnombre = $this->input->post('txtNombres');
        $rapellidoPaterno = $this->input->post('txtPaterno');
        $rapellidoMaterno = $this->input->post('txtMaterno');
        $rUsuario = $this->input->post('txtUsuario');
        $rClave = $this->input->post('txtClave');
        $rClave2 = $this->input->post('txtClave2');
        $this->form_validation->set_rules('txtNombres', 'Nombre', 'required');
        $this->form_validation->set_rules('txtPaterno', 'Apellido Paterno', 'required');
        $this->form_validation->set_rules('txtMaterno', 'Apellido Materno', 'required');
        $this->form_validation->set_rules('txtUsuario', 'Usuario', 'required');
        $this->form_validation->set_rules('txtClave', 'Password', 'required');
        $this->form_validation->set_rules('txtClave2', 'Password Confirmation', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->nuevo_usuario($rnombre, $rapellidoPaterno, $rapellidoMaterno, $rUsuario, $rClave, $rClave2);
        } else {
            $hid_Persona = $this->input->post('idPersona');
            $txtNombres = $this->input->post('txtNombres');
            $txtPaterno = $this->input->post('txtPaterno');
            $txtMaterno = $this->input->post('txtMaterno');
            $txtUsuario = $this->input->post('txtUsuario');
            $txtClave = $this->input->post('txtClave');
            $cboRol = $this->input->post('cboRol');
            $default = $this->input->post('default');
            $detaccion = $this->input->post('detaccion');
            $cboEstablecimiento = $this->input->post('cboEstablecimiento');
            $usuario = $this->usuario_model->insertar_datosUsuario($txtNombres, $txtPaterno, $txtMaterno, $txtUsuario, $txtClave, $cboEstablecimiento, $cboRol, $default, $detaccion, $hid_Persona);
            // exit('{"result":"ok"}'); 
            header("location:" . base_url() . "index.php/seguridad/usuario/usuarios");
        }
    }

    public function editar_usuario($codigo)
    {
        $datos_usuario = $this->usuario_model->obtener($codigo);
        $persona = $datos_usuario->PERSP_Codigo;
        $usuario = $datos_usuario->USUA_usuario;
        $clave = $datos_usuario->USUA_Password;
        $nombres = $datos_usuario->PERSC_Nombre;
        $paterno = $datos_usuario->PERSC_ApellidoPaterno;
        $materno = $datos_usuario->PERSC_ApellidoMaterno;
        $lblNombres = form_label('NOMBRES', 'nombres');
        $lblPaterno = form_label('APELLIDO PATERNO', 'paterno');
        $lblMaterno = form_label('APELLIDO MATERNO', 'materno');
        $lblUsuario = form_label('USUARIO', 'usuario');
        $lblClave = form_label('CLAVE', 'clave');
        $lblClave2 = form_label('REPETIR CLAVE', 'clave');
        $idPersona = "";
        $txtNombres = form_input(array('name' => 'txtNombres', 'id' => 'txtNombres', 'value' => $nombres, 'maxlength' => '50', 'class' => 'cajaMedia'));
        $txtPaterno = form_input(array('name' => 'txtPaterno', 'id' => 'txtPaterno', 'value' => $paterno, 'maxlength' => '50', 'class' => 'cajaMedia'));
        $txtMaterno = form_input(array('name' => 'txtMaterno', 'id' => 'txtMaterno', 'value' => $materno, 'maxlength' => '50', 'class' => 'cajaMedia'));
        $txtUsuario = form_input(array('name' => 'txtUsuario', 'id' => 'txtUsuario', 'value' => $usuario, 'maxlength' => '50', 'class' => 'cajaPequena'));
        $txtClave = form_password(array('name' => 'txtClave', 'id' => 'txtClave', 'value' => '', 'maxlength' => '30', 'class' => 'cajaPequena', 'onClick' => 'this.value=\'\''));
        $txtClave2 = form_password(array('name' => 'txtClave2', 'id' => 'txtClave2', 'value' => '', 'maxlength' => '30', 'class' => 'cajaPequena', 'onClick' => 'this.value=\'\''));
        $data['idPersona'] = $idPersona;
        $lista_establec = $this->usuario_compania_model->listar_establecimiento($codigo);

        $lista = array();
        foreach ($lista_establec as $indice => $value) {
            $cboEstablecimiento = "<select id='cboEstablecimiento[" . ($indice + 1) . "]' name='cboEstablecimiento[" . ($indice + 1) . "]' class='comboMedio''>" . $this->OPTION_generador($this->compania_model->listar_establecimiento($this->somevar ['empresa']), 'COMPP_Codigo', 'EESTABC_Descripcion', $value->COMPP_Codigo) . '</select>';
            $cboRol = "<select id='cboRol[" . ($indice + 1) . "]' name='cboRol[" . ($indice + 1) . "]' class='comboMedio''>" . $this->OPTION_generador($this->rol_model->listar_roles(), 'ROL_Codigo', 'ROL_Descripcion', $value->ROL_Codigo) . '</select>';
            //$default = "<input type='checkbox' name='default[" . ($indice + 1) . "]' id='default[" . ($indice + 1) . "]' " . ($value->USUCOMC_Default == '1' ? 'checked="checked"' : '') . " value='1'>";
            $default = "<input type='radio' name='default' id='default[" . ($indice + 1) . "]' " . ($value->USUCOMC_Default == '1' ? 'checked="checked"' : '') . " value='1_" . ($indice + 1) . "'>";
            $borrar = "<a href='#' onclick='eliminar_establecimiento(" . ($value->USUCOMP_Codigo) . "," . $codigo . ");'><img height='16' width='16' src='" . base_url() . "images/delete.gif' title='Buscar' border='0'></a>";
            $lista[] = array($cboEstablecimiento, $cboRol, $default, $borrar);
        }

        $compania = $this->somevar ['compania'];
        $temp = $this->compania_model->obtener_compania($compania);
        $empresa = $temp[0]->EMPRP_Codigo;
        $oculto = form_hidden(array('accion' => "", 'codigo' => $codigo, 'modo' => "modificar", 'base_url' => base_url()));
        $data['titulo'] = "EDITAR USUARIO";
        $data['formulario'] = "frmUsuario";
        $data['campos'] = array($lblNombres, $lblPaterno, $lblMaterno, $lblUsuario, $lblClave, $lblClave2);
        $data['valores'] = array($txtNombres, $txtPaterno, $txtMaterno, $txtUsuario, $txtClave, $txtClave2);
        $data['lista'] = $lista;
        $data['action'] = base_url() . "index.php/seguridad/usuario/modificar_usuario";
        $data['oculto'] = $oculto;
        $data['onload'] = "onload=\"$('#txtNombres').select();$('#txtNombres').focus();\"";

        $this->layout->view('seguridad/usuario_nuevo', $data);
    }

    public function modificar_usuario()
    {

        $this->form_validation->set_rules('txtNombres', 'Nombre', 'required');
        $this->form_validation->set_rules('txtPaterno', 'Apellido Paterno', 'required');
        $this->form_validation->set_rules('txtMaterno', 'Apellido Materno', 'required');
        $this->form_validation->set_rules('txtUsuario', 'Usuario', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->editar_usuario($this->input->post("codigo"));
        } else {

            $usuario = $this->input->post('codigo');

            $nombre_usuario = $this->input->post('txtUsuario');
            $clave = $this->input->post('txtClave');
            $nombres = $this->input->post('txtNombres');
            $paterno = $this->input->post('txtPaterno');
            $materno = $this->input->post('txtMaterno');

            if (!empty($clave)) {
                $this->usuario_model->modificar_usuarioClave($usuario, $clave);
            }
            $this->usuario_model->modificar_datosUsuario22($usuario, $nombre_usuario, $nombres, $paterno, $materno);
            // for ---------
            $rol = $this->input->post('cboRol');
            $establecimiento = $this->input->post('cboEstablecimiento');
            $default = $this->input->post('default');
            $this->usuario_model->modificar_rolestauser($usuario, $rol, $establecimiento, $default);
            //header("Location: ".base_url()."index.php/seguridad/usuario/usuarios");
            $this->usuarios();
        }
    }

    public function eliminar_usuario()
    {
        $usuario = $this->input->post('usuario');
        $this->usuario_model->eliminar_usuario($usuario);
        $this->load->view('seguridad/usuario_index');
    }

    public function ver_usuario($codigo)
    {
        $datos_usuario = $this->usuario_model->obtener($codigo);
        $data['datos_persona'] = $datos_usuario;
        $data['titulo'] = "VER USUARIO";
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        //------------------------

        $lista_establec = $this->usuario_model->buscar_usuariosrolesta($codigo);
        $lista = array();
        if (count($lista_establec) > 0) {
            foreach ($lista_establec as $indice => $value) {
                $cestab = $value->EESTABC_Descripcion;
                $rol = $value->ROL_Descripcion;
                $lista[] = array($cestab, $rol);
            }
        } else {
            $lista[] = array("no tiene un Rol asignado", "");
        }
        //--------------------------------------------------------------
        $data['lista'] = $lista;
        $this->layout->view('seguridad/usuario_ver', $data);
    }

    public function buscar_usuarios($j = '0')
    {
        $nombres = $this->input->post('txtNombres');
        $usuario = $this->input->post('txtUsuario');
        $rol = $this->input->post('txtRol');
        $data['txtNombres'] = $nombres;
        $data['txtUsuario'] = $usuario;
        $data['txtRol'] = $rol;
        $filter = new stdClass();
        $filter->nombres = $nombres;
        $filter->usuario = $usuario;
        $filter->rol = $rol;
        $data['registros'] = count($this->usuario_model->buscar_usuarios($filter));
        $conf['base_url'] = site_url('seguridad/usuario/buscar_usuarios/');
        $conf['total_rows'] = $data['registros'];
        $conf['per_page'] = 10;
        $conf['num_links'] = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $listado_usuarios = $this->usuario_model->buscar_usuarios($filter, $conf['per_page'], $j);
        $item = $j + 1;
        $lista = array();
        if (count($listado_usuarios) > 0) {
            foreach ($listado_usuarios as $indice => $valor) {
                $codigo = $valor->USUA_Codigo;
                $persona = $valor->PERSP_Codigo;
                $rol = $valor->ROL_Codigo;
                $usuario = $valor->USUA_usuario;
                $datos_persona = $this->persona_model->obtener_datosPersona($persona);
                $datos_rol = $this->rol_model->obtener_rol($rol);
                $nombre_persona = $datos_persona[0]->PERSC_Nombre . " " . $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno;
                $nombre_rol = $datos_rol[0]->ROL_Descripcion;
                $editar = "<a href='#' onclick='editar_usuario(" . $codigo . ")' target='_parent'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver = "<a href='#' onclick='ver_usuario(" . $codigo . ")' target='_parent'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Ver'></a>";
                $eliminar = "<a href='#' onclick='eliminar_usuario(" . $codigo . ")' target='_parent'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";
                $lista[] = array($item++, $nombre_persona, $usuario, $nombre_rol, $editar, $ver, $eliminar);
            }
        }
        $data['action'] = base_url() . "index.php/seguridad/usuario/buscar_usuarios";
        $data['titulo_tabla'] = "RESULTADO DE BUSQUEDA de USUARIOS";
        $data['titulo_busqueda'] = "BUSCAR USUARIOS";
        $data['lista'] = $lista;
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('seguridad/usuario_index', $data);
    }

    public function editar_cuenta($codigo)
    {
        $datos_roles = $this->rol_model->listar_roles();
        $arreglo = array('' => '::Selecione::');
        foreach ($datos_roles as $indice => $valor) {
            $indice1 = $valor->ROL_Codigo;
            $valor1 = $valor->ROL_Descripcion;
            $arreglo[$indice1] = $valor1;
        }
        $datos_usuario = $this->usuario_model->obtener($codigo);
        $persona = $datos_usuario->PERSP_Codigo;
        $rol = $datos_usuario->ROL_Codigo;
        $usuario = $datos_usuario->USUA_usuario;
        $clave = $datos_usuario->USUA_Password;
        $datos_rol = $this->rol_model->obtener_rol($rol);
        $nombres = $datos_usuario->PERSC_Nombre;
        $paterno = $datos_usuario->PERSC_ApellidoPaterno;
        $materno = $datos_usuario->PERSC_ApellidoMaterno;
        $nombre_rol = $datos_rol[0]->ROL_Descripcion;
        $lblNombres = form_label('NOMBRES', 'nombres');
        $lblPaterno = form_label('APELLIDO PATERNO', 'paterno');
        $lblMaterno = form_label('APELLIDO MATERNO', 'materno');
        $lblUsuario = form_label('USUARIO', 'usuario');
        $lblClave = form_label('CLAVE', 'clave');
        $txtNombres = form_input(array('name' => 'txtNombres', 'id' => 'txtNombres', 'value' => $nombres, 'maxlength' => '50', 'class' => 'cajaMedia'));
        $txtPaterno = form_input(array('name' => 'txtPaterno', 'id' => 'txtPaterno', 'value' => $paterno, 'maxlength' => '50', 'class' => 'cajaMedia'));
        $txtMaterno = form_input(array('name' => 'txtMaterno', 'id' => 'txtMaterno', 'value' => $materno, 'maxlength' => '50', 'class' => 'cajaMedia'));
        $txtUsuario = form_input(array('name' => 'txtUsuario', 'id' => 'txtUsuario', 'value' => $usuario, 'maxlength' => '50', 'class' => 'cajaPequena'));
        $txtClave = form_password(array('name' => 'txtClave', 'id' => 'txtClave', 'value' => '', 'maxlength' => '30', 'class' => 'cajaPequena'));
        $oculto = form_hidden(array('accion' => "", 'codigo' => $codigo, 'modo' => "modificar", 'base_url' => base_url()));
        $data['titulo'] = "MI CUENTA";
        $data['formulario'] = "frmCuenta";
        $data['campos'] = array($lblNombres, $lblPaterno, $lblMaterno, $lblUsuario, $lblClave);
        $data['valores'] = array($txtNombres, $txtPaterno, $txtMaterno, $txtUsuario, $txtClave);
        $data['oculto'] = $oculto;
        $data['onload'] = "onload=\"$('#txtNombres').select();$('#txtNombres').focus();\"";
        $this->layout->view('seguridad/cuenta_nuevo', $data);
    }

    public function modificar_cuenta()
    {
        $this->form_validation->set_rules('txtNombres', 'Nombre', 'required');
        $this->form_validation->set_rules('txtPaterno', 'Apellido Paterno', 'required');
        $this->form_validation->set_rules('txtMaterno', 'Apellido Materno', 'required');
        $this->form_validation->set_rules('txtUsuario', 'Usuario', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->nuevo_usuario();
        } else {
            $usuario = $this->input->post('codigo');
            $datos_usuario = $this->comercial_model->obtener_datosUsuario2($usuario);
            $persona = $datos_usuario[0]->PERSP_Codigo;
            $nombre_usuario = $this->input->post('txtUsuario');
            $clave = $this->input->post('txtClave');
            $nombres = $this->input->post('txtNombres');
            $paterno = $this->input->post('txtPaterno');
            $materno = $this->input->post('txtMaterno');
            if (!empty($clave)) {
                $this->comercial_model->modificar_usuarioClave($usuario, $clave);
            }
            $this->usuario_model->modificar_usuario2($usuario, $nombre_usuario);
            $this->comercial_model->modificar_datosPersona_nombres($persona, $nombres, $paterno, $materno);
            $this->load->view('seguridad/inicio');
        }
    }

    public function seleccionar_rol($indSel = '')
    {
        $array_rol = $this->rol_model->listar_roles();
        $arreglo = array();
        foreach ($array_rol as $indice => $valor) {
            $indice1 = $valor->ROL_Codigo;
            $valor1 = $valor->ROL_Descripcion;
            $arreglo[$indice1] = $valor1;
        }
        $resultado = $this->html->optionHTML($arreglo, $indSel, array('', '::Seleccione::'));
        return $resultado;
    }

//----------------------------------------------------------------------------------------------------       
//--------------------------------------------------------------------------------------------------
    public function confirmacion_usuario_anulafb($serie, $comprobante)
    {

        $this->form_validation->set_rules('txtUsuario', 'Nombre Usuario', 'required|max_length[20]');
        $this->form_validation->set_rules('txtClave', 'Clave de Usuario', 'required|max_length[15]|md5');

        if ($this->form_validation->run() == FALSE) {
            $this->ventana_confirmacion_usuario2($serie, $comprobante);
        } else {
            $txtUsuario = $this->input->post('txtUsuario');
            $txtClave = $this->input->post('txtClave');
            $establecimiento = $this->input->post('txtRol');
            $empresa = 2; // este campo tiene el codigo de la empresa

            $datos_usuario = $this->usuario_model->obtener_datosUsuarioLogin($txtUsuario, $txtClave);

            if (count($datos_usuario) > 0) {
                //Obtenemos la compañia por defecto
                $datos_usu_com = $this->usuario_compania_model->listar($datos_usuario[0]->USUA_Codigo, $empresa);

                if (count($datos_usu_com) > 0) {
                    $datos_compania = $this->compania_model->obtener($datos_usu_com[0]->COMPP_Codigo);
                    $datos_empresa = $this->empresa_model->obtener_datosEmpresa($datos_compania[0]->EMPRP_Codigo);
                    $datos_establec = $this->emprestablecimiento_model->obtener($datos_compania[0]->EESTABP_Codigo);
                    $usuario = $datos_usuario[0]->USUA_Codigo;
                    $userCod = $usuario;
                    //obtengo rol
                    $obtener_rol = $this->usuario_model->obtener_rolesUsuario($usuario, $empresa, $establecimiento);
                    //----------------
                    if (count($obtener_rol) > 0) {
                        $persona = $datos_usuario[0]->PERSP_Codigo;
                        $rol = $obtener_rol[0]->ROL_Codigo;
                        //--------------------------------------------

                        if ($serie == "guiarem") {
                            $this->guiarem_model->eliminar($comprobante, $userCod);
                        } else {
                            if ($serie == "guiatrans") {
                                $this->guiatrans_model->eliminar($comprobante);
                            } else {
                                $this->comprobante_model->eliminar_comprobante($comprobante, $userCod);


                            }
                        }
                        $datax = "";
                        $funcion = "";
                        $this->ventana_confirmacion_usuario2($datax, $funcion);

                        //anular la combrobante
                        //---------------------------------------------
                    } else {
                        $msgError = "<br><div align='center' class='error'>Su usuario no tiene acceso a la informacion de ninguna empresa.</div>";
                        echo $msgError;
                        $this->ventana_confirmacion_usuario2($serie, $comprobante);
                    }
                    //---------------------
                } else {
                    $msgError = "<br><div align='center' class='error'>Su usuario no tiene acceso a la informacion de ninguna empresa.</div>";
                    echo $msgError;
                    $this->ventana_confirmacion_usuario2($serie, $comprobante);
                }
            } else {
                $msgError = "<br><div align='center' class='error'>Usuario y/o contrasena no valido para esta empresa.</div>";
                echo $msgError;
                $this->ventana_confirmacion_usuario2($serie, $comprobante);
            }
        }
    }

    public function ventana_confirmacion_usuario2($serie, $comprobante){
    	$rolusuario = $this->session->userdata('rol');
        $lblUsuario = form_label('USUARIO *', 'usuario');
        $lblClave = form_label('CLAVE *', 'clave');
        $txtUsuario = form_input(array('name' => 'txtUsuario', 'id' => 'txtUsuario', 'value' => '', 'maxlength' => '30', 'class' => 'cajaGeneral'));
        $txtClave = form_password(array('name' => 'txtClave', 'id' => 'txtClave', 'value' => '', 'maxlength' => '30', 'class' => 'cajaGeneral', 'onClick' => 'this.value=\'\''));
        $oculto = form_hidden(array('accion' => "", 'codigo' => "", 'modo' => "insertar", 'base_url' => base_url()));
        $data['titulo'] = "";
        $data['formulario'] = "frmUsuario";
        $data['nota'] = "";
        $data['img'] = "<img src='" . base_url() . "images/anular.jpg' width='100%' height='auto' border='0' title='Ver'>";
        $data['btnAceptar'] = "verificarUsuario";
        $data['campos'] = array($lblUsuario, $lblClave);
        $data['valores'] = array($txtUsuario, $txtClave);
        $data['lista'] = array();
        $data['action'] = base_url() . "/index.php/seguridad/usuario/confirmacion_usuario_anulafb/" . $serie . "/" . $comprobante;
        $data['oculto'] = $oculto;
        
		$data['comprobante'] = $comprobante;
		$data['rolinicio'] = $rolusuario;
		
        if ($serie == "" and $comprobante == "") {
            $data['onload'] = "redireccionar2()";
        } else {
            $data['onload'] = "javascript:txtUsuario.focus();";
        }
        $this->load->view('seguridad/ventana_confirmacion_usuario', $data);
    }
    
    
    public function eliminarUsuarioRol(){
    	$UsuarioRol = $this->somevar['rol'];
    	
    	$this->caja_model->eliminar_caja($caja);
    }

    //--------------------------------------------------------------------------------
    //------------------------------------------------------------------------------
    //ventana confimacion de usuario

    public function ventana_confirmacion_usuario($datax = '')
    {

        $lblUsuario = form_label('USUARIO *', 'usuario');
        $lblClave = form_label('CLAVE *', 'clave');
        $txtUsuario = form_input(array('name' => 'txtUsuario', 'id' => 'txtUsuario', 'value' => '', 'maxlength' => '30', 'class' => 'cajaGeneral'));
        $txtClave = form_password(array('name' => 'txtClave', 'id' => 'txtClave', 'value' => '', 'maxlength' => '30', 'class' => 'cajaGeneral', 'onClick' => 'this.value=\'\''));
        $oculto = form_hidden(array('accion' => "", 'codigo' => "", 'modo' => "insertar", 'base_url' => base_url()));
        $data['titulo'] = "";
        $data['formulario'] = "frmUsuario";
        $data['img'] = "<img src='" . base_url() . "images/emision.jpg' width='100%' height='auto' border='0' title='Ver'>";
        $data['nota'] = "*Nota: Es necesario la confirmacion de esta operacion";
        $data['btnAceptar'] = "verificarUsuario";
        $data['campos'] = array($lblUsuario, $lblClave);
        $data['valores'] = array($txtUsuario, $txtClave);
        $data['lista'] = array();
        $data['action'] = base_url() . "/index.php/seguridad/usuario/verificar_confirmacion_usuario";
        $data['oculto'] = $oculto;

        if ($datax == '') {
            $data['onload'] = "javascript:txtUsuario.focus();";
        } else {
            $data['onload'] = "confirmar_usuario('valido');";
        }


        $this->load->view('seguridad/ventana_confirmacion_usuario', $data);
    }

    public function verificar_confirmacion_usuario()
    {

        $this->form_validation->set_rules('txtUsuario', 'Nombre Usuario', 'required|max_length[20]');
        $this->form_validation->set_rules('txtClave', 'Clave de Usuario', 'required|max_length[15]|md5');

        if ($this->form_validation->run() == FALSE) {
            $this->ventana_confirmacion_usuario();
        } else {
            $txtUsuario = $this->input->post('txtUsuario');
            $txtClave = $this->input->post('txtClave');
            $establecimiento = $this->input->post('txtRol');
            $empresa = 2; // este campo tiene el codigo de la empresa

            $datos_usuario = $this->usuario_model->obtener_datosUsuarioLogin($txtUsuario, $txtClave);

            if (count($datos_usuario) > 0) {
                //Obtenemos la compañia por defecto
                $datos_usu_com = $this->usuario_compania_model->listar($datos_usuario[0]->USUA_Codigo, $empresa);

                if (count($datos_usu_com) > 0) {
                    $datos_compania = $this->compania_model->obtener($datos_usu_com[0]->COMPP_Codigo);
                    $datos_empresa = $this->empresa_model->obtener_datosEmpresa($datos_compania[0]->EMPRP_Codigo);
                    $datos_establec = $this->emprestablecimiento_model->obtener($datos_compania[0]->EESTABP_Codigo);
                    $usuario = $datos_usuario[0]->USUA_Codigo;
                    $userCod = $usuario;
                    //obtengo rol
                    $obtener_rol = $this->usuario_model->obtener_rolesUsuario($usuario, $empresa, $establecimiento);
                    //----------------
                    if (count($obtener_rol) > 0) {
                        $persona = $datos_usuario[0]->PERSP_Codigo;
                        $rol = $obtener_rol[0]->ROL_Codigo;

                        $datos_persona = $this->persona_model->obtener_datosPersona($persona);
                        $datos_rol = $this->rol_model->obtener_rol($rol);
                        $nombre_rol = $datos_rol[0]->ROL_Descripcion;
                        $nombre_persona = $datos_persona[0]->PERSC_Nombre . " " . $datos_persona[0]->PERSC_ApellidoPaterno;
                        $datos_permisos = $this->permiso_model->obtener_permisosMenu($rol);
                        $data2 = array();

                        $dataxs = "valido";
                        $this->ventana_confirmacion_usuario($dataxs);

                        //-----------------------
                    } else {
                        $msgError = "<br><div align='center' class='error'>Su usuario no tiene acceso a la informacion de ninguna empresa.</div>";
                        echo $msgError;
                        $this->ventana_confirmacion_usuario();
                    }
                    //---------------------
                } else {
                    $msgError = "<br><div align='center' class='error'>Su usuario no tiene acceso a la informacion de ninguna empresa.</div>";
                    echo $msgError;
                    $this->ventana_confirmacion_usuario();
                }
            } else {
                $msgError = "<br><div align='center' class='error'>Usuario y/o contrasena no valido para esta empresa.</div>";
                echo $msgError;
                $this->ventana_confirmacion_usuario();
            }
        }
    }

    //---------------------------------------------------------------------------------------------

    public function ventana_confirmacion_transusuario($datax = '', $funcion = '')
    {
        $tipoTrans = $this->uri->segment(4);
        $codTrans = $this->uri->segment(5);
        $lblUsuario = form_label('USUARIO *', 'usuario');
        $lblClave = form_label('CLAVE *', 'clave');
        $txtUsuario = form_input(array('name' => 'txtUsuario', 'id' => 'txtUsuario', 'value' => '', 'maxlength' => '30', 'class' => 'cajaGeneral'));
        $txtClave = form_password(array('name' => 'txtClave', 'id' => 'txtClave', 'value' => '', 'maxlength' => '30', 'class' => 'cajaGeneral', 'onClick' => 'this.value=\'\''));
        $oculto = form_hidden(array('accion' => "", 'codigo' => "", 'modo' => "insertar", 'base_url' => base_url()));
        $data['img'] = '';
        $data['nota'] = '';
        $data['titulo'] = "TRANSPORTE";
        if ($tipoTrans <= 0) {
            $data['titulo'] = "";
            $data['img'] = "<img src='" . base_url() . "images/transporte.jpg' width='100%' height='auto' border='0' title='Ver'>";
            $data['nota'] = "*Nota: Es necesario la confirmacion de la persona que realizara la entrega";
        }
        if ($tipoTrans == 1) {
            $data['titulo'] = "";
            $data['img'] = "<img src='" . base_url() . "images/recepcion.jpg' width='100%' height='auto' border='0' title='Ver'>";
            $data['nota'] = "*Nota: Es necesario la conformidad de la persona que recepciona la tranferencia";
        }

        $data['formulario'] = "frmUsuario";
        $data['btnAceptar'] = "verificarTransUsuario";
        $data['campos'] = array($lblUsuario, $lblClave);
        $data['valores'] = array($txtUsuario, $txtClave);
        $data['lista'] = array();
        $data['action'] = base_url() . "/index.php/seguridad/usuario/verificar_transconfirmacion/" . $tipoTrans . "/" . $codTrans;
        $data['oculto'] = $oculto;
        if ($datax == '') {
            $data['onload'] = "javascript:txtUsuario.focus();";
        } else {
            $data['onload'] = "confirmar_usuario('valido');";
        }
        if ($funcion == "activo") {
            $data['onload'] = "redireccionar()";
        }
        $this->load->view('seguridad/ventana_confirmacion_usuario', $data);
    }

    //-----------------------------------------------------------
    ///-----------------------------------------------------------
    public function verificar_transconfirmacion($datax = '')
    {
        $tipoTrans = $this->uri->segment(4);
        $codTrans = $this->uri->segment(5);
        $estadoTrans = $tipoTrans + 1;

        $this->form_validation->set_rules('txtUsuario', 'Nombre Usuario', 'required|max_length[20]');
        $this->form_validation->set_rules('txtClave', 'Clave de Usuario', 'required|max_length[15]|md5');

        if ($this->form_validation->run() == FALSE) {
            $this->ventana_confirmacion_transusuario();
        } else {
            $txtUsuario = $this->input->post('txtUsuario');
            $txtClave = $this->input->post('txtClave');
            $establecimiento = $this->input->post('txtRol');
            $empresa = 1; // este campo tiene el codigo de la empresa

            $datos_usuario = $this->usuario_model->obtener_datosUsuarioLogin($txtUsuario, $txtClave);

            if (count($datos_usuario) > 0) {
                //Obtenemos los datos del usuario
                $userCod = $datos_usuario[0]->USUA_Codigo;
                //condicionar si el creador tiene el mismo codigo que el receptor
                $obtener_creador = $this->guiatrans_model->obtener($codTrans);
                $userrecep = $obtener_creador[0]->USUA_Codigo;
                //--

                $estado = 1;

                //-------------
                if ($estadoTrans == 0) {
                    $this->guiatrans_model->actualiza_usuatrans("", $estadoTrans, $codTrans);
                }
                //-------------
                if ($estadoTrans == 1) {
                    $this->guiatrans_model->actualiza_usuatrans($userCod, $estadoTrans, $codTrans);
                }
                //
                if ($estadoTrans == 2) {
                    $this->guiatrans_model->actualiza_receptrans($userCod, $estadoTrans, $codTrans, $estado);
                    header("location:" . base_url() . "index.php/almacen/guiatrans/insertar_guiaintrans/" . $codTrans);
                }

                $funcion = 'activo';
                $this->ventana_confirmacion_transusuario($datax = '', $funcion);
                //---------------------
            } else {
                $msgError = "<br><div align='center' class='error'>Su usuario no tiene acceso a la informacion de ninguna empresa.</div>";
                echo $msgError;
                $this->ventana_confirmacion_transusuario();
            }
        }
    }

    //-----------------------------------------------------------------------------

    public function JSON_listar_establecimiento(){
        echo json_encode($this->compania_model->listar_establecimiento($this->somevar ['empresa']));
    }

    public function eliminar_establecimiento($usuario_compania, $usuario){
        $this->usuario_model->eliminar_rolestablecimiento($usuario_compania);
        //$this->layout->view('seguridad/cuenta_nuevo',$usuario);
        header("location:" . base_url() . "index.php/seguridad/usuario/editar_usuario/" . $usuario);
    }

}