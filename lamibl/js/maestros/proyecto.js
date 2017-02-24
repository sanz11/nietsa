var base_url
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();       
    $("#imgGuardarProyecto").click(function(){
		dataString = $('#frmProyecto').serialize();
		$("#container").show();
		$("#frmProyecto").submit();
    });
    $("#buscarProyecto").click(function(){
		$("#form_busqueda").submit();
    });	
    $("#nuevoProyecto").click(function(){
		url = base_url+"index.php/maestros/proyecto/nuevo_proyecto";
		$("#zonaContenido").load(url);
    });
    $("#limpiarProyecto").click(function(){
        url = base_url+"index.php/maestros/proyecto/proyectos";
        location.href=url;
    });
    $("#imgCancelarProyecto").click(function(){
        base_url = $("#base_url").val();
        location.href = base_url+"index.php/maestros/proyecto/proyectos";
    });
    
	container = $('div.container');
 	$("#frmProyecto").validate({
		event    : "blur",
		rules    : {
					'ruc'             : {required:true,minlength:11,number:true},
					'razon_social'    : "required"
 			    },
		debug    : true,
		errorContainer      : "container",
		errorLabelContainer : $(".container"),
		wrapper             : 'li',
		submitHandler       : function(form){
				dataString  = $('#frmProyecto').serialize();
				modo        = $("#modo").val();
				$('#VentanaTransparente').css("display","block");
				if(modo=='insertar'){
					url = base_url+"index.php/maestros/proyecto/insertar_proyecto";
					$.post(url,dataString,function(data){
					$("#VentanaTransparente").css("display","none");
				alert('Se ha ingresado una proyecto.');
						location.href = base_url+"index.php/maestros/proyecto/proyectos";
					});
				}
				else if(modo=='modificar'){
					url = base_url+"index.php/maestros/proyecto/modificar_proyecto";
					$.post(url,dataString,function(data){
						$("#VentanaTransparente").css("display","none");
						alert('Su registro ha sido modificado.');
						location.href = base_url+"index.php/maestros/proyecto/proyectos";
					});
				}
		}
	});

    container = $('div.container');	
    //Funcionalidades
    $("#nuevoRegistro").click(function(){
        opcion   = $("#opcion").val();
		proyecto  = $("#proyecto").val();
		
		modo     = $("#modo").val();
		img_url  = base_url+"system/application/views/images/";
		if(opcion==4){
			n = document.getElementById('tablaArea').rows.length/2;
			j = n+1;
			fila  = "<tr>";
			fila += "<td align='center'>"+j+"</td>";
			fila += "<td align='left'><input type='text' name='nombre_area["+n+"]' id='nombre_area["+n+"]' class='cajaGrande'></td>";
			if(modo=='modificar'){
				fila += "<td align='center'>&nbsp;</td>";
				fila += "<td align='center'><a href='#' onclick='insertar_area();'><img src='"+base_url+"images/save.gif' border='0'></a></td>";
				fila += "</tr>";
			}
			$("#tablaArea").append(fila);
		}
        else if(opcion==3){
			$("#msgRegistros").hide();		
			n = (document.getElementById('tablaContacto').rows.length);
			a = "contactoNombre["+n+"]";
			j = n+1;
			fila  = "<tr>";
			fila += "<td align='center'>"+n+"</td>";
			fila += "<td align='left' style='position:relative;'>";
			fila += "<input type='hidden' name='contactoPersona["+n+"]' id='contactoPersona["+n+"]' class='cajaMedia'>";
			fila += "<input type='text' name='contactoNombre["+n+"]' id='contactoNombre["+n+"]' class='cajaMedia' onfocus='ocultar_homonimos("+n+")'>";
			fila += "<a href='#' onclick='mostrar_homonimos("+n+");'><image src='"+base_url+"images/ver.png' border='0'></a>";
			fila += "<div id='homonimos["+n+"]' style='display:none;background:#ffffff;width:300px;border:1px solid #cccccc;height:40px;overflow:auto;position:absolute;z-index:1;'></div>";
			fila += "</td>";
			fila += "<td align='center'><select name='contactoArea["+n+"]' id='contactoArea["+n+"]' class='comboMedio' ><option value='0'>::Seleccionar::</option></select></td>";
			fila += "<td align='left'><select name='cargo_encargado["+n+"]' id='cargo_encargado["+n+"]' class='cajaMedia'><option value='0'>::Seleccione::</option></select></td>";
			fila += "<td align='left'><input type='text' name='contactoTelefono["+n+"]' id='contactoTelefono["+n+"]' class='cajaPequena'></td>";
			fila += "<td align='left'><input type='text' name='contactoEmail["+n+"]' id='contactoEmail["+n+"]' class='cajaPequena'></td>";
			if($('#proyecto_persona').val()!=''){
				fila += "<td align='center'>&nbsp;</td>";
				fila += "<td align='center'><a href='#' onclick='insertar_contacto("+n+");'><img src='"+base_url+"images/save.gif' border='0'></a></td>";
			}
                        else{
                            fila += "<td>&nbsp;</td>";
                            fila += "<td>&nbsp;</td>";
                        }
			fila += "</tr>";
			$("#tablaContacto").append(fila);
			document.getElementById(a).focus();
			listar_areas(n);
		}
		else if(opcion==2){
                        $("#msgRegistros2").hide();		
			n = document.getElementById('tablaSucursal').rows.length;
			a = "nombreSucursal["+n+"]";
			j = n+1;
			fila  = "<tr>";
			fila += "<td align='center'>"+n+"</td>";
			fila += "<td align='left'>";
			fila += "<input type='text' name='nombreSucursal["+n+"]' id='nombreSucursal["+n+"]' class='cajaMedia'>";
			fila += "<input type='hidden' name='proyectoSucursal["+n+"]' id='proyectoSucursal["+n+"]' class='cajaMedia' value='"+proyecto+"'>";
			fila += "</td>";
			fila += "<td align='left'><select name='tipoEstablecimiento["+n+"]' id='tipoEstablecimiento["+n+"]' class='comboMedio' ><option>::Seleccione::</option></select></td>";
			fila += "<td align='left'><input type='text' name='direccionSucursal["+n+"]' id='direccionSucursal["+n+"]' class='cajaGrande'></td>";
			fila += "<td align='left'>";
			fila += "<input type='hidden' name='dptoSucursal["+n+"]' id='dptoSucursal["+n+"]' class='cajaGrande' value='15'>";
			fila += "<input type='hidden' name='provSucursal["+n+"]' id='provSucursal["+n+"]' class='cajaGrande' value='01'>";
			fila += "<input type='hidden' name='distSucursal["+n+"]' id='distSucursal["+n+"]' class='cajaGrande'>";
			fila += "<input type='text' name='distritoSucursal["+n+"]' id='distritoSucursal["+n+"]' class='cajaPequena' readonly='readonly' onclick='abrir_formulario_ubigeo_sucursal("+n+");'/>";
			fila += "<a href='#' onclick='abrir_formulario_ubigeo_sucursal("+n+");'><image src='"+base_url+"images/ver.png' border='0'></a>";
			fila += "</td>";
			if($('#proyecto_persona').val()!=''){
				fila += "<td align='center'>&nbsp;</td>";
				fila += "<td align='center'><a href='#' onclick='insertar_sucursal("+n+");'><img src='"+base_url+"images/save.gif' border='0'></a></td>";
			}
                        else{
                            fila += "<td>&nbsp;</td>";
                            fila += "<td>&nbsp;</td>";
                        }
			fila += "</tr>";
			$("#tablaSucursal").append(fila);
			document.getElementById(a).focus();
			listar_tipoEstablecimientos(n);
		}
    });
  
});
function editar_proyecto(proyecto){
        var url = base_url+"index.php/maestros/proyecto/editar_proyecto/"+proyecto;
	$("#zonaContenido").load(url);
}
function eliminar_proyecto(proyecto){
	if(confirm('Esta seguro desea eliminar este proyecto?')){
		dataString = "proyecto="+proyecto;
		url = base_url+"index.php/maestros/proyecto/eliminar_proyecto";
		$.post(url,dataString,function(data){
			url = base_url+"index.php/maestros/proyecto/proyectos";
			location.href = url;
		});
	}
}

