<?php
namespace Toolbox\Controller;

use Workshop\Entity\User;

class AccountController {
  
  
  static function generateToken() {
    $token = md5(microtime(TRUE)*100000);
    return $token;
  }
  
  function sendActivationLink(string $token, int $userId, string $sendFunction = 'email'):void {
    $link = "https://lutinfacetieux.net/account/activate/$userId/$token";
    $message = "Pour acriver votre compte, cliquez sur <a href=\"$link\">le lien suivant.</a> Si lelien direct ne marche pas, copier-coller ceci dans la barre de recherche du navigateur : $link . À très bientôt!";
    $this->$sendFunction($userId, $message);
  }
  private function email($userId, $message) {
    
  }
  private function displayLink($userId, $message) {
    
  }
  /*
  private function sendSms ($userId, $message) {
    
  }
  */
  
  function activateAccount() {
    //check token
  }

  public static function activate(int $id, string $token) {
    $user = new UserManager;
    $selectedUser = $user->findById($id);
    if (!$selectedUser) {
      $_SESSION['error'] = 'Il n\'y a pas de compte à ce nom';
    }
    else {
      if ($selectedUser['activated'] ==1) {
        $_SESSION['error'] = 'Le compte est déjà actif';
      }
      else if ($selectedUser['controlKey'] == $controlKey) {
        $newUser = $user->hydrate($selectedUser);
        $newUser->setActivated(1)->update();
      }
      else {
        $_SESSION['error'] = 'la clé de contrôle est absente ou ne correspond pas, cliquer pour (r)envoyer un lien d\'activation';
        self::render('sendRegisterMail',['user' => $selectedUser['login']]);
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