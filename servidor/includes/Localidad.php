<?php
class Localidad{
	private $atributos = [];
    public function __construct($atributos){
    	foreach ($atributos as $nombre => $valor) {
    		$this->atributos[$nombre] = $valor;
    	}
    }
    public static function getLocalidad($nombre){

    }
    public static function getAll(){
      return bd::selectAll("localidad")->fetchAll(PDO::FETCH_KEY_PAIR);
    }

}
