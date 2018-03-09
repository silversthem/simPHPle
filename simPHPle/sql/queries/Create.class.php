<?php
/*
  Generates SQL Query to create a schema and a table
  @TODO : Not safe -- Fix
*/


namespace sql\queries;

class Create {
  public static function schema($name) { // SQL Query for a schema
    return 'CREATE SCHEMA '.$name.';';
  }
  public static function table($schema,$table) { // SQL Query for a table
    $q = 'CREATE TABLE '.$schema->name.'.'.$table->tablename.' ('."\n";
    $fields = array_merge($table->fields,$table->key);
    $q .= \Container::assemble(",\n",$fields,function($field,$type) {
      return $field.' '.\Types::parse($type,'in');
    });
    foreach($table->keys as $model => $keys) { // Creating foreign keys
      $q .= ",\n";
      $f = $schema->model($model); // Foreign model
      $ref = key($f->key);
      $type = $f->key[$ref];
      $fk_name = $keys; // Foreign key name
      if(is_array($keys)) { // Multiple values foreign keys
        // Create fields
        $ref = \Container::assemble(',',$ref,function($key,$value) {
          return $key;
        });
        $fk_name = implode(',',$keys);
      } else { // Single value foreign key
        $q .= $fk_name.' '.\Types::parse($type,'foreign');
      }
      $q .= ",\n".'FOREIGN KEY('.$fk_name.') REFERENCES '.$schema->name.'.'.$schema->tablename($model).'('.$ref.')';
    }
    $key = (count($table->key) == 1) ? key($table->key) : \Container::assemble(',',$ref,function($key,$value) {
      return $key;
    });
    $q .= ",\n".'PRIMARY KEY('.$key.')';
    $q .= ');';
    return $q;
  }
}
