<?php
namespace Workshop\Controller\Service\DocumentService;

class CheckUserRights {
  public function checkStatus{
    //connected
  }
  public function checkRights(array $properties):string {
    $userId = $_SESSION['user']['id'] ?? 0;
    $status = '';
    $ownerId = $properties['owner'];
    $receiverId = $properties['receiver'];
    if (($userId === $ownerId) || ($ownerId === 0)) {
      $status = 'owner';
    }
    else if (($userId === $receiverId) || $receiverId === 0) {
      $status = 'receiver';
    }
    else {
      $status = 'forbidden';
    }
    return $status;
  }
}