<?php
namespace Workshop\Controller\Service\UserService;

use Workshop\Controller\Element\AbstractElement;
use Workshop\Controller\Service\UserService\UserStatus;
use Workshop\Controller\Element\Element;

class UserIsReceiver extends UserStatus {
  private int $userId;
  public function __construct(int $userId) {
    $this->userId = $userId;
  }
  public function check(/*AbstractElement*/ $element) {
      //
    if ($element->getReceiver() != $this->userId) {
      echo 'user is not receiver';
      return false;
    }
    $element->setUserStatus('receiver');
    parent::check($element);
  }
}