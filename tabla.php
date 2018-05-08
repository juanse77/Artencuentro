<?php
include_once 'presentation.class.php';
include_once 'VistaMostrar.class.php';
include_once 'NegocioObras.class.php';

View::start('Artencuentro', array("estilos.css", "tabla.css"));
View::navegacion();

$res = NegocioObras::getTodas();
VistaMostrar::tabla($res);

View::end();
?>