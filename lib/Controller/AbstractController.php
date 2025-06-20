<?php
namespace Toolbox\Controller;
abstract class AbstractController {
  /**
   * @param $file fichier contenant le html specifique à la page demandée
   * @param $data données générées par le controlleur
   * @param $template le template choisi (ex: calendrier utilisateur sans menu)
   */
   
  
  public function render(string $page, array $data = [], string $template = 'main') {
    
    $data['page'] = ROOT.'/templates/pages/'.$page.'.php';
    extract($data);
    
    ob_start();
    require_once(ROOT.'/templates/'.$template.'.php');
    $content = ob_get_clean();
    
    require_once(ROOT.'/templates/layout.php');
    
  }
  public function index (/*array $data = []*/) {
    $classNameParts = explode('\\', get_class($this));
    $page = lcfirst(end($classNameParts));
    $this->render($page);
  }
  
  /*
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
  */
  
}
 

      
