<?php
namespace Workshop\Controller;

use Workshop\Controller\{SetController, BoardController, CalendarController};

class FrameFactory {
  public function createFrame(array $gridContent) {
    switch ($gridContent['frame']) {
      case 'set' :
        return new SetController;
        break;
        
      case 'board' :
        return new BoardController;
        break;
        
      case 'set' :
        return new CalendarController;
        break;  
    }
  }
}