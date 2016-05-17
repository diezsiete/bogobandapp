<?php
class Bar {

    private $atributos = [];
    private $generoMusical = [];

    public static function instancia($filtro = null){
        $consulta = "SELECT b.usuario_id id, b.nombre, l.nombre localidad, b.precios, b.imagen, gm.nombre genero_musical
                     FROM bar b
                     JOIN localidad l ON b.localidad_id = l.id
                     JOIN bar_genero_musical bgm ON b.usuario_id = bgm.bar_id
                     JOIN genero_musical gm ON bgm.genero_musical_id = gm.id ";

        $valores_filtro = [];
        $where = false;
        if(isset($filtro['texto']) && !empty($filtro['texto'])){
            $where = true;
            $texto =  $filtro['texto'];
            $consulta .= "WHERE b.nombre LIKE '%{$texto}%' OR l.nombre LIKE '%{$texto}%'
                          OR gm.nombre LIKE '%{$texto}%'";

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
        }


        $pdoStatement = Bd::execute($consulta, $valores_filtro);

        $bares = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        $genero_musical = [];
        $bares_objs = [];
        foreach($bares as $indice => $bar){
            $genero_musical[] = $bar['genero_musical'];
            if(isset($bares[$indice+1]) && $bares[$indice+1]['id'] == $bar['id'])
                continue;
            $bares_objs[] = new static($bar, $genero_musical);
            $genero_musical = [];
        }
        return $bares_objs;
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
            $valor = Util::config("base_img_bar") . $valor;
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
    public static function agregarEntidadComercial($campos){

    }


}
