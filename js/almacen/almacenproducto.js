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
    
    $('#txtCodigo, #txtNombre, #txtFamilia, #txtMarca').keyup(function(e){
       var key=e.keyCode || e.which;
        if (key==13){
            $("#form_busqueda").submit();
        } 
    });
});

function ver_kardex(producto, ci,nombre){
    almacen = $("#almacen_id").val();
    $("#producto").val(producto);
    $("#almacen").val(almacen);
    $("#nombre_producto").val(nombre);
    $("#codproducto").val(ci);
    $("#frmkardex").submit();
}
function atras_almacen(){
    location.href = base_url+"index.php/almacen/almacen/listar";
}