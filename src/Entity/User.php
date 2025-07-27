<?php
namespace Workshop\Entity;

use Toolbox\Controller\AbstractController;
use Workshop\Manager\UserManager;
class User extends AbstractController {
  
  private ?int $id;
  private ?string $login;
  private ?string $password;
  private ?string $name;
  private ?string $token;
  private ?bool $active;
  
  const MESSAGES = ['accountActivated' => 'Votre compte a été activé avec succès, vous pouvez maintenant sauvegrder vos créations'];

  public function getId(): ?id {
    return $this->id;
  }
  public function setLogin(string $login) {
    $this->login = $login;
    return $this;
  }
  public function getLogin(): ?string {
    return $this->login;
  }
    public function setPassword(string $password) {
    $this->password = $password;
    return $this;
  }
  public function getPassword(): ?string {
    return $this->password;
  }
  public function setName(string $name) {
    $this->name = $name;
    return $this;
  }
  public function getName(): ?string {
    return $this->name;
  }
  public function setToken(string $token) {
    $this->token = $token;
    return $this;
  }
  public function getToken(): ?string {
    return $this->token;
  }
  public function setActive(int $active) {
    $this->active = $active;
    return $this;
  }
  public function getActive(): ?int {
    return $this->active;
  }
  public function setSession() {
    foreach ($this as $key => $value) {
      $_SESSION['user'][$key] = $value;
    }
  }
 /* 
  public function hydrate() {
    foreach ($this as $key => $value) {
      $setter = 'set'.ucfirst($key);
      if (method_exists($this, $setter)) {
        $this->$setter($value);
      }
    }
    return $this;
  }
  */

  /*
  public function register() {
    if (isset($_POST['login']) && !empty($_POST['login'])) {
      echo ('login');
      var_dump($_POST);
    }
    
    $this->render('user', ['userForm' => 'register']);
    
    echo('coucou');
  }
  */
  
  
  public function register() {
        // On vérifie si le formulaire est valide
        if (isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['password'])  && !empty($_POST['password'])) {
          if ($_POST['password-confirm'] !== $_POST['password']) {
            echo('les deux mots de passe sont différents');
          }
          var_dump($_POST);
            // Le formulaire est valide
            // On "nettoie" l'adresse email
            
            $email = strip_tags($_POST['login']);

            // On chiffre le mot de passe
            $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // On hydrate l'utilisateur
            $userManagee = new UserManager;
            
            if (!empty($userManager->findOneByLogin($email))) {
              $_SESSION['error'] = 'un utilisateur avec l\'adresse e-mail'.$email.' existe déjà';
              $this->render('connexion', ['formSubmit' => 'login']);
            }
            else {
              $sendToken = $userManger->generateControlKey();
              $user->setLogin($email)
                ->setPassword($pass)
                ->setActivated(0)
                ->setControlKey($controlKey)
            ;

            // On stocke l'utilisateur
            $user->create();
            $message = 'cliquez sur le lien suivant: <br><a href="'.SITE_ROOT.'/User/activation/'.urlencode($email).'/'.urlencode($controlKey).'">Lien d\'activation ('.SITE_ROOT.'/User/activation/'.urlencode($email).'/'.urlencode($controlKey).')</a><br> ou copiez le dans la barre de navigation pour activer votre compte.';
            mail($email, 'confirmez votre inscription à l\'atelier du Lutin Facétieux', $message, 'de: lutinfacetieux@lutinfacetieux.net');
            echo $message;
            }
        }

        $this->render('user', ['userForm' => 'register', 'inputButton' => 'inscription']);
    }
    
    
}