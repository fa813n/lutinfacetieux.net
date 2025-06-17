<?php

namespace Toolbox;
echo "<h2>Autoloader</h2>";
const ALIASES = ["Toolbox" => "lib", "Workshop" => "src"];
class Autoloader
{
  static function register()
  {
    echo "class: " .
      __CLASS__ .
      "<br> nam: " .
      __NAMESPACE__ .
      " <br>dir: " .
      __DIR__;
    spl_autoload_register([__CLASS__, "autoload"]);
  }

  static function autoload($class)
  {
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
    if (!file_exists($filepath)) {
      throw new Exception(
        "Fichier « " .
          $filepath .
          " » introuvable pour la classe « " .
          $class .
          " ». Vérifier le chemin, le nom de la classe ou le namespace"
      );
    }
    require $filepath;
  }

  /*
    echo '<br>fct autoload <br>class: '.__CLASS__.'<br> nam: '.__NAMESPACE__.' <br>dir: '.__DIR__;
    echo '<br>$class before = '.$class.'<br>';
    echo '<br> ns : '.__NAMESPACE__.'<br>';
    $class = str_replace(__NAMESPACE__.'\\','',$class);
    echo '<br>$class1 = '.$class.'<br>';
    $class = str_replace('\\','/', $class);
    echo '$class = '.$class.'<br>';
    var_dump($_GET);
    */
  /*
    if (file_exists(__DIR__.'/'.$class.'.php')) {
      require(__DIR__.'/'.$class.'.php');
    }
    */
}
