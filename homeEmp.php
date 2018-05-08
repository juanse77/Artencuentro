<?php
require_once 'presentation.class.php';
require_once 'VistaAutor.class.php';
require_once 'business.class.php';
require_once 'NegocioObras.class.php';

if(!($datosUsuario = User::getLoggedUser()) || $datosUsuario['tipo'] != 3){
	header("Location: login.php");
}

View::start('Artencuentro: área de autores', array("estilos.css", "tabla.css"));

View::navegacion();
View::printCabecera("Área privada de ". $datosUsuario['nombre'].":");

$datos = NegocioObras::getPropuestasEmp($datosUsuario['id']);
VistaAutor::mostrarPropuestas("Propuestas:", $datos, $datosUsuario);

View::end();