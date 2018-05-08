<?php
require_once 'presentation.class.php';
require_once 'VistaAutor.class.php';
require_once 'business.class.php';
require_once 'NegocioObras.class.php';

if(!($datosUsuario = User::getLoggedUser()) || $datosUsuario['tipo'] != 2){
	header("Location: login.php");
}

View::start('Artencuentro: área de autores', array("estilos.css", "tabla.css"));

View::navegacion();

$datos = NegocioObras::getObrasLigero($datosUsuario['id']);
VistaAutor::mostrarTablaEdit($datos, "Área personal de ".$datosUsuario['nombre'].":");

$datos = NegocioObras::getPropuestas($datosUsuario['id']);
VistaAutor::mostrarPropuestas("Propuesta:", $datos, $datosUsuario);

View::end();