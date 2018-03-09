<?php

namespace sql;

class Types {
  static $vars = [
    'sql' => [
      'id' => ['in' => 'INT AUTO_INCREMENT','foreign' => 'INT']
    ]
  ];
  public static function parse($str,$ctx = 'in') {
    $parameters = explode('.',$str);
    if(count($parameters) == 1) {
      return $str;
    } else {
      $possibilities = self::$vars;
      foreach($parameters as $parameter) {
        if(!array_key_exists($parameter,$possibilities)) {
          return $str;
        } else {
          $possibilities = $possibilities[$parameter];
        }
      }
      return array_key_exists($ctx,$possibilities) ? $possibilities[$ctx] : $possibilities;
    }
  }
  public static function check($type,$value) {
    // ...
  }
}
