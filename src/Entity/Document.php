<?php
namespace Workshop\Entity;
use Toolbox\Controller\AbstractController;

abstract class Document extends AbstractController {
  
  protected string $type; //grid or cell
  protected array $attributes;
  protected $identifier;
  
  abstract public function setIdentifier();
  
  abstract public function create($attributes);
  
  public function getAttributesFromPost(){
    //
    //if ($_POST && $_POST[$this->type]) {
      //return $_POST[$this->type];
    // }
    //return null;
    return $_POST;
  }
  public function getAttributesFromSession() {
    $identifier = $this->setIdentifier();
    //if ($_SESSION && $_SESSION[$this->type][$identifier])
    echo 'type : '.$this->type.' id: ';
    var_dump($this->identifier);
    return $_SESSION[$this->type][$identifier] ?: null;
  }
  public function getAttributesFromDatabase() {
    //
    //$documentModel = new DocumentModel;
    return null;
  }
  public function getAttributes() {
    //
    return null;
  }
  public function setSession(array $attributes):void {
    $_SESSION[$this->type][$this->identifier] = $attributes;
  }
  public function display() {
    //var_dump($_POST);
    $attributes = $this->getAttributesFromPost() ?: $this->getAttributesFromSession() ?: $this->getAttributesFromDatabase() ?: null;
    if ($attributes) {
      $entity = $this->create($attributes);
      //$entity->checkRights
      $this->setSession($attributes);
      return $entity->generate();
    }
    else {
      $this->flashMessage('Objet non trouvé', 'error');
      header('location: '.ROOT_URL.'/game');
    }
  }
}