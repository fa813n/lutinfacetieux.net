<?php
namespace Toolbox;

class FlashMessage {
  
  static function displayMessage() {
    $error = [];
    if (isset($_SESSION['flashMessage']) && !empty($_SESSION['flashMessage'])) {
      $flashMessage['message'] = $_SESSION['flashMessage']['message'];
      $flashMessage['class'] = $_SESSION['flashMessage']['type'];
      unset($_SESSION['flashMessage']);
    }
    else {
      $flashMessage['message'] = '';
      $flashMessage['class'] = 'no-message';
    }
    return($flashMessage);
  }
}