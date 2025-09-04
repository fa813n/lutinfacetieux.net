<ul>Exemples
<?php
foreach ($publicGames as $game) {
?>
  <li><a href="<?= ROOT_URL ?>/game/displayGame/<?= $game['id'] ?>">jeu <?= $game['id'] ?></a></li>
<?php
}
?>
</ul>
<ul>Mes Énigmes
<?php
foreach ($privateGames as $game) {
?>
  <li><a href="<?= ROOT_URL ?>/game/displayGame/<?= $game['id'] ?>">jeu <?= $game['id'] ?></a></li>
<?php
}
?>
</ul>
<ul>
  <li><a href="<?= ROOT_URL ?>/game/displayGame/<?= $currentGame['id'] ?>">En cours de création</a></li>
</ul>
</ul>