<?php
namespace Workshop\Controller\Element;

use Workshop\Controller\Element\GridInterface;
//use Workshop\Entity\Calendar;

class Calendar implements GridInterface {
  //private Calendar $calendar;
  //
  //private int $id = 0;
  private string $startDate = '';
  private string $endDate ='';
  private ?int $grid = null;
  private string $title = '';
  
  public function __construct(array $params) {
    $this->startDate = $params['startDate'] ?: '';
    $this->endDate = $params['endDate'] ?: 'end';
    $this->grid = (int)$params['id'];
    $this->title = $params['title'] ?: 'un titre';
  }
  public function generateContent() {
    return ['startDate' => $this->startDate, 'endDate' => $this->endDate, 'title' => $this->title, 'id' => $this->id];
  }
}