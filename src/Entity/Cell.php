<?php
namespace Workshop\Entity;

use Workshop\Entity\Document;

class Cell extends Document {
  //private string $template;
  private int $grid;
  private int $cellNumber;
  
  public function __construct($grid, $number) {
    $this->grid = $grid;
    $this->number = $number;
    $this->type = 'cell';
  }
  public function setIdentifier() {
    return $this->grid.'['.$this->cellNumber.']';
  }
  /*
  public function getFromPost() {
    //
  }
  public function getFromSession() {
    //
  }
  public function getFromDatabase() {
    //
  }
  */
  
}