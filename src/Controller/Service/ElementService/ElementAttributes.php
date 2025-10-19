<?php
namespace Workshop\Controller\Service\ElementService;

abstract class ElementAttributes {
  private ?ElementAttributes $nextStep;
  
  public function setNext(ElementAttributes $nextStep): ElementAttributes {
    $this->nextStep = $nextStep;
    return $nextStep;
  }
  public function get(string $type, int|array|null $id): ?array {
    if (isset($this->nextStep)) {
      return $this->nextStep->get($type, $id);
    }
    return null;
  }
}