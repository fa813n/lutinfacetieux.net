<?php
namespace Workshop\Entity;

use Workshop\Entity\Document;
use Workshop\Controller\CalendarController;
use Workshop\Controller\GridInterface;

class Grid extends Document {
  //private string $template;
  protected int $id;
  
  public function __construct($id) {
    $this->id = $id;
    $this->type = 'grid';
    $this->identifier = $this->setIdentifier();
  }
  public function setIdentifier() {
    return $this->id;
  }
  
  public function create($attributes): GridInterface {
    //$attributes = $this->attributes;
    switch ($attributes['frame']) {
      case 'set' :
        return new SetController($attributes);
        break;
        
      case 'board' :
        return new BoardController($attributes);
        break;
        
      case 'calendar' :
        return new CalendarController($attributes);
        break; 
      /*
      case 'enigma' :
        return new enigmaController($attributes);
        */
    }
  }
  public function generate($attributes) {
    $grid = $this->create($attributes);
  }
}