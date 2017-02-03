var base_url;
jQuery(document).ready(function(){
	base_url   = $("#base_url").val();
	
	$("#nuevaArea").click(function(){
		estado = $("#txtEstado").val();
        docu = $("#cbodocumento").val();
        des = $("#txtdescripcion").val();
        color = $("#txtcolor").val();
		  
        if(estado != "" && docu != "" && des != "" && color != ""){
        	nombreColor = $("#txtcolor").val();
            SSnombreColor = nombreColor.substr(1,6);
//        	alert("hola : " + SSnombreColor);
			dataString = $('#form_state').serialize();
			url = base_url+"index.php/maestros/state/state_nuevo/"+SSnombreColor;
			
			$.post(url,dataString,function(data){
				url = base_url+"index.php/maestros/state/state_index";
				location.href=url;
			});
        }else{
        	
        	alert("Ingresar todo los campos !");
        }
	});	

	$("#limpiarState").click(function(){
            $("#txtEstado").val('');
            $("#cbodocumento").val(13);
            $("#txtdescripcion").val('');
            $("#txtcolor").val('');
          
	});
	$("#buscarState").click(function(){
            alert("Falta");
	});

});


function eliminar_state(codigo){
	if(confirm('Esta seguro de eliminar un Estado ?')){
		dataString = "codigo="+codigo;
		url=base_url+"index.php/maestros/state/state_eliminar";
		$.post(url,dataString,function(data){
			url = base_url+"index.php/maestros/state/state_index";
			location.href=url;
		});
	}
}

