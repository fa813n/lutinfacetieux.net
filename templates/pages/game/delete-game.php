<h1><?= $id ?></h1>
<form method="post" action="<?= ROOT_URL ?>/game/deleteGame/<?= $id ?>">
  <label for="delete">Voulez-vous vraiment supprimer cette énigme?</label>
  <input type="submit" id="delete" name="delete" value="confirmer">
</form>