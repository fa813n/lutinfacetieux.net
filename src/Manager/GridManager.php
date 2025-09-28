<?php
namespace Workshop\Manager;
use Toolbox\Manager\AbstractManager;
use Workshop\Entity\Game;

class GridManager extends AbstractManager {
  public function __construct() {
    $this->table = 'grid';
  }
  
}