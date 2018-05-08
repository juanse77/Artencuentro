<?php
require_once 'presentation.class.php';
require_once 'VistaAutor.class.php';
require_once 'NegocioObras.class.php';
require_once 'data_access.class.php';

View::start('Artencuentro', array("estilos.css", "tabla.css"));
View::navegacion();

$resultado = false;

if(isset($_GET['idautor'])){

    $nombre = NegocioObras::getUserName($_GET['idautor']);

    if($nombre == ""){
    	$cabecera = "No se encontraron obras para el usuario consultado.";
    }else{
    	$cabecera = "Listado de obras de ".$nombre.":";	
    }    

    $resultado = NegocioObras::getObrasLigero($_GET['idautor']);

}else{
	$cabecera = "No se seleccionó ningún usuario.";
    View::printCabecera($cabecera);
}

if($resultado){

    if(count($resultado) > 0){
	   VistaAutor::mostrarTabla($resultado, $cabecera);
    }else{
        View::printCabecera("El usuario consultado no existe.");
    }
}

View::end();
