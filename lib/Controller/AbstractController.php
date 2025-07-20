<?php
namespace Toolbox\Controller;

use Toolbox\ErrorDisplay;

abstract class AbstractController {
  
  /**
   * @param $file fichier contenant le html specifique à la page demandée
   * @param $data données générées par le controlleur
   * @param $template le template choisi (ex: calendrier utilisateur sans menu)
   */

  public function render(string $page, array $data = [], string $template = 'main') {
    
    $data['page'] = ROOT.'/templates/pages/'.$page.'.php';
    $data['errorMessage'] = ErrorDisplay::displayErrorMessage()['message'];
    $data['errorClass'] = ErrorDisplay::displayErrorMessage()['class'];
    
    extract($data);
    
    ob_start();
    require_once(ROOT.'/templates/'.$template.'.php');
    $content = ob_get_clean();
    
    require_once(ROOT.'/templates/layout.php');
  }
  
  public function index (/*array $data = []*/) {
    echo('<p style="color:red">');
    var_dump(get_class($this));
    var_dump(get_called_class());
    echo('</p>');
    $classNameParts = explode('\\', get_class($this));
    $page = str_replace('Controller','',(lcfirst(end($classNameParts))));
    $this->render($page);
  }
}
 

      
