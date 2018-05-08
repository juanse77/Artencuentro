<?php

class VistaBuscar{

    public static function buscador($tipos){
        ?>
        <section>
            <h2>Buscador de obras:</h2>
            
            <form class="elementos-centrados" method="post">
                <fieldset>
                    <legend>Buscador</legend>
                    <div class="fila">
                        <label for="obra">Título de la obra:</label>
                        <input type="text" id="obra" name="obra" tabindex="1" onkeydown="buscaObra()" />
                    </div>
                    <div class="fila">
                        <label for="tipo">Tipo de obra:</label>
                        <select id="tipo" name="tipo" tabindex="2" onchange="buscaObra()">
                            <option selected="selected" value="">Cualquier tipo</option>
        <?php
            foreach ($tipos as $fila) {
                foreach ($fila as $value) {
        ?>
                            <option value="<?=$value?>"><?=ucfirst($value)?></option>
        <?php
                }
            }
        ?>
                        </select>
                    </div>
                    <div class="fila">
                        <input class="boton" type="submit" value="Buscar" id="btn-buscar" tabindex="4" />
                        <input class="boton" type="reset" value="Limpiar" id="btn-limpiar" tabindex="3" />
                    </div>
                </fieldset>
            </form>
        </section>
        <?php
    }

    public static function mostrar_tabla($datos){
        //nombre, idautor, titulo, id_obra, fecha, tipo_obra
        ?>
        <div id="resultado">
        <?php
        if($datos){
        ?>
            <section>
                <h3>Resultado:</h3>
                <div class="trabajos" id="trabajos">
                    <table id="obras">    
                        <tr>
                            <th>Autor</th><th>Nombre del trabajo</th><th>Fecha</th><th>Tipo de trabajo</th>
                        </tr>
        <?php
            foreach($datos as $fila){
        ?> 
                        <tr>
                            <td><a href="autor.php?idautor=<?=$fila["idautor"]?>"><?=$fila["nombre"]?></a></td>
                            <td><a href="trabajo.php?id_obra=<?=$fila["id_obra"]?>"><?=$fila["titulo"]?></a></td>
                            <td><?=$fila["fecha"]?></td>
                            <td><?=ucfirst($fila["tipo_obra"])?></td>
                        </tr>
        <?php
            }
        ?>
                    </table>
                </div>
            </section>
        <?php
        }
        ?>
        </div>
        <?php
    }
}