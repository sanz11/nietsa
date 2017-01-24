
$(document).ready(function() {
    $('input[onfinishinput]').live("keydown", function(e)
    {
        
        var inp = String.fromCharCode(e.keyCode);
        if (/[a-zA-Z0-9-_ ]/.test(inp) || e.keyCode === 8)
            startTypingTimer($(e.target));
    });
    $("#cerrar_inventario_input").click(function(){
        parent.$.fancybox.close(); 
    });
});


var typingTimeout;
function startTypingTimer(input_field)
{
    if (typingTimeout != undefined)
        clearTimeout(typingTimeout);
    typingTimeout = setTimeout(function()
    {
        eval(input_field.attr("onfinishinput"));
    }
    , 500);
}

function numbersonly(myfield, e, dec)
{
	var key;
	var keychar;
	if (window.event)
		key = window.event.keyCode;
	else if (e)
		key = e.which;
	else
		return true;
	keychar = String.fromCharCode(key);
	// control keys
	//if ((key==13) )
			//alert("aaaaaaaa");

	if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) )
		return true;
	// numbers
	if (dec && (keychar == "." || keychar == ","))
	{
		var temp=""+myfield.value;
		if(temp.indexOf(keychar) > -1)
			return false;
	}
	else if ((("0123456789").indexOf(keychar) > -1))
		return true;
	// decimal point jump
	else
	return false;
}

function textoonly(myfield, e)
{
	var key;
	var keychar;
	if (window.event)
		key = window.event.keyCode;
	else if (e)
		key = e.which;
	else
		return true;
	keychar = String.fromCharCode(key);
	// control keys
	//if ((key==13) )
			//alert("aaaaaaaa");

	/*if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) )
		return true;
	// numbers
	if ((("ABCDEFGHIJKLMN?OPQRSTUVWXYZabcdefghijklmn?opqrstuvwxyz ").indexOf(keychar) > -1))
		return true;
	// decimal point jump
	else
	return false; */

	if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) ){
		return true;
	}
	else if (("1234567890".indexOf(keychar) == -1)){
		//alert("validando letras");
		return true;
	}
	else{
		return false;
	}
}
function ventana_producto_serie0(indice, compania){
    producto = "prodcodigo["+indice+"]"
    prod = document.getElementById(producto).value;
    almacen_id = document.getElementById("almacen_id").value;
    if(almacen_id=='')
        almacen_id='0';
    if(!compania)
        compania = document.getElementById("compania").value;
    url  = base_url+"index.php/almacen/producto/ventana_producto_serie0/"+prod+"/"+almacen_id+"/"+compania;
    $("a#linkSerie").attr('href', url).click();
    //window.open(url,"_blank","width=600,height=400,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0'");
}
/**gcbq ventana producto serie compra venta**/
function ventana_producto_serie(indice){
    producto = "prodcodigo["+indice+"]"
    cantidad = "prodcantidad["+indice+"]";
	guias	 = "codigoguia";
    prod = document.getElementById(producto).value;
    cant = document.getElementById(cantidad).value;
	tipo=1;
	tipoOperacion= document.getElementById("tipo_oper").value;
	almacenProducto = "almacenProducto["+indice+"]";
	almacen  = document.getElementById(almacenProducto).value;
	if(tipoOperacion!=null && tipoOperacion=='V'){
		if(almacen==''){
			alert('Seleccione primero un almacen');
	        document.getElementById("almacen").focus();
	        return false;
	    }
	}
	
	
	/**verificamos si el almacen es null para series que seleccione el almacen de donde va sacarm de o.compra , presupuesto , recurrentes ***/
	
	isSeleccionarAlmacen = "isSeleccionarAlmacen["+indice+"]";
	if(document.getElementById(isSeleccionarAlmacen)){
		isSeleccionarAlmacen= document.getElementById(isSeleccionarAlmacen).value;
		if(isSeleccionarAlmacen!=null && isSeleccionarAlmacen.trim()!=''){
			if(isSeleccionarAlmacen==1){
				isSeleccionarAlmacen=1;
			}
		}else{
			isSeleccionarAlmacen=0;
		}
	}else{
		isSeleccionarAlmacen=0;
	}
	/**guardamos la posicion selecionada para el proceso de añadir almacen a esta posicion**/
	$("#posicionSeleccionadaSerie").val(indice);
	
	url  = base_url+"index.php/almacen/producto/ventana_producto_serie/"+prod+"/"+cant+"/"+tipo+"/"+tipoOperacion+"/"+almacen+"/"+isSeleccionarAlmacen;
	var win=window.open(url,"_blank","width=600,height=400,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0'");
	
}
/****/

