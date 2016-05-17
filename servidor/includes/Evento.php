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
        $consulta = "SELECT e.id, e.nombre, e.descripcion, l.nombre localidad, e.usuario_id, u.nombre usuario, et.nombre evento_tipo, e.precio, e.fecha,
                     gm.nombre genero_musical, e.imagen
                     FROM evento e
                     JOIN localidad l ON e.localidad_id = l.id
                     JOIN evento_tipo et ON e.evento_tipo_id = et.id
                     JOIN evento_genero_musical egm ON e.id = egm.evento_id
                     JOIN genero_musical gm ON egm.genero_musical_id = gm.id
                     JOIN (
                         SELECT id, CONCAT(IFNULL(b.nombre,''), IFNULL(se.nombre,'')) nombre
                             FROM usuario u
                             LEFT JOIN bar b ON u.id = b.usuario_id
                             LEFT JOIN sala_ensayo se ON u.id = se.usuario_id
                             WHERE b.nombre IS NOT NULL OR se.nombre IS NOT NULL
                     )u ON e.usuario_id = u.id ";

        $valores_filtro = [];

        $where = false;

        if(isset($filtro['texto']) && !empty($filtro['texto'])){
            $where = true;
            $texto = $filtro['texto'];

            $consulta .= "WHERE e.nombre LIKE '%{$texto}%' OR e.descripcion LIKE '%{$texto}%'
                          OR l.nombre LIKE '%{$texto}%' OR u.nombre LIKE '%{$texto}%'
                          OR et.nombre LIKE '%{$texto}%' OR gm.nombre LIKE '%{$texto}%'";

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
        if(isset($filtro['generoMusical'])){
            if(!$where){
                $consulta .="WHERE ";
                $where = false;
            }else{
                $consulta .= "AND ";
            }
            $consulta .= "gm.id IN ( " . implode(", ", $filtro['generoMusical']) . ") ";
        }if(isset($filtro['eventoTipo'])){
            if(!$where){
                $consulta .="WHERE ";
                $where = false;
            }else{
                $consulta .= "AND ";
            }
            $consulta .= "et.id IN ( " . implode(", ", $filtro['eventoTipo']) . ") ";
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
