<?php

class Usuario {

    private static $columnas = [ "correo", "telefono","celular","password", "username"];
    private static $tabla = "usuario";
    private static $parentId = false;
    protected $atributos = [];
     

   
    protected static function agregarGetCampos($campos){
        return array_intersect($campos, array_flip(static::$columnas));
    }
    protected static function agregar($campos) {
         if(static::$parentId){
             $campos[static::$parentId] = parent::agregar($campos);
         }
          bd::insert(static::$tabla, static::$columnas, static::agregarGetCampos($campos));
          return bd::$conn->lastInsertId();
      
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
    /*
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

    public static function quemarconsulta(){
        $filtro = [
            "precio" => 25];
        $ensayos_objs = SalaEnsayo::instancia($filtro);

        var_dump($ensayos_objs);
    

    }
*/
}

?>
