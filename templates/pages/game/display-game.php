<?php
require_once(ROOT.'/templates/pages/game/_game-display.html');
if ($userRights === 'owner') {
  include_once(ROOT.'/templates/pages/game/_game-manage.html');
}