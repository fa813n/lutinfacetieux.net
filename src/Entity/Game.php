<?php
namespace Workshop\Entity;

use Workshop\Entity\Entity;

class Game { //extends Entity
  private ?int $id;
  private ?int $grid;
  private ?int $cell;
  //private ?string $chosenGame;
  private ?string $content;

  const INDEX_CONTENT = ["include" => "menu"];
  const SCRIPTS = [
    "data",
    "encodeMessage",
    "main",
    "games/Flags",
    "games/LettersToSymbols",
    "games/Memory",
    "games/ScrollImages",
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
  public function getId(): ?id {
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

  /*
  public function getChosenGame(): string
  {
    return $this->chosenGame;
  }
  public function setChosenGame(string $chosengame): self
  {
    $this->chosenGame = $chosenGame;
    return $this;
  }
  */

  public function getContent(): string {
    return $this->content;
  }
  public function setContent(string $content): self {
    $this->content = $content;
    return $this;
  }
}
