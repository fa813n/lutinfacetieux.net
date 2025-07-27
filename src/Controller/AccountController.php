<?php
namespace Workshop\Controller;

use Workshop\Entity\User;
use Workshop\Manager\UserManager;

class AccountController {
  
  
  static function generateToken() {
    $token = md5(microtime(TRUE)*100000);
    return $token;
  }
  
  static function sendActivationLink(int $userId, string $token, string $sendFunction = 'email'):void {
    //$token = self::generateToken();
    $link = ROOT_URL."/account/activate/$userId/$token";
    $message = "Pour acriver votre compte, cliquez sur <a href=\"$link\">le lien suivant.</a> Si lelien direct ne marche pas, copier-coller ceci dans la barre de recherche du navigateur : $link . À très bientôt!";
    self::$sendFunction($userId, $message);
  }
  private static function email($userId, $message) {
    
  }
  private static function displayLink($userId, $message) {
    echo($message);
  }
  /*
  private function sendSms ($userId, $message) {
    
  }
  */

  public static function activate(int $id, string $token) {
    $user = new UserManager;
    $selectedUser = $user->findById($id);
    if (!$selectedUser) {
      $_SESSION['error'] = 'Il n\'y a pas de compte à ce nom';
      header('location: '.ROOT_URL.'/user/register');
    }
    else {
      if ($selectedUser['active'] == 1) {
        $_SESSION['error'] = 'Le compte est déjà actif';
        header('location: '.ROOT_URL.'/user/login');
      }
      else if ($selectedUser['token'] == $token) {
        //$newUser = $user->hydrate($selectedUser);
        $user->update(['active' => 1], $id);
        header('location: '.ROOT_URL.'/user/successMessage/accountActivated');
      }
      else {
        $_SESSION['error'] = 'la clé de contrôle est absente ou ne correspond pas, cliquer pour (r)envoyer un lien d\'activation';
        header('location: '.ROOT_URL.'/user/sendActivationLink/'.$id);
      }
    }
  }
  public static function setNewPassword(int $userId, string $controlKey) {
    $userModel = new UserModel;
    $foundUser = $userModel->findById($userId);
    if (!$foundUser) {
      $_SESSION['error'] = 'utilisateur inconnu';
      header('location :'.SITE_ROOT.'/User/index');
    }
    else {
      $user = $userModel->hydrate($foundUser);
    }
    if ($foundUser['controlKey'] == $controlKey) {
      if (isset ($_POST['newPassword'])) {
        $user->setPassword(password_hash($_POST['userPassword'], PASSWORD_DEFAULT))->update();
      }
    }
    else {
      $_SESSION['error'] = 'la clé de contrôle ne correspond pas au compte utilisateur';
      header('location :'.SITE_ROOT.'/User/index');
    }
  }
}