<?php
namespace Workshop\Entity;

use Workshop\Entity\Entity;

class Game { //extends Entity
  private ?int $id;
  private ?int $grid;
  private ?int $cell;
  //private ?string $chosenGame;
  private ?string $content;
  private ?int $owner;
  private ?int $receiver;

  const INDEX_CONTENT = ["include" => "menu"];
  /*
  const SCRIPTS = [
    "data",
    "encodeMessage",
    "main",
    "games/Flags",
    "games/LettersToSymbols",
    "games/Memory",
    "games/ScrollImages",
  ];
  */
  
  const MAIN_SCRIPTS = ['data', 'encodeMessage', 'main', 'Symbol'];
  const GAME_SCRIPTS = [
    'flags' => 'games/Flags',
    'letters-to-symbols' => 'games/LettersToSymbols',
    'memory' => 'games/Memory',
    'scroll-images' => 'games/ScrollImages',
    'dobble' => 'games/Dobble',
  ];

  /*
  public function __construct($grid, $cellNuber) {
    foreach ($this as $key => $value) {
      $propertyValue = $_POST['game'][$gridId][$cellNuber][$key] ?? $_SESSION['game'][$gridId][$cellNuber][$key] ?? $value;
      $this->$key = $value;
    }
    echo '<p style=color:pink">game constructor : '.var_dump($this).'</p>';
  }
  */
  public function getId(): int {
    return $this->id;
  }

  public function getGrid(): int {
    return $this->grid;
  }
  public function setGrid(int $grid): self {
    $this->grid = $grid;
    return $this;
  }

  public function getCell(): int {
    return $this->cell;
  }
  public function setCell(int $cell): self {
    $this->cell = $cell;
    return $this;
  }


  public function getContent(): string {
    return $this->content;
  }
  public function setContent(string $content): self {
    $this->content = $content;
    return $this;
  }
  
  public function getOwner():int {
    return $this->owner;
  }
  public function setOwner(int $owner):self {
    $this->owner = $owner;
    return $this;
  }
  
  public function getReceiver():int {
    return $this->receiver;
  }
  public function setReceiver(int $receiver):self {
    $this->receiver = $receiver;
    return $this;
  }
}
