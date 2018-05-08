<?php
require_once 'business.class.php';
require_once 'NegocioObras.class.php';

$res = new stdClass();
$res->realizado = false;
$res->likes = 0;
$res->mensaje_error = '';

$usuario = User::getLoggedUser();

if($usuario && $usuario['tipo'] == 2){

	try{
	    $datoscrudos = file_get_contents("php://input");
	    $datos = json_decode($datoscrudos);

	    $sql = false;
	    if($datos->bandera){
	    	$sql = NegocioObras::desmarcarLike($usuario, $datos->id_obra);
	    }else{
	    	$sql = NegocioObras::registrarLike($usuario, $datos->id_obra);	
	    }

	    if($sql){

	    	if($sql->rowCount() == 1){
	    		$res->realizado = true;		
	    		$res->likes = NegocioObras::cuentaLikes($datos->id_obra);
	    	}else{
	    		$res->mensaje_error = 'Error 1';
	    	}
 
	    }else{
	        $res->mensaje_error = 'Error en la ejecución de la sentencia SQL';
	    }

	}catch(Exception $e){
	   $res->mensaje_error = "Se ha producido una excepción en el servidor: ".$e->getMessage(); 
	}

}else{
	$res->mensaje_error = 'No tiene permisos para la operación solicitada';
}

header('Content-type: application/json');
echo json_encode($res);
