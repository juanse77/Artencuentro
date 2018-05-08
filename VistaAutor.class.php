<?php
require_once 'NegocioObras.class.php';
require_once 'presentation.class.php';
require_once 'Validadores.class.php';

class VistaAutor{

	public static function getNombreAutor($datos){
        return $datos[0]['nombre'];
    }

	public static function mostrarTabla($datos, $cabecera){
        //id, titulo, fecha, tipo
		?>
        <section>
            <h2><?=$cabecera?></h2>
            <div class=trabajos id="trabajos">
                <table>    
                    <tr>
                        <th>Nombre del trabajo</th>
                        <th>Fecha</th>
                        <th>Tipo de trabajo</th>
                    </tr>
        <?php
        foreach($datos as $fila){    
        ?> 
                    <tr>
                        <td><a href="trabajo.php?id_obra=<?=$fila["id"]?>"><?=$fila["titulo"]?></a></td>
                        <td><?=$fila["fecha"]?></td>
                        <td><?=ucfirst($fila["tipo"])?></td>
                    </tr>
        <?php
        }
        ?>
                </table>
            </div>
        </section>
        <?php
	}

    public static function mostrarTablaEdit($datos, $cabecera){
        //id, titulo, fecha, tipo
        ?>
        <section>
            <h2><?=$cabecera?></h2>
        <?php
        if($datos){
        ?>
            <div class="trabajos" id="trabajos">
                <input type="hidden" id="num_obras" value="<?=count($datos)?>" />
                <table>    
                    <tr>
                        <th>Nombre del trabajo</th>
                        <th>Fecha</th>
                        <th>Tipo de trabajo</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
        <?php
            foreach($datos as $fila){    
        ?> 
                    <tr id="obra_<?=$fila['id']?>">
                        <td><a href="trabajo.php?id_obra=<?=$fila["id"]?>"><?=$fila["titulo"]?></a></td>
                        <td><?=$fila["fecha"]?></td>
                        <td><?=ucfirst($fila["tipo"])?></td>
                        <td><a href="editar_trabajo.php?id_obra=<?=$fila["id"]?>"><img class="pequenha" src="iconos/photo_edit.png" alt="Editar trabajo"></a></td>
                        <td><a href="javascript:void(0);" onclick="borrar_trabajo(<?=$fila["id"]?>, '<?=$fila['titulo']?>')"><img class="pequenha" src="iconos/photo_trash.png" alt="Eliminar trabajo"></a></td>
                    </tr>
        <?php
            }
        ?>
                </table>
            </div>
            
        <?php
        } else {
        ?> 
            <h3>Todavía no ha subido ninguna obra.</h3>
        <?php
        } 
        ?>
            <div>
                <a href="anhadir_trabajo.php">+ Añadir nueva obra</a>
            </div>
        </section>
        <?php
    }

    public static function formNuevaObra($cabecera){
        ?>
        <section>
            <h2><?=$cabecera?></h2>
            
            <form class="elementos-centrados" enctype="multipart/form-data" method="post" onsubmit="return validaNuevaObra();">
                <fieldset>
                    <legend>Nueva obra</legend>
                    <div class="fila">
                        <label for="titulo">Título de la obra:</label>
                        <input type="text" id="titulo" name="titulo" />
                        <div class="error-val" id="error-titulo"></div>
                    </div>
                    <div class="fila">
                        <label for="tipo">Tipo de obra:</label>
                        <input type="text" id="tipo" name="tipo" />
                        <div class="error-val" id="error-tipo"></div>
                    </div>
                    <div class="fila">
                        <label for="fecha">Fecha:</label>
                        <input type="date" min="1900-01-01" max="2099-12-31" id="fecha" name="fecha" />
                        <div class="error-val" id="error-fecha"></div>
                    </div>
                    <div class="fila">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" placeholder="Describa la naturaleza del proyecto"></textarea>
                        <div class="error-val" id="error-descripcion"></div>
                    </div>
                    <div class="fila">
                        <label for="imagen">Imagen:</label>
                        <input class="boton" type="file" id="imagen" name="imagen" />
                        <div class="error-val" id="error-imagen"></div>
                    </div>
                    <div class="fila">
                        <input class="boton" type="submit" name="nueva-obra" value="Añadir" id="btn-add" />
                        <input class="boton" type="reset" value="Limpiar" id="btn-limpiar" />
                    </div>
                </fieldset>
            </form>
        </section>
        <?php
    }

