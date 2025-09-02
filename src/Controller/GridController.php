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
    //$_SESSION['grid']['id'] = 0;
    $this->render("edit-grid", [
      "include" => "edit-form",
      "id" => 0,
      ($ownerId = 0),
    ]);
  }
  public function displayGrid(int $id) {
    //$grid = new Grid();
    $gridContent = [];
    var_dump($_SESSION);
    //s'il y a un post uti%isateur, il passe devant le reste
    if (isset($_POST["id"]) && (int) $_POST["id"] === $id) {
      //fill with post
      //echo 'prout<br>';
      //$gridContent = [];
      foreach ($_POST as $key => $value) {
        echo "key: " . var_dump($key) . " value: " . var_dump($value) . "<br>";
        $gridContent[$key] = htmlspecialchars(trim($value));
      }
      unset($_SESSION["grid"]);
      $_SESSION["grid"] = $gridContent;
    }
    // si la grille n'est pas déjà chrgée en session, on va la chercher
    elseif (
      !isset($_SESSION["grid"]) ||
      (int) $_SESSION["grid"]["id"] !== $id
    ) {
      $gridContent = $this->loadGrid($id);
    } else {
      $gridContent = $_SESSION["grid"];
    }
    $frame = (new FrameFactory)->createFrame($gridContent);
    $frame->generateGrid(27);
    
    //$this->hydrate($grid, $gridContent);
    $data = $_SESSION["grid"];
    echo '<p style="color;pink">';
    var_dump($grid);
    echo "</p>";
    $this->render("display-grid", $data);
  }
  /**
   *
   */
  public function loadGrid($id) {
    //echo 'should load grid number '.$id;
    $gridManager = new GridManager();
    $grid = $gridManager->finById($id);
    if (!$grid) {
      $_SESSION["error"] = 'le jeu demandé n\'existe pas';
      header("location: " . ROOT_URL . "/grid");
      exit();
    }
    $userRights = $this->checkRights($grid);
    if ($userRights === "forbidden") {
      $_SESSION["error"] = 'vous n\'avez pas les droits pour voir ce jeu';
      header("location: " . ROOT_URL . "/grid");
    }
    foreach ($grid as $key => $value) {
      $_SESSION["grid"][$id][$key] = $value;
    }
  }
}
