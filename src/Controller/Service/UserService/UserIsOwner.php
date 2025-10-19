<?php
namespace Workshop\Controller\Service\UserService;

use Workshop\Controller\Element\AbstractElement;
use Workshop\Controller\Service\UserService\UserStatus;
use Workshop\Controller\Element\Element;

class UserIsOwner extends UserStatus {
  //private Element $element
  private int $userId;
  public function __construct(int $userId) {
    $this->userId = $userId;
  }
  public function check(AbstractElement $element) {
      //
    if ($element->getOwner() != $this->userId) {
      echo 'user is not owner';
      return false;
    }
    $element->setUserStatus('owner');
    parent::check($element);
  }
}