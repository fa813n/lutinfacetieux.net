<?php
namespace Workshop\Controller;

use Workshop\Controller\FrameInterface;

class BoardController implements FrameInterface {
  public function generateGrid() {
    $numberOfCells = $_POST['numberOfCells'];
    echo 'il y a '.$numberOfCells.' cases sur ce plateau';
  }
}