<?php
namespace Workshop\Controller;

use \Toolbox\Controller\AbstractController;
use \Workshop\Manager\CalendarManager;
use \Workshop\Entity\Calendar;

class CalendarController extends AbstractController {
  private $indexContent = ['content' => 'calendar-menu'];
  //private Calendar $calendar;
  
  private function loadCalendar($id) {
    /*
    new CalendarManager;
    find
    check rights
    set session
    
    */
    
  }
  public function createCalendar() {
    // il s'agit d'u§e création, on met l'id à 0 çe qui créera `une nouvelle entrée quand on fera appel à la fonction saveCalendar
    $_SESSION['calendar']['id'] = 0;
    $this->render('calendar', ['content' => 'calendar-form']);
  }
  public function saveCalendar($id) {
    
  }
  public function deleteCalendar($id) {
    
  }
  public function editCalendar($id) {
    // si on essaie d'acceder via l'url
    if ($id !== $_SESSION['calendar']['id']) {
      $this->loadCalendar($id);
    }
    
  }
  public function displayCalendars() {
    
  }
  public function displayCalendar($id) {
    
  }
}
