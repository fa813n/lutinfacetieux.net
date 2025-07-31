<?php
namespace Workshop\Entity;

class Entity {
  public function hydrate(array $data):self {
    foreach ($data as $key => $value) {
      $setter = 'set'.ucfirst($key);
      if (method_exists($this, $setter)) {
        $this->$setter($value);
      }
    }
    return $this;
  }
}