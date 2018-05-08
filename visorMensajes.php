<?php
require_once 'business.class.php';
require_once 'NegocioObras.class.php';
require_once 'VistaAutor.class.php';

if(($datosUsuario = User::getLoggedUser()) && isset($_GET['idpropuesta']) && NegocioObras::esPropuestaDe($_GET['idpropuesta'], $datosUsuario['id'])){

	$error = "";
	if(isset($_GET['error'])){
		if($_GET['error'] == 1){
			$error = "El mensaje debe tener entre 1 y 256 caracteres.";	
		}
	}

	View::start('Artencuentro: visor de mensajes', array("estilos.css", "propuesta.css"));
	View::navegacion();

	$propuesta = NegocioObras::getPropuestaNombres($_GET['idpropuesta']);
	$mensajes = NegocioObras::getMensajes($_GET['idpropuesta']);
	VistaAutor::mostrarMensajes($propuesta, $mensajes, $_GET['idpropuesta'], $error);

	View::end();
}else{
	header('Location: login.php');	
}
