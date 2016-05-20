<?php
class Musico extends EntidadMusical {
   

   private static $tabla = "musico";
   private static $parentId = "idEntidad_musical";
   private static $columnas = ["nombre", "apellido", "fecha_nacimiento", "anios_exp", "idEntidad_musical", "influencias" ];
   private $atributos = [];
   public static function instancia($filtros = null){
     $pdoStatement = bd::selectAll(static::$tabla, $filtros);
     $musicos = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
     $musicos_objs = [];

        foreach($musicos as $musico)
            $musicos_objs[] = new static($musico);

        return $musicos_objs;
   }
   
   public function __construct($atributos){
        foreach($atributos as $nombre => $valor)
            $this->atributos[$nombre] = $valor;
    }

    public function __get($attr) {
        $valor = $this->atributos[$attr];
        if($attr == 'imagen'){
            $valor = Util::config("base_img_sala_ensayo") . $valor;
        }

        return $valor;
    }
 

} 
