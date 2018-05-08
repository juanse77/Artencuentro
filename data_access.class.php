<?php
require_once 'presentation.class.php';

class DB{
    private static $connection=null;
    
    private static function get(){
        if(self::$connection === null){
            self::$connection = $db = new PDO('sqlite:'.__DIR__.'/datos.db');
            self::$connection->exec('PRAGMA foreign_keys = ON;');
            self::$connection->exec('PRAGMA encoding="UTF-8";');
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }

    public static function execute_sql($sql,$parms=null){
        try {
            $db = self::get();
            $ints= $db->prepare($sql);
            if ($ints->execute($parms)) {
                return $ints;
            }
        
        } catch (PDOException $e) {
            View::error($e->getMessage());
        }
        return false;
    }

    public static function user_exists($usuario,$pass, &$datosUsuario){
        $db = self::get();
        $inst=$db->prepare('SELECT * FROM usuarios WHERE cuenta=? and clave=?');
        $inst->execute(array($usuario,md5($pass)));
        $inst->setFetchMode(PDO::FETCH_NAMED);
        $res=$inst->fetchAll();
        if(count($res) == 1){
            $datosUsuario = $res[0];
            return true;
        }else{
            return false;
        }        
    }
}
