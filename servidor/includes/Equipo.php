<?php
class Equipo{
   private $atributos = [];
   private static $tabla = "Equipo";

   public static function instancia($filtros = null){
       $pdoStatement = bd::selectAll(static::$tabla, $filtros);

        $equipos = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        $equipos_objs = [];

        foreach($equipos as $equipo)
            $equipos_objs[] = new static($equipo);

        return $equipos_objs;
   }

   public static function agregar($campos){
   	   $column = [ "descripcion", "marca", "nombre"];
           bd::insert(static::$tabla, $column, $campos);
           return static::instancia(["idEquipo" => bd::$conn->lastInsertId()]);
   }

}