/**gcbq debe mostrar listado de series realizadas por cada documento producto y almacen**/
function ventana_producto_serieMostrar(docu,codigo,producto,almacen){
	
	/**verificamos si esta inicializado para destroy los campos**/
	if($('.ui-table').length > 0){
		$('#detallesSeriesAsociadas').columns('destroy');
	}
		/**OBTENER DATOS JSON DE SERIES***/
		 url = base_url + "index.php/almacen/producto/series_ingresadas_comprobante_producto_almacen_json/"+docu+"/"+codigo+"/"+producto + "/"+almacen,
         $.getJSON(url, function (data) {
        	 example1 = $('#detallesSeriesAsociadas').columns({
                 data:data,
                 schema: [
                     {"header":"Nro.", "key":"i"},
                     {"header":"Número Serie", "key":"numero"},
                     {"header":"Fecha de Registro", "key":"fecha"}
                 ],
                 evenRowClass: 'even-rows'
             }); 
             $("#dialogSeriesAsociadas" ).dialog( "open" );
         });
	
	
}



function ventana_producto_serie_1(){
    prod = document.getElementById("producto").value;
    cant = document.getElementById("cantidad").value;
    tipo =0;
    if(prod=='')
        return false;
    if(cant=='' || parseInt(cant)<=0)
        return false;
    
    tipoOperacion= document.getElementById("tipo_oper").value;
    almacen=document.getElementById("almacenProducto").value;
    if(tipoOperacion!=null && tipoOperacion=='V'){
    	almacen  = document.getElementById("almacenProducto").value;
        if(almacen==''){
            alert('Seleccione primero un almacen');
            document.getElementById("almacenProducto").focus();
            return false;
        }
    }
    
   
    /**tanto para VENTAS Y COMPRAS**/
  	url  = base_url+"index.php/almacen/producto/ventana_producto_serie/"+prod+"/"+cant+"/"+tipo+"/"+tipoOperacion+"/"+almacen;
    window.open(url,"_blank","width=600,height=400,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0'");
  	
  	return true;
}
function ventana_producto_serie_1_1(prod, cant){
    if(prod=='')
        return false;
    if(cant=='' || parseInt(cant)<=0)
        return false;
    
    url  = base_url+"index.php/almacen/producto/ventana_producto_serie/"+prod+"/"+cant;
    window.open(url,"_blank","width=400,height=400,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0'");
    return true;
}

function ventana_producto_serie2(indice){
    producto = "prodcodigo["+indice+"]"
    cantidad = "prodcantidad["+indice+"]";
    almacen  = document.getElementById("almacen").value;
	guias	 = "codigoguia";
	guia = document.getElementById(guias).value;

    if(almacen==''){
        alert('Seleccione primero un almacen');
        document.getElementById("almacen").focus();
        return false;
    }
	
    prod = document.getElementById(producto).value;
    cant = document.getElementById(cantidad).value;
    
	
  if(guia==""){
 
	 url  = base_url+"index.php/almacen/producto/ventana_producto_serie2/"+prod+"/"+cant+"/"+almacen+"/"+guia;
	}else{
	 url  = base_url+"index.php/almacen/producto/ventana_producto_series2/"+prod+"/"+cant+"/"+almacen+"/"+guia;
	}
	 
	
    window.open(url,"_blank","width=700,height=500,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0'");
    return true;
}



function ventana_producto_serie2t(indice){
    producto = "prodcodigo["+indice+"]"
    cantidad = "prodcantidad["+indice+"]";
    almacen  = document.getElementById("almacen").value; 
	guiain = document.getElementById("codigoguiain").value;
	guiasa = document.getElementById("codigoguiasa").value;
	tipo = document.getElementById("tipoguia").value;
	
    if(almacen==''){
        alert('Seleccione primero un almacen');
        document.getElementById("almacen").focus();
        return false;
    }
	
    prod = document.getElementById(producto).value;
    cant = document.getElementById(cantidad).value;
    
	  if(guiain==""){
	   url  = base_url+"index.php/almacen/producto/ventana_producto_serie2/"+prod+"/"+cant+"/"+almacen+"/"+guiasa+"/"+guiain;
 
	}else{
	 url  = base_url+"index.php/almacen/producto/ventana_producto_series2/"+prod+"/"+cant+"/"+almacen+"/"+guiasa+"/"+guiain;
	}

	 //url  = base_url+"index.php/almacen/producto/ventana_producto_serie2/"+prod+"/"+cant+"/"+almacen+"/"+guiasa+"/"+guiain+"/"+tipo;
	
    window.open(url,"_blank","width=700,height=500,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0'");
    return true;
}

