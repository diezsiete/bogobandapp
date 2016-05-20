<?php

class UsuarioControlador {
    
    public static function getLocalidadAccion(){
        return Util::getLocalidad();
    }
    
    public static function sesionAccion(){
        $session_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
        return ["id" => $session_id];
    }
    
    public static function iniciarSesionAccion($usuario, $contraseña){
        //obtenemos usuario
        $usuario = ["id" => 1, "entidad" => "musical"];
        if($usuario){
            $_SESSION['id'] = $usuario["id"];
        }
        return $usuario;
    }
    
    public static function cerrarSesionAccion(){
        unset($_SESSION['id']);
    }

    public static function registroAccion($campos_string){
        parse_str($campos_string, $campos);
        echo '<pre>' . print_r($campos, 1) . '</pre>';
    }
}