function ver_proyecto(proyecto){
	url = base_url+"index.php/maestros/proyecto/ver_proyecto/"+proyecto;
	$("#zonaContenido").load(url);
}

function atras_proyecto(){
	location.href = base_url+"index.php/maestros/proyecto/proyectos";
}


function agregar_direccion_proyecto() {
	

	posicion = $("#posicionEditar").val();
	alert(posicion);
	if(posicion.trim()!=""){
		a='descripcionDireccion['+posicion+']';
		b='referenciaDireccion['+posicion+']';
		c='cboDepartamentoD['+posicion+']';
		d='cboProvinciaD['+posicion+']';
		e='cboDistritoD['+posicion+']';
		f='cordenadaY['+posicion+']';
		g='cordenadaX['+posicion+']';
		
		descripcionGeneral=$("#descripcion").val();
		$("#idlDescripcionDireccion"+posicion).html(descripcionGeneral);
		document.getElementById(a).value=descripcionGeneral;
		
		referenciaGeneral=$("#referencia").val();
		$("#idlReferenciaDireccion"+posicion).html(referenciaGeneral);
		document.getElementById(b).value=referenciaGeneral;
		
		document.getElementById(c).value=$("#cboDepartamento").val();
		document.getElementById(d).value=$("#cboProvincia").val();
		document.getElementById(e).value=$("#cboDistrito").val();
		
		$("#idlNombresUbigeo"+posicion).html($("#cboDepartamento option:selected").text()+' / '+$("#cboProvincia option:selected").text()+' / '+$("#cboDistrito option:selected").text());
		
		document.getElementById(f).value=$("#cordY").val();
		document.getElementById(g).value=$("#cordX").val();
		
		limpiarDireccion();
		
	}else{
		direccionCodigo = null;
	    descripcionDireccion = $("#descripcion").val();
	    referenciaDireccion = $("#referencia").val();
	    cboDepartamento =  $("#cboDepartamento").val();
	    cboProvincia = $("#cboProvincia").val();
	    cboDistrito = $("#cboDistrito").val();
	    
	    nombreDepartamento =  $("#cboDepartamento option:selected").text();
	    nombreProvincia = $("#cboProvincia option:selected").text();
	    nombreDistrito = $("#cboDistrito  option:selected").text();
	    
	    cordenadaY = $("#cordY").val();
	    cordenadaX = $("#cordX").val();    
	    n = document.getElementById('tblDetalleDireccionProyecto').rows.length;   
	    j = n + 1;
	    if (j % 2 == 0) {
	        clase = "itemParTabla";
	    } else {
	        clase = "itemImparTabla";
	    }    

	    
	    
	    fila = '<tr id="' + n + '" class="' + clase + '">';
	    fila += '<td width="2%"><div align="center"  style="width: 70%;" ><font color="red"  style="width: 100%;" ><strong>';
	    fila += '<a href="javascript:;" onclick="eliminar_direccion(' + n + ');"><span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span></a>';
	    fila += '</strong></font></div></td>';
		fila += '<td width="2%">' + n + '</td>';
	    fila += '<input type="hidden" name="direccionCodigo[' + n + ']"  id="direccionCodigo[' + n + ']"  />	';				
	    fila += '<td width="5%"><div align="left" style="width: 60%;" >';
	    fila += '<label id="idlDescripcionDireccion' + n + '" >' + descripcionDireccion + '</label>';
	    fila += '<input type="hidden" name="descripcionDireccion[' + n + ']"   id="descripcionDireccion[' + n + ']"  value="' + descripcionDireccion + '"/>';
	    fila += '</div></td>';
		fila += ' <td width="5%"> <div align="left"  style="width: 60%;" >';
	    fila += '<label id="idlReferenciaDireccion' + n + '">' + referenciaDireccion + '</label>';
	    fila += '<input type="hidden" name="referenciaDireccion[' + n + ']"  id="referenciaDireccion[' + n + ']"  value="' + referenciaDireccion + '"/>';
	    fila += '</div></td>';
	    fila += '<td width="10%">	    ';
	    fila += ' <input type="hidden"  name="cboDepartamentoD[' + n + ']" id="cboDepartamentoD[' + n + ']"	value="' + cboDepartamento + '"/>';
	    fila += '<input type="hidden"  name="cboProvinciaD[' + n + ']" id="cboProvinciaD[' + n + ']" value="' + cboProvincia + '"/>';
	    fila += '<input type="hidden"  name="cboDistritoD[' + n + ']"	id="cboDistritoD[' + n + ']"	value="' + cboDistrito + '"/>	';
	    fila += '<label id="idlNombresUbigeo' + n + '">'+nombreDepartamento+' / '+nombreProvincia+' / '+nombreDistrito+'</label>';
	    fila += '<textarea  name="cordenadaX[' + n + ']" id="cordenadaX[' + n + ']"  style="display:none;" >'+ cordenadaX +'</textarea>';
	    fila += '<textarea  name="cordenadaY[' + n + ']" id="cordenadaY[' + n + ']"  style="display:none;">'+ cordenadaY +'</textarea>';
	    fila += '<input type="hidden" class="cajaMinima" name="direaccion[' + n + ']" id="direaccion[' + n + ']" value="n">';
	    fila += '</td>';
	    fila += '<td width="5%"><div align="left"  style="width: 60%;" >';
	    fila += '<a href="javascript:;" onclick="editar_direccion(' + n + ')"><img src="'+base_url+'images/modificar.png" width="16" height="16" border="0" title="Modificar"></a>';
	    fila += '</div></td>';
	    fila += '</tr>';
	    
	    $("#tblDetalleDireccionProyecto").append(fila);
	    $("#direccion").focus();
	    limpiarDireccion();
	}
	
	

}

