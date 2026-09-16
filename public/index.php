<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

require_once '../app/config/config.php';
require_once '../app/config/Database.php';

// URL base del proyecto - Educación Continua
define('URL_BASE', 'https://eci.superarse.edu.ec/');

// Obtener la URL amigable
$url = $_GET['url'] ?? 'curso/index';
$url = rtrim($url, '/');
$url = explode('/', $url);

// Controlador
$nombreControlador = ucfirst($url[0]) . 'Controller';
$archivoControlador = '../app/controllers/' . $nombreControlador . '.php';

// Método y parámetro
$metodo = $url[1] ?? 'index';
$parametro = $url[2] ?? null;

if (file_exists($archivoControlador)) {
    require_once $archivoControlador;
    $controlador = new $nombreControlador();

    if (method_exists($controlador, $metodo)) {
        $controlador->$metodo($parametro);
    } else {
        http_response_code(404);
        echo "Error 404: Método no encontrado";
    }
} else {
    http_response_code(404);
    echo "Error 404: Controlador no encontrado";
}
