<ul>Exemples
<?php
if (isset($publicGames) && !empty($publicGames)):
  foreach ($publicGames as $game): ?>
  <li><a href="<?= ROOT_URL ?>/game/displayGame/<?= $game[
  'id'
] ?>">jeu <?= $game['id'] ?></a></li>
<?php endforeach; ?>
</ul>
<?php
endif;
if (isset($privateGames) && !empty($privateGames)): ?><ul>Mes Énigmes
<?php foreach ($privateGames as $game):
  //var_dump($game); ?>
  <li><a href="<?= ROOT_URL ?>/game/displayGame/<?= $game['id'] ?>">jeu <?= $game['id'] ?></a></li>
<?php
endforeach; ?>
</ul>
<?php endif;
if (isset($currentGame) & !empty($currentGame)): ?>
<ul>
  <li><a href="<?= ROOT_URL ?>/game/displayGame/<?= $currentGame[
  'id'
] ?>">En cours de création</a></li>
</ul>
<?php endif;
 ?>
