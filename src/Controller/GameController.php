<?php
namespace Workshop\Controller;

use \Toolbox\Controller\AbstractController;
use \Workshop\Manager\GameManager;
use \Workshop\Entity\Game;
use \Workshop\UserController;
use \Workshop\Toolbox\UserRights;

class GameController extends AbstractController {
  
  public function editGame($id) {
    if (id != 0) {
      if ($_SESSION['game']['id'] === $id) {
        $game = new Game;
      }
    }
    
    
    //-------------------------------
    else {
      $game = new Game;
     // foreach 
      $this->render('game', ['include' => 'edit']);
    }
  }
  public function createGame() {
    $_SESSION['game']['id'] = 0;
    $this->render('game', ['include' => 'edit']);
  }
  private function loadGame(int $id):Game {
    //
    $gameManager = new GameManager;
    $foundGame = $gameManager->findById($id);
    $userId = $_SESSION['user']["id"] ?? 0;
    if ($this->checkRights($userId, $id) != ('owner' || 'receiver')) {
      $_SESSION['error'] = 'vous n\'êtes pas autorisé à voir ce jeu';
    }
    foreach ($foundGame as $key => $value) {
      $setter = 'set'.ucfirst($key);
      if (method_exists($game, $setter)) {
        $game->$setter($value);
      }
      
    }
  }
  public function displayGame($id) {
    
  }
}