<?php
class Instrumento{
	 private static $tabla = "Instrumento";
     private $atributos = [];
     
     public static function instancia($filtros = null){
         
     }


     public static function agregar($campos){
     	   $column = [ "idInstrumento", "nombre", "idInstrumento_tipo"];
           bd::insert(static::$tabla, $column, $campos);
           return static::instancia(["idInstrumento" => bd::$conn->lastInsertId()]);

     }

}
?>