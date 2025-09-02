<?php
namespace Workshop\Controller;

use \Toolbox\Controller\AbstractController;
use \Workshop\Controller\AccountController;
use \Workshop\Manager\UserManager;
use \Workshop\Entity\User;

class UserController extends AbstractController {
  
  public function index() {
    $userForm = '';
    $userName = '';
    if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
      $userForm = 'logout';
      $userName = $_SESSION['user']['name'];
    }
     else {
       $userForm = 'connect';
     }
    $this->render('user', 
                  ['userForm' => $userForm,
                  'userName' => $userName]);
  }
  
  public function createUser(array $newUser):int {
    $user = new User;
    $userManager = new userManager;
    $token = AccountController::generateToken();
    $user->setLogin($newUser['login'])
         ->setName($newUser['name'])
         ->setPassword($newUser['password'])
         ->setToken($token)
         ->setActive(0);
    //AccountController::sendActivationMail($user);
    $userManager->createUser($user);
    $userId = $userManager->getNewId();
    AccountController::sendActivationLink($userId, $token, 'displayLink');
    return $userId;
    //header('location: '.ROOT_URL.'/account/activate/'.$userId);
  }
  
  private function setUserSession(array $connectedUser) {
    foreach ($connectedUser as $key => $value) {
      $_SESSION['user'][$key] = $value;
    }
    //var_dump($connectedUser);
    /*$user = new User;
    $user->setLogin($connectedUser['login'])
         ->setName($connectedUser['name'])
         ->setActive($connectedUser['active'])
         ->setSession();
         */
         
  }
  
  public function register() {
    $newUser = [];
    if (isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['password'])  && !empty($_POST['password'])) {
      if ($_POST['password'] !== $_POST['password-confirm']) {
        $_SESSION['error'] = 'le mot de passe et la confirmation ne correspondent pas';
        header('location: '.ROOT_URL.'/user/register');
        exit;
      }
      $newUser['login'] = $_POST['login'];
      $newUser['name'] = $_POST['name'] ?? $_POST['login'];
      $newUser['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $userManager = new UserManager;
      if (!empty($userManager->findOneByLogin($newUser['login']))) {
        $_SESSION['error'] = 'un utilisateur avec l\'adresse e-mail'.$newUser['login'].' existe déjà';
        $this->render('user', ['formSubmit' => 'login']);
      }
      else {
        $newUserId = $this->createUser($newUser);
        $this->render('user', ['userForm' => 'send-activation-link',
                                'id' => $newUserId, 
                                'message' => 'un lien vous a été envoyé par e-mail pour activer votre compte, si vous ne l\'avez pas reçu, cliquez ici pour le renvoyer']);
      }
    }
    $this->render('user', ['userForm' => 'register', 'inputButton' => 'inscription']);
      
  }
  
  public function sendActivationLink() {
    if (isset($_POST['send-method'])) {
      $id = $_POST['id'];
      $sendMethod = $_POST['send-method'];
      $userManager = new UserManager;
      $selectedUser = $userManager->findById($id);
      if ($selectedUser) {
        //$user = new User;
        //$user->hydrate($user, $selectedUser);
        $token = AccountController::generateToken();
        //$user->setToken($token);
        $userManager->update(['token' => $token], $id);
        AccountController::sendActivationLink($id, $token, $sendMethod);
        $this->render('user', ['userForm' => 'send-activation-link',
                                        'id' => $id,
                                        'message' => 'un message contenant un lien vient de vous être envoyé, si vous ne l\'avez pas reçu, cliquez ici pour le renvoyer']);
      }
      else {
        $_SESSION['error'] = 'désolé, je ne trouve pas ce compte';
        header('location: '.ROOT_URL.'/user/register');
      }
    }
    $this->render('user', ['userForm' => 'send-activation-link', 'id' => $id]);
  }
  public function connect() {
    if (isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['password'])  && !empty($_POST['password'])) {
      $login = strip_tags($_POST['login']);
      $password = $_POST['password'];
      //$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $userManager = new UserManager;
      $userToConnect = $userManager->findOneByLogin($login);
      if (!$userToConnect) {
        $_SESSION['error'] = 'identifiant ou mot de passe incorrect';
        header('location: '.ROOT_URL.'/user/register');
        exit;
      }
      else {
        if (password_verify($password, $userToConnect['password'])) {
          $this->setUserSession($userToConnect);
          $this->render('user', ['userForm' => 'logout']);
        }
        else {
          $_SESSION['error'] = 'identifiant ou mot de passe incorrect';
          header('location: '.ROOT_URL.'/user/register');
          exit;
        }
      }
    }
    else {
      $_SESSION['error'] = 'identifiant ou mot de passe manquant';
    }
    $this->render('user', ['userForm' => 'connect']);
  }
  
  public function logout() {
    if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
      if (isset($_POST['logout']) && !empty($_POST['logout'])) {
        unset($_SESSION['user']);
        $this->render('user', ['userForm' => 'connect', "message" => 'vous êtes maintenant déconnecté']);
      }
      else {
        $this->render('user', 
                      ['userForm' => 'logout', 
                      'userName' => $_SESSION['user']['name']]);
      }
    }
    else {
      $this->render('user', ['userForm' => 'connect', "message" => 'vous n\'êtes pas connecté']);
    }
    
  }
  
  public function successMessage(string $message) {
    $detail = User::MESSAGES[$message];
    $this->render('user', ['message' => $detail]);
  }
}