<?php
/* The route loads the module and creates the module object */
namespace routing;

class route
{
  protected $module; // the module name
  protected $base = false; // if defined, the base thing everything corresponds to, makes things faster
  protected $allow_display_module = true; // if the display module should be loaded
  protected $allow_non_routing_modules = true; // if modules loaded direclty through the launcher should be loaded, can also be BEFORE_ONLY and AFTER_ONLY
  protected $whitelist = array(); // the whitelist of modules that can be loaded with this one (not implemented)
  protected $enable_whitelist = false; // enables the whitelist (not implemented)
  protected $patterns = array(); // the patterns
  public $files; // the files to load, corresponding to the pattern

  const NOT_ALLOWED = 42; // when the user isn't allowed to access the url
  const BEFORE_ONLY = 1; // only loads modules before this one
  const AFTER_ONLY = 2; // only loads modules after this one

  public function __construct($module,$base = false) // sets up the route
  {
    $this->files = new \handling\files();
    $this->module = $module;
    $this->base = $base;
  }
  public function get_allow_display_module() // returns $this->allow_display_module
  {
    return $this->allow_display_module;
  }
  public function allow_non_routing_modules($v) // sets $this->allow_non_routing_modules
  {
    $this->allow_non_routing_modules = $v;
  }
  public function get_allow_non_routing_modules() // returns $this->allow_non_routing_modules
  {
    return $this->allow_non_routing_modules;
  }
  public static function simple_route($module,$pattern,$file = 'index.php') // creates a simple route
  {
    $route = new \routing\route($module);
    $route->set_couple($pattern,$file);
    return $route;
  }
  public function get_module_name() // returns the module name
  {
    return $this->module;
  }
  public static function test_url($url,$pattern,$create_get = true) // reads the url and tels if it corresponds to the pattern, and eventually creates $_GET vars
  {
    if(is_array($pattern)) // if there's multiple patterns
    {
      $found = false;
      foreach($pattern as $p)
      {
        $found = route::test_url($url,$p,$create_get);
        if($found) // found something
        {
          return $found;
        }
      }
      return false;
    }
    $testPattern = preg_replace('#\{(\w+)\}#isU','(\w+)',$pattern);
    $testPattern = preg_replace('#\{\?(\w+)\}#isU','(\w*)',$testPattern);
    $testPattern = preg_replace('#\{\[(\w+)\]\}#isU','(.+)',$testPattern);
    $testPattern = preg_replace('#\{\?\[(\w+)\]\}#isU','(.*)',$testPattern);
    $testPattern = preg_replace('#/#isU','/*',$testPattern);
    if(preg_match_all('#^'.$testPattern.'$#',$url,$matches)) // if the url matches
    {
      if(!$create_get) // no need to create get, so it's over
      {
        return true;
      }
      if(preg_match_all('#\{(.+)\}#isU',$pattern,$names)) // the gets, if existing
      {
        unset($matches[0]);
        if(count($matches) == count($names[1])) // if every argument is filled
        {
          foreach($names[1] as $key => $get_name)
          {
            $name = preg_replace('#\[(.+)\]#isU','$1',$get_name);
            $name = ltrim($name,'?');
            if($get_name[0] == '?') // if optional parameter
            {
              if($matches[$key+1][0] != '') // if filled
              {
                $_GET[$name] = $matches[$key+1][0];
              }
            }
            else // regular parameter
            {
              $_GET[$name] = $matches[$key+1][0];
            }
          }
        }
      }
      return true;
    }
    return false;
  }
  public function set_couples() // adds files to load, associated with patterns in url
  {
    $a = func_get_args();
    foreach($a as $element)
    {
      if(array_key_exists(2,$element))
      {
        $this->set_couple($element[0],$element[1],$element[2]);
      }
      else
      {
        $this->set_couple($element[0],$element[1]);
      }
    }
  }
  public function set_couple($pattern,$files,$permissions = false) // adds files to load associated to a pattern
  {
    $this->patterns[] = array('pattern' => $pattern,'files' => $files,'permission' => $permissions);
  }
  public function allow_display_module($v) // changes the setting for the display module
  {
    $this->allow_display_module = $v;
  }
  public function test($url) // test if the module should be loaded
  {
    if($this->base != false) // if base is defined
    {
      if(!preg_match('#^'.preg_quote($this->base).'/?$#',$url)) // test if the base doesn't corresponds
      {
        return false;
      }
    }
    foreach($this->patterns as $thing)
    {
      if(\routing\route::test_url($url,$thing['pattern'])) // if the pattern corresponds
      {
        if(($thing['permission'] == false) || ($thing['permission']->test())) // test the permission if exists
        {
          if(array_key_exists('files',$thing) && $thing['files'] != false) // if there's files specific_file to this url
          {
            $this->files->add_files_array($thing['files']);
          }
          $this->create_object(); // creates the module object
          return $this;
        }
        else // if permission doesn't allow access
        {
          return \routing\route::NOT_ALLOWED;
        }
      }
    }
  }
  public function create_object() // creates the module object
  {
    $GLOBALS[$this->module] = new \module\module($this->module);
  }
}
?>
