<?php
require_once 'NegocioObras.class.php';

class VistaTrabajo{

	public static function mostrarLista($fila, $usuario, $id_obra){
		//titulo, u.id id_usuario, nombre, o.tipo tipo_obra, fecha, descripcion, imagen
		?>
		<section>
			<h2>Trabajo:</h2>
            <div class="elementos-centrados">
                <div class="caja">
                	<dl>
	                    <dt>Nombre del trabajo:</dt><dd><?=$fila['titulo']?></dd>
	                    <dt>Autor:</dt><dd><a href="autor.php?idautor=<?=$fila['id_usuario']?>"><?=$fila['nombre']?></a></dd>
	                    <dt>Tipo de trabajo:</dt><dd><?=ucfirst($fila['tipo_obra'])?></dd>
	                    <dt>Fecha:</dt><dd><?=$fila['fecha']?></dd>
	                    <dt>Descripción:</dt><dd><?=$fila['descripcion']?></dd>
                        <dt>Número de likes:</dt><dd id="likes"><?= NegocioObras::cuentaLikes($id_obra) ?></dd>
	                </dl>
                </div>
                <div class="caja">
                	<dl>
                    	<dt>Imagen:</dt><dd><img class="decorada" id="imagen-trabajo" src="data:image/jpeg;base64,<?=base64_encode($fila['imagen'])?>" alt="<?=$fila['titulo']?>" /></dd>
                    </dl>
                <?php
                if(NegocioObras::puedeVotar($usuario)){
                ?>
                    <button class="boton" id="me-gusta" name="like" onclick="megusta('<?=$id_obra?>');"><?= NegocioObras::yaMeGusta($usuario, $id_obra) ? 'Dejar de gustar':'Me gusta'?></button>
                <?php    
                }
                ?>   
                </div>
            </div>
        </section>   
        <?php
	}
}