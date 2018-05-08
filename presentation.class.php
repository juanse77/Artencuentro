<?php
require_once 'business.class.php';
require_once 'conf.php';

class View{
    public static function start($title, $estilos){
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="iconos/favicon.png" />
		<link href="https://fonts.googleapis.com/css?family=Tajawal:300,400,700,800" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    foreach ($estilos as $estilo) {
        ?>
        <link rel="stylesheet" type="text/css" href="<?=$estilo?>" />
        <?php
    }
    ?>
        <script src="jquery-3.3.1.js"></script>
        <script src="scripts.js"></script>
        <title><?=$title?></title>
    </head>
    <body>
        <header>
            <h1>Artencuentro</h1>
            <p>Sitio web dedicado a la intermediación de profesionales dedicados a las artes gráficas.</p>
        </header>
    <?php
    }

    public static function error($msg_error){
        ?>
        <div class="error">
            <h3><?=$msg_error?></h3>
        </div>
        <?php
    }

    public static function printCabecera($cabecera, $estilo=""){
        ?>
        <section <?=$estilo?>>
            <h2><?=$cabecera?></h2>
        </section>
        <?php
    }

    public static function navegacion(){
        global $roles;
        ?>
        <nav>
            <?php
            if($datosUsuario = User::getLoggedUser()){
            ?>
                <a href="logout.php">Logout</a>
                <a href="home<?=$roles[$datosUsuario['tipo']]?>.php">Home</a>
            <?php
            }else{
            ?>
                <a href="login.php">Login</a>
            <?php
            }
            ?>
            <a href="buscar.php">Buscar obras</a>
            <a href="tabla.php">Ver obras</a>
            <a href="index.php">Pág. Inicio</a>
        </nav>
        <?php
    }
    
    public static function end(){
        ?>
        <footer>
            <a href="tabla.php">Obras</a>
            <a href="contacto/contacto.html">Contacte con nosotros</a>
            <span id="trademark">Arteencuentro<sup>&reg;</sup>: Todos los derechos reservados</span>
        </footer>
    </body>
</html>
        <?php
    }
}
