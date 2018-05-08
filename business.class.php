<?php
include_once 'data_access.class.php';

class User{
    
    public static function session_start(){
        if(session_status () === PHP_SESSION_NONE){
            session_start();
        }
    }

    public static function getLoggedUser(){
        self::session_start();
        if(!isset($_SESSION['user'])) return false;
        return $_SESSION['user'];
    }
    
    public static function login($usuario,$pass){
        self::session_start();
        if(DB::user_exists($usuario, $pass, $datosUsuario)){
            $_SESSION['user'] = $datosUsuario;
            return true;
        }
        return false;
    }
    
    public static function logout(){
        self::session_start();
        unset($_SESSION['user']);
    }
}
