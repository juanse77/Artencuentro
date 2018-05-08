<?php
require_once 'data_access.class.php';

class NegocioObras{

	public static function getUserName($idautor){
		$consulta = "select distinct nombre from obras o, usuarios u where idautor=u.id and idautor=?;";

		$nombre = "";
		$resultado = DB::execute_sql($consulta, array($idautor));

	    if($resultado){
	    	$resultado->setFetchMode(PDO::FETCH_NAMED);
	    	$datos = $resultado->fetchAll();

	    	if(count($datos) == 1){
	    		$nombre = $datos[0]['nombre'];
	    	}
	    	 
	    }

	    return $nombre;
	}

	public static function getTipos(){

		$consulta = "Select distinct tipo from obras order by tipo;";
		$resultado = DB::execute_sql($consulta);

		if($resultado){
		    $resultado->setFetchMode(PDO::FETCH_NAMED);
			return $resultado->fetchAll();
		}

		return false;
	}

	public static function getObrasLigero($idautor){
		$consulta = "select id, titulo, fecha, tipo from obras where idautor=? order by fecha desc;";
		
    	$resultado = DB::execute_sql($consulta, array($idautor));

		if($resultado){

			$resultado->setFetchMode(PDO::FETCH_NAMED);
    		return $resultado->fetchAll();

		}
		
		return array();	
	}

	public static function getObra($id_obra){
		$consulta = "select id, idautor, titulo, tipo, fecha, descripcion, imagen from obras where id=?;";

		$resultado = DB::execute_sql($consulta, array($id_obra));
	
		if($resultado){
	    	$resultado->setFetchMode(PDO::FETCH_NAMED);
	    	$datos = $resultado->fetchAll();

	    	if(count($datos) == 1){
	    		return $datos[0];
	    	}
		}

		return false;
	}

	public static function getObrasPesado($id_obra){
		$consulta = "select titulo, u.id id_usuario, nombre, o.tipo tipo_obra, fecha, descripcion, imagen from usuarios u, obras o where o.idautor=u.id and o.id=?;";

		$resultado = DB::execute_sql($consulta, array($id_obra));
	
		if($resultado){
	    	$resultado->setFetchMode(PDO::FETCH_NAMED);
	    	$datos = $resultado->fetchAll();

	    	if(count($datos) == 1){
	    		return $datos[0];
	    	}
		}

		return false;
	}

	public static function getObrasCompuesto($obra, $tipo){

		$parametros = array();
		$cadena_obra = "";
		$cadena_tipo = "";

		if($obra != ""){
			$parametros[] = "%".$obra."%";
			$cadena_obra = "titulo LIKE ?";
		}

		if($tipo != ""){
			$parametros[] = $tipo;
			$cadena_tipo = "o.tipo = ?";
		}

		$consulta = "select nombre, idautor, titulo, o.id id_obra, fecha, o.tipo tipo_obra from obras o, usuarios u where idautor=u.id and ";

		if($cadena_obra != "" && $cadena_tipo != ""){
			$consulta .= "($cadena_obra and $cadena_tipo)";
		}elseif($cadena_obra != ""){
			$consulta .= $cadena_obra;
		}elseif($cadena_tipo != ""){
			$consulta .= $cadena_tipo;
		}else{
			$consulta = false;
		}

		if($consulta){
			$consulta .= " order by fecha desc;";
			$resultado = DB::execute_sql($consulta, $parametros);

			if($resultado){
			    $resultado->setFetchMode(PDO::FETCH_NAMED);
			    return $resultado->fetchAll();
			}	
		}    
	}

	public static function esAutorDe($id_obra, $id_usuario){
		$consulta = "select count(*) from obras where id = ? and idautor = ?;";

		$resultado = DB::execute_sql($consulta, array($id_obra, $id_usuario));

		if($resultado){
			$resultado->setFetchMode(PDO::FETCH_NUM);
			$dato = $resultado->fetchAll();
			
			if($dato[0][0] == 1){
				return true;
			}
		}

		return false;
	}

	public static function eliminarObra($id_obra){
		$sentencia = "delete from obras where id = ?;";
		return DB::execute_sql($sentencia, array($id_obra));
	}

	public static function addObra($obra){
		$sentencia = "insert into obras (idautor, titulo, tipo, fecha, descripcion, imagen) values (?, ?, ?, ?, ?, ?);";
		DB::execute_sql($sentencia, $obra);
	}

	public static function editObra($obra){
		$sentencia = "update obras set titulo=?, tipo=?, fecha=?, descripcion=? where id=?;";
		DB::execute_sql($sentencia, $obra);
	}

	public static function yaMeGusta($usuario, $id_obra){

		$consulta = "select id, idobra, idusuario from megusta where idobra=? and idusuario=?;";
		$resultado = DB::execute_sql($consulta, array($id_obra, $usuario['id']));
		
		if($resultado){
			$resultado->setFetchMode(PDO::FETCH_NUM);
			$datos = $resultado->fetchAll();

			if(count($datos) == 1){
				return true;
			}else{
				return false;
			}

		}else{
			exit("Error de conexión.");
		}
	}

	public static function puedeVotar($usuario){
		if($usuario && $usuario['tipo'] == 2){
			return true;
		}
		return false;
	}

