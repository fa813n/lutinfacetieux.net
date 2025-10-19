<?php
namespace Workshop\Controller;

use Toolbox\Controller\AbstractController;
use Workshop\Manager\GridManager;
use Workshop\Controller\Factory\Grid;
//use Workshop\Entity\Grid;
use Workshop\Controller\Service\UserService\{AccountIsActive, 
ElementIsPublic,
UserExists,
userIsConnected,
userIsOwner,
UserIsReceiver};
//use Workshop\Traits\UserRights;

class GridController extends AbstractController {
  
    // to save: userIsConnected->AccountIsActive->userIsOwner
  // to display: elementIsPublic->userIsConnected->userIsReceiver->userIsOwner
  
  //sets session grid id to 0
  public function createGrid() {
    $this->flashMessage('fonction pour avertir de la perte de la création en cours', 'warning');
    $_SESSION['grid']['id'] = 0;
    $owner = $_SESSION['user']['id'] ?? 0;
    $receiver = $owner;
    $this->render("edit-grid", [
     // "include" => "edit-form",
      "id" => 0,
      "owner" => $owner
    ]);
  }
  public function display($id) {
    //var_dump($_POST);
    $grid = new Grid($id);
    //var_dump($grid);
    $userId = 0;
    $elemnentIsPublic = new ElementIsPublic();
    //$userIsReceiver = new UserIsReceiver($userId);
    //$userIsOwner = new UserIsOwner($userId);
    //$userIsReceiver->setNext($userIsOwner);
    //$elemnentIsPublic->setNext($userIsReceiver)->setNext($userIsOwner)->check($grid);
    $elemnentIsPublic->setNext(new UserIsReceiver($userId))->setNext(new UserIsOwner($userId))->check($grid);
    /*
    echo "1 ";
    var_dump($elemnentIsPublic);
    echo '<br> 2 ';
    var_dump($userIsReceiver);
    echo '<br> 3 ';
    var_dump($userIsOwner);
    
    $elemnentIsPublic->check($grid);
    $userIsReceiver->check($grid);
    $userIsOwner->check($grid);
    */
    
    //$elemnentIsPublic->setNext($userIsReceiver)->setNext($userIsOwner)->check($grid);
    $content = $grid->getContent();
    //echo 'content: <br>';
    //var_dump($content);
    if (!$content) {
      $this->flashMessage('Objet non trouvé', 'error');
      header('location: '.ROOT_URL.'/game');
      exit;
    }
    $file = $content['file'];
    $this->render($file, $content);
  }
  
  public function saveGrid($id) {
    $gridFactory = new GridFactory($id);
    $gridFactory->saveGrid();
  }
  
}
