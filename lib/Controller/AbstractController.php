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
    $indexContent = $this->indexContent ?? [];
    print_r($indexContent);
    $classNameParts = explode('\\', get_class($this));
    $page = str_replace('Controller','',(lcfirst(end($classNameParts))));
    $this->render($page, $indexContent);
    //print_r($indexContent);
    print_r($this->indexContent);
  }
}