<?php
/*
  Representing a model, an instance of a table
*/

namespace sql;

class Model extends Table implements \ArrayAccess, \core\Model {
  /* Attributes */
  public $name; // Model name
  /* Data */
  protected $data = []; // Model data

  /* Methods */
  public function __construct($name,$schema,$table) {
    parent::__construct($schema,$table);
    $this->name = $name;
  }
  /* Insertion */
  public function insert($data = []) { // Inserting data
    $this->data = array_merge($this->data,$data);
    return parent::insert($this->data);
  }
  /* Setters */
  public function inherits($model) { // Get keys from a model
    if(array_key_exists($this->name,$model->keys)) { // If the model is a primary key source
      $this->data[key($this->key)] = $model->get_col($model->keys[$this->name]);
    }
    if(array_key_exists($model->name,$this->keys)) { // if the model is a foreign key sources
      $this->data[$this->keys[$model->name]] = current($model->get_key());
    }
    foreach($this->keys as $modelname => $key) { // if the model has foreign key sources
      if(array_key_exists($modelname,$model->keys)) {
        $c = $model->get_col($key);
        $this->data[$key] = $c;
      }
    }
    return $this;
  }
  public function set_col($col,$val) { // Setting a column
    $this->data[$col] = $val;
    return $this;
  }
  public function set_key($value) { // Sets primary key
    if(!is_array($value)) {
      $this->data[key($this->key)] = $value;
    } else {
      // ...
    }
  }
  public function set_foreign_key($modelname,$value) { // Sets foreign key
    if(!is_array($value)) {
      $this->data[key($this->keys[$modelname])] = $value;
    } else {

    }
  }
  /* Getters */
  public function get_col($col) { // Reading a column
    return $this->data[$col] ?? NULL; // @TODO Exception
  }
  public function get_key() { // Returns model key value
    $a = [];
    foreach($this->key as $k => $v) {
      $a[$k] = $this->data[$k] ?? NULL;
    }
    return $a;
  }
  public function get_keys() { // Returns model foreign keys
    $a = [];
    foreach($this->keys as $mname => $key) {
      if(is_array($key)) {
        // Multi column key
      } else {
        if(array_key_exists($key,$this->data)) {
            $a[$mname] = $this->data[$key];
        }
      }
    }
    return $a;
  }
  public function __get($table) { // Gets a model linked to this one by a foreign relation
    $model = $this->schema->table($table,$this);
    $model->query->merge($this->query); // Merging queries
    return $model;
  }
  /* Model interface */
  public function data() { // Returns model data
    return $this->data;
  }
  public function key($key = NULL) { // Sets primary key
    $this->set($key);
    return $this;
  }
  public function set($data) { // Sets model data
    foreach($data as $col => $v) {
      $this->set_col($col,$v);
    }
    return $this;
  }
  public function read($key) {

  }
  public function write() {

  }
  public function delete() {

  }
  /* Array Access for table columns */
  public function offsetExists($col) { // Check if column has value (not NULL or non existant)
    $c = $this->get_col($col);
    return !is_null($c);
  }
  public function offsetGet($col) { // Alias off get_col
    return $this->get_col($col);
  }
  public function offsetSet($col,$value) { // Alias of set_col
    $this->set_col($col,$value);
  }
  public function offsetUnset($col) { // Sets col to NULL
    $this->set_col($col,NULL);
  }
}
