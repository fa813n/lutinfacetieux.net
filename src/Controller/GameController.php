<?php
namespace Workshop\Controller;

use Toolbox\Controller\AbstractController;
use Workshop\Manager\GameManager;
use Workshop\Entity\Game;
use Workshop\Controller\UserController;
// use Workshop\Traits\UserRights;

use Toolbox\Utils;

class GameController extends AbstractController {

  public function displayGameList() {
    $gameList = $this->loadGameList();
    $this->render('game-list', $gameList);
  }

  public function createGame() {
    $userId = $_SESSION['user']['id'] ?? 0;
    $scripts = array_merge(Game::MAIN_SCRIPTS, Game::GAME_SCRIPTS);
    $this->render('edit-game', [
      'scripts' => $scripts,
      'id' => 0,
      'message' => '',
      'owner' => $userId,
      'receiver' => $userId,
      'grid' => 0,
      'cell' => 0,
	   'content' => []
    ]);
  }

  public function getGame(int $id) {
    $gameParams = [];
    $gameAttributes = [];
    $userRights = '';
    $game = new Game();

    if ($id === 0) {
      $userRights = 'owner';
    } else {
      $gameManager = new GameManager();
      $gameParams = $gameManager->findById($id);
      if ($gameParams) {
        $userRights = $this->checkRights($gameParams);
      } else {
        //throw new exception
        $this->flashMessage('jeu non trouvé', 'error');
        header('location: ' . ROOT_URL . '/game');
        exit();
      }
    }
    if ($userRights === 'forbidden') {
      //throw new exception
      $this->flashMessage('accès refusé', 'error');
      header('location: ' . ROOT_URL . '/game');
      exit();
    }
    //S'il y a un post utilisateur ou que le jeu est déjà chargé en session, on écrase les attributs chargés lors de l'appel à la bdd
    if (isset($_POST) && !empty($_POST) && $id === (int) $_POST['id']) {
      foreach ($_POST as $key => $value) {
        $gameParams[$key] = htmlspecialchars(stripslashes(trim($value)));
        $_SESSION['game'][$id][$key] = $value;
      }
    } elseif (isset($_SESSION['game'][$id]) && !empty($_SESSION['game'][$id])) {
      $gameParams = $_SESSION['game'][$id];
    }
    /*
    var_dump($gameParams);
    echo '<br>Session<br>';
    var_dump($_SESSION);
    */
    
    if ((int)$gameParams['id'] === 0 && $_SESSION['user']['id']) {
      //echo 'verified';
      $gameParams['owner'] = $_SESSION['user']['id'];
     // echo '<br>$gameParams<br>';
      //var_dump($gameParams);
    }
    $gameAttributes['userRights'] = $userRights;
    $gameAttributes['id'] = (int) Utils::array_extract($gameParams, 'id');
    $gameAttributes['owner'] = (int) Utils::array_extract($gameParams, 'owner');
    $gameAttributes['receiverLogin'] = Utils::array_extract($gameParams, 'receiver-login');
    $gameAttributes['receiver'] = (int) Utils::array_extract(
      $gameParams,
      'receiver'
    );

    $gameAttributes['grid'] = (int) Utils::array_extract($gameParams, 'grid');
    $gameAttributes['cell'] = (int) Utils::array_extract($gameParams, 'cell');
    //on r#groupe les attributs restznt dans cont#nt

    $gameAttributes['content'] =
      isset($gameParams['content']) && !empty($gameParams['content'])
        ? Utils::array_extract($gameParams, 'content')
        : json_encode($gameParams);
    return $gameAttributes;
  }

