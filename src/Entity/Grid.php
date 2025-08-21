<?php
namespace Workshop\Entity;


class Grid {
  private int $id = 0;
  private int $owner = 0;
  private int $receiver = 0;
  private ?string $frame //calendar, board, single, set
  private ?string $content;
  
  public function getId(): ?id {
    return $this->id;
  }
  
  public function getFrame():string {
    return $this->frame;
  }
  public function setFrame($frame):self {
    $this->frame = $frame;
    return $this;
  }
  
  public function getContent():string {
    return $this->content;
  }
  public function setContent($content):self {
    $this->content = $content;
    return $this;
  }
  
  public function getOwner():string {
    return $this->owner;
  }
  public function setOwner($owner):self {
    $this->owner = $owner;
    return $this;
  }
  
  public function getReceiver():string {
    return $this->receiver;
  }
  public function setReceiver($receiver):self {
    $this->receiver = $receiver;
    return $this;
  }
}