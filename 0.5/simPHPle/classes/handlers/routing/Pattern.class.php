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
  protected $get_patterns; // @TODO : Regular expressions associated with the parameters in the url
  protected $options; // @TODO : Allows options at the end of the url like ?opt1=val&opt2=val2 -> Created in $_GET['options']

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
  public static function pattern_make($pattern,$url,$gets = array()) // If the pattern is valid, creates get associated with it and returns true
  {
    if(preg_match_all('#^'.$pattern.'$#isU',$url,$gets_values,PREG_SET_ORDER)) // Testing if pattern matches
    {
      // TODO : Add backtrace and exception
      if(count($gets) > 0) // We're creating gets
      {
        $gets_values[0] = array_map(function($char){return ltrim($char,'/');},$gets_values[0]);
        unset($gets_values[0][0]);
        foreach($gets_values[0] as $key => $val)
        {
          if($val != '')
          {
            $_GET[$gets[$key-1]] = $val;
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
  public static function pattern_valid($pattern,$url,$createGet = true) // Checks pattern validy, and creates $_GET if it is and $createGet is set to true
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
          $gets[] = $name;
        }
        else
        {
          $test_pattern = str_replace($match[0],'(.+)',$test_pattern); // Needed parameter
          $gets[] = $match[1];
        }
      }
    }
    $possibilities = explode('(.*)',$test_pattern); // possibilities with optional parameters
    if(count($possibilities) > 1) // Testing all possibilities
    {
      $possibility = '';
      $temp = array();
      foreach($possibilities as $part)
      {
        $possibility .= $part;
        $temp[] = preg_replace('#/$#','/?',$possibility);
        $possibility .= '(.+)';
      }
      $possibilities = array_reverse($temp);
      foreach($possibilities as $p)
      {
        if(self::pattern_make($p,$url,$gets))
        {
          return true;
        }
      }
    }
    else // One Possibility
    {
      return self::pattern_make($test_pattern,$url,$gets);
    }
  }
}
?>
