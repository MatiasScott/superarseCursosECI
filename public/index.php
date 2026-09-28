<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

require_once '../app/config/config.php';
require_once '../app/config/Database.php';

// URL base del proyecto
// 1) Si existe la variable de entorno APP_URL (producción), se respeta tal cual.
// 2) Si no, se detecta automáticamente del dominio actual (para trabajar en local).
$url_base_app = getenv('APP_URL');
if (!$url_base_app) {
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ($_SERVER['SERVER_PORT'] ?? '') === '443';
    $esquema = $https ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $carpeta = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
    $carpeta = ($carpeta === '/' || $carpeta === '.') ? '' : rtrim($carpeta, '/');
    $url_base_app = $esquema . '://' . $host . $carpeta . '/';
}
define('URL_BASE', rtrim($url_base_app, '/') . '/');

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
