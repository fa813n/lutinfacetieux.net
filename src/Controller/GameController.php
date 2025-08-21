<?php
namespace Workshop\Controller;

use Toolbox\Controller\AbstractController;
use Workshop\Manager\GameManager;
use Workshop\Entity\Game;
//use Workshop\UserController;
use Workshop\Traits\UserRights;

class GameController extends AbstractController {
  public function editGame($id) {
    if (id != 0) {
      if ($_SESSION["game"]["id"] === $id) {
        $game = new Game();
      }
    }

    //-------------------------------
    else {
      $game = new Game();
      // foreach
      $this->render("game", ["include" => "edit"]);
    }
  }
  public function createGame(int $gridId, int $cellNumber) {
    $this->render("game", [
      "include" => "edit-form",
      "scripts" => Game::SCRIPTS,
      "gridId" => $gridId,
      "cellNumber" => $cellNumber,
    ]);
  }
  private function loadGame(int $id): Game {
    //
    $gameManager = new GameManager();
    $foundGame = $gameManager->findById($id);
    $userId = $_SESSION["user"]["id"] ?? 0;
    if ($this->checkRights($userId, $id) != ("owner" || "receiver")) {
      $_SESSION["error"] = 'vous n\'êtes pas autorisé à voir ce jeu';
    }
    foreach ($foundGame as $key => $value) {
      $setter = "set" . ucfirst($key);
      if (method_exists($game, $setter)) {
        $game->$setter($value);
      }
    }
  }
  public function displayGame(int $gridId, int $cellNumber) {
    $game = new Game();
    $gameContent = [];

    if (
      isset($_POST) &&
      $gridId === (int) $_POST["gridId"] &&
      $cellNumber === (int) $_POST["cellNumber"]
    ) {
      foreach ($_POST as $key => $value) {
        $gameContent[$key] = htmlspecialchars(stripslashes(trim($value)));
      }
      unset($gameContent["gridId"], $gameContent["cellNumber"]);
      $gameContent = json_encode($gameContent);
    } 
    elseif (isset($_SESSION["game"][$gridId][$cellNumber])) {
      $gameContent = $_SESSION["game"][$gridId][$cellNumber];
    } 
    else {
      //$gameContent = $this->loadGame($gridId, $cellNumber);
    }

    $game
      ->setGrid($gridId)
      ->setCell($cellNumber)
      ->setContent($gameContent);

    $this->render("game", ["include" => "menu"]);
  }
}
