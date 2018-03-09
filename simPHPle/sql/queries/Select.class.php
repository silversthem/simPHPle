<?php
/*

*/

namespace sql\queries;

class Select {
  protected $query; // Query
  protected $fields; // Fields to query
  protected $statement; // PDOStatement
  protected $str; // Query as string

  public function __construct($query,$fields = []) { // Creating a select query
    $this->query = $query;
    $this->fields = $fields;
    $this->str = $this->str();
    $this->statement = $this->get_statement();
  }
  protected function get_statement() { // PDO statement
    return $this->query->model->schema->query($this->str);
  }
  /* Str */
  protected function str() { // String evaluation
    $q = 'SELECT '.$this->str_fields().' FROM '.$this->query->model->tablename."\n";
    $q .= $this->query->str_join();
    $q .= $this->query->str_where();
    // Order by, group by, having, limit
    return $q;
  }
  protected function str_fields() { // Fields as string
    return '*';
    if(count($this->fields) == 0) {
      return '*';
    }
    return \Container::assemble(',',$this->fields,function($mname,$field) {
      if(is_int($mname)) { // No model name
        return $field; // Different kind of field
      }
      if(is_string($mname) && is_array($field)) {
        $table = $this->query->model->schema->tablename($mname);
        return \Container::assemble(',',$field,function($k,$v) use ($mname) {
          return $table.'.'.$v;
        });
      }
    });
  }
  public function __toString() { // Alias of str()
    return $this->str();
  }
  /* Querying */
  protected function get_results($col,$models) { // Transforms fetch results into models
      $a = [];
      foreach($this->fields as $model => $field) {
        if(is_int($model)) {
          $a[$field] = $col[$field] ?? NULL;
        } else {
          if(is_array($field)) {
            foreach($field as $col_name) {
              $models[$model][$col_name] = $col[$col_name] ?? NULL;
            }
          }
        }
      }
      return array_merge($a,$models);
  }
  protected function create_models() { // Create model to store fetch results
    $models = [];
    foreach(array_keys($this->fields) as $model) {
      if(is_string($model)) {
        $models[$model] = $this->query->model->schema->model($model,$this->query->model);
      }
    }
    return $models;
  }
  public function foreach($fn) { // Runs query and applies function $fn to all records selected
    $this->statement->execute();
    $models = $this->create_models();
    while($r = $this->statement->fetch(\PDO::FETCH_ASSOC)) {
      $f = $this->get_results($r,$models);
      $fn(...array_values($f));
    }
    $this->statement->closeCursor();
  }
  public function first() { // Returns first query element
    $this->statement->execute();
    $r = $this->statement->fetch(\PDO::FETCH_ASSOC);
    $this->statement->closeCursor();
    $models = $this->create_models();
    return $this->get_results($r,$models);
  }
  /* IteratorAggregate */
  public function getIterator() {
    return $this->statement;
  }
}
