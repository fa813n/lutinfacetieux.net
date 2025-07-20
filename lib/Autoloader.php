<?php

namespace Toolbox;

use \Exception;

const ALIASES = ["Toolbox" => "lib", "Workshop" => "src", "Config" => "config"];
class Autoloader {
  static function register() {
    // var_dump(__CLASS__);
    spl_autoload_register([__CLASS__, "autoload"]);
  }

  static function autoload($class) {
    $namespaceParts = explode("\\", $class);

    if (in_array($namespaceParts[0], array_keys(ALIASES))) {
      $namespaceParts[0] = ALIASES[$namespaceParts[0]];
    } else {
      throw new Exception(
        "Namespace « " .
          $namespaceParts[0] .
          " » invalide. Un namespace doit commencer par : « Toolbox » ou « Workshop »"
      );
    }

    $filepath = dirname(__DIR__) . "/" . implode("/", $namespaceParts) . ".php";
    
    if (file_exists($filepath)) {
      require $filepath;
    }
    /*
    if (!file_exists($filepath)) {
      $_SESSION['error'] = 'classe introuvable';
      header('location', ROOT);
      
      throw new \Exception(
        "Fichier « " .
          $filepath .
          " » introuvable pour la classe « " .
          $class .
          " ». Vérifier le chemin, le nom de la classe ou le namespace"
      );
      */
  }
}
