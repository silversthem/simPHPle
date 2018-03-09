<?php
/*
  Generates SQL Query to drop a schema and a table
  @TODO : Not safe -- Fix
*/


namespace sql\queries;

class Drop {
  public static function schema($name) { // SQL Query for a schema
    return 'DROP SCHEMA '.$name.';';
  }
  public static function table($schema,$model) { // SQL Query for a table
    return 'DROP TABLE '.$schema->name.'.'.$model->name.';';
  }
}
