<?php
require_once 'business.class.php';
require_once 'NegocioObras.class.php';
require_once 'Validadores.class.php';

if(isset($_POST['enviar_respuesta']) && ($datosUsuario = User::getLoggedUser()) && isset($_GET['id_propuesta']) && NegocioObras::esPropuestaDe($_GET['id_propuesta'], $datosUsuario['id'])){

	if(!Validadores::compruebaTamanho($_POST['respuesta'], 1, 256)){
		header('Location: visorMensajes.php?error=1&idpropuesta='.$_GET['id_propuesta']);
		exit();
	}

    NegocioObras::guardarRespuesta($_GET['id_propuesta'], $datosUsuario['id'], $_POST['respuesta']);
    header('Location: visorMensajes.php?idpropuesta='.$_GET['id_propuesta']);

}else{
	header('Location: login.php');
}