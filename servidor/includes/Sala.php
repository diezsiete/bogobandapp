<?php
class Sala{
  private $atributos = [];
  private static $tabla = "sala";

 public static function instancia($campos){

 }
 public static function agregar($campos){
     $column = [ "precio", "idSala_ensayo"];
     bd::insert(static::$tabla, $column, $campos);
     return static::instancia(["idSala" => bd::$conn->lastInsertId()]);
 }
 public function __get($attr) {
        $valor = $this->atributos[$attr];
        if($attr == 'imagen'){
            $valor = Util::config("base_img_sala_ensayo") . $valor;
        }

        return $valor;
    }
public function getEquipos($id = null){
       if(!$id){
       	   $IdsEquipos = bd::select("equipo_has_sala", ["idEquipo"], ['idSala' => $this->__get('idSala')])
       	   				 ->fetchAll(PDO::FETCH_COLUMN);
           return !empty($idsEquipos) ? Equipo::instancia(['idEquipo' => $idsEquipos]) : [];
       }
    }

}