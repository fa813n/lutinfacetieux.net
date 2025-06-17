<?php
namespace Toolbox\Controller;
abstract class AbstractController {
  /**
   * @param $file fichier contenant le html specifique à la page demandée
   * @param $data données générées par le controlleur
   * @param $template le template choisi (ex: calendrier utilisateur sans menu)
   */
  public function render(/*string $file, */array $data = [], string $template = 'main/home.php') {
    
    $error = $this->displayErrorMessage();
    $data['errorMessage'] = $error['message'];
    $data['errorClass'] = $error['class'];
    
    extract($data);
    
    ob_start();
    require_once('templates/'.$templatePath'.php');
    $content = ob_get_clean();
    require_once('templates/layout.php');
  }
  
  private function displayErrorMessage() {
    $error = [];
    if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
      $error['message'] = $_SESSION['error'];
      $error['class'] = 'display-error-message';
      unset($_SESSION['error']);
    }
    else {
      $error['class'] = 'no-message';
    }
    return($error);
  }
  
  public function setSession(string $content) {
    foreach ($this as $key => $value) {
      $_SESSION[$content][$key] = $value;
   }
  }
 
 /**
  * vérifie si un utilisateur est connecté et si oui, ses droits sur un calendrier (propriétaire, destinataire, ou interdit)
  * @param owner_id id çréateur du calendrier
  * @param receiver_id du destinataire du calendrier
  * @return $userRight array avec le status (connecté ou pas) et ses droits sur le calendrie4 courant
  */ 
  public function checkUserRights(int $owner_id , int $receiver_id) {
    echo('<p style="color:orange">own: '.$owner_id.' rec: '.$receiver_id.'</p>');
    $userRight = [];
    /*
    if (empty($owner_id)) {
      $owner_id = $_SESSION['calendar']['owner_id'] ?? 0;
    }
    if (empty($receiver_id)) {
      $receiver_id = $_SESSION['calendar']['receiver_id'] ?? 0;
    }
    */

    if ((isset($_SESSION['user'])) && !empty($_SESSION['user'])) {
      $userRight['status'] = 'connected';
       
       // l'utilisateur est le propriétaire du calendrier ou le calendrier est en cours de création
      if ($_SESSION['user']['id'] == $owner_id || $_SESSION['calendar']['id'] == 0) {
        $userRight['role'] = 'owner';
      }
      
      // l'utilisateur est le destinataire du calendrier ou le calendrier est public
      else if ($_SESSION['user']['id'] == $receiver_id || $receiver_id == 0) {
        $userRight['role'] = 'receiver';
      }
      
      else {
        $userRight['role'] = 'forbidden';
      }
     }
     
     else {
       $userRight['status'] = 'unconnected';
       // uti%isateur non connecté, calendrier en cours de créatuon 
      if (isset($_SESSION['calendar']) && $_SESSION['calendar']['id'] == 0) {
      $userRight['role'] = 'owner';
      }
      //utilisateur non connecté, calendrier oublic
      else if ($receiver_id == 0) {
      $userRight['role'] = 'receiver';
      }
      else {
      $userRight['role'] = 'forbidden';
      }
     }
     //print_r($_SESSION['calendar']['id'].'<br>'.$receiver_id.'<br>'.$owner_id);
     echo('<p style="color:pink">owner : ');
     print_r($owner_id);
     echo('receiver: ');
     print_r($receiver_id);
     echo('</p>');
    return $userRight;
  }
 
   /**
    * genere une clé de validation pour l'inscription d'un nouvel utilisateur
    * @return $controlKey
    */
   protected function generateControlKey() {
    $controlKey = md5(microtime(TRUE)*100000);
    return $controlKey;
 }
   
   protected function sendActivationLink($login, $emailContent, $pageLink = 'User/Activation') {
     
   }
}