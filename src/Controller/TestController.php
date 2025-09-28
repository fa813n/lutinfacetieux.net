<?php
namespace Workshop\Controller;

use Toolbox\Controller\AbstractController;
use Toolbox\Renderer\RenderForm;
use Workshop\Controller\FrameFactory;

class TestController extends GameConstructor {
  private string $entityName = 'grid';
  
  //public function __construct
  public function testForm() {
    /*
    $form = new RenderForm;
    $form->startForm('post', '#');
    $form->addInput('text', 'test', ['placeholder' => 'du texte', 'required' => true], 'entrer du texte', 'valeur');
    $form->addRadio('test', [
                            'val1' => 'valeur 1',
                            'val2' => 'valeur 2',
                            'val3' => 'valeur 3'
                            ],
                    'val2');
    $formCode = $form->displayForm();
    echo($formCode);
    */
    $form = new RenderForm;
    $str = $form->setForm($form->addInput('text', 'test', ['placeholder' => 'du texte', 'required' => true], 'entrer du texte', 'valeur'), 'post', '#');
    echo $str;
  }
  public function gridTest(int $id) {
    var_dump($_POST);
  }
}