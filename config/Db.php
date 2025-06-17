<?php
namespace Lutin\config;
use PDO;
use PDOException;
class Db extends PDO {
  private static $instance;
  
  private const DBHOST = '127.0.0.1';
  private const DBNAME = 'adventCalendar';
  private const DBUSER = 'root';
  private const DBPASS = 'admin';
  
  private function __construct() {
    $_dsn = 'mysql:dbname='.self::DBNAME.';host='.self::DBHOST;
    try {
      parent::__construct($_dsn, self::DBUSER, self::DBPASS);
      //reglage des attributs PDO
      // utf8
      $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
      // fetch mode (récupération des résultats de requète): sous forme d'objet
      $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      // gestion des erreurs
      $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die($e->getMessage());
    }
  }
  public static function getInstance():self {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }
}