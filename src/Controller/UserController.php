<?php
namespace Workshop\Controller;

use \Toolbox\Controller\AbstractController;
use \Toolbox\Controller\AccountController;
use \Workshop\Manager\UserManager;
use \Workshop\Entity\User;

class UserController extends AbstractController {
  
  public function createUser(array $newUser) {
    $user = new User;
    $userManager = new userManager;
    $user->setLogin($newUser['login'])
         ->setName($newUser['name'])
         ->setPassword($newUser['password'])
         ->setToken(AccountController::generateToken())
         ->setActive(0);
    $userManager->createUser($user);
  }
  
  private function setUserSession(array $connectedUser) {
    //var_dump($connectedUser);
    $user = new User;
    $user->setLogin($connectedUser['login'])
         ->setName($connectedUser['name'])
         ->setActive($connectedUser['active'])
         ->setSession();
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
        $this->createUser($newUser);
      }
    }
    $this->render('user', ['userForm' => 'register', 'inputButton' => 'inscription']);
      
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
          echo 'connecté';
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
        $this->render('user', ['userForm' => 'logout', "message" => 'vous êtes connecté en tant que '.$_SESSION['user']['name'].', cliquez ici our vous déconnecter: ']);
      }
    }
    else {
      $this->render('user', ['userForm' => 'connect', "message" => 'vous n\'êtes pas connecté']);
    }
    
  }
}