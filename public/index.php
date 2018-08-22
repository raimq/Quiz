<?php

use Quiz\Repositories\AnswerDataBaseRepository;
use Quiz\Repositories\QuestionDatabaseRepository;
use Quiz\Repositories\QuizDataBaseRepository;
use Quiz\Repositories\UserAnswerDataBaseRepository;
use Quiz\Repositories\UserDataBaseRepository;
use Quiz\Repositories\UserScoreDataBaseRepository;
use Quiz\Services\QuizServiceTwo;

include_once '../bootstrap.php';


define('BASE_DIR', __DIR__ . '/..');
define('SOURCE_DIR', BASE_DIR . '/src');
define('VIEW_DIR', SOURCE_DIR . '/views');


$quizRepo = new QuizDataBaseRepository();
$userRepo = new UserDataBaseRepository();
$userAnswersRepo = new UserAnswerDataBaseRepository();
$answersRepo = new AnswerDataBaseRepository();
$questionRepo = new QuestionDatabaseRepository();
$scoreRepo = new UserScoreDataBaseRepository();

$service = new QuizServiceTwo($quizRepo,$userRepo,$userAnswersRepo,$answersRepo,$questionRepo,$scoreRepo);



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


$controller = new $controllerName($service);
$controller->handleCall($actionName);