function listar_departamento(n){
    var base_url = $("#base_url").val();
    a      = "cboDepartamento["+n+"]";
    url    = base_url+"index.php/maestros/proyecto/JSON_listar_departamento";
    select = document.getElementById(a);
    $.getJSON(url,function(data){
        $.each(data, function(i,item){
            codigo      = item.UBIGC_CodDpto;
            descripcion = item.UBIGC_Descripcion;
            opt         = document.createElement('option');
            texto       = document.createTextNode(descripcion);
            opt.appendChild(texto);
            opt.value = codigo;
            select.appendChild(opt);
        });
    });
}

function eliminar_direccion(n) {
    if (confirm('Esta seguro que desea eliminar esta direccion ffff?')) {
    	a = "direccionCodigo[" + n + "]";
    	b = "direaccion[" + n + "]";
        fila = document.getElementById(a).parentNode;
        fila.style.display = "none";
        document.getElementById(b).value = "e";
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


function cargar_provincias(obj){
    departamento = obj.value;
    provincia    = "01";
    if(departamento!='00'){
        url = base_url+"index.php/maestros/ubigeo/cargar_ubigeos/"+departamento+"/"+provincia;
        $("#divUbigeos").load(url);
    }
}


function cargar_distritos(obj){
    departamento = $("#cboDepartamento").val();
    provincia    = obj.value;
    if(departamento!='00' && provincia!='00'){
        url = base_url+"index.php/maestros/ubigeo/cargar_ubigeos/"+departamento+"/"+provincia;
        $("#divUbigeos").load(url);
    }
}

function limpiarDireccion(){
	$('#descripcion').val("");
	$('#referencia').val("");
	$('#cboDepartamento').val("");
	$('#cboProvincia').val("");
	$('#cboDistrito').val("");
	$('#cordY').val("");
	$('#cordX').val("");
	$('#codigoDireccion').val("");
	$('#posicionEditar').val("");
	$('#idLcordY').html("");
	$('#idLcordX').html("");
	
}


