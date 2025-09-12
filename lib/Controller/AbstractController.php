<?php
namespace Toolbox\Controller;

use Toolbox\ErrorDisplay;
use Toolbox\FlashMessage;
use Workshop\Traits\UserRights;

abstract class AbstractController {
  
  private function getEntityName():string {
    $classNameParts = explode('\\', get_class($this));
    $entityName = str_replace('Controller','',(end($classNameParts)));
    return(lcfirst($entityName));
  }
  /**
   * @param $file fichier contenant le html specifique à la page demandée
   * @param $data données générées par le controlleur
   * @param $template le template choisi 
   */
  public function render(string $page, array $data = [], string $template = 'main') {
    $folder = $data['folder'] ?? $this->getEntityName();
    $data['page'] = ROOT.'/templates/pages/'.$folder.'/'.$page.'.php';
    /*$data['errorMessage'] = ErrorDisplay::displayErrorMessage()['message'];
    $data['errorClass'] = ErrorDisplay::displayErrorMessage()['class'];
    */
    $data['flashMessage'] = FlashMessage::displayMessage();
    
    extract($data);
    
    ob_start();
    require_once(ROOT.'/templates/'.$template.'.php');
    $content = ob_get_clean();
    
    require_once(ROOT.'/templates/layout.php');
  }
  /**
   * génère une vue en fonction du nom de la rubrique
   */
  public function index () {
    $page = $this->getEntityName();
    $entityName = ucfirst($page);
    $entity = '\Workshop\\Entity\\'.$entityName;
    $indexContent = defined($entity.'::INDEX_CONTENT') ? $entity::INDEX_CONTENT : ['include' => ''];
    
    $this->render($page, $indexContent);
  }
  public function hydrate(object $obj, array $data):void {
    foreach ($data as $key => $value) {
      $setter = 'set'.ucfirst($key);
      if (method_exists($obj, $setter)) {
        $obj->$setter($value);
      }
    }
  }
  
  public function checkRights(array $properties):string {
    $userId = $_SESSION['user']['id'] ?? 0;
    $status = '';
    $ownerId = $properties['owner'];
    $receiverId = $properties['receiver'];
    if (($userId === $ownerId) || ($ownerId === 0)) {
      $status = 'owner';
    }
    else if (($userId === $receiverId) || $receiverId === 0) {
      $status = 'receiver';
    }
    else {
      $status = 'forbidden';
    }
    return $status;
  }
  
  public function flashMessage(string $message, string $type = 'info'){
    $_SESSION['flashMessage'] = ['message' => $message, 'type' => $type];
  }
  
}