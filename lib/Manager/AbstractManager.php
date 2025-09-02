<?php
namespace Toolbox\Manager;

use Config\Db;

abstract class AbstractManager {
  
  protected $table;
  private $db;
 
 public function request(string $sql, ?array $attributes = null) {
   $this->db = Db::getInstance();
   //requete préparée
   if ($attributes !== null) {
     $query = $this->db->prepare($sql);
     $query->execute($attributes);
     return $query;
   }
   else {
   return $this->db->query($sql); 
   }
 } 
 //CREATE
  public function create(array $entity) {
    $fields = [];
    $inter = [];
    $values = [];
    foreach($entity as $field => $value) {
    // INSERT INTO table (val1, val2, val3) VALUES (?, ?, ?)
      if($value !== null && $field != 'db' && $field != 'table') {
        $fields[] = $field;
        $values[] = $value;
        $inter[] = "?";
      }
    }
      $fields_list = implode(', ', $fields);
      $inter_list = implode(', ', $inter);
    

      return $this->request('INSERT INTO '.$this->table.' ('  .$fields_list.') VALUES ('.$inter_list.')', $values);
  }
  // récupère l'id de l'entrée crée
  public function getNewId() {
      $this->db = Db::getInstance();
      $newId = $this->db->lastInsertId();
      //$this->setId($newId);
      return $newId;
    }
  //READ
  public function findAll() {
        $query = $this->request('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
  }

  public function findBy(array $criteria) {
        $fields = [];
        $values = [];
        
    foreach ($criteria as $field => $value) {

            $fields[] = "$field = ?";
            $values[] = $value;
    }
        $fields_list = implode(' AND ', $fields);
        
        return $this->request('SELECT * FROM ' . $this->table . ' WHERE ' . $fields_list, $values)->fetchAll();
    }
  public function findById(int $id){
    return $this->request("SELECT * FROM $this->table where id = $id")->fetch();
  }    
  //UPDATE
  public function update(array $newValues, $id) {
    $fields = [];
    $values = [];
    foreach($newValues as $field => $value) {
    // UPDATE SET field1= ?, field2= ? WHERE id = ?
      if($value !== null && $field != 'db' && $field != 'table') {
        $fields[] = "$field = ?";
        $values[] = $value;
      }
    }
      $values[] = $id;
      $fields_list = implode(', ', $fields);
      
      return $this->request('UPDATE '.$this->table.' SET '.$fields_list.' WHERE id = ? ', $values);
    // return $values;
  }
  //DELETE
  public function delete(int $id) {
        return $this->request("DELETE FROM {$this->table} WHERE id = ?", [$id]);
  }
  // public function hydrate($obj, array $data) {
//     foreach ($data as $key => $value) {
//       $setter = 'set'.ucfirst($key);
//       if (method_exists($obj, $setter)) {
//         $obj->$setter($value);
//       }
//     }
//     return $obj;
//   }
}