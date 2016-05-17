<?php
class EntidadComercial{
	private $atributosComercial = [];
    public function __construct($atributosUsuario, $atributosEntidad){
    	parent::__construct($atributosUsuario);
    	foreach ($atributosEntidad as $nombre => $valor) {
    		$this->atributosComercial[$nombre] = $valor;
    	}
    }
    public static function agregarEntidadComercial($tipo, $campos, $idEntidad){
    	$campos["idEntidad_comercial"] = $idEntidad;
    	if($tipo == "bar"){
          $tabla = "bar";
          $columnas = [ "precios", "imagen", "idEntidad_comercial" ] ;
          bd::insert($tabla, $columnas, $campos );
    	  return;
    	}
    	if($tipo == "SalaEn"){
    	 $tabla = "sala_ensayo";
          $columnas = [ "precios", "grabacion", "descripcion_grabacion", "idEntidad_comercial" ] ;
          bd::insert($tabla, $columnas, $campos );
    	  return;    	}

    }


    public function __get($attr) {
        $valor = $this->atributos[$attr];
        return $valor;
    }


}
