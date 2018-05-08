<?php
require_once 'presentation.class.php';
require_once 'business.class.php';
require_once 'conf.php';

if(!($datosUsuario = User::getLoggedUser()) || $datosUsuario['tipo'] != 1){
	header("Location: login.php");
}

View::start('Artencuentro: área de administración', array("estilos.css"));

View::navegacion();

View::printCabecera("Área de administración.");

View::end();