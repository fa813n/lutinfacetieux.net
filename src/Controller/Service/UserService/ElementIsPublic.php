<?php
namespace Workshop\Controller\Service\UserService;

use Workshop\Controller\Service\UserService\UserStatus;
use Workshop\Controller\Element\Element;
use Workshop\Controller\Element\AbstractElement;

class ElementIsPublic extends UserStatus {
  
  public function check(AbstractElement $element) {
    if ($element->getReceiver() != 0) {
      echo 'element is not public';
      return false;
    }
    $element->setUserStatus('receiver');
    parent::check($element);
  }
}