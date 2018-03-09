<?php
/*

*/

namespace http;

class HttpRequest {
  protected $url; // Request Url
  protected $path; // Request path
  protected $parameters; // Request parameters (in url)

  public function __construct($url,$parameters = []) { // Creates a request
    $this->url = $url;
    $this->parameters = $parameters;
    $this->path = '';
  }
  public function apply($pattern) { // Applies a pattern to the request
    $parameter_names = [];
    $regex = $pattern->get_regex($parameter_names);
    if(preg_match($regex,$this->url,$parameter_values)) {
      if(count($parameter_values) >= count($parameter_names) + 1) {
        foreach ($parameter_names as $key => $name) {
          $value = $parameter_values[$key+1];
          $this->parameters[$name] = $value;
        }
      }
      $this->path = $parameter_values[0];
      return true;
    }
    return false;
  }
  public function path() { // Returns url's path
    return $this->path;
  }
  public function url(...$parameters) { // Reads an url parameter
    $values = [];
    foreach($parameters as $parameter) {
      if(array_key_exists($parameter,$this->parameters)) {
        $values[] = $this->parameters[$parameter];
      } else {
        // @TODO exception
      }
    }
    if(count($values) == 1) {
      return $values[0];
    } else {
      return $values;
    }
  }
}
