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
    /*$indexContent = $this->indexContent ?? [];
    print_r($indexContent);*/
    //$entity = str_replace('Controller', '', ge)
    $classNameParts = explode('\\', get_class($this));
    $entityName = str_replace('Controller','',(end($classNameParts)));
    $entity = '\Workshop\\Entity\\'.$entityName;
    $page = lcfirst($entityName);
    $indexContent = defined($entity.'::INDEX_CONTENT') ? $entity::INDEX_CONTENT : ['include' => ''];
    //$indexContent = [];
    //print_r($entity);
    $this->render($page, $indexContent);
    //print_r($indexContent);
    //print_r($this->indexContent);
  }
}