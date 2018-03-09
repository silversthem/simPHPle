<?php
/*

*/

namespace sql;

class Table {
  /* Defined Properties */
  public $fields = []; // Table Columns
  public $key = [];    // Table Primary key
  public $keys = [];   // Table Foreign Keys
  /* Properties */
  public $schema; // Parent schema
  public $tablename; // Table name
  public $query; // Current active query

  /* Methods */
  public function __construct($schema,$tablename) { // Creates a Table
    $this->schema = $schema;
    $this->tablename = $tablename;
    $this->query = new queries\Query($this);
  }
  /* SQL Statements */
  public function create() { // Creating table
    return $this->schema->create_model($this);
  }
  public function insert($data) { // Inserting data into table
    return $this->schema->insert($this,$data);
  }
  public function drop() { // Dropping table

  }
  /* Querying */
  public function __call($queryfn,$args) { // Calls a query method
    if(method_exists($this->query,$queryfn)) {
      $a = call_user_func_array([$this->query,$queryfn],$args);
      $this->queryExecuted = false;
    }
    return (is_null($a)) ? $this : $a;
  }
  /* Getters */
  public function columns() { // Get column names, including foreign and primary key
    $keys = [];
    foreach($this->keys as $model => $v) {
        $keys += [$v];
    }
    return array_merge(array_merge(array_keys($this->key),$keys),array_keys($this->fields));
  }
}
