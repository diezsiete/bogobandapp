<?php
$GLOBALS["config"] = array(
		"bd"     => "louielou_bogobandapp",
		"bd_usuario" => "louielou_bba",
		"bd_clave" => "",
        
        "base_img" => 'http://espaciokb.co/server/img/'
);

$GLOBALS["config"]["base_img_evento"] = $GLOBALS["config"]['base_img'] . "evento/";
$GLOBALS["config"]["base_img_musico"] = $GLOBALS["config"]['base_img'] . "musico/";
$GLOBALS["config"]["base_img_banda"]  = $GLOBALS["config"]['base_img'] . "banda/";
$GLOBALS["config"]["base_img_bar"]    = $GLOBALS["config"]['base_img'] . "bar/";
$GLOBALS["config"]["base_img_sala_ensayo"] = $GLOBALS["config"]['base_img'] . "sala_ensayo/";



date_default_timezone_set('America/Bogota');