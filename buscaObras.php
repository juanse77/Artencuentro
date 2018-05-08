<?php
require_once 'NegocioObras.class.php';

$res = new stdClass();
$res->registros = array();
$res->mensaje_error = '';

try{

    $datoscrudos = file_get_contents("php://input");
    $datos = json_decode($datoscrudos);

    $res->registros = NegocioObras::getObrasCompuesto($datos->titulo, $datos->tipo);

}catch(Exception $e){
   $res->mensaje_error = "Se ha producido una excepción en el servidor: ".$e->getMessage(); 
}

header('Content-type: application/json');
echo json_encode($res);