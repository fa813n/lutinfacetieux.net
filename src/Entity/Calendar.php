<?php
namespace Workshop\Entity;

use Toolbox\Controller\AbstractController;


class Calendar extends AbstractController {
  /*
  public function index() {
    echo '<h4>Calendar Index</h4>';
  }
  */
  
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