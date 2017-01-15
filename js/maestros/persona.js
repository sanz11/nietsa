var base_url
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    
    $("#imgGuardarPersona").click(function(){
		dataString = $('#frmPersona').serialize();
		$("#container").show();
		$("#frmPersona").submit();
    });
    $("#buscarPersona").click(function(){
		$("#form_busqueda").submit();
    });	
    $("#nuevoPersona").click(function(){
		url = base_url+"index.php/maestros/persona/nuevo_persona";
		$("#zonaContenido").load(url);
    });
    $("#limpiarPersona").click(function(){
        url = base_url+"index.php/maestros/persona/personas";
        location.href=url;
    });
    $("#imgCancelarPersona").click(function(){
	base_url = $("#base_url").val();
        location.href = base_url+"index.php/maestros/persona/personas";
    });
    $("#imprimirPersona").click(function(){
			var documento = $("#txtNumDoc").val();
			var nombre = $("#txtNombre").val();
			var flagBS = "B";
		///
		  if(documento==""){
                    documento="--";
            }
             if(nombre==""){
                    nombre="--";
            }

        url = base_url+"index.php/almacen/producto/registro_persona_pdf/"+flagBS+"/"+documento+"/"+ nombre;
        window.open(url,'',"width=800,height=600,menubars=no,resizable=no;");
    });
	container = $('div.container');
 	$("#frmPersona").validate({
		event    : "blur",
		rules    : {
					'nombres'         : "required",
					'paterno'         : "required",
					'email'           : {required:false,email:true},
					'tipo_documento'  : "required",
					'cboSexo'         : "required",
					'cboNacionalidad' : "required"
 				   },
		debug    : true,
		errorContainer      : "container",
		errorLabelContainer : $(".container"),
		wrapper             : 'li',
		submitHandler       : function(form){
				dataString  = $('#frmPersona').serialize();                               
				modo        = $("#modo").val();
				$('#VentanaTransparente').css("display","block");
				if(modo=='insertar'){
					url = base_url+"index.php/maestros/persona/insertar_persona";
					$.post(url,dataString,function(data){
					$("#VentanaTransparente").css("display","none");
						alert('Se ha ingresado un persona.');
						location.href = base_url+"index.php/maestros/persona/personas";
					});
				}
				else if(modo=='modificar'){
                                        $('tipo_documento').val('2');
					$('cboNacionalidad').val('193');
					url = base_url+"index.php/maestros/persona/modificar_persona";
					$.post(url,dataString,function(data){
						$("#VentanaTransparente").css("display","none");
						alert('Su registro ha sido modificado.');
						location.href = base_url+"index.php/maestros/persona/personas";
					});
				}
		}
	});
   
	container = $('div.container');   
});
function editar_persona(persona){
        var url = base_url+"index.php/maestros/persona/editar_persona/"+persona;
	$("#zonaContenido").load(url);
}
function eliminar_persona(persona){
	if(confirm('Esta seguro desea eliminar este persona?')){
		dataString = "persona="+persona;
		url = base_url+"index.php/maestros/persona/eliminar_persona";
		$.post(url,dataString,function(data){
			url = base_url+"index.php/maestros/persona/personas";
			location.href = url;
		});
	}
}


function cargar_provincia(obj){
    departamento = obj.value;
    provincia    = "01";
    if(departamento!='00'){
        url = base_url+"index.php/maestros/ubigeo/cargar_ubigeo/"+departamento+"/"+provincia;
        $("#divUbigeo").load(url);
    }
}
function cargar_distrito(obj){
    departamento = $("#cboDepartamento").val();
    provincia    = obj.value;
    if(departamento!='00' && provincia!='00'){
        url = base_url+"index.php/maestros/ubigeo/cargar_ubigeo/"+departamento+"/"+provincia;
        $("#divUbigeo").load(url);
    }
}


function abrir_formulario_ubigeo(){
	ubigeo = $("#cboNacimiento").val();
        if(ubigeo=='')
            ubigeo='000000';
	url = base_url+"index.php/maestros/ubigeo/formulario_ubigeo/"+ubigeo;
	window.open(url,'Formulario Ubigeo','menubar=no,resizable=no,width=610,height=110');
}

function ver_persona(persona){
	url = base_url+"index.php/maestros/persona/ver_persona/"+persona;
	$("#zonaContenido").load(url);
}
function atras_persona(){
	location.href = base_url+"index.php/maestros/persona/personas";
}

