<?php
namespace Workshop\Controller\Element;

use Workshop\Controller\Element\Element;

interface GridInterface extends Element {
  public function generateContent();
}