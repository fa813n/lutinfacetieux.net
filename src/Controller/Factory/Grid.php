<?php
namespace Workshop\Controller\Factory;

use Workshop\Controller\Element\AbstractElement;
use Workshop\Controller\Element\{Calendar, Set, Board};
use Workshop\Controller\Element\GridInterface;

class Grid extends AbstractElement {
  //private string $template;
  protected ?int $id;
  protected ?int $owner;
  protected ?int $receiver;
  //protected ?array $attributes;
  
  public function __construct($id) {
    //parent::__construct();
    $this->id = $id;
    $this->type = 'grid';
    $this->attributes = $this->getAttributes();
    //var_dump($_SESSION);
    //var_dump($this->attributes);
    //$this->identifier = $this->setIdentifier();
    //$this->owner = 
    //echo '<h2>grid</h2>';
  }
  public function getIdentifier():int {
    return $this->id;
  }
  public function getOwner():?int {
    if ($this->attributes) {
      return (int)$this->attributes['owner'] ?? null;
    }
    return null;
  }
  public function getReceiver():?int {
    if ($this->attributes) {
      return (int)$this->attributes['receiver'] ?? null;
    }
    return null;
  }
  
  public function create(/*$attributes*/): GridInterface {
    switch ($this->attributes['frame']) {
      case 'set' :
        return new Set($this->attributes);
        break;
        
      case 'board' :
        return new Board($this->attributes);
        break;
        
      case 'calendar' :
        return new Calendar($this->attributes);
        break; 
      /*
      case 'enigma' :
        return new enigmaController($attributes);
        */
    }
  }
}