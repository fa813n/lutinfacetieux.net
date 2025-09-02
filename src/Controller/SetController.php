<?php
namespace Workshop\Controller;

use Workshop\Controller\FrameInterface;

class SetController implements FrameInterface {
  public function generateGrid($numberOfCells) {
    echo 'il y a '.$numberOfCells.' énigmes dans ce jeu';
  }
}