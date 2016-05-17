<?php
class EntidadMusical{

    private $atributos = [];

    protected function __construct($atributosUsuario, $atributosEntidad ){
        //parent::__construct($atributosUsuario);
        foreach($atributosMusical as $nombre => $valor){
            $this->atributosMusical[$nombre] = $valor;
        }

    }
    public static function agregarEntidadMusical($tipo, $campos, $idEntidad_musical, $idInstrumento, $nivel )
    {
        $campos["idEntidad_musical"] = $idEntidad_musical;
        if($tipo == "banda")
        {
            $tabla = "banda";
            $columnas = ["nombre","anio", "idEntidad_musical"];
            bd::insert($tabla, $columnas, $campos );
            return;
        }
        if($tipo == "musico")
        {
            $tabla = "musico";
            $columnas  = ["nombre","genero","apellido","fecha_nacimiento","anios_exp","influencias", "idEntidad_musical"];
            bd::insert($tabla, $columnas, $campos );
            $idMusico = bd::$conn->lastInsertId();
           if($idInstrumento)
            {
                $tabla = "musico_has_instrumento";
                $columnas = ["idMusico","idInstrumento","nivel"];
                $array = [
                "idMusico" => $idMusico ,
                "idInstrumento" => $idInstrumento,
                "nivel" => $nivel
             ];
            bd::insert($tabla, $columnas,$array);
            }
            return ;
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
