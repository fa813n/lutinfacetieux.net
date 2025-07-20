<?php
namespace Toolbox;

class ErrorDisplay {
  
  static function displayErrorMessage() {
    $error = [];
    if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
      $error['message'] = $_SESSION['error'];
      $error['class'] = 'display-error-message';
      unset($_SESSION['error']);
    }
    else {
      $error['message'] = '';
      $error['class'] = 'no-message';
    }
    return($error);
  }
}