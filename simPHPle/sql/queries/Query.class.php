<?php
/*

*/

namespace sql\queries;

class Query {
  /* Properties */
  public $source; // Query Source, can be table/model/query
  /* SQL Query */
  protected $where = []; // Where clauses
  protected $join = [];  // Joint tables
  protected $parameters; // Query parameters

  /* Methods */
  public function __construct($source) { // Creates a query from a schema/table/other query
    $this->source = $source;
  }
  /* Query */
  public function join($model,$theta = NULL) { // Joins a model, possibly by a theta join
    if(is_string($model)) {
      $this->join[$model] = $theta;
    } elseif($model instanceof \Model) {
      // ...
    }
  }
  public function where($expr) { // Adds a where clause

  }
  /* str */
  public function str_join() { // Join clauses as string
    $q = '';
    foreach($this->join as $model => $theta) {
      if($theta != NULL) {
        // ...
      } else {
        $q .= 'JOIN '.$this->model->schema->tablename($model);
        if(array_key_exists($model,$this->model->keys)) {
          if(is_array($this->model->keys[$model])) {
            // ...
          }
          $f = $this->model->schema->model($model);
          $q .= ' ON '.$f->tablename.'.'.key($f->key).' = '.$this->model->tablename.'.'.$this->model->keys[$model]."\n";
        }
      }
    }
    return $q;
  }
  public function str_where() { // Where clauses as string
    $q = 'WHERE ';
    
    /* Other where clauses */
    // ...
    $q .= "\n";
    return $q;
  }
  /* Querying */
  /* Select & aliases */
  public function select(...$fields) { // Returns a selection query
    if(count($fields) == 0) { // Default fields are from current model and joined models
      $mname = $this->model->name;
      $fields = [$mname => $this->model->columns()];
      foreach($this->join as $model => $th) {
        $fields[$model] = $this->model->schema->model($model)->columns();
      }
    }
    return new \sql\queries\Select($this,$fields);
  }
  public function first() { // Returns first element of the query
    $d = $this->select()->first();
    $this->model->set($d);
    return $this->model;
  }
  public function foreach($fn) { // Equivalent to select()->foreach($fn)
    return $this->select()->foreach($fn);
  }
  /* Update & Deletion */
  public function update($data = []) { // Returns an update query

  }
  public function delete() { // Returns a delete query

  }
}
