<?php
namespace Workshop\Entity;

use Toolbox\Controller\AbstractController;


class Calendar extends AbstractController {
  private int $id = 0;
  private string $name;
  private string $startDate;
  private string $endDate;
  private int $ownerId;
  
  public function __construct() {
    foreach ($this as $key => $value) {
      if (isset($_POST['calendar'][$key]) && !empty($_POST['calendar'][$key])) {
        $value = strip_tags($_POST['calendar'][$key]);
        $this->$key = $value;
      }
      else if (isset($_SESSION['calendar'][$key]) && !empty($_SESSION['calendar'][$key])) {
        $value = strip_tags($_SESSION['calendar'][$key]);
        $this->$key = $value;
      }
    }
  }
 
  public function setName(string $name):self {
    $this->name = $name;
  }
  public function getName(): ?string {
    return $this->name;
  }
  
  public function setStartDate(string $startdate):self {
    $this->startdate = $startdate;
  }
  public function getStartDate(): ?string {
    return $this->startdate;
  }
  
  public function setEndDate(string $enddate):self {
    $this->enddate = $enddate;
  }
  public function getEndDate(): ?string {
    return $this->enddate;
  }
  
  public function setOwnerId(string $ownerId):self {
    $this->ownerId = $ownerId;
  }
  public function getOwnerId(): ?string {
    return $this->ownerId;
  }
  
  public function something($var) {
    $this->render('calendar', ['message' => $var]);
  }
  /*
  private ?int $id;
  private ?string name
  private User $owner;
  private User $receiver;
  private Grid $grid;
  
  public function create() {
    // create Calendar
  }
  public function delete() {
    // delete Calendar
  }
  */
}