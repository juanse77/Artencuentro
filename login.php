<?php
require_once 'presentation.class.php';
require_once 'VistaLogin.class.php';
require_once 'business.class.php';
require_once 'conf.php';

if($datosUsuario = User::getLoggedUser()){
	header("Location: home".$roles[$datosUsuario['tipo']].".php");
}

$usuario;
if(isset($_POST['usuario'])){
	$usuario = User::login($_POST['usuario'], $_POST['clave']);

	if($usuario){
		$datosUsuario = User::getLoggedUser();
		header("Location: home".$roles[$datosUsuario['tipo']].".php");
	}
}

View::start('Artencuentro', array("estilos.css"));

View::navegacion();

VistaLogin::login();

if(isset($_POST['usuario']) && !$usuario){
	VistaLogin::errorLogin();
}

View::end();