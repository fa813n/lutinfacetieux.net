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
    $message = '';
    $id = 0;
    if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
      $id = (int)$_SESSION['user']['id'];
      if ($_SESSION['user']['active'] === 0) {
        $userForm = 'send-activation-link';
        $message = 'Il faut que votre compte soit activé pour pouvoir enregistrer vos créations';
        $this->flashMessage('ce compte n\'a pas été activé', 'warning');
      }
      else {
        $userForm = 'logout';
      }
      $userName = $_SESSION['user']['name'];
    }
     else {
       $userForm = 'connect';
     }
    $this->render('user', 
                  ['userForm' => $userForm,
                  'userName' => $userName,
                  'message' => $message,
                  'id' => $id
                  ]);
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
    $userManager->createUser($user);
    $userId = $userManager->getNewId();
    //AccountController::sendActivationLink($userId, $token, $newUser['login'], 'displayLink');
    return $userId;
    //header('location: '.ROOT_URL.'/account/activate/'.$userId);
  }
  
  private function setUserSession(array $connectedUser) {
    $_SESSION['user']['id'] = $connectedUser['id'];
    $_SESSION['user']['login'] = $connectedUser['login'];
    $_SESSION['user']['name'] = $connectedUser['name'];
    $_SESSION['user']['active'] = $connectedUser['active'];
  }
  
  public function register() {
    $newUser = [];
    if (isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['password'])  && !empty($_POST['password'])) {
      if ($_POST['password'] !== $_POST['password-confirm']) {
        $this->flashMessage('le mot de passe et la confirmation ne correspondent pas', 'error');
        header('location: '.ROOT_URL.'/user/register');
        exit;
      }
      if (!filter_var(trim($_POST['login']), FILTER_VALIDATE_EMAIL)) {
        $this->flashMessage('erreur : addresse e-mail non valide!', 'error');
        header('location: '.ROOT_URL.'/user/register');
        exit;
      }
      $newUser['login'] = $_POST['login'];
      $newUser['name'] = (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : $_POST['login'];
      $newUser['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $userManager = new UserManager;
      if (!empty($userManager->findOneByLogin($newUser['login']))) {
        $this->flashMessage('un utilisateur avec l\'adresse e-mail'.$newUser['login'].' existe déjà', 'error');
        $this->render('user', ['userForm' => 'connect', 'formSubmit' => 'login']);
      }
      else {
        $newUserId = $this->createUser($newUser);
        $token = AccountController::generateToken();
        $userManager->update(['token' => $token], $newUserId);
        AccountController::sendActivationLink($newUserId, $token, $newUser['login'], 'displayLink');
        $this->render('user', ['userForm' => 'send-activation-link',
                                'id' => $newUserId, 
                                'message' => 'un lien vous a été envoyé par e-mail pour activer votre compte, si vous ne l\'avez pas reçu, cliquez ici pour le renvoyer']);
      }
    }
    $this->render('user', ['userForm' => 'register', 'inputButton' => 'inscription']);
      
  }
  
  public function sendActivationLink() { //activateAccount 
    $id = 0;
    if (isset($_SESSION['user'])) {
      $id = (int)$_SESSION['user']['id'];
    }
    else {
      $this->flashMessage('connectez-vous à votre compte pour pouvoir l\'activer', 'error');
      header('location: '.ROOT_URL.'/user/connect');
      exit;
    }
    if (isset($_POST['send-method'])) {
      if ((int)$_POST['id'] !== $id) {
        $this->flashMessage('le compte à activer ne correspond pad à l\'utilisateur connecté', 'error');
        unset($_SESSION['user']);
        header('location: '.ROOT_URL.'/user/connect');
        exit;
      }
      $id = (int)$_POST['id'];
      $sendMethod = $_POST['send-method'];
      $userManager = new UserManager;
      $selectedUser = $userManager->findById($id);
      if ($selectedUser) {
        $token = AccountController::generateToken();
        $userManager->update(['token' => $token], $id);
        AccountController::sendActivationLink($id, $token, $selectedUser['login'], $sendMethod);
        $this->flashMessage('un message contenant un lien vient de vous être envoyé, si vous ne l\'avez pas reçu, cliquez ici pour le renvoyer', 'info');
        $this->render('user', ['userForm' => 'send-activation-link',
                                        'id' => $id,
                                        'message' => 'un message contenant un lien vient de vous être envoyé, si vous ne l\'avez pas reçu, cliquez ici pour le renvoyer']);
      }
      else {
        $this->flashMessage('désolé, je ne trouve pas ce compte', 'error');
        header('location: '.ROOT_URL.'/user/register');
      }
    }
    $this->render('user', ['userForm' => 'send-activation-link', 'id' => $id]);
  }
  public function connect() {
    if (isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['password'])  && !empty($_POST['password'])) {
      $login = strip_tags(trim($_POST['login']));
      $password = $_POST['password'];
      $userManager = new UserManager;
      $userToConnect = $userManager->findOneByLogin($login);
      if (!$userToConnect) {
        $this->flashMessage('identifiant ou mot de passe incorrect', 'error');
        header('location: '.ROOT_URL.'/user/connect');
        exit;
      }
      else {
        if (password_verify($password, $userToConnect['password'])) {
          $this->setUserSession($userToConnect);
          if ($userToConnect['active'] === 0) {
            $this->flashMessage('ce compte n\'a pas été activé', 'warning');
            $this->render('user', [
                                  'userForm' => 'send-activation-link',
                                  'message' => 'cliquez pour recevoir le lien d\'activation',
                                  'id' => $userToConnect['id']
                                  ]);
          }
          else {
            $this->render('user', [
                                  'userForm' => 'logout',
                                  'userName' => $userToConnect['name']
                                  ]);
          }
        }
        else {
          $this->flashMessage('identifiant ou mot de passe incorrect','error');
          header('location: '.ROOT_URL.'/user/connect');
          exit;
        }
      }
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
  public function findOneByLogin($login) {
    return (new UserManager)->findOneByLogin($login);
  }
  public function successMessage(string $message) {
    $detail = User::MESSAGES[$message];
    $this->render('user', ['message' => $detail]);
  }
}