//function ventana_producto_serie2_2(){
//    almacen  = document.getElementById("almacen").value;
//    if(almacen==''){
//        alert('Seleccione primero un almacen');
//        document.getElementById("almacen").focus();
//        return false;
//    }
//    prod = document.getElementById("producto").value;
//    cant = document.getElementById("cantidad").value;
//    if(prod=='')
//        return false;
//    if(cant=='' || parseInt(cant)<=0)
//        return false;
//    
//    url  = base_url+"index.php/almacen/producto/ventana_producto_serie2/"+prod+"/"+cant+"/"+almacen;
//    window.open(url,"_blank","width=700,height=500,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0'");
//    return true;
//}

//function ventana_producto_serie2_3(almacen, prod, cant){
//    if(almacen==''){
//        alert('Seleccione primero un almacen');
//        return false;
//    }
//    if(prod=='')
//        return false;
//    if(cant=='' || parseInt(cant)<=0)
//        return false;
//    
//    url  = base_url+"index.php/almacen/producto/ventana_producto_serie2/"+prod+"/"+cant+"/"+almacen;
//    window.open(url,"_blank","width=700,height=500,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0'");
//    return true;
//}

//Para dar formato a la moneda (2 decimales)
function money_format(amount) {
      /*var val = parseFloat(amount);
      if (isNaN(val)) { return "0.00"; }
      if (val <= 0) { return "0.00"; }
      val += "";
      // Next two lines remove anything beyond 2 decimal places
      if (val.indexOf('.') == -1) { return val+".00"; }
      else { val = val.substring(0,val.indexOf('.')+3); }
      val = (val == Math.floor(val)) ? val + '.00' : ((val*10 ==
      Math.floor(val*10)) ? val + '0' : val);
      return val;*/
      
      var original=parseFloat(amount);
      var result=Math.round(original*10000)/10000 ;
      return result;
      //return amount;
}
function limpiar_combobox(combobox){
    select   = document.getElementById(combobox);
    options = select.getElementsByTagName("option"); 
    var num_option=options.length;
    for(i=1;i<=num_option;i++){
        select.remove(0)
     }
    opt = document.createElement("option");
    texto = document.createTextNode(":: Seleccione ::");
    opt.appendChild(texto);
    opt.value = "";
    select.appendChild(opt);
}
function cambiar_sesion(){
        var compania = $("#cboCompania").val();
        var base_url   = $("#base_url").val();
        if(compania != ''){
           var dataString  = "compania="+compania;
           var url = base_url+"index.php/maestros/configuracion/cambiar_sesion";
            $.post(url,dataString,function(data){
              if(data != 0){
                window.location.reload();
              }else{
                alert('Error al cambiar la sesion');
              }

            });
			
        }


}

/**gcbq debe mostrar listado se series realizadas por cada almacen**/
function mostrarSeriesProducto(codigoProducto,codigoAlmacen){
	
	/**verificamos si esta inicializado para destroy los campos**/
	if($('.ui-table').length > 0){
		$('#detallesSeries').columns('destroy');
	}
		/**OBTENER DATOS JSON DE SERIES***/
		 url = base_url + "index.php/almacen/producto/series_ingresadas_almacen_json/" +codigoProducto + "/"+codigoAlmacen,
         $.getJSON(url, function (data) {
        	 example1 = $('#detallesSeries').columns({
                 data:data,
                 schema: [
                     {"header":"Nro.", "key":"i"},
                     {"header":"Número Serie", "key":"numero"},
                     {"header":"Fecha de Registro", "key":"fecha"},
                     {"header":"Almacen", "key":"almacen"}
                 ],
                 evenRowClass: 'even-rows'
             }); 
             
        	 
             $("#dialogSeries" ).dialog( "open" );
         });
}
function comprobante_ver_pdf_conmenbrete(comprobante,documento,imagen,tipo) {
    //tipo="V";
    var url = base_url + "index.php/maestros/configuracionimpresion/impresionDocumento/"+comprobante+"/"+documento+"/"+imagen+"/"+tipo+"/";
    window.open(url, '', "width=800,height=600,menubars=no,resizable=no;");
}

/**MODIFICAMOS EL TIPO DE SLECCION DE UN PRESUPUESTO***/
function modificarTipoSeleccionPrersupuesto(codigoPresupuesto,flagSeleccion){
	url=base_url + "index.php/ventas/presupuesto/modificarTipoSeleccion/" + codigoPresupuesto+"/"+flagSeleccion;
	$isRealizado=true;
	$.ajax({
	        url: url,
	        async: false, 
	        success: function (data) {
	        	//alert(data);
	        	switch (data) {
				case 0:
					$isRealizado=false;
					alert("ya se encuentra seleccionado");
					break;
				case 1:
					break;
				case 0:
					$isRealizado=false;
					alert("error consulte con el administrador.");
					break;
				}
	       	}
	});
	return $isRealizado;
}


