<h1>User</h1>
<nav>
  <ul>
    <li><a href="<?= ROOT_URL ?>/user/connect">Se connecter</a></li>
    <li><a href="<?= ROOT_URL ?>/user/register">S'inscrire</a></li>
  </ul>
</nav>
<?= $message ?>
<?php
if ($userForm) {
  include_once(ROOT.'/templates/_user-'.$userForm.'-form.html');
  //var_dump($_SESSION);
}
?>
<h3>Bienvenue <?= $_SESSION['user']['name'] ?></h3>
