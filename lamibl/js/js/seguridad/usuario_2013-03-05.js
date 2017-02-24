var base_url;
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    $("#nuevoUsuario").click(function(){
        url = base_url+"index.php/seguridad/usuario/nuevo_usuario";
        location.href = url;
    });
        
    $("#directivo").change(function(){
        if($("#directivo").val()!=""){
            array_nombre_cod=$("#directivo").val().split('_');
            opcion_nombre=array_nombre_cod[0];
            var array_nombre=opcion_nombre.split("-");
            $('#txtNombres').val(array_nombre[0]);
            array_apellidos=array_nombre[1].split(" ");
            $("#txtPaterno").val(array_apellidos[0]);
            $("#txtMaterno").val(array_apellidos[1]);
            $("#idPersona").val(array_nombre_cod[1]);
            url = base_url+"index.php/seguridad/usuario/buscar_usuario";
        
            dataString  = "idpersona="+$("#idPersona").val();
           
            $.ajax({
                type : "POST",
                url  : url,
                data : dataString,
                beforeSend: function(data) {
                    $('img#loading').css('visibility','visible');
                },
                success: function(data){
                    va_resultado=data.split('_|_');
                    if(va_resultado[0]==1){
                        $('#txtUsuario').attr('disabled','disabled');
                        $('#txtUsuario').val("");
                        $('#txtClave').val("");
                        $('#txtClave2').val("");
                        $('#txtClave').attr('disabled','disabled');
                        $('#txtClave2').attr('disabled','disabled');
                        $('#grabarUsuario').css('display','none');
                        $('#limpiarUsuario').css('display','none');
                    }else{
                        $('#txtUsuario').removeAttr("disabled");
                         $('#txtClave').removeAttr("disabled");
                        $('#txtClave2').removeAttr("disabled");
                        $('#txtUsuario').val("");
                        $('#txtClave').val("");
                        $('#txtClave2').val("");
                        $('#grabarUsuario').css('display','inline');
                        $('#limpiarUsuario').css('display','inline');
                    }
                    $('img#loading').css('visibility','hidden');
                }
            });
        }else{
            $('#txtNombres').val('');
            $("#txtPaterno").val('');
            $("#txtMaterno").val('');
            $("#idPersona").val("");
            $('#txtUsuario').removeAttr("disabled");
        /*$('#txtClave').removeAttr("disabled");
            $('#txtClave2').removeAttr("disabled");*/
            
        }
    });
        
    $("#grabarUsuario").click(function(){
        $("#frmUsuario").submit();
    //location.href= base_url+"index.php/index/inicio";
    }); 	
    /*   $("#grabarUsuario").click(function(){ 
            $('img#loading').css('visibility','visible');
            var codigo=$('#codigo').val();
            if(codigo=='')
                url = base_url+"index.php/seguridad/usuario/insertar_usuario";
            else
                url = base_url+"index.php/seguridad/usuario/modificar_usuario";
            
            dataString  = $('#frmUsuario').serialize();
            $.post(url,dataString,function(data){
                    $('img#loading').css('visibility','hidden');
                    switch(data.result){
                        case 'ok': location.href = base_url+"index.php/seguridad/usuario/usuarios/";
                                break;
                        case 'error': 
                                if(data.campo){
                                    $('input[type="text"][readonly!="readonly"], select, textarea').css('background-color', '#FFFFFF');
                                    $('#'+data.campo).css('background-color', '#FFC1C1').focus();
                                }else
                                    if(data.msj)
                                        alert(data.msj);
                                break;
                    }
            },'json');
	}); 
        */
        
    $("#limpiarUsuario").click(function(){
        url = base_url+"index.php/seguridad/usuario/usuarios";
        $("#txtNombres").val('');
        $("#txtUsuario").val('');
        $("#txtRol").val('');
        location.href=url;
    });
    $("#cancelarUsuario").click(function(){
        url = base_url+"index.php/seguridad/usuario/usuarios";
        location.href = url;
    });
    $("#buscarUsuario").click(function(){
        $("#form_busquedaUsuario").submit();
    });
    /*$("#frmUsuario").validate({
		event    : "blur",
		rules    : {'txtNombres' : "required"},
		debug    : true,
		errorElement   : "label",
		errorContainer : $("#errores"),
		submitHandler  : function(form){
			txtNombres     = $("#txtNombres").val();
			txtPaterno     = $("#txtPaterno").val();
			txtMaterno     = $("#txtMaterno").val();
			txtUsuario     = $("#txtUsuario").val();
			txtClave       = $("#txtClave").val();
			cboRol         = $("#cboRol").val();
			modo           = $("#modo").val();
			codigo         = $("#codigo").val();
			dataString  = "txtNombres="+txtNombres+"&txtPaterno="+txtPaterno+"&txtMaterno="+txtMaterno+"&txtUsuario="+txtUsuario+"&txtClave="+txtClave+"&cboRol="+cboRol+"&modo="+modo+"&codigo="+codigo;
			if(modo=='insertar'){
				url = base_url+"index.php/seguridad/usuario/insertar_usuario";
				$.post(url,dataString,function(data){	
					alert('Se ha insertado un nuevo usuario.');
					location.href = base_url+"index.php/seguridad/usuario/usuarios";
				});				
			}
			else if(modo=='modificar'){
				url = base_url+"index.php/seguridad/usuario/modificar_usuario";
				$.post(url,dataString,function(data){	
					location.href = base_url+"index.php/seguridad/usuario/usuarios";
				});				
			}
		}
	});*/
    /*Cuenta*/
    $("#grabarCuenta").click(function(){
        $("#frmCuenta").submit();	
    }); 
    //--------
    $("#verificarUsuario").click(function(){
        $("#form_busqueda").submit();

    }); 
    $("#verificarTransUsuario").click(function(){
        $("#form_busqueda").submit();           
    }); 
    //---------
    $("#limpiarCuenta").click(function(){
        $("#frmCuenta").each(function(){
            this.reset();
        });
    });
    $("#cancelarCuenta").click(function(){
        url = base_url+"index.php/seguridad/usuario";
        location.href = url;		
    });
    $('#cerrarUsuario').click(function(){
        parent.$.fancybox.close(); 
    });	
    $("#frmCuenta").validate({
        event    : "blur",
        rules    : {
            'txtNombres' : "required"
        },
        debug    : true,
        errorElement   : "label",
        errorContainer : $("#errores"),
        submitHandler  : function(form){
            txtNombres     = $("#txtNombres").val();
            txtPaterno     = $("#txtPaterno").val();
            txtMaterno     = $("#txtMaterno").val();
            txtUsuario     = $("#txtUsuario").val();
            txtClave       = $("#txtClave").val();
            modo           = $("#modo").val();
            codigo         = $("#codigo").val();
            dataString  = "txtNombres="+txtNombres+"&txtPaterno="+txtPaterno+"&txtMaterno="+txtMaterno+"&txtUsuario="+txtUsuario+"&txtClave="+txtClave+"&modo="+modo+"&codigo="+codigo;
            if(modo=='modificar'){
                url = base_url+"index.php/seguridad/usuario/modificar_cuenta";
                $.post(url,dataString,function(data){	
                    location.href = base_url+"index.php/seguridad/usuario";
                });				
            }
        }
    });

    $('#nuevoRegistro').click(function(){
        n = document.getElementById('tblEstablec').rows.length;
        fila='<tr>'
        fila+='<td><div align="left"><select name="cboEstablecimiento['+n+']" id="cboEstablecimiento['+n+']" class="comboMedio"><option value="" selected="selected">::Seleccione::</option></select></div></td>';
        fila+='<td><div align="left"><select name="cboRol['+n+']" id="cboRol['+n+']" class="comboMedio"><option value="" selected="selected">::Seleccione::</option></select></div></td>';
        fila+='<td><div align="center"><input type="checkbox" name="default['+n+']" id="default['+n+']" value="1" /></div></td>'
        fila+='<td align="center"><div align="left"><a href="#" onclick="eliminar_establecimientos('+n+');"><img src="'+base_url+'images/delete.gif" border="0"></a></div>';
        fila+='<input type="hidden" name="detacodi['+n+']" id="detacodi['+n+']">';
        fila+='<input type="hidden" name="detaccion['+n+']" id="detaccion['+n+']" value="n">';
        fila+='</td>';
        fila+='</tr>';
        $("#tblEstablec").append(fila);
        listar_establecimiento(n);
    });
       
});


