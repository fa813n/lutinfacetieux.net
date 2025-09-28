<?php
namespace Workshop\Controller;

use Workshop\Controller\FrameInterface;
use Workshop\Entity\Calendar;

class CalendarController implements GridInterface {
  //private Calendar $calendar;
  //
  //protected int $id = 0;
  private string $startDate = '';
  private string $endDate ='';
  private ?int $grid = null;
  
  public function __construct(array $params) {
    $this->startDate = $params['startDate'] ?: '';
    $this->endDate = $params['endDate'] ?: '';
    $this->grid = (int)$params['id'];
  }
  
  
  public function displayGrid() {
    echo 'ce calendrier commence le '.$this->startDate.' et fini le '.$this->endDate;
  }
}