	public static function registrarLike($usuario, $id_obra){
		$sentencia = "insert into megusta (idobra, idusuario) values (?, ?);";
		return DB::execute_sql($sentencia, array($id_obra, $usuario['id']));
	}

	public static function desmarcarLike($usuario, $id_obra){
		$sentencia = "delete from megusta where idusuario=? and idobra=?;";
		return DB::execute_sql($sentencia, array($usuario['id'], $id_obra));
	}

	public static function cuentaLikes($id_obra){
		$consulta = "select count(*) from megusta where idobra=?;";
		$resultado = DB::execute_sql($consulta, array($id_obra));

		if($resultado){
			$resultado->setFetchMode(PDO::FETCH_NUM);
			$dato = $resultado->fetchAll();

			return $dato[0][0];
		}

		return 0;
	}

	public static function getPropuestas($id_autor){
		$consulta = "select p.id idpropuesta, idautor, idempresa, nombre usuario, hora, descripcion, presupuesto, acuerdo from usuarios u, propuestas p where idempresa=u.id and idautor=?;";

		$resultado = DB::execute_sql($consulta, array($id_autor));

		if($resultado){
			$resultado->setFetchMode(PDO::FETCH_NAMED);
			return $resultado->fetchAll();
		}else{
			exit("Error de conexión.");
		}
	}

	public static function getPropuestasEmp($id_empresa){
		$consulta = "select p.id idpropuesta, idautor, idempresa, nombre usuario, hora, descripcion, presupuesto, acuerdo from usuarios u, propuestas p where idautor=u.id and idempresa=?;";

		$resultado = DB::execute_sql($consulta, array($id_empresa));

		if($resultado){
			$resultado->setFetchMode(PDO::FETCH_NAMED);
			return $resultado->fetchAll();
		}else{
			exit("Error de conexión.");
		}
	}

	public static function getPropuesta($id_propuesta){
		$consulta = "select p.id idpropuesta, idautor, idempresa, nombre empresa, hora, descripcion, presupuesto, acuerdo from usuarios u, propuestas p where idempresa=u.id and p.id=?;";

		$resultado = DB::execute_sql($consulta, array($id_propuesta));

		if($resultado){
			$resultado->setFetchMode(PDO::FETCH_NAMED);
			return $resultado->fetchAll();
		}else{
			exit("Error de conexión.");
		}
	}

	public static function borrarPropuesta($idpropuesta){
		$sentencia = "delete from propuestas where id=?;";
		DB::execute_sql($sentencia, array($idpropuesta));
	}

	public static function guardarRespuesta($idpropuesta, $idusuario, $mensaje){
		$sentencia = "insert into mensajes (idpropuesta, idusuario, hora, mensaje) values (?, ?, ?, ?);";
		DB::execute_sql($sentencia, array($idpropuesta, $idusuario, time(), $mensaje));
	}

	public static function hayMensajes($idpropuesta){
		$sentencia = "select count(*) from mensajes where idpropuesta=?;";
		$resultado = DB::execute_sql($sentencia, array($idpropuesta));

		if($resultado){
			$resultado->setFetchMode(PDO::FETCH_NUM);
			$dato = $resultado->fetchAll();

			if($dato[0][0] > 0){
				return true;
			}else{
				return false;
			}
		}else{
			exit("Error de conexión");
		}
	}

	public static function getMensajes($idpropuesta){
		$consulta = "select idpropuesta, nombre, hora, mensaje from usuarios u, mensajes where idusuario=u.id and idpropuesta=? order by hora desc;";

		$resultado = DB::execute_sql($consulta, array($idpropuesta));

		if($resultado){
			$resultado->setFetchMode(PDO::FETCH_NAMED);
			return $resultado->fetchAll();
		}else{
			exit("Error de conexión");
		}	
	}

	public static function getPropuestaNombres($idpropuesta){
		$consulta = "select emp.nombre empresa, aut.nombre autor, descripcion from propuestas p, usuarios emp, usuarios aut where p.idautor=aut.id and p.idempresa=emp.id and p.id=?;";

		$resultado = DB::execute_sql($consulta, array($idpropuesta));

		if($resultado){
			$resultado->setFetchMode(PDO::FETCH_NAMED);
			$dato = $resultado->fetchAll();
			return $dato[0];
		}else{
			exit("Error de conexión");
		}
	}

	public static function esPropuestaDe($id_propuesta, $id_usuario){
		$consulta = "select count(*) from propuestas where id = ? and (idautor = ? or idempresa = ?);";

		$resultado = DB::execute_sql($consulta, array($id_propuesta, $id_usuario, $id_usuario));

		if($resultado){
			$resultado->setFetchMode(PDO::FETCH_NUM);
			$dato = $resultado->fetchAll();
			
			if($dato[0][0] == 1){
				return true;
			}
		}

		return false;
	}
	
	public static function getTodas(){
        $consulta = 'SELECT usuarios.id idusuario, obras.id idobra, nombre, titulo, fecha, obras.tipo, imagen FROM obras INNER JOIN usuarios ON usuarios.id=obras.idautor';
        
        $resultado = DB::execute_sql($consulta);
        
        if($resultado){
			$resultado->setFetchMode(PDO::FETCH_NAMED);
			$datos = $resultado->fetchAll();
			
			if(count($datos) > 0){
				return $datos;
			}
		}
		
        return false;
	}
}