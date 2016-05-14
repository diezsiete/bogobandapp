<?php
class SalaEnsayo {
    
    private $atributos = [];
    
    public static function instancia($filtro = null){
        $consulta = "SELECT se.usuario_id id, se.nombre, l.nombre localidad, se.precios, se.imagen
                     FROM sala_ensayo se 
                     JOIN localidad l ON se.localidad_id = l.id ";
        
        $valores_filtro = [];
        
        $where = false;
        if(isset($filtro['texto']) && !empty($filtro['texto'])){
            $where = true;
            $texto =  $filtro['texto'];
            $consulta .= "WHERE se.nombre LIKE '%{$texto}%' OR l.nombre LIKE '%{$texto}%'";
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