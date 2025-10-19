<?php
namespace Workshop\Controller\Service\UserService;

use Workshop\Controller\Service\UserService\UserStatus;

class UserIsConnected extends UserStatus {
  public function check() {
    if (!$_SESSION['user']) {
      $this->flashMessage('connectez-vous pour continuer');
      header('location: '.ROOT_URL.'/user/connect');
      return false;
    }
    return true;
  }
}