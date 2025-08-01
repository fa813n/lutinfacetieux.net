<?php
namespace Workshop\Entity;

use \Workshop\Entity\Entity;

class Game extends Entity {
  private int $id;
  private int $gridId;
  private string $choosenGme;
  private string $content;  
  
  const INDEX_CONTENT = ['include' => 'menu'];
  const SCRIPTS = ['data', 'encodeMessage', 'main', 'games/Flags', 'games/LettersToSymbols', 'games/Memory', 'games/ScrollImages'];
  //const SCRIPTS = ['test'];
 
 /* 
  public function __construct() {
    foreach ($this as $key => $value) {
      
    }
  }
  */
  
  
}