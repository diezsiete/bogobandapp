<?php

class BuscarControlador
{

    public static function getLocalidadAccion(){
        return Util::getLocalidad();
    }
    
    public static function getGeneroMusicalAccion(){
        return Util::getGeneroMusical();
    }
    
    public static function getEventoTipoAccion(){
        return Util::getEventoTipo();
    }
    
    public static function getCategoriaClasificadoAccion(){
        return Util::getCategoriaClasificado();
    }
    
    public static function getInstrumentoAccion(){
        return Util::getInstrumento();
    }

    public static function buscarEventoAccion($filtros){
        $eventos = Evento::instancia($filtros);
        $retorno = new stdClass();
        foreach($eventos as $index => $evento)
            $retorno->$index = $evento->aArreglo();
        return $retorno;
    }
    
    public static function buscarClasificadoAccion($filtros){
        $clasificados = Clasificado::instancia($filtros);
        $retorno = new stdClass();
        foreach($clasificados as $index => $clasificado)
            $retorno->$index = $clasificado->aArreglo();
        return $retorno;
    }

    public static function buscarBarAccion($filtros){
        $bares = Bar::instancia($filtros);
        $retorno = new stdClass();

        foreach($bares as $index => $bar)
            $retorno->$index = $bar->aArreglo();
        return $retorno;
    }

    public static function buscarSalaEnsayoAccion($filtros){
        $ensayos = SalaEnsayo::instancia($filtros);
        $retorno = new stdClass();

        foreach($ensayos as $index => $ensayo)
            $retorno->$index = $ensayo->aArreglo();
        return $retorno;
    }
}