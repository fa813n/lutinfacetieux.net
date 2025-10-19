<?php
namespace Workshop\Model;

use Toolbox\Model\AbstractModel;

class GridModel extends AbstractModel {
  public function __construct() {
    $this->table = 'grid';
  }
  public function saveGrid($attributes) {
    $this->create($attributes);
  }
}