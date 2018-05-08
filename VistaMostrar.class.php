<?php

class VistaMostrar{
    public static function tabla($res){
        // idusuario, idobra, nombre, titulo, fecha, tipo, imagen
        if($res){
            ?>
        <section>
            <h2>Listado de obras:</h2>
            
            <div class=trabajos id="trabajos">
                <table id="tabla">
                    
                    <tr>
                        <th>Autor</th>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Obra</th>
                    </tr>
                    
                <?php
                foreach($res as $obra){
                ?>    
                    <tr>
                        <td><a href="autor.php?idautor=<?=$obra['idusuario']?>"><?=$obra['nombre']?></a></td>
                        <td><a href="trabajo.php?id_obra=<?=$obra['idobra']?>"><?=$obra['titulo']?></a></td>
                        <td><?=$obra['fecha']?></td>
                        <td><?=$obra['tipo']?></td>
                        <td><img class="decorada" id="imagen-trabajo" src="data:image/jpeg;base64,<?=base64_encode($obra['imagen'])?>" alt="<?= $obra['titulo'] ?>"></td>
                    </tr>
                <?php
                }
                ?>
                </table>
            </div>
        </section>
        <?php
        }
    }
}