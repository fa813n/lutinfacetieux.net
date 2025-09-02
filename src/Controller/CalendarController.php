<?php
namespace Workshop\Controller;

use Workshop\Controller\FrameInterface;

class CalendarController implements FrameInterface {
  public function generateGrid($startDate, $endDate) {
    echo 'ce calendrier commence le '.$startDate.' et fini le '.$endDate;
  }
}