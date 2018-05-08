<?php
require_once 'presentation.class.php';
require_once 'VistaAutor.class.php';
require_once 'business.class.php';
require_once 'NegocioObras.class.php';
require_once 'Validadores.class.php';

if(!($datosUsuario = User::getLoggedUser()) || $datosUsuario['tipo'] != 2){
	header("Location: login.php");
}

if(isset($_GET['id_obra']) && NegocioObras::esAutorDe($_GET['id_obra'], $datosUsuario['id'])){
	$errores = false;
	
	if(isset($_POST['edit-obra'])){
		$errores = Validadores::validaEditObra($_POST);
	}

	View::start('Artencuentro: área de autores', array("estilos.css"));

	View::navegacion();

	$obra = NegocioObras::getObra($_GET['id_obra']);
	$cabecera = "Área personal de ".$datosUsuario['nombre'].":";

	VistaAutor::formEditObra($cabecera, $obra);

	if($errores){
		foreach ($errores as $error) {
			View::error($error);
		}
	}

	View::end();

}else{
	header('Location: login.php');
}