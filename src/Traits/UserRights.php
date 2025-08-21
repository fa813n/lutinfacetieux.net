<?php
namespace Workshop\Traits
trait UserRights {
  public function checkRights(array $properties):string {
    $userId = $_SESSION['user']['id'] ?? 0;
    $status = '';
    $ownerId = $properties['$ownerId'];
    $receiverId = $properties['receiverId'];
    if (($userId === $ownerId) || ($ownerId === 0) {
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