  public function displayGame($id) {
    $gameAttributes = $this->getGame($id);
    $scripts = Game::MAIN_SCRIPTS;

    $chosenGame = json_decode($gameAttributes['content'], 1)['chosen-game'];
    $gameScript = Game::GAME_SCRIPTS[$chosenGame];

    $scripts[] = $gameScript;
    $parameters = $gameAttributes['content'];
    //var_dump($gameAttributes);
    $this->render('display-game', [
      'id' => $id,
      'scripts' => $scripts,
      'parameters' => $parameters,
      'userRights' => $gameAttributes['userRights']
    ]);
  }
  public function editGame($id) {
    $gameAttributes = $this->getGame($id);
    // extrzits les attributs de'content'
    $content = json_decode(Utils::array_extract($gameAttributes, 'content'), 1);
	//$gameAttributes = array_merge($gameAttributes, $content);
	$gameAttributes['content'] = $content;
	//var_dump($gameAttributes);
    if ($gameAttributes['userRights'] === 'owner') {
      $gameAttributes['scripts'] = array_merge(Game::MAIN_SCRIPTS, Game::GAME_SCRIPTS);
      $this->render('edit-game', $gameAttributes);
    } else {
      $this->flashMessage(
        'vous n\'avez pas les droits pour modifier ce jeu',
        'error'
      );
      header('location; ', ROOT . '/game');
    }
  }
  public function deleteGame(int $id) {
    $gameAttributes = $this->getGame($id);
    if ($id === 0){
      $this->flashMessage('ce jeu n\'a pas encore été sauvegardé', 'error');
      header('location: '.ROOT_URL.'/game/displayGame/'.$od);
    }
    //var_dump($gameAttributes);
    
    if ($gameAttributes['userRights'] === 'owner') {
      if (isset($_POST['delete']) && $_POST['delete'] === 'confirmer') {
        $gameManager = new GameManager;
        $gameManager->delete($id);
        $this->render('game-list');
        exit;
      }
      else $this->flashMessage('confirmez-vous la suppression?', 'warning');
      $this->render('delete-game', $gameAttributes);
      //$this->render('edit-game', $gameAttributes);
    } else {
      $this->flashMessage(
        'vous n\'avez pas les droits pour supprimer ce jeu',
        'error'
      );
      header('location; ', ROOT . '/game');
    }
  }
  private function loadGameList() {
    $gameList = [];
    if (isset($_SESSION['game'][0]) && !empty($_SESSION['game'][0])) {
      $gameList['currentGame'] = $_SESSION['game'][0];
    }
    $gameManager = new GameManager();
    $gameList['publicGames'] = $gameManager->getPublicList();

    if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
      $gameList['privateGames'] = $gameManager->getPrivateList(
        $_SESSION['user']['id']
      );
    }
    return $gameList;
  }

  public function saveGame(int $id) {
    $gameAttributes = $this->getGame($id);
    if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
      if ($_SESSION['user']['active'] !== 1) {
        $this->flashMessage(
          'Ce compte utilisateur doit être activé avant de pouvoir sauvegarder vos créations',
          'info'
        );
        header('location: '.ROOT_URL.'/user/sendActivtionLink');
        exit;
      }
      if ($gameAttributes['userRights'] === 'owner') {
        $game = new Game();
        $receiver = 0;
        
        if (isset($gameAttributes['receiverLogin']) && !empty($gameAttributes['receiverLogin'])) {
          $receiverLogin = $gameAttributes['receiverLogin'];
          $userController = new UserController;
          $user = $userController->findOneByLogin($receiverLogin);
          if ($user) {
            $receiver = $user['id'];
          }
          else {
            $receiver = $userController->createUser(['login' => $receiverLogin, 'name' => '', 'password' => '']);
          }
        }
        else {
          $receiver =
          $gameAttributes['receiver'] === 0
            ? $_SESSION['user']['id']
            : $gameAttributes['receiver'];
            $owner = $_SESSION['user']['id'];
        }
        $owner = $gameAttributes['owner'];
        $game
          ->setGrid(0)
          ->setCell(0)
          ->setContent($gameAttributes['content'])
          ->setOwner($owner)
          ->setReceiver($receiver);
        $gameManager = new GameManager();
        if ($gameManager->countGames($owner) > 3) {
          $this->flashMessage('vous avez atteint le maximum de créations, supprimez-en pour pouvoir en sauvegarder de nouvelles', 'warning');
          header('location: '.ROOT_URL.'/games/displayGameList');
          exit;
        }
        if ($id === 0) {
          $newId = $gameManager->createGame($game);
          $gameAttributes['id'] = $newId;
          $_SESSION['game'][$newId] = $gameAttributes;
          unset($_SESSION['game'][0]);
        } else {
          $gameManager->updateGame($id);
        }
      } else {
        $this->flashMessage(
          'vous devez être le créateur du jeu pour le sauvegarder',
          'error'
        );
        header('location:' . ROOT . '/game');
        exit();
      }
    } else {
      $this->flashMessage(
        'vous devez être connecté pour sauvegarder vos créations',
        'error'
      );
      header('location: ' . ROOT_URL . '/user/connect');
      exit();
    }
    $this->render('game');
  }
}
