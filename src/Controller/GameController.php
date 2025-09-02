<?php
namespace Workshop\Controller;

use Toolbox\Controller\AbstractController;
use Workshop\Manager\GameManager;
use Workshop\Entity\Game;
//use Workshop\UserController;
use Workshop\Traits\UserRights;

use Toolbox\Utils;

class GameController extends AbstractController {
  
  const MAIN_SCRIPTS = [
    "data",
    "encodeMessage",
    "main"
    ];
  const GAME_SCRIPTS = [  
    'flags' => "games/Flags",
    'letters-to-symbols' => "games/LettersToSymbols",
    'memory' => "games/Memory",
    'scroll-images' => "games/ScrollImages"
  ];
  
  
  public function createGame() {
    $userId = $_SESSION['user']['id'] ?? 0;
    $this->render("edit-game", [
      "scripts" => Game::SCRIPTS,
      "id" => 0,
      'message' => '',
      'owner' => $userId,
      'receiver' => $userId,
      'grid' => 0,
      'cell' => 0
    ]);
  }
  /*
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
  */
  
  public function getGame(int $id) {
    //$game = new Game();
    $gameParams = [];
    $gameAttributes = [];
    $userRights = '';
    $game = new Game;
    
    if ($id === 0) {
        $userRights = 'owner';
    }
    else {
      $gameManager = new GameManager;
      $gameParams = $gameManager->findById($id);
      if ($gameParams) {
        $userRights = $this->checkRights($gameParams);
      }
      else {
        //throw new exception
      $_SESSION['error'] = 'jeu non trouvé';
      header('location: '.ROOT_URL.'/game');
      exit;
      }
    }
    if ($userRights === 'forbidden') {
      //throw new exception
      $_SESSION['error'] = 'accès refusé';
      header('location: '.ROOT_URL.'/game');
      exit;
    }
    //var_dump($_POST);
    //S'il y a un post utilisateur ou que le jeu est déjà chargé en session, on écrase les attributs chargés lors de l'appel à la bdd
    if (isset($_POST) && !empty($_POST) && $id === (int) $_POST["id"]) {
      foreach ($_POST as $key => $value) {
        $gameParams[$key] = htmlspecialchars(stripslashes(trim($value)));
        $_SESSION['game'][$id][$key] = $value;
      }
    } 
    elseif (isset($_SESSION["game"][$id]) && !empty($_SESSION['game'][$id])) {
      $gameParams = $_SESSION["game"][$id];
    }
    
    $gameAttributes['userRights'] = $userRights;
    $gameAttributes['id'] = Utils::array_extract($gameParams, 'id');
    //$gameAttributes['chosenGame'] = Utils::array_extract($gameParams, 'chosen-game');
    $gameAttributes['owner'] = Utils::array_extract($gameParams, 'owner');
    $gameAttributes['receiver'] = Utils::array_extract($gameParams, 'receiver');
    
    $gameAttributes['grid'] = Utils::array_extract($gameParams, 'grid');
    $gameAttributes['cell'] = Utils::array_extract($gameParams, 'cell');
    //on r#groupe les attributs restznt dans cont#nt
  
    $gameAttributes['content'] = (isset($gameParams['content']) && !empty($gameParams['content'])) ? Utils::array_extract($gameParams, 'content') : json_encode($gameParams);
    return $gameAttributes;
  } 
    

  
  
  public function displayGame($id) {
    $gameAttributes = $this->getGame($id);
    $scripts = Self::MAIN_SCRIPTS;
    
    $chosenGame = json_decode($gameAttributes['content'], 1)['chosen-game'];
    $gameScript = Self::GAME_SCRIPTS[$chosenGame];
    
    $scripts[] = $gameScript;
    $parameters = $gameAttributes['content'];

    $this->render("display-game", 
                  [
                    'id' => $id,
                    "scripts" => $scripts,
                    "parameters" =>$parameters
                    ]);
  }
  public function editGame($id) {
    $gameAttributes = $this->getGame($id);
    echo '<br>game attributes:<br';
    var_dump($gameAttributes);
    if ($gameAttributes['userRights'] === 'owner') {
      $gameAttributes['scripts'] = Game::SCRIPTS;
      $this->render('edit-game', $gameAttributes);
    }
    else {
      $_SESSION['error'] = "vous n'avez pas les droits pour modifier ce jeu";
      header('location; ', ROOT.'/game');
    }
  }
  public function displayGameList() {
    $gameList = [];
    if (isset($_SESSION['game'][0]) && !empty($_SESSION['game'][0])) {
      $gameList['public'][0] = $_SESSION['game'][0];
    }
    $gameManager = new GameManager;
  }
  public function recordGame($id) {
    //in session
  }
  public function saveGame(int $id) {
    $gameAttributes = $this->getGame($id);
    if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
      if ($gameAttributes['userRights'] === 'owner'){
        $game = new Game;
        $game/*->setId($gameAttributes['id'])*/
             ->setGrid(0)
             ->setCell(0)
             ->setContent($gameAttributes['content'])
             ->setOwner($gameAttributes['owner'])
             ->setReceiver($gameAttributes['receiver']);
        $gameManager = new GameManager;
        if ($id === 0) {
          $newId = $gameManager->createGame($game);
          foreach ($gameAttributes as $gameAttribute) {
            $_SESSION['game'][$newId] = $gameAttribute;
            unset($_SESSION['game'][0]);
          }
        }
        else {
          $gameManager->updateGame($id);
        }
             
      }
      else {
        $_SESSION['error'] = "vous devez être le créateur du jeu pour le sauvegarder";
        header('location:'.ROOT.'/game');
        exit;
      }
    }
    else {
      $_SESSION['error'] = "vous devez être connecté pour sauvegarder vos création";
      header('location: '.ROOT_URL.'/user/connect');
      exit;
      
    }
  }
}
