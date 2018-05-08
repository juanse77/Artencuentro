<?php
require_once 'presentation.class.php';
require_once 'VistaBuscar.class.php';
require_once 'NegocioObras.class.php';

View::start('Artencuentro: buscador', array("estilos.css", "tabla.css"));
View::navegacion();

$resultado = NegocioObras::getTipos();
VistaBuscar::buscador($resultado);

$datos = false;
if(isset($_POST['obra'])){
	$datos = NegocioObras::getObrasCompuesto($_POST['obra'], $_POST['tipo']);   
}

VistaBuscar::mostrar_tabla($datos);
View::end();