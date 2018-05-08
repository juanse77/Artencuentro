<?php
require_once 'business.class.php';
require_once 'NegocioObras.class.php';

$res = new stdClass(); // Clase vacía para añadir atributos
$res->borrado = false;
$res->mensaje_error = '';

$usuario = User::getLoggedUser();

if($usuario && $usuario['tipo'] == 2){

	try{
	    $datoscrudos = file_get_contents("php://input"); //Accedemos al flujo de datos
	    $datos = json_decode($datoscrudos);

		if(NegocioObras::esAutorDe($datos->id_obra, $usuario['id'])){

			$sql = NegocioObras::eliminarObra($datos->id_obra); 
		    if($sql){
		    
		        if($sql->rowCount() > 0){
		           $res->borrado = true;
		        }else{
		            $res->mensaje_error = 'No se ha encontrado el registro a borrar';
		        }
		    
		    }else{
		        $res->mensaje_error = 'Error en la ejecución de la sentencia SQL';
		    }

		}else{
			$res->mensaje_error = 'La obra seleccionada no pertenece al autor';
		}	    

	}catch(Exception $e){
	   $res->mensaje_error = "Se ha producido una excepción en el servidor: ".$e->getMessage(); 
	}

}else{
	$res->mensaje_error = 'No tiene permisos para la operación solicitada';
}

header('Content-type: application/json');
echo json_encode($res);
