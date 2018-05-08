<?php
require_once 'presentation.class.php';
require_once 'VistaPortada.class.php';

View::start('Artencuentro', array("estilos.css"));
View::navegacion();
VistaPortada::portada();    
View::end();