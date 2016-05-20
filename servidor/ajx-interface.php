<?php
session_start();

header('Access-Control-Allow-Origin: *');
header('text/html; charset=utf-8');
header('Access-Control-Allow-Credentials: true');


define('INCLUDES_DIR', 'includes/');
define('CONTROLADORES_DIR', INCLUDES_DIR . 'controladores/');

require_once 'config.php';

require_once INCLUDES_DIR . 'krumo/class.krumo.php';

spl_autoload_register(function ($class) {
    if(file_exists(INCLUDES_DIR . $class . '.php')) 
        include INCLUDES_DIR . $class . '.php';
    elseif(file_exists(CONTROLADORES_DIR . $class . '.php'))
        include CONTROLADORES_DIR . $class . '.php';
});

if(isset($_POST['controlador_metodo'])){
    $controlador_metodo = $_POST['controlador_metodo'];
    if(isset($_POST['post'])) {
        unset($_POST['controlador_metodo'], $_POST['post']);
        $datos = $_POST;
    }else
        $datos = empty($_POST["datos_envio"]) ? [] : json_decode($_POST["datos_envio"], true);
    echo json_encode(call_user_func_array($controlador_metodo, $datos));
}