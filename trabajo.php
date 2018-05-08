<?php
require_once 'presentation.class.php';
require_once 'VistaTrabajo.class.php';
require_once 'NegocioObras.class.php';
require_once 'business.class.php';

$datos_usuario = User::getLoggedUser();

View::start('Artencuentro', array("estilos.css", "lista.css"));
View::navegacion();

if(isset($_GET['id_obra'])){

	$resultado = NegocioObras::getObrasPesado($_GET['id_obra']);

	if($resultado){
		VistaTrabajo::mostrarLista($resultado, $datos_usuario, $_GET['id_obra']);
	}else{
		View::printCabecera("No se ha seleccionado ningún trabajo.");
	}

}else{
	View::printCabecera("No se ha seleccionado ningún trabajo.");
}

View::end();