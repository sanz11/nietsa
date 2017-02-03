<html>
<head>
	<title><?php echo TITULO;?></title>
	<link rel="stylesheet" href="<?php echo URL_CSS;?>estilos.css" type="text/css">
	<link rel="stylesheet" href="<?php echo URL_CSS;?>theme.css" type="text/css">		
	<script language="javaScript" src="<?php echo URL_JS;?>JSCookMenu.js"></script>
	<script language="javaScript" src="<?php echo URL_JS;?>theme.js"></script>	
	<script type="text/javascript" src="<?php echo URL_BASE;?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo URL_BASE;?>js/comercialjs.js"></script>	
	<script type="text/javascript">
		$(function(){
		$('#mi_form').submit(function(event){
		event.preventDefault(); //Evitamos que el evento submit siga en ejecuci�n, evitando que se recargue toda la p�gina
		$.post("mi_controller/procesa_form",
			$("form#edit_form").serialize(), //Codificamos todo el formulario en formato de URL
			function (data) {
				$('div#sending_form').prepend(data); //A�adimos la respuesta AJAX a nuestro div de notificaci�n de respuesta
			});
		});
		});
	</script>
</head>
<body>
<?php
$attr = 'id="mi_form"'; //Le damos el id mi_form al formulario
echo form_open('mi_controller/procesa_form',$attr);
 //Creamos un campo de tipo texto
 echo form_label('Campo1: ','campo1');
 $data = array(
 'name'        => 'campo1',
 'id'          => 'campo1',
 'value'       => ''
 );
 echo form_input($data);
 //Creamos una serie de checkboxes
 $data = array(
 'name'        => 'campo2',
 'id'          => 'campo2',
 'value'       => '2',
 'checked'     => false
 );
 echo form_checkbox($data);
 $data = array(
 'name'        => 'campo3',
 'id'          => 'campo3',
 'value'       => '3',
 'checked'     => false
 );
 echo form_checkbox($data);
 //Creamos unos radio
 $data = array(
 'name'        => 'radio',
 'id'          => 'radio1',
 'value'       => 'radio1',
 'checked'     => false
 );
 echo form_radio($data);
 $data = array(
 'name'        => 'radio',
 'id'          => 'radio2',
 'value'       => 'radio2',
 'checked'     => false
 );
 echo form_radio($data);
 //Un textarea
 echo form_label('Textarea: ','textarea');
 $data = array(
 'name'        => 'textarea',
 'id'          => 'textarea',
 'value'       => '',
 'rows'        => '2',
 'cols'        => '50'
);
 echo form_textarea($data);
 echo "<br><input type='submit' value='Enviar'>";
echo form_close();

?>
</body>
</html>