<?php

require_once 'controllers/ActionController.php';
require_once 'services/Router.php';
require_once 'services/MemsourceApi.php';
require_once 'models/User.php';
require_once 'models/Project.php';
require_once 'models/Deserializer.php';

use App\Controller\ActionController;
use App\Services\Router;
use App\Services\MemsourceApi;

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$actions = new ActionController();
$router = new Router($actions);
$memsourceApi = new MemsourceApi($router);
session_start();
$_SESSION['memsource_api'] = $memsourceApi;

if (isset($_GET['action'])){
    $router->handleRequest($_GET['action']);
}else{
    $router->handleRequest('login_view');
}
