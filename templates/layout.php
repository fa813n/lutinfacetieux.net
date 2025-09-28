<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--<meta http-equiv="X-UA-Compatible" content="ie=edge">-->
  <title><?= $title ?? 'lutin facétieux, créateur d\'énigmes' ?></title>
  <!-- Minified version
<link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">

Un-Minified version 
<link rel="stylesheet" href="https://cdn.simplecss.org/simple.css">
-->
  <link rel="stylesheet" href="<?= ROOT_URL ?>/public/css/workshop.css">
  
  <link rel="stylesheet" href="<?= ROOT_URL ?>/public/css/games.css">
  <?php 
  
  if (isset($scripts) && !empty($scripts)) {
    foreach ($scripts as $script) {
      echo('<script src="'.ROOT_URL.'/public/scripts/'.$script.'.js" defer></script>');
    }
  }
  
  ?>
  
</head>
<body>
  <main>
  
  <?= $content ?>
 
  
    <?php
    echo '<section style="border: 1px solid gold"> Session<br>';
    var_dump($_SESSION);
    echo '<button onclick="sessionStorage.clean()">unset</button></section>';
  ?>
  
  
  </main>
</body>
</html> 