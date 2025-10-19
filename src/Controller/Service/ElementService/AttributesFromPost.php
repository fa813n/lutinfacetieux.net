<?php
namespace Workshop\Controller\Service\ElementService;
use Workshop\Controller\Service\ElementService\ElementAttributes;

class AttributesFromPost extends ElementAttributes{
  //
  public function get(string $type, int|array|null $id): ?array {
    //
    if ($_POST /*&& $_POST[$type]*/) {
      //var_dump($_POST);
      $attributes = [];
      foreach ($_POST as $key => $value) {
        $attributes[$key] = htmlspecialchars($value); 
      }
      return $attributes;
    }
    else {
      return parent::get($type, $id);
    }
  }
}