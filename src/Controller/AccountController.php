<?php
namespace Workshop\Controller;

use Workshop\Entity\User;
use Workshop\Manager\UserManager;

class AccountController {
  
  
  static function generateToken() {
    $token = md5(microtime(TRUE)*100000);
    return $token;
  }
  
  public static function sendActivationLink(int $userId, string $token, string $login, string $sendFunction = 'email', ?string $message = null):void {
    //$token = self::generateToken();
    $link = ROOT_URL."/account/activate/$userId/$token";
    if (!$message) {
      $message = "Pour acriver votre compte, cliquez sur <a href=\"$link\">le lien suivant.</a> Si lelien direct ne marche pas, copier-coller ceci dans la barre de recherche du navigateur : $link . À très bientôt!";
    }
    self::$sendFunction($login, $message);
  }
  private static function email($login, $message) {
    mail($login, 'activation de votre compte chez le lutin facetieux', $message);
  }
  private static function displayLink($userId, $message) {
    echo($message);
  }

  public static function activate(int $id, string $token) {
    $user = new UserManager;
    $selectedUser = $user->findById($id);
    if (!$selectedUser) {
      $_SESSION['error'] = 'Il n\'y a pas de compte à ce nom';
      header('location: '.ROOT_URL.'/user/register');
      exit;
    }
    else {
      if ($selectedUser['active'] == 1) {
        $_SESSION['error'] = 'Le compte est déjà actif';
        header('location: '.ROOT_URL.'/user/login');
        exit;
      }
      else if ($selectedUser['token'] == $token) {
        //$newUser = $user->hydrate($selectedUser);
        $user->update(['active' => 1], $id);
        if (isset($_SESSION['user']) && (int)$_SESSION['user']['id'] === $id ) {
          $_SESSION['user']['active'] = 1;
        }
        header('location: '.ROOT_URL.'/user/successMessage/accountActivated');
        exit;
      }
      else {
        $_SESSION['error'] = 'la clé de contrôle est absente ou ne correspond pas, cliquer pour (r)envoyer un lien d\'activation';
        header('location: '.ROOT_URL.'/user/sendActivationLink/'.$id);
        exit;
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