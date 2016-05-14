<?php
class Util {
    
    public static function arrayToStdClass($array){
        $retorno = new stdClass();
        foreach($array as $index => $dato)
            $retorno->$index = $dato;
        return $retorno;
    }
    
    public static function config($attr){
        return isset($GLOBALS["config"][$attr]) ? $GLOBALS["config"][$attr] : NULL;
    }
    
    public static function getLocalidad(){
        return static::arrayToStdClass(Bd::selectAll("localidad")->fetchAll(PDO::FETCH_OBJ));
    }
    
    public static function getGeneroMusical(){
        return static::arrayToStdClass(Bd::selectAll("genero_musical")->fetchAll(PDO::FETCH_OBJ));
    }
    
    public static function getEventoTipo(){
        return static::arrayToStdClass(Bd::selectAll("evento_tipo")->fetchAll(PDO::FETCH_OBJ));
    }
    
    public static function getCategoriaClasificado(){
        return static::arrayToStdClass(Bd::selectAll("clasificado_categoria")->fetchAll(PDO::FETCH_OBJ));
    }
    
    public static function getInstrumento(){
        return static::arrayToStdClass(Bd::selectAll("instrumento")->fetchAll(PDO::FETCH_OBJ));
    }
}