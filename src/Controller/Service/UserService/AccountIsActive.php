<?php
namespace Workshop\Controller\Service\UserService;

use Workshop\Controller\Service\UserService\UserStatus;

class AccountIsActive extends UserStatus {
  private int $userId;
  
  public function __construct(int $userId): void {
    $this->userId = $userId;
  }
  public function check(/*Element $element*/) {
    if (/*not active*/) {
      $element->setUserStatus[] = 'inactive';
      return false;
    }
    $element->userStatus[] = 'active';
    return parent::check(/*$element*/)
  }
}