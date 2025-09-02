<?php
namespace Workshop\Manager;
use Toolbox\Manager\AbstractManager;
use Workshop\Entity\Game;

class GameManager extends AbstractManager {
  public function __construct() {
    $this->table = 'games';
  }
  public function createGame(Game $game):int {
    $this->create([
                    'grid' => $game->getGrid(),
                    'cell' => $game->getCell(),
                    'content' => $game->getContent(),
                    'owner' => $game->getOwner(),
                    'receiver' => $game->getReceiver()
                    ]);
    $newId = $this->getNewId();
    return $newId;
  }
  public function updateGame(Game $game):void {
    $this->update([
                  'grid' => $game->getGrid(),
                  'cell' => $game->getCell,
                  'content' => $game->getContent(),
                  'user' => $game->getUser(),
                  'receiver' => $game->getReceiver()
                  ],
                  $game->getId());
  }
  
}