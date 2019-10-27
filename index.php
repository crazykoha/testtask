<?php

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

include_once "controllers/MainController.php";
include_once "controllers/AuthController.php";
include_once "controllers/TaskController.php";

$url_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$url_parts = explode('/', $url_parts[0]);
$controller_name = '\controllers\\MainController';
$action_name = 'actionIndex';
if (count($url_parts) >= 2 && $url_parts[1] !== '') {
    $controller_name = '\\controllers\\'.ucfirst($url_parts[1]).'Controller';
}
if (count($url_parts) >= 3) {
    $action_name = 'action'.ucfirst($url_parts[2]);
}
$controller = new $controller_name;
$controller->$action_name();