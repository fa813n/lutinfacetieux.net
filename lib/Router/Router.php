<?php
namespace Toolbox\Router;

use Workshop\Entity\Homepage;
use Toolbox\Controller;

class Router {
public function start() {
  session_start();
  echo '<h2>Router</h2>';
  $uri = $_SERVER['REQUEST_URI'];
  
  // si l'url se termine par un /, on l'enleve pour retirer les erreurs éventuelles et on redirige
  if (!empty($uri) && $uri != '/' && $uri[-1] === '/') {
    
   $uri = substr($uri,0,-1);

   http_response_code(301);
   header('location: '.$uri);
   
   //exit;
  }
  //echo $uri;
  $params = explode('/', $_GET['action']);
  var_dump($params);
  if ($params[0] != '') {
    // Si le premier parametre ne renvoie pas vers un controleur existant, on instancie homepage
    $controller = class_exists('\\Workshop\\Entity\\'.ucfirst($params[0])) ? '\\Workshop\\Entity\\'.ucfirst(array_shift($params)) : 'Workshop\\Entity\\Homepage';
    
    $method = isset($params[0]) ? array_shift($params) : 'index'; 
    $controller = new $controller();
    if (method_exists($controller, $method)) {
      (isset($params[0])) ? call_user_func_array([$controller, $method],$params) : $controller->$method();
    }
    else {
      $_SESSION['error'] = 'la page demandée n\'existe pas';
      $controller->index();
    }
  }
  else {
   // $_SESSION['error'] = 'la rubrique demandée n\'existe pas';
   echo 'Homepage shoul´load';
    $controller = new \Workshop\Entity\Homepage;
    $controller->index();
  }
  
  }
}