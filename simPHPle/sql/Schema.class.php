<?php
/*

*/

namespace sql;

class Schema {
  /* Schema description */
  public $name; // Schema name
  public $models; // Models and table description
  public $tables; // Tables not bound to any model
  /* Attributes */
  protected $table_objects = []; // Table objects
  protected $database; // Parent database
  protected $env;      // Environment to load models from

  public function __construct($database,$env = '') { // Creates a schema
    $this->database = $database;
    $this->env = $env;
  }
  public function tablename($model) { // Returns tablename from modelname
    foreach($this->models as $table => $modelname) {
      if($modelname == $model) {
        return (is_string($table)) ? $table : $model;
      }
    }
  }
  public function modelname($table) { // Returns modelname from tablename
    foreach($this->models as $tablename => $modelname) {
      if((is_string($table) && $table == $tablename) || $modelname == $table) {
        return $modelname;
      }
    }
  }
  public function model($name,$parent = NULL) { // Returns a model object
    $model = new $name($name,$this,$this->tablename($name));
    if($parent instanceof Model) {
      $model->inherits($parent);
    }
    return $model;
  }
  public function table($name,$parent = NULL) { // Returns a model object from tablename
    return $this->model($this->modelname($name),$parent);
  }
  public function __get($table) { // Gets a model object from its tablename
    $model = $this->modelname($table);
    return new $model($model,$this,$table);
  }
  /* SQL Queries */
  public function create() { // Creates schema
    $q = queries\Create::schema($this->name);
    return $this->database->execute($q);
  }
  public function create_model($model) { // Creates a model
    $q = queries\Create::table($this,$model);
    return $this->database->execute($q);
  }
  public function insert($table,$values) { // Inserts into schema
    $q = queries\Insert::query($this->name,$table->tablename,$values);
    return $this->database->execute($q);
  }
  public function drop() { // Drops schema
    return $this->database->execute(queries\Drop::schema($this->name));
  }
  public function query($query) { // Executes a PDOStatement type query
    $this->database->execute('USE '.$this->name.';');
    return $this->database->prepare($query);
  }
}
