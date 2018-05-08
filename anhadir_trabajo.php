<?php
require_once 'presentation.class.php';
require_once 'VistaAutor.class.php';
require_once 'business.class.php';
require_once 'Validadores.class.php';

if(!($datosUsuario = User::getLoggedUser()) || $datosUsuario['tipo'] != 2){
	header("Location: login.php");
}

$errores = false;
if(isset($_POST['nueva-obra'])){ //Validación en PHP
	$errores = Validadores::validaAddObra($_POST, $_FILES['imagen'], $datosUsuario['id']);
}

View::start('Artencuentro: área de autores', array("estilos.css"));

View::navegacion();

$cabecera = "Área personal de ".$datosUsuario['nombre'].":";
VistaAutor::formNuevaObra($cabecera);

if($errores){
	foreach ($errores as $error) {
		View::error($error);
	}
}

View::end();