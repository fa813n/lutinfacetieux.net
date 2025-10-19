<?php
namespace Workshop\Controller\Element;

use Workshop\Controller\Element\GridInterface;
//use Workshop\Entity\Calendar;

class Set implements GridInterface {
  private $id;
  private int $setNumberOfCells;
  private $title;
  //private int $grid
  public function __construct(array $params) {
    $this->id = $params['id'];
    $this->setNumberOfCells = $params['set-number-of-cells'];
    $this->title = $params['title'];
  }
  public function generateContent() {
    //
    $content = [];
    $content['grid'] = $this->id;
    $content['title'] = $this->title;
    $content['file'] = 'set';
    $content['cells'] = [];
    for ($i = 0; $i < $this->setNumberOfCells; $i++) {
      //$cell = ['cellNumber' => $i];
      $content['cells'][$i] = 'to be precised';
    }
    return $content;
  }
}