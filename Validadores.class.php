<?php
require_once 'NegocioObras.class.php';

class Validadores{
	
	public static function compruebaTamanho($cadena, $min, $max){
		$tamanho = strlen($cadena);
		return ($tamanho >= $min && $tamanho <= $max);
	}

	public static function compruebaCaracteres($cadena){
		$patron = '/^[a-záéíóúñ]+(\s[a-záéíóúñ]+)*[a-záéíóúñ]$/';
		return preg_match($patron, $cadena);
	}

	public static function compruebaFecha($strFecha){
		$fecha = strtotime($strFecha);
		
		if($fecha){ //Navegador que permite html date
			return true;
		}else{ // Si no permite input date, hacer...
		    $fechaNoEuropea = self::pasarFechaNoEuropea($strFecha);
		    if(strtotime($fechaNoEuropea)){
		        return true;
		    }
        }
        return false;
	}
	public static function pasarFechaNoEuropea($strFecha){
        $fechaEuropea = explode("/", $strFecha);
        
        if(count($fechaEuropea) != 3){
            return false;
        }else{
            return $fechaEuropea[1]."/".$fechaEuropea[0]."/".$fechaEuropea[2];
        }
	}

    public static function validaEditObra($datosObraEdit){

        $errores = array();
        if(!self::compruebaTamanho($datosObraEdit['titulo'], 2, 32)){
            $errores[] = "El título debe tener entre 2 y 32 caracteres.";
        }
        
        if(!self::compruebaTamanho($datosObraEdit['tipo'], 5, 16)){
            $errores[] = "El tipo debe tener entre 5 y 16 caracteres.";
        }

        if(!self::compruebaCaracteres($datosObraEdit['tipo'])){
            $errores[] = "El tipo debe estar formado únicamente por caracteres minúsculos y espacios."; 
        }   
        
        if(!self::compruebaFecha($datosObraEdit['fecha'])){
            $errores[] = "La fecha debe tener el formato [d]d/[m]m/aaaa y ser una fecha válida.";
        }
            
        if(!self::compruebaTamanho($datosObraEdit['descripcion'], 12, 1024)){
            $errores[] = "La descripción debe tener entre 12 y 1024 caracteres."; 
        }

        if($errores){
            return $errores;    
        }else{
        	
        	$fechaMilis = 0;
        	if(!$fechaMilis = strtotime($datosObraEdit['fecha'])){
				$fecha = self::pasarFechaNoEuropea($datosObraEdit['fecha']);
				$fechaMilis = strtotime($fecha);
			}
			
			$fechaFormateada = date("j/n/Y", $fechaMilis);
			
            $obra = array(
                $datosObraEdit['titulo'],
                $datosObraEdit['tipo'],
                $fechaFormateada,
                $datosObraEdit['descripcion'],
                $datosObraEdit['id_obra']
            );
            NegocioObras::editObra($obra);
            return false;
        }
    }

    public static function validaAddObra($datosObra, $imagen, $id_autor){
    	$errores = array();

    	if(!self::compruebaTamanho($datosObra['titulo'], 2, 32)){
			$errores[] = "El título debe tener entre 2 y 32 caracteres.";
		}
		
		if(!self::compruebaTamanho($datosObra['tipo'], 5, 16)){
			$errores[] = "El tipo debe tener entre 5 y 16 caracteres.";
		}

		if(!self::compruebaCaracteres($datosObra['tipo'])){
			$errores[] = "El tipo debe estar formado únicamente por caracteres minúsculos y espacios.";	
		}	
		
		if(!self::compruebaFecha($datosObra['fecha'])){
			$errores[] = "La fecha debe tener el formato [d]d/[m]m/aaaa y ser una fecha válida.";
		}
			
		if(!self::compruebaTamanho($datosObra['descripcion'], 12, 1024)){
			$errores[] = "La descripción debe tener entre 12 y 1024 caracteres.";
		}
		
		if(empty($imagen['name'])){
			$errores[] = "No se ha seleccionado una imagen.";
		}

		if($errores){
			return $errores;
		}else{

			$datos_foto = file_get_contents($imagen['tmp_name']);
			
			$fechaMilis = 0;
        	if(!$fechaMilis = strtotime($datosObraEdit['fecha'])){
				$fecha = self::pasarFechaNoEuropea($datosObraEdit['fecha']);
				$fechaMilis = strtotime($fecha);
			}
			
			$fechaFormateada = date("j/n/Y", $fechaMilis);

			$obra = array(
				$id_autor,
				$datosObra['titulo'],
				$datosObra['tipo'],
				$fechaFormateada,
				$datosObra['descripcion'],
				$datos_foto
			);

			NegocioObras::addObra($obra);
			return false;
		}		

    }	

}