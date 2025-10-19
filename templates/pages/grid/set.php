<h2>This grid is entitled <?= $title ?> and its id is <?= $grid ?></h2>
<ul>
<?php
foreach($cells as $key => $value) {
  ?><li>
    cell <a href="<?= ROOT_URL ?>/cell/display/<?= $grid ?>/<?= $key ?>">number <?= $key ?> </a>containing <?= $value ?>
  </li>
  <?php
}
?>
</ul>
<form method="post" action="<?= ROOT_URL ?>/grid/saveGrid/<?= $grid ?>">
  <input type="submit" value="sauvegarder">
</form>
