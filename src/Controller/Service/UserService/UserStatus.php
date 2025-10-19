<?php
namespace Workshop\Controller\Service\UserService;

use Workshop\Controller\Element\AbstractElement;

abstract class UserStatus {
  private ?UserStatus $nextStep = null;
  
  public function check(AbstractElement $element) {
    if ($this->nextStep) {
      $this->nextStep->check($element);
    }
  }
  public function setNext(UserStatus $nextStep):self {
    $this->nextStep = $nextStep;
    return $this;
  }
}