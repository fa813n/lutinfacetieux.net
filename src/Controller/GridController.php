<?php
namespace Workshop\Controller;

use Toolbox\Controller\AbstractController;
use Workshop\Manager\GridManager;
use Workshop\Entity\Grid;
use Workshop\Controller\FrameFactory;
use Workshop\Traits\UserRights;

class GridController extends AbstractController {
  
  //sets session grid id to 0
  public function createGrid() {
    $_SESSION['grid']['id'] = 0;
    $this->render("edit-grid", [
     // "include" => "edit-form",
      "id" => 0,
    ]);
  }
  public function displayGrid($id) {
    var_dump($_POST);
    $gridFactory = new GridFactory($id);
    $grid = $gridFactory->createGrid();
    $grid->displayGrid();
  }
}
