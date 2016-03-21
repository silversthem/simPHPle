<?php
/*
  Class
  Checks if an url matches it
  Can eventually return a controller or parts of it
*/

namespace handlers\routing;

class Pattern
{
  protected $pattern; // The pattern string
  protected $pile; // Pile associated with pattern

  public function __construct($pattern,$pile = array()) // Creates a pattern
  {
    $this->pattern = $pattern;
    $this->pile = $pile;
  }
  public function get_pile() // Returns pile
  {
    return $this->pile;
  }
  public function valid($url) // If a pattern matches the url given
  {
    return (is_array($this->pattern)) ? // If there's multiple patterns
    !is_null(\Launcher::valid_in($this->pattern,array('\routing\Pattern','pattern_valid'),$url)) : // Testing all patterns
    self::pattern_valid($this->pattern,$url); // Else, testing the only one
  }
  public static function pattern_valid($pattern,$url,$createGet = true) // Checks pattern validy, and creates get if it is and $createGet is set to true
  {
    $test_pattern = preg_quote($pattern); // The regex that'll be tested
    $gets = array(); // The get variables, if $create_get is true
    if(preg_match_all('#\\\{(.+)\\\}#isU',$test_pattern,$matches,PREG_SET_ORDER))
    {
      foreach($matches as $match)
      {
        if(preg_match('#\?$#',$match[1])) // If the "?" was captured
        {
          $name = str_replace('\?','',$match[1]);
          $test_pattern = str_replace($match[0],'(.*)',$test_pattern); // Optional parameter
          $test_pattern = str_replace('/(.*)','/?(.*)',$test_pattern); // Making / optional before an optional parameter
          $gets[] = $name;
        }
        else
        {
          $test_pattern = str_replace($match[0],'(.+)',$test_pattern); // Needed parameter
          $gets[] = $match[1];
        }
      }
    }
    if(preg_match_all('#^'.$test_pattern.'$#isU',$url,$gets_values)) // Testing if pattern matches
    {
      // TODO : Add backtrace and exception
      if($createGet) // We're creating gets
      {
        $gets_values[1] = array_map(function($char){return ltrim($char,'/');},$gets_values[1]);
        if(count($gets) != 0 && count($gets_values[1]) != count($gets)) // Not same number of key and values
        {
          // Exception
          return false;
        }
        foreach($gets_values[1] as $key => $value) // Creating the $_GET variables from url
        {
          if($value != "") // Not an unfilled optional parameter
          {
            $_GET[$gets[$key]] = urldecode($value);
          }
        }
        return true;
      }
      else
      {
        return true;
      }
    }
    return false;
  }
}
?>
