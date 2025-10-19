<?php
namespace Workshop\Controller;

use Toolbox\Controller\AbstractController;
use Workshop\Manager\CellManager;
use Workshop\Entity\Cell;
//use Workshop\Controller\GridFactory;

class CellController extends AbstractController {
  public function display($grid, $number) {
    $cell = new Cell($grid, $number);
    //set from
    $cellFactory = new CellFactory($cell);
  }
}