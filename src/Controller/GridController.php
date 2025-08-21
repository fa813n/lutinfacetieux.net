<?php
namespace Workshop\Controller;

use Toolbox\Controller\AbstractController;
use Workshop\Manager\GridManager;
use Workshop\Entity\Grid;
//use Workshop\UserController;
use Workshop\Traits\UserRights;

class GridController extends AbstractController {
  //sets session grid id to 0
  public function createGrid() {
    //$_SESSION['grid']['id'] = 0;
    $this->render("edit-grid", ["include" => "edit-form", "gridId" => 0]);
  }
  public function displayGrid(int $id) {
    //s'il y a un post uti%isateur, il passe devant le reste
    if (isset($_POST["gridId"]) && (int)$_POST["gridId"] === $id) {
      //fill with post
      echo 'prout<br>';
      $gridContent = [];
      foreach ($_POST as $key => $value) {
        echo 'key: '.var_dump($key).' value: '.$value.'<br>';
        $gridContent[$key] = htmlspecialchars(trim($value));
      }
      unset($_SESSION["grid"]);
      $_SESSION["grid"][$id] = $gridContent;
    }
    // si la grille n'est pas déjà chrgée en session, on va la chercher
    elseif (
      !isset($_SESSION["grid"]) ||
      (int) $_SESSION["grid"][$id] === $id
    ) {
      $this->loadGrid($id);
    }
    $data = $_SESSION["grid"][$id];
    $this->render("grid", $data);
  }
  public function loadGrid($id) {
    echo 'should load grid number '.$id;
  }
}
