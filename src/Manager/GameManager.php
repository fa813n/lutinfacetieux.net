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
  public function getPublicList():array {
    $publicList = [];
    $publicGames = $this->findBy(['receiver' => 0]);
    foreach ($publicGames as $publicGame) {
      $id = $publicGame['id'];
      $publicList[$id] = $publicGame;
    }
    return $publicList;
  }
  public function getPrivateList(int $ownerId):array {
    $privateList = [];
    $privateGames = $this->findBy(['owner' => $ownerId]);
    foreach ($privateGames as $privateGame) {
      $id = $privateGame['id'];
      $privateList[$id] = $privateGame;
    }
    return $privateList;
  }
  public function countGames(int $owner):int {
    return count($this->findBy(['owner' => $owner]));
  }
  
}