function redireccionar(){
    top.location.href = base_url+"index.php/almacen/guiatrans/listar";
}
 

function redireccionar2(){

    top.location.href = base_url+"index.php/index/inicio";
}


function confirmar_usuario(cod){
    parent.confirmar_usuario(cod);
    parent.$.fancybox.close(); 
}
function listar_establecimiento(n){
    var base_url = $("#base_url").val();
    a      = "cboEstablecimiento["+n+"]";
    url    = base_url+"index.php/seguridad/usuario/JSON_listar_establecimiento/";
    select = document.getElementById(a);
    $.getJSON(url,function(data){
        $.each(data, function(i,item){
            codigo      = item.COMPP_Codigo;
            descripcion = item.EESTABC_Descripcion;
            opt         = document.createElement('option');
            texto       = document.createTextNode(descripcion);
            opt.appendChild(texto);
            opt.value = codigo;
            select.appendChild(opt);
        });
        listar_rol(n);
    });
}
function listar_rol(n){
    var base_url = $("#base_url").val();
    a      = "cboRol["+n+"]";
    url    = base_url+"index.php/seguridad/rol/JSON_listar_rol/";
    select = document.getElementById(a);
    $.getJSON(url,function(data){
        $.each(data, function(i,item){
            codigo      = item.ROL_Codigo;
            descripcion = item.ROL_Descripcion;
            opt         = document.createElement('option');
            texto       = document.createTextNode(descripcion);
            opt.appendChild(texto);
            opt.value = codigo;  
            select.appendChild(opt);
        });
    });
}
function editar_usuario(usuario){
    location.href = base_url+"index.php/seguridad/usuario/editar_usuario/"+usuario;
}
function eliminar_establecimiento(usuario_compania,usuario){
    //location.href = base_url+"index.php/seguridad/usuario/editar_usuario/"+usuario;
    
    location.href=base_url+"index.php/seguridad/usuario/eliminar_establecimiento/"+usuario_compania+"/"+usuario;
}
function eliminar_usuario(usuario){
    if(confirm('¿Está seguro que desea eliminar este usuario?')){
        dataString        = "usuario="+usuario;
        $.post("eliminar_usuario",dataString,function(data){
            location.href = base_url+"index.php/seguridad/usuario/usuarios";		
        });			
    }
}
function ver_usuario(usuario){
    location.href = base_url+"index.php/seguridad/usuario/ver_usuario/"+usuario;
}
function atras_usuario(){
    location.href = base_url+"index.php/seguridad/usuario/usuarios";
}
function editar_cuenta(usuario){
    location.href = base_url+"index.php/seguridad/editar_cuenta/"+usuario;
}