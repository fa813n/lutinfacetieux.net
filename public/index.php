<?php
session_start();
error_reporting(E_ALL);
// constante ROOT contenant le dossier raçine
define('ROOT',dirname(__DIR__));

//define('ROOT', 'http://localhost:8080/lutinfacetieux');
use Toolbox\Autoloader;
use Toolbox\Router\Router;

//echo(ROOT.'/../lib/Autoloader.php');
require_once(ROOT.'/lib/Autoloader.php');

Autoloader::register();

$router = new Router();
$router->start();
