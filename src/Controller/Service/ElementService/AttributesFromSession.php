<?php
namespace Workshop\Controller\Service\ElementService;
use Workshop\Controller\Service\ElementService\ElementAttributes;

class AttributesFromSession extends ElementAttributes{
  //
  public function get(string $type, int|array|null $id): ?array {
    if (isset($_SESSION[$type][$id]) && !empty($_SESSION[$type][$id])) {
      $attributes = [];
      foreach ($_SESSION[$type][$id] as $key => $value) {
        $attributes[$key] = ($value); 
      }
      //var_dump($attributes);
      return $attributes;
    }
    else {
      return parent::get($type, $id);
    }
  }
}