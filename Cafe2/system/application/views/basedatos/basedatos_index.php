            
<html>
    <head>	
        <script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js"></script>	
        <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
                 <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.blockUI.js"></script>
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
        <style>
       .lista_botones li{
       margin-top:-7px;
       margin-bottom:5px;
       } 
        </style>
        <script language="javascript">

        /*** DESHABILITAR LA TECLA F5 - INICIO****/
        function checkKeyCode(evt){
	        var evt = (evt) ? evt : ((event) ? event : null);
	        var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
		        if(event.keyCode==116){
		        evt.keyCode=0;
		        return false
		        }
        }
        document.onkeydown=checkKeyCode;
        /*** DESHABILITAR LA TECLA F5 - FIN****/
        
            $(document).ready(function(){
           

            $("a#ventanaProveedor").fancybox({
                'width': 500,
                'height': 210,
                'autoScale': false,
             //   'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': false,
                'type': 'iframe'
            });

            $("a#ventanaArticulo").fancybox({
                'width': 500,
                'height': 200,
                'autoScale': false,
               // 'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': false,
                'type': 'iframe'
            });

            $("a#ventanaCliente").fancybox({
                'width': 500,
                'height': 210,
                'autoScale': false,
               // 'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': false,
                'type': 'iframe'
            });

            $("a#ventanaDestruir").fancybox({
                'width': 515,
                'height': 240,
                'autoScale': false,
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': true,
                'type': 'iframe'
            });

            $("a#ventanaDestruirTransaccionales").fancybox({
                'width': 515,
                'height': 240,
                'autoScale': false,
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': true,
                'type': 'iframe'
            });

            
        $('#cargarArticulo').click(function() {
            $('#ventanaArticulo').click();
        });

        $('#cargarProveedor').click(function() {
            $('#ventanaProveedor').click();
        });

        $('#cargarCliente').click(function() {
            $('#ventanaCliente').click();
        });

        $('#destruirTabla').click(function() {
            $('#ventanaDestruir').click();
        });

        $('#destruirTrans').click(function() {
            $('#ventanaDestruirTransaccionales').click();
        });

      

    });

            /**Redireccionar a salida al momento de confirmar en el boton detruir base de datos**/
           function RedireccionIndex(){
        		var urlDireccion= "<?php echo base_url(); ?>index.php/index/salir_sistema";
	    		location.href=urlDireccion;
          }

            var cursor;
            if (document.all) {
                // Está utilizando EXPLORER
                cursor='hand';
            } else {
                // Está utilizando MOZILLA/NETSCAPE
                cursor='pointer';
            }
        </script>	
    </head>
    
<body>


	<div id="pagina">
		<div id="zonaContenido">		
		
			<div align="center">
				<div id="tituloForm" class="header">Cargar De Excel</div>
				<div class="acciones">
				
					<div id="botonBusqueda">

						<ul id="cargarArticulo" class="lista_botones">
							<li id="uploadArticulo">
							Cargar Articulo 
							<a href="<?php echo base_url() . 'index.php/basedatos/basedatos/ventana_cargar_Articulo' ?>" id="ventanaArticulo"></a>
							</li>
						</ul>
						<ul id="cargarCliente" class="lista_botones">
							<li id="uploadCliente">
							Cargar Cliente
							<a href="<?php echo base_url() . 'index.php/basedatos/basedatos/ventana_cargar_cliente' ?>" id="ventanaCliente"></a>
							</li>
						</ul>
                       <ul id="cargarProveedor" class="lista_botones">
							<li id="uploadProveedor">
							Cargar Proveedor
							<a href="<?php echo base_url() . 'index.php/basedatos/basedatos/ventana_cargar_proveedor' ?>" id="ventanaProveedor"></a>
							</li>
						</ul>
					</div>
				</div>
				</div>
				
				
				
				<div align="center">
				<div id="tituloForm" class="header">Destruccion de Tablas de Base de Datos</div>
				<div class="acciones">
				
					<div id="botonBusqueda">
                       <ul id="destruirTabla" class="lista_botones">
							<li id="uploadDestroyer">
							Limpiar Registros y Transaccionales
							<a href="<?php echo base_url() . 'index.php/basedatos/basedatos/ventana_destruir_tablas' ?>" id="ventanaDestruir"></a>
							</li>
						</ul>
						<ul id="destruirTrans" class="lista_botones">
							<li id="uploadDestroyerTrans">
							Limpiar Transaccionales
							<a href="<?php echo base_url() . 'index.php/basedatos/basedatos/ventana_destruir_transaccionales' ?>" id="ventanaDestruirTransaccionales"></a>
							</li>
						</ul>
						
					</div>
				</div>
				</div>
			</div>
			
		
		</div>
		
		
</body>
</html>
