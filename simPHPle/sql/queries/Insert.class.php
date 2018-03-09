<?php
/*
  @TODO : Insertion not secure -- fix
  @TODO : Insertion not safe -- fix
*/

namespace sql\queries;

class Insert {
  public static function query($schema_name,$tablename,$data) {
    $cols = \Container::assemble(',',$data,function($k,$v) {
      return $k;
    });
    $values = \Container::assemble(',',$data,function($k,$v) {
      return '"'.$v.'"';
    });
    return 'INSERT INTO '.$schema_name.'.'.$tablename.' ('.$cols.') VALUES ('.$values.');';
  }
  public static function multiple($schema,$table,$records) {
    // ...
  }
}
