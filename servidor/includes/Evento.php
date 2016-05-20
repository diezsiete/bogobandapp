<?php
class Evento {
    private $atributos = [];
    private $generoMusical = [];

    public static function agregarEvento( $campos)
    {
        $tabla = "evento";
        $columnas = ["nombre","descripcion", "precio","fecha","imagen", "idLocalidad","genero_musical","idEntidad_comercial"];

        bd::insert($tabla, $columnas, $campos );
        return ;
    }

    public static function instancia($filtro = null){
        $consulta = "SELECT e.id, e.nombre, e.descripcion, e.precio, e.fecha, e.imagen, e.idLocalidad, e.idEntidad_comercial, g.nombre as genero, l.nombre as localidad, ec.nombre as entidad_comercial 
            FROM evento e
            JOIN localidad l ON e.idLocalidad
            JOIN entidad_comercial ec ON e.idEntidad_comercial = ec.idEntidad_comercial
            JOIN evento_has_genero eg ON e.idEvento = eg.eveto_idEvento
            JOIN genero g ON eg.genero_idgenero = g.idGenero ";

        $valores_filtro = [];

        $where = false;
        if(isset($filtro['texto']) && !empty($filtro['texto'])){
            $where = true;
            $texto = $filtro['texto'];

            $consulta .= "WHERE e.nombre LIKE '%{$texto}%' OR e.descripcion LIKE '%{$texto}%'
                          OR l.nombre LIKE '%{$texto}%' OR ec.nombre LIKE '%{$texto}%' OR g.nombre LIKE '%{$texto}%'";

        }

        if(isset($filtro['localidad'])){
            if(!$where){
                $consulta .="WHERE ";
                $where = false;
            }else{
                $consulta .= "AND ";
            }
            $consulta .= "l.idLocalidad IN ( " . implode(", ", $filtro['localidad']) . ") ";
        }
        if(isset($filtro['generoMusical'])){
            if(!$where){
                $consulta .="WHERE ";
                $where = false;
            }else{
                $consulta .= "AND ";
            }
            $consulta .= "g.idGenero IN ( " . implode(", ", $filtro['generoMusical']) . ") ";
        }if(isset($filtro['fecha'])){
            if(!$where){
                $consulta .="WHERE ";
                $where = false;
            }else{
                $consulta .= "AND ";
            }
            $consulta .= "e.fecha IN ( " . implode(", ", $filtro['fecha']) . ") ";
        }

        $pdoStatement = Bd::execute($consulta, $valores_filtro);

        $eventos = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        $genero_musical = [];
        $eventos_objs = [];
        foreach($eventos as $indice => $evento){
            $genero_musical[] = $evento['genero_musical'];
            if(isset($eventos[$indice+1]) && $eventos[$indice+1]['id'] == $evento['id'])
                continue;

            $eventos_objs[] = new static($evento, $genero_musical);
            $genero_musical = [];
        }

        return $eventos_objs;
    }

    protected function __construct($atributos, $genero_musical){
        foreach($atributos as $nombre => $valor){
            $this->atributos[$nombre] = $valor;
        }
        $this->generoMusical = $genero_musical;
    }

    public function __get($attr) {
        $valor = $this->atributos[$attr];
        if($attr == 'imagen'){
            $valor = Util::config("base_img_evento") . $valor;
        }

        return $valor;
    }

    public function aArreglo(){
        $a = [];
        foreach($this->atributos as $nombre => $valor){
            $a[$nombre] = $this->__get($nombre);
        }
        $a['genero_musical'] = $this->generoMusical;
        return $a;
    }
}
