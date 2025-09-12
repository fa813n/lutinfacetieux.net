<?php
namespace Toolbox;

class utils {
  public static function array_extract(array &$array, $key) {
    $offset = array_search($key, array_keys($array));
    //var_dump($offset);
    $extract = array_splice($array, $offset, 1);
    $value = $extract[$key];
    return $value;
  }
}