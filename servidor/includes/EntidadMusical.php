<?php
class EntidadMusical extends Usuario {

    private static  $columnas = ["descripcion", "idUsuario"];
    private static $tabla = "EntidadMusical";
    private static $parentId = "idUsuario";

    private $atributos = [];



    protected function __construct($attr)
       parent::__construct($attr);
    }
    

    public static function agregarEntidadMusical($tipo, $campos)
    {
        $campos["idEntidad_musical"] = $idEntidad_musical;
        if($tipo == "banda")
        {
            $tabla = "banda";
           
            bd::insert($tabla, $columnas, $campos );
            return;
        }
        if($tipo == "musico")
        {
            $campos['idEntidad_musical'] = 
            $inst = Musico::agregar($campos);
            return $inst;
        }
    }
    public function __get($attr) {
        $valor = $this->atributos[$attr];
        return $valor;
    }

    public static function agregarClasificado($campos, $idEntidad_musical)
    {
        Clasificado::agregarClasificado($campos);
        $idClasificado = bd::$conn->lastInsertId();

        $tabla = "clasificado_has_entidad_musical";
        $columnas = ["idEntidad_musical","idClasificado"];
          $array = [
          "idEntidad_musical" => $idEntidad_musical ,
          "idClasificado" => $idClasificado
         ];
        bd::insert($tabla, $columnas, $array );
        return;
    }
}
