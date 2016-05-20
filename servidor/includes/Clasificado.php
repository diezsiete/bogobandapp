<?php
class Clasificado {

    private $atributos = [];
    private $generoMusical = [];

    public static function agregarClasificado( $campos )
    {
        $tabla = "clasificado";
        $columnas = ["titulo","categoria", "descripcion","instrumento","nivel"];
        bd::insert($tabla, $columnas, $campos );

        return ;
    }
public static function instancia2($filtro = null){
        $consulta = "SELECT c.idClasificado, c.titulo, c.categoria, c.descripcion, c.instrumento, c.nivel,
                     u.nombre
                            
                     FROM clasificado c
                    
                     JOIN (
                        SELECT cg.clasificado_idClasificado as idClasificado, g.nombre
                        FROM genero g
                        JOIN clasificado_has_genero cg ON g.idGenero = cg.genero_idGenero
                     )u ON c.idClasificado = u.idClasificado ";
        $valores_filtro = [];
/*
        $where = false;
        if(isset($filtro['texto']) && !empty($filtro['texto'])){
            $where = true;
            $texto =  $filtro['texto'];
            $consulta .= "WHERE c.categoria LIKE '%{$texto}%' OR c.titulo LIKE '%{$texto}%'
                          OR c.descripcion LIKE '%{$texto}%' OR i.nombre LIKE '%{$texto}%'
                          OR u.nombre LIKE '%{$texto}%' OR gm.nombre LIKE '%{$texto}%'";
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
        if(isset($filtro['categoriaClasificado'])){
            if(!$where){
                $consulta .="WHERE ";
                $where = false;
            }else{
                $consulta .= "AND ";
            }
            $consulta .= "cc.id IN ('".implode("', '", $filtro['categoriaClasificado'])."') ";
        }
        if(isset($filtro['instrumento'])){
            if(!$where){
                $consulta .="WHERE ";
                $where = false;
            }else{
                $consulta .= "AND ";
            }
            $consulta .= "i.id IN ('".implode("', '", $filtro['instrumento'])."') ";*/
        }
    public static function instancia($filtro = null){
        $consulta = "SELECT c.id, cc.nombre categoria, c.titulo, c.descripcion, i.nombre as instrumento,
                            inv.nombre as instrumento_nivel, u.nombre usuario, gm.nombre as genero_musical
                     FROM clasificado c
                     LEFT JOIN instrumento i ON c.instrumento_id = i.id
                     LEFT JOIN instrumento_nivel inv ON c.instrumento_nivel_id = inv.id
                     JOIN clasificado_genero_musical cgm ON c.id = cgm.clasificado_id
                     JOIN genero_musical gm ON cgm.genero_id = gm.id
                     JOIN clasificado_categoria cc ON c.categoria = cc.id
                     JOIN (
                        SELECT id, CONCAT(IFNULL(b.nombre,''), IFNULL(m.nombre,'')) nombre
                        FROM usuario u
                        LEFT JOIN banda b ON u.id = b.usuario_id
                        LEFT JOIN musico m ON u.id = m.usuario_id
                        WHERE b.nombre IS NOT NULL OR m.nombre IS NOT NULL
                     )u ON c.usuario_id = u.id ";
        $valores_filtro = [];

        $where = false;
        if(isset($filtro['texto']) && !empty($filtro['texto'])){
            $where = true;
            $texto =  $filtro['texto'];
            $consulta .= "WHERE c.categoria LIKE '%{$texto}%' OR c.titulo LIKE '%{$texto}%'
                          OR c.descripcion LIKE '%{$texto}%' OR i.nombre LIKE '%{$texto}%'
                          OR u.nombre LIKE '%{$texto}%' OR gm.nombre LIKE '%{$texto}%'";
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
        if(isset($filtro['categoriaClasificado'])){
            if(!$where){
                $consulta .="WHERE ";
                $where = false;
            }else{
                $consulta .= "AND ";
            }
            $consulta .= "cc.id IN ('".implode("', '", $filtro['categoriaClasificado'])."') ";
        }
        if(isset($filtro['instrumento'])){
            if(!$where){
                $consulta .="WHERE ";
                $where = false;
            }else{
                $consulta .= "AND ";
            }
            $consulta .= "i.id IN ('".implode("', '", $filtro['instrumento'])."') ";
        }


        $pdoStatement = Bd::execute($consulta, $valores_filtro);

        $clasificados = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        $genero_musical = [];
        $clasificados_objs = [];
        foreach($clasificados as $indice => $clasificado){
            $genero_musical[] = $clasificado['genero_musical'];
            if(isset($clasificados[$indice+1]) && $clasificados[$indice+1]['id'] == $clasificado['id'])
                continue;
            $clasificados_objs[] = new static($clasificado, $genero_musical);
            $genero_musical = [];
        }
        return $clasificados_objs;
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
            $valor = Util::config("base_img_clasificado") . $valor;
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
