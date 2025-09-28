<?php
namespace Workshop\Controller;

use Workshop\Controller\CalendarController;
use Workshop\Entity\Calendar as Calendar;

class GridFactory {
  //abstract public function getGrid(): GridInterface;
  private int $id;
  private string $frame = '';
  private ?array $params;
  
  public function __construct($id) {
    $this->id = $id;
    $this->params = $this->setFromPost() ?: $this->setFromSession() ?: $this-> setFromDatabase();
  }
  /*
  public function setParams(): array {
    $this->params = $this->setFromPost() ?: $this->setFromSession() ?: $this-> setFromDatabase();
    return $params;
  }
  */
  
  public function setFromPost(): ?array {
    if ($_POST['frame']) {
      echo 'from post';
      //$entityName = 'Workshop\Entity\\'.ucfirst($frame);
      $params = [];
      foreach ($_POST as $key => $param) {
        $param = gettype($param) === 'string' ? htmlspecialchars(trim($param)) : $param;
        $params[$key] = $param;
      }
      return $params;
    }
    return null;
  }
  public function setFromSession(): ?Entity {
    //si la grille demandée est déjà chargée en session
    if ($_SESSION['grid']['id'] === $this->id) {
      $frame = $_SESSION['grid']['frame'];
      $entityName = ucfirst($frame);
      $entity = new $entityName($_SESSION['grid']);
      $this->frame = $frame;
      return $entity;
    }
    return null;
  }
  public function setFromDatabase(): ?Entity {
    return null;
  }
  
  public function createGrid(): GridInterface {
    $params = $this->params;
    switch ($this->params['frame']) {
      case 'set' :
        return new SetController($params);
        break;
        
      case 'board' :
        return new BoardController($entity);
        break;
        
      case 'calendar' :
        return new CalendarController($params);
        break; 
      
      case 'enigma' :
        return new enigmaController($entity);
    }
  }
  public function displayGrid() {
    $grid = $this->createGrid();
    return $grid->displayGrid();
  }
}