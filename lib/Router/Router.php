<?php
namespace Toolbox\Router;

use Workshop\Entity\Homepage;
use Toolbox\Controller;

class Router {
public function start() {
  $uri = $_SERVER['REQUEST_URI'];
  
  // si l'url se termine par un /, on l'enleve pour retirer les erreurs éventuelles et on redirige
  if (!empty($uri) && $uri != '/' && $uri[-1] === '/') {
    
   $uri = substr($uri,0,-1);

   /*
   http_response_code(301);
   header('location: '.$uri);
   
   exit;
   */
   
  }
  $params = explode('/', $_GET['action']);
  if ($params[0] != '') {
    
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
    $controller = new \Workshop\Entity\Homepage;
    $controller->index();
  }

  }
}