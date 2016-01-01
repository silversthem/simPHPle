<?php
/* A pattern is something that'll be compared to the url, and if matching will return files needed to be loaded */

namespace routing;

load_interface('pattern');

class pattern implements \ipattern
{
  protected $regex = array(); // the regulars expression that'll be used
  protected $permission; // options concerning the regular expressions comparaison
  protected $get_options = array(); // options for the gets
  protected $override_default_files = false; // decides whether the default files have to be loaded
  public $handler; // the handler for constructors

  public function __construct() // creates a pattern, and eventually defines the first regex
  {
    $this->handler = new \handling\constructors\handler();
  }
  public function set_override($v = true) // sets the override
  {
    $this->override_default_files = $v;
  }
  public function add_permission($p) // adds a permission to the pattern
  {
    $this->permissions[] = $p;
  }
  public static function option($permission = false,$pattern = false) // creates an option array easily
  {
    $o = array();
    if($permission !== false)
    {
      $o['permission'] = $permission;
    }
    elseif($pattern !== false)
    {
      $o['pattern'] = $pattern;
    }
    return $o;
  }
  protected function read_option($option,$var = "") // reads an option concerning the $_GET
  {
    if(array_key_exists('permission',$option)) // if there's permissions to check
    {
      // ...
    }
    elseif(array_key_exists('pattern',$option)) // if the $_GET corresponds to a certain pattern
    {
      // ...
    }
    return true;
  }
  public function add_get_option($key,$option) // adds an option for the get
  {
    $this->get_options[$key] = $option;
  }
  public function add_regex($regex,$specific_files = false,$permission = false) // adds regex to be tested
  {
    $this->regex[] = array('regex' => $regex,'files' => $specific_files,'permission' => $permission);
  }
  protected function create_get($names,$values) // creates the gets
  {
    $testing = true; // this var will change to false if a get isn't approved by its options
    if(count($names) == count($values)) // if there's a much names as values
    {
      foreach($values as $key => $value)
      {
        $_GET[$names[$key]] = $value[1]; // adds it to the $_GET array
        if(array_key_exists($names[$key],$this->get_options)) // if there's options for this get
        {
          $testing = $this->read_option($this->get_options[$names[$key]],$value[1]);
        }
      }
    }
    return $testing;
  }
  protected function test($url,$pattern,$create_get) // tests a pattern
  {
    $regex = $pattern;
    $varname = array(); // the $_GET var keys
    if(preg_match_all('#\{(\[?\w+\]?)\}#isU',$pattern,$matches,PREG_SET_ORDER)) // get the $_GET vars
    {
      foreach($matches as $match)
      {
        if(substr($match[1],0,1) == '[') // anything type of search
        {
          $varname[] = trim($match[1],'[]');
          $regex = str_replace($match[0],'(.+)',$regex);
        }
        else // string type of search
        {
          $varname[] = $match[1];
          $regex = str_replace($match[0],'(\w+)',$regex);
        }
      }
    }
    $regex = '#^'.$regex.'$#isU';
    if(preg_match_all($regex,$url,$matches,PREG_SET_ORDER)) // if the pattern matches
    {
      if($create_get)
      {
        $rep = $this->create_get($varname,$matches);
        return $rep;
      }
      return true;
    }
    return false;
  }
  public function test_url($url,$create_get = true) // tests if the pattern matches the url, and eventually fills in the $_GET variables
  {
    foreach($this->regex as $value)
    {
      if($this->test($url,$value['regex'],true)) // test if the pattern is valid
      {
        if($value['permission'] != false) // if the pattern has permissions
        {
          if(!$value['permission']->check()) // permission not granted
          {
            return array('result' => false);
          }
        }
        return array('result' => true,'constructor' => $this->handler->exec());
      }
    }
    return array('result' => false);
  }
}
?>
