<?php
namespace Toolbox;

class utils {
  public static function array_extract(array &$array, $key) {
    $offset = array_search($key, array_keys($array));
    //var_dump($offset);
    $extract = array_splice($array, $offset, 1);
    $value = $extract[$key];
    /*
    echo '<br>array: ';
    var_dump($array);
    echo'<br> extract : ';
    var_dump($extract);
    echo '<br>';
    echo'<br>offset : ';
    var_dump($offset);
    echo'<br>key: ';
    var_dump($key);
    echo'<br>value: ';
    var_dump($value);
    */
    
    return $value;
     //$gameId = array_splice($gameAttributes,array_search($id,array_keys($gameAttributes)),1);  
  }
  public static function getOffset(array $array, $key) {
    return array_search($key, array_keys($array));
  }
}