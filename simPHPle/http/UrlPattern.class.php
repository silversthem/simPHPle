<?php
/*

*/

namespace http;

class UrlPattern {
  /* Class properties */
  static $re_shortcuts = [ // Some regular expression selectors shortcuts to make things faster
    'int' => '(\-?[0-9]+)'
  ];
  /* Attributes */
  protected $pattern; // URL pattern
  protected $begin = '^'; // Beginning of regex used to check pattern
  protected $end = '/?$'; // End

  /* Methods */
  public function __construct($pattern,$env = '') { // Creates a pattern
    $this->pattern = $pattern;
    if($env != '') {
      $this->set_beginning($env);
    }
  }
  public function open_end() { // Allows url to be longer than pattern predicted
    $this->end = '/?';
  }
  public function set_beginning($begin) { // States what comes before expected pattern
    $this->begin = '^'.preg_quote($begin).'/?';
  }
  protected function scan_for_shortcuts($re) { // Scanning regex for shortcuts
    if(array_key_exists($re,self::$re_shortcuts)) {
      return self::$re_shortcuts[$re];
    }
    return $re;
  }
  protected function pattern_replace($fn_read,...$args) { // Uses a reading function to read and interpret pattern
    preg_match_all('#\{(.+)\}#isU',$this->pattern,$parameters,PREG_SET_ORDER);
    $pattern = preg_quote($this->pattern);
    foreach ($parameters as $set) {
      $split = explode(':',$set[1]);
      $parameter_name = $split[0];
      $parameter_regex = (count($split) > 1) ? $this->scan_for_shortcuts(implode(':',\Container::tail($split))) : '(\w+)';
      $pattern = str_replace(preg_quote($set[0]),$fn_read($parameter_name,$parameter_regex,...$args),$pattern);
    }
    return $pattern;
  }
  public function url($parameters) { // Creates an url from pattern with fixed parameters
    return $this->pattern_replace(function($name,$re,$parameters) {
      if(array_key_exists($name,$parameters)) {
        return $parameters[$name];
      } else {
        // @TODO exception if parameter was required
      }
    },$parameters);
  }
  public function get_regex(&$parameter_names = []) { // Returns a regex to test if pattern matches
    // Replacing parameters by their expected value in a regular expression
    return '#'.$this->begin.$this->pattern_replace(function($name,$re) use (&$parameter_names) {
      $parameter_names[] = $name; // Storing parameter name
      return $re;
    }).$this->end.'#';
  }
}
