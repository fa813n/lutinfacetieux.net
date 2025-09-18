<?php
namespace Toolbox\Renderer;

class Renderer {
  
  static function render($buffer) {
    return self::createList($buffer);
  }

  static function createList($string) {
    $pattern = '/tentative/';
    $replacement = 'super victoire';
    return preg_replace($pattern, $replacement, $string);
  }
}