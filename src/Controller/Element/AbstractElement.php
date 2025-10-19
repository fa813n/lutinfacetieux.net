<?php
namespace Workshop\Controller\Element;
use Toolbox\Controller\AbstractController;
use Workshop\Controller\Service\ElementService\{AttributesFromPost, AttributesFromSession, AttributesFromDatabase};

abstract class AbstractElement extends AbstractController {
  
  protected string $type; //grid or cell
  protected ?array $attributes;
  //protected int|array $identifier;
  protected ?array $userStatus = [];
  
  protected ?int $owner;
  protected ?int $receiver;
  
  abstract public function getIdentifier();
  abstract public function getOwner():?int;
  abstract public function getReceiver():?int;
  
  abstract public function create(/*$attributes*/);
  
  public function setUserStatus(string $userStatus):self {
    $this->userStatus[] = $userStatus;
    return $this;
  }
  public function getUserStatus(): ?array {
    return $this->userStatus;
  }
  public function getAttributes(): array {
    $attributesFromPost = new AttributesFromPost;
    $attributesFromSession = new AttributesFromSession;
    $attributesFromDatabase = new AttributesFromDatabase;
    $attributesFromPost->setNext($attributesFromSession)->setNext($attributesFromDatabase);
    return $attributesFromPost->get($this->type, $this->getIdentifier()) ?? [];
  }
  public function setSession(array $attributes):void {
    $_SESSION[$this->type][$this->getIdentifier()] = $attributes;
  }
  public function getContent() {
    if ($this->attributes) {
      $element = $this->create();
      $this->setSession($this->attributes);
      return $element->generateContent();
    }
  }
  public function save() {
    // userIsConnected->AccountIsActive->userIsOwner
    //new $this->type->save
  }
  public function setOwner($owner):self {
    $this->owner = $owner;
    return $this;
  }
}