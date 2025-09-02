<?php
namespace Workshop\Traits
trait UserRights {
  /**
   * @properties array contenant la liste des propriétés de l'objet sur lequel on souhaite connaître les droits utilisateur
   * @return $status une chaine de caractères indiquant le status utilisateur par rapport à l'objet
   */
   /*
   public function checkRights(array $properties):string {
    $userId = $_SESSION['user']['id'] ?? 0;
    $status = '';
    $ownerId = $properties['$ownerId'];
    $receiverId = $properties['receiverId'];
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
  */
  
}