<?php
class SalaEnsayo {

    private $atributos = [];

    public static function agregarSala($campos, $idSala_Ensayo){
          $campos["idSala_Ensayo"] = $idSala;
          $tabla = "sala";
          $columnas = [ "precio", "grabacion", "idSala_Ensayo" ] ;
          bd::insert($tabla, $columnas, $campos );
    	  return;
    }

    public static function agregarEquipo($campos, $idSala)
    {
        $tabla = "equipo";
        $columnas = ["descripcion","marca","nombre"];
        bd::insert($tabla,$columnas,$campos);
        $idEquipo = bd::$conn->lastInsertId();
        $tabla = "equipo_has_sala";
        $columnas = ["idEquipo","idSala"];
        $array = [
         "idEquipo" => $idEquipo ,
         "idSala" => $idSala
        ];
        bd::insert($tabla,$columnas,$array);
    }

    public static function agregarHorario ($campos, $idSala)
    {
        $tabla = "horario";
        $columnas = ["hora_inicio", "hora_fin","dia"];
        bd::insert($tabla,$columnas,$campos);
        $idHorario = bd::$conn->lastInsertId();
        $tabla = "sala_has_horario";
        $columnas = ["idSala","idHorario"];
        $array = [
            "idSala" => $idSala,
            "idHorario" => $idHorario
        ];
        bd::insert($tabla,$columnas,$array);
    }
    public static function agregarInstrumento($campos, $idSala_Ensayo, $idInstrumento_tipo)
    {
        $tabla = "instrumento";
        $columnas = ["nombre", "idInstrumento_tipo"];
        $campos["idInstrumento_tipo"] = $idInstrumento_tipo;
        bd::insert($tabla,$columnas,$campos);
    }

    public static function instancia($filtro = null){
        $consulta = "SELECT se.idSala_Ensayo id, se.precio, se.grabacion,
        se.descripcion_grabacion, ec.direccion, ec.nombre, l.nombre
        FROM sala_ensayo se
        JOIN entidad_comercial ec ON se.idEntidad_comercial
        JOIN localidad l ON ec.idLocalidad";

        $valores_filtro = [];

        $where = false;
       if(isset($filtro['texto']) && !empty($filtro['texto'])){
            $where = true;
            $texto =  $filtro['texto'];
            $consulta .= " WHERE ec.nombre LIKE '%{$texto}%' OR l.nombre LIKE '%{$texto}%' ";
        }
        if(isset($filtro['localidad'])){
            if(!$where){
                $consulta .="WHERE ";
                $where = false;
            }else{
                $consulta .= "AND ";
            }
            $consulta .= "l.id IN ( " . implode(", ", $filtro['localidad']) . ") ";
        }
        if(isset($filtro['grabacion'])){
            $where = true;
            $bool = $filtro['grabacion'];
            $consulta .= " WHERE se.grabacion =  $bool ";
        }

        if(isset($filtro['precio'])){
            $where = true;
            $precio = $filtro['precio'];
            $consulta .= " WHERE se.precio <=  $precio ";
        }

        $pdoStatement = Bd::execute($consulta, $valores_filtro);

        $ensayos = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        $ensayos_objs = [];

        foreach($ensayos as $ensayo)
            $ensayos_objs[] = new static($ensayo);

        return $ensayos_objs;


    }

    protected function __construct($atributos){
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

    public function aArreglo(){
        $a = [];
        foreach($this->atributos as $nombre => $valor){
            $a[$nombre] = $this->__get($nombre);
        }

        return $a;
    }
}
