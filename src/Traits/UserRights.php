<?php
namespace Workshop\Tools
trait UserRights {
  public function checkRights(int $userId, array $object):string {
    $status = '';
    $ownerId = $object['$ownerId'];
    $receiverId = $object['receiverId'];
    if (($userId === $ownerId) || ($ownerId === 0) {
      $status = 'owner';
    }
    else if (($userId === $receiverId) || $receiverId === 0) {
      $status = 'receiver';
    }
    else {
      $status = 'forbidden';
    }
  }
}