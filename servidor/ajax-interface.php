<?php
define('INCLUDES_DIR', 'includes/');

require_once 'config.php';

require_once INCLUDES_DIR . 'krumo/class.krumo.php';

spl_autoload_register(function ($class) {
    $path = INCLUDES_DIR . $class . '.php';
    file_exists($path) ? include $path : NULL;
});

if(isset($_GET['solicitud'])){	
	echo "respuesta{$_GET['solicitud_cuenta']}(" . json_encode($_GET['solicitud']()) . ");";
}

function getEventos(){
    $eventos = Evento::instancia($_GET);
    $retorno = new stdClass();
  
    foreach($eventos as $index => $evento)
        $retorno->$index = $evento->aArreglo();
    return $retorno;
}

function getClasificados(){
    $clasificados = Clasificado::instancia($_GET);
    $retorno = new stdClass();
    foreach($clasificados as $index => $clasificado)
        $retorno->$index = $clasificado->aArreglo();
    return $retorno;
}

function getBares(){
    $bares = Bar::instancia($_GET);
    $retorno = new stdClass();

    foreach($bares as $index => $bar)
        $retorno->$index = $bar->aArreglo();
    return $retorno;
}

function getSalaEnsayos(){
    $ensayos = SalaEnsayo::instancia($_GET);
    $retorno = new stdClass();
    
    foreach($ensayos as $index => $ensayo)
        $retorno->$index = $ensayo->aArreglo();
    return $retorno;
}

function _aArreglo($arreglo_objs){
    $retorno = new stdClass();
    foreach($arreglo_objs as $index => $obj)
        $retorno->$index = $obj->aArreglo();
    return $retorno;
}

function filtrar(){
    $retorno = new stdClass();
    foreach($_GET['filtros'] as $entidad => $filtros){
        $retorno->$entidad = _aArreglo(call_user_func( "{$entidad}::instancia", $filtros));
    }
    return $retorno;
}

function getLocalidad(){
    return Util::getLocalidad();
}
function getGeneroMusical(){
    return Util::getGeneroMusical();
}
function getEventoTipo(){
    return Util::getEventoTipo();
}
function getCategoriaClasificado(){
    return Util::getCategoriaClasificado();
}
function getInstrumento(){
    return Util::getInstrumento();
}