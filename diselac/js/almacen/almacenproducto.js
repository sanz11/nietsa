var base_url;
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    $("#buscarStock").click(function(){
        $("#frmStock").submit();
    });
    $("#limpiarProducto").click(function(){
        url = base_url+"index.php/almacen/almacenproducto/listar_general";
        location.href=url;
    });
    $("#buscarProducto").click(function(){
        $("#form_busqueda").submit();
    });

    $("#imprimirProducto").click(function(){
        
            var codigo = $("#txtCodigo").val();
            var nombre = $("#txtNombre").val();

            var codigo = sintilde(codigo);
            var nombre= sintilde(nombre);
        ///
          if(codigo==""){codigo="--";}
          if(nombre==""){nombre="--";}

        url = base_url+"index.php/almacen/almacenproducto/registro_producto_pdf/"+codigo+"/"+ nombre;
        window.open(url,'',"width=800,height=600,menubars=no,resizable=no;");
    });

    
    $('#txtCodigo, #txtNombre, #txtFamilia, #txtMarca').keyup(function(e){
       var key=e.keyCode || e.which;
        if (key==13){
            $("#form_busqueda").submit();
        } 
    });
});

function sintilde(cadena){
   
   var specialChars = "!@#$^&%*()+=-[]\/{}|:<>?,.";

   
   for (var i = 0; i < specialChars.length; i++) {
       cadena= cadena.replace(new RegExp("\\" + specialChars[i], 'gi'), '');
   }   

   // Lo queremos devolver limpio en minusculas
   cadena = cadena.toLowerCase();

   // Quitamos acentos y "ñ". Fijate en que va sin comillas el primer parametro
   cadena = cadena.replace(/á/gi,"a");
   cadena = cadena.replace(/é/gi,"e");
   cadena = cadena.replace(/í/gi,"i");
   cadena = cadena.replace(/ó/gi,"o");
   cadena = cadena.replace(/ú/gi,"u");
   cadena = cadena.replace(/ñ/gi,"n");
   return cadena;
}


function ver_kardex(producto, ci,nombre){
    almacen = $("#almacen_id").val();
    $("#producto").val(producto);
    $("#almacen").val(almacen);
    $("#nombre_producto").val(nombre);
    $("#codproducto").val(ci);
    $("#frmkardex").submit();
}
function atras_almacen() {
	location.href = base_url + "index.php/almacen/almacen/listar";
}

function descargarExcel() {

//	var aprobado = $('#aprobado').val();
//var productoPrueba = "TABLET TH5549+AU SILVER - ADVANCE";
//	url = base_url + "index.php/almacen/almacenproducto/verReporteExcel/"+ productoPrueba;
	url = base_url + "index.php/almacen/almacenproducto/verReporteExcel";
	window.open(url, '', "width=800,height=600,menubars=no,resizable=no;");
}
