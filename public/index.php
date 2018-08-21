<?php

use Quiz\Controllers\BaseController;

include_once '../bootstrap.php';


define('BASE_DIR', __DIR__ . '/..');
define('SOURCE_DIR', BASE_DIR . '/src');
define('VIEW_DIR', SOURCE_DIR . '/views');


$requestUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$requestString = substr($requestUrl, strlen($baseUrl));
$urlParams = explode('/', $requestString);
$controllerName = ucfirst(array_shift($urlParams));
$controllerName = $controllerNamespace . ($controllerName ? $controllerName : 'Index') . 'Controller';
$actionName = strtolower(array_shift($urlParams));
$actionName = ($actionName? $actionName: 'index') . 'Action';

$content = explode(';', $_SERVER["CONTENT_TYPE"]);
$contentType = array_shift($content);
if ($contentType == "application/json") {
    $_POST = json_decode(file_get_contents('php://input'), true);
}



/** @var BaseController $controller */

$controller = new $controllerName;
$controller->handleCall($actionName);