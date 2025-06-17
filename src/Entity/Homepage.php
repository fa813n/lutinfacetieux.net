<?php
namespace Workshop\Entity;

class Homepage /*extends AbstractController*/ {
  public function index() {
    /*
    $this->render('homepage',['title' => 'Lutin facétieux'],'default');
    */
    
    echo'<h3>This is the homepage, and we are here</h3>'. __DIR__;
  }
}