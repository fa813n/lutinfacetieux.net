<?php
namespace Workshop\Entity;


class Calendar {
  public function index() {
    echo '<h4>Calendar Index</h4>';
  }
  public function something($var) {
    echo '<h5>Something with '.$var;
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