<?php
namespace Workshop\Manager;
use Toolbox\Manager\AbstractManager;
use Workshop\Entity\User;

class UserManager extends AbstractManager {
  //protected $login;
  //protected $password;
  //protected $name;
  //protected $id;
  protected $controlKey;
  protected $activated;
  
  public function __construct() {
    $this->table = 'users';
  }
  public function createUser(User $newUser) {
    return $this->create(['login' => $newUser->getLogin(),
                          'password' => $newUser->getPassword(),
                          'name' => $newUser->getName(),
                          'active' => $newUser->getActive(),
                          'token' => $newUser->getToken()
                          ]);
  }
  
  public function findOneByLogin(string $login) {
    /*
    $selectedUser = $this->findBy(['login' =>  $login]);
    return $selectedUser;
    en procédant ainsi, on obtient un tableau d'utilisateurs avec un seul membre, ça ne marche pqs pour l'utilisation de hydrate()
    */
    return $this->request("SELECT * FROM {$this->table} WHERE login = ?", [$login])->fetch();
  }
  public function activate($id) {
    $this->update(['active' => 1], $id);
  }
  
/**
     * Crée la session de l'utilisateur
     * @return void 
     */
    public function setUserSession()
    {
        $_SESSION['user'] = [
            'id' => $this->id,
            'login' => $this->login,
            'name' => $this->name
        ];
    }
    
    public static function unsetUserSession() {
      unset($_SESSION['user']);
    }

    /**
     * Get the value of id
     */ 
    
  
}