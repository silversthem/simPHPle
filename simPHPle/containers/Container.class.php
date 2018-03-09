<?php
/*

*/

namespace containers;

class Container {
  public static function assemble($fill,$array,$transform_function = NULL) { // Assembles an array
    if(is_null($transform_function)) {
      $transform_function = function($k,$v) {
        return $v;
      };
    }
    reset($array);
    $t = $transform_function(key($array),current($array));
    while(next($array) !== false) {
      $t .= $fill.$transform_function(key($array),current($array));
    }
    return $t;
  }
  public static function init($array) { // Returns every array element except last one
    $a = [];
    $last = end($array);
    foreach($array as $key => $element) {
      if($element == $last) {
        break;
      }
      $a[$key] = $element;
    }
    return $a;
  }
  public static function tail($array) { // Returns every array element except first one
    $a = [];
    reset($array);
    while(next($array) !== false) {
      $a[key($array)] = current($array);
    }
    return $a;
  }
  public static function until($array,$callback) { // Goes through an array and applies a function
    foreach($array as $v) {
      $r = $callback($v);
      if(!is_null($r)) {
        return $r;
      }
    }
  }
  public static function sum(...$arrays) { // Creates an array from multiple arrays

  }
}
