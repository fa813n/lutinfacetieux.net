<?php
session_start();
error_reporting(E_ALL);
// constante ROOT contenant le dossier raçine
define('ROOT',dirname(__DIR__));
define('ROOT_URL', 'http://localhost:8080/dev/lutinfacetieux');
define('PREFERED_SEND_METHOD', 'displayLink');

//define('ROOT', 'http://localhost:8080/lutinfacetieux');
use Toolbox\Autoloader;
use Toolbox\Router\Router;

//echo(ROOT.'/../lib/Autoloader.php');
/*
if (isset($_POST['lutin']) && $_POST['lutin'] === 'facetieux') {
  $_SESSION['lutin'] = 'yes';
}
if ($_SESSION['lutin'] === 'yes') {
*/

require_once(ROOT.'/lib/Autoloader.php');

Autoloader::register();

$router = new Router();
$router->start();
/*
  
}
else {
  echo '<form method="post" action="#"><input type="text" name="lutin"><input type="submit"></form>';
}
*/