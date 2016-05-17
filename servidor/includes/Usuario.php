<?php

class Usuario {

    private $atributos = [];


    public function __construct($atributos ){
        foreach($atributos as $nombre => $valor){
            $this->atributos[$nombre] = $valor;
        }
    }

    public function __get($attr) {
        $valor = $this->atributos[$attr];
        if($attr == 'imagen'){
            $valor = Util::config("base_img_usuario") . $valor;
        }
        return $valor;
    }

    public static function agregarUsuario($camposU, $camposE, $camposEs,  $tipoEntidad, $tipoEspecifico, $idGenero_musical=NULL,$idInstrumento=NULL, $nivel=NULL) {
      $usuario = "usuario";
      $columnas = [ "correo", "telefono","celular","password", "username"];
      Bd::insert($usuario, $columnas, $camposU);
      $idUsuario = bd::$conn->lastInsertId();
      $camposE["idUsuario"] = $idUsuario;

      if($tipoEntidad == "comercial"){
          $tabla = "entidad_comercial";
          $columnas = [ "direccion", "idLocalidad", "nombre", "idUsuario" ] ;
          bd::insert($tabla, $columnas, $camposE );
          $idComercial = bd::$conn->lastInsertId();
          EntidadComercial::agregarEntidadComercial($tipoEspecifico, $camposEs, $idComercial);
          if($idGenero_musical)
          {
             $tabla = "entidad_comercial_has_genero_musical";
             $columnas = ["idEntidad_comercial","idGenero_musical"];
             $array = [
              "idEntidad_comercial" => $idComercial ,
              "idGenero_musical" => $idGenero_musical
             ];
            bd::insert($tabla, $columnas,$array);
          }

      }
      if($tipoEntidad == "musical"){
        $tabla = "entidad_musical";
        $columnas = [ "descripcion", "idUsuario" ] ;
        bd::insert($tabla, $columnas, $camposE);

        $idMusical = bd::$conn->lastInsertId();
        $tabla = "entidad_musical_has_genero_musical";
        $columnas = ["idEntidad_musical","idGenero_musical"];
        $array = [
          "idEntidad_musical" => $idMusical ,
          "idGenero_musical" => $idGenero_musical
         ];
        bd::insert($tabla, $columnas,$array);
        echo "id de la entidad musical creado " . $idMusical;
        EntidadMusical::agregarEntidadMusical($tipoEspecifico, $camposEs, $idMusical,$idInstrumento, $nivel);
      }




    }
    public static function eliminarUsuario($campos){
      $usuario = "usuario";
      $columnas = [ "idUsuario"];
      bd::delete($usuario, $columnas, $campos );
    }
    public static function editarUsuario($campos, $id){
      $usuario = "usuario";
      bd::update($usuario, $campos, $id);


    }
    public static function quemarInsertar(){

        $camposU = [

          "correo" => "casdsa@javeriana.edu.co",
          "telefono" => "82131",
          "celular" => "23123",
          "password" => "sadjsaijd",
          "username" => "jimevargas532"
         ];

        $usuario = "usuario";
        //self::quemarLocalidad();
        //$idLocalidad = bd::$conn->lastInsertId();
        $camposE =
        ["descripcion" => "asdasda"];
        $camposEs = [
        "nombre" => "Jimena",
          "genero" => "1995",
          "apellido" => "vargas",
          "fecha_nacimiento" => "01/02/2016",
          "anios_exp" => "7",
          "influencias" => "Tony melendez"
        ];

        self::agregarUsuario($camposU, $camposE, $camposEs, "musical", "musico","1","1","Experto");
    }

    public static function quemarLocalidad(){
      $array = [
          "nombre" => "pepitoAntonio",
         ];
      $columnas = [ "nombre"];
      $tabla = "localidad";
      bd::insert($tabla, $columnas, $array);
    }
   public static function quemarEvento(){
      $array = [
          "nombre" => "Rock al parque",
          "descripcion" => "es un concierto",
          "precio" => "$50.000",
          "fecha" => "01 may",
          "imagen" => "iqdiasj",
          "idLocalidad" => "22",
          "genero_musical" => "Rock",
          "idEntidad_comercial" => "7",
         ];

      Evento::agregarEvento( $array);
    }
    public static function quemarClasificado(){

        $array = [
          "titulo" => "busciomusico",
          "categoria" => "cancion",
          "descripcion" => "necsitpersonas",
          "instrumento" => "rita",
          "nivel" => "experto",
         ];
       EntidadMusical::agregarClasificado($array,"7");
    }
    public static function quemarBorrar(){

        $array = [
          "correo" => "casdsa@javeriana.edu.co",
          "telefono" => "82131",
          "celular" => "23123",
          "password" => "sadjsaijd"
         ];

        $usuario = "usuario";
        bd::delete($usuario, $array);
    }

}

?>