    public static function formEditObra($cabecera, $obra){
        ?>
        <section>
            <h2><?=$cabecera?></h2>
            
            <form class="elementos-centrados" id="form_obra" method="post" action="<?=$_SERVER['PHP_SELF']?>?id_obra=<?=$obra['id']?>" onsubmit="return validaCampos();">
                <fieldset>
                    <legend>Edición obra</legend>
                    <input type="hidden" name="id_obra" value="<?=$obra['id']?>" />
                    <div class="fila">
                        <label for="titulo">Título de la obra:</label>
                        <input type="text" id="titulo" name="titulo" value="<?=$obra['titulo']?>" />
                        <div class="error-val" id="error-titulo"></div>
                    </div>
                    <div class="fila">
                        <label for="tipo">Tipo de obra:</label>
                        <input type="text" id="tipo" name="tipo" value="<?=$obra['tipo']?>" />
                        <div class="error-val" id="error-tipo"></div>
                    </div>
                    <div class="fila">
                        <label for="fecha">Fecha:</label>
                        <input type="date" min="1900-01-01" max="2099-12-31" id="fecha" name="fecha" value="<?php
                            $auxFecha = explode("/", $obra['fecha']);
                            $fechaAmericana = $auxFecha[2]."-".$auxFecha[1]."-".$auxFecha[0];
                            $auxFecha2 = strtotime($fechaAmericana);
                            echo date("Y-m-d", $auxFecha2);
                        ?>" />
                        <div class="error-val" id="error-fecha"></div>
                    </div>
                    <div class="fila">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion"><?=$obra['descripcion']?></textarea>
                        <div class="error-val" id="error-descripcion"></div>
                    </div>
                    <div class="fila">
                        Imagen:
                        <img class="decorada" id="imagen-trabajo-pequenha" src="data:image/jpeg;base64,<?=base64_encode($obra['imagen'])?>" alt="<?=$obra['titulo']?>" />
                    </div>
                    <div class="fila">
                        <input class="boton" type="submit" name="edit-obra" value="Modificar" id="btn-modificar" />
                        <input class="boton" type="reset" value="Limpiar" id="btn-limpiar" />
                    </div>
                </fieldset>
            </form>
        </section>
        <?php    
    }

    public static function mostrarPropuestas($cabecera, $datos, $datosUsuario, $estilo=""){
        //idpropuesta, idautor, idempresa, (empresa o autor) usuario, hora, descripcion, presupuesto, acuerdo    
        foreach ($datos as $fila) {
            $fecha = date("j/n/Y", $fila['hora']);
        ?>
        <section <?=$estilo?>>
            <h3><?=$cabecera?></h3>
            <div class="trabajos">
                <table>    
                    <tr>
                        <th><?= ($datosUsuario['tipo'] == 2) ? "Empresa": "Autor"?></th>
                        <th>Fecha</th>
                        <th>Presupuesto</th>
                        <th>Acuerdo</th>
                        <?= ($datosUsuario['tipo'] == 2) ? "<th>Responder</th>" : ""?>
                    </tr>
                    <tr>
                        <td class="ancho"><?=$fila['usuario']?></td>
                        <td><?=$fecha?></td>
                        <td><?=$fila['presupuesto']?> &euro;</td>
                        <td><?=$fila['acuerdo'] ? "Sí" : "No" ?></td>
        <?php
            if($datosUsuario['tipo'] == 2){
        ?>
                        <td><a href="visorMensajes.php?idpropuesta=<?=$fila['idpropuesta']?>"><img class="pequenha" src="iconos/email_forward.png" alt="responder" /></a></td>
        <?php
            }
        ?>
                    </tr>
                    <tr>
                        <td colspan="<?= ($datosUsuario['tipo'] == 2) ? '5' : '4' ?>"><span style="font-weight: bold">Descripción:</span> <?=$fila['descripcion']?></td>
                    </tr>
                </table>
            </div>
        <?php
            if(NegocioObras::hayMensajes($fila['idpropuesta'])){
        ?>
            <div>
                <a href="visorMensajes.php?idpropuesta=<?=$fila['idpropuesta']?>">Ver mensajes</a>
            </div>
        <?php
            }else{
        ?>
            <div style="color: blue">
                No hay mensajes
            </div>
        <?php    
            }
        ?>
        </section>
        <?php
        }
    }

    public static function formPropuesta($cabecera, $idpropuesta, $error){
        ?>
        <h4><?=$cabecera?></h4>
            
        <form method="post" action="respuesta.php?id_propuesta=<?=$idpropuesta?>">
            <div class="fila">
                <label for="respuesta"><span class="resaltado">Mensaje:</span></label>
            </div>
            <div class="fila">
                <textarea id="respuesta" name="respuesta" placeholder="Escriba aquí el mensaje"></textarea>
            </div>
            <div class="fila">
                <input type="submit" class="boton" name="enviar_respuesta" value="Enviar" />
                <input type="reset" class="boton" id="btn-limpiar" name="limpiar" value="Limpiar" />
            </div>
            <div class="fila"><?= ($error != "") ? View::error($error) : "" ?></div>
        </form>
    <?php
    }

    public static function mostrarMensajes($propuesta, $mensajes, $idpropuesta, $error){
        //propuesta: empresa, autor, descripcion
        //mensajes: idpropuesta, nombre, hora, mensaje
        ?>
        <section>  
            <h2>Propuesta de la empresa <?=$propuesta['empresa']?> al autor <?=$propuesta['autor']?>.</h2>

            <h3>Descripción de la propuesta:</h3>
            <p id="descripcion">"<?=$propuesta['descripcion']?>"</p>
        </section>
        <section>
            <div class="elementos-centrados">
                <div class="mensajes">
                    <div class="mensaje">
        <?php 
        self::formPropuesta("Responder:", $idpropuesta, $error);
        ?>
                    </div>
        <?php
        if(count($mensajes) > 0){
            foreach ($mensajes as $mensaje) {
                $fecha = date("j/n/Y", $mensaje['hora']);
        ?>
                    <div class="mensaje">    
                        <div class="fila"><span class="resaltado">De: </span><?=$mensaje['nombre']?></div>
                        <div class="fila"><span class="resaltado">Mensaje:</span></div>
                        <div class="cuerpo"><?=nl2br($mensaje['mensaje'])?></div>
                        <div class="fecha"><span class="resaltado">Fecha: </span><?=$fecha?></div>
                    </div>
        <?php
            }
        ?>
                </div>
            </div>
        <?php
        }
        ?>
        </section>   
        <?php        
    }

}