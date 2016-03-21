<?php
/* A single route, to load a module */
class route
{
  protected $module; // the module name
  protected $files = array('index.php'); // files to call
  protected $pattern; // url(s) to test whether to call the module or not
  protected $patternFiles = array(); // files to load with certain patterns
  protected $linked_routes_before = array(); // if there's routes linked (loaded before the module)
  protected $linked_routes_after = array(); // if there's routes linked (loaded after the module)

  const DEFAULT_NAME = 1; // to make code clearer
  const BEFORE = 2;
  const AFTER = 3;

  public function __construct($module) // creates a route
  {
    $this->module = $module;
    $args = func_get_args();
    if(count($args) != 1) // if urls are called with the route
    {
      unset($args[0]);
      $this->pattern = $args;
    }
  }
  public function add_pattern_with_linked_file($pattern) // add file(s) to load when $pattern is met
  {
    $files = func_get_args();
    unset($files[0]);
    $this->pattern[] = $pattern; // we add the pattern
    $id = count($this->pattern) - 1;
    $this->patternFiles[$id] = $files;
  }
  public function get_module_name() // returns the module name
  {
    return $this->module;
  }
  public function link_module($module,$place) // add another module to call, whatever the url is
  {
    $files = func_get_args();
    unset($files[0]);
    unset($files[1]);
    $route = new route($module);
    $route->set_files($files);
    $this->link($route,$place);
  }
  public function link($route,$place) // add another module to call, whatever the url is
  {
    if($place == route::BEFORE)
    {
      $this->linked_routes_before[] = $route;
    }
    else
    {
      $this->linked_routes_after[] = $route;
    }
  }
  public static function compare_url_to_pattern($url,$pattern) // compare the url to a pattern
  {
    if(preg_match_all('#\{.+\}#isU',$pattern,$varname)) // if there's vars in the url
    {
      $p = preg_replace('#\{\[.+\]\}#isU','(.+)',$pattern);
      $p = preg_replace('#\{.+\}#isU','(\w+)',$p);
      $create_get = true;
    }
    else // just an url
    {
      $p = $pattern;
      $create_get = false;
    }
    if(preg_match_all('#^'.$p.'$#is',$url,$matches) || preg_match_all('#^'.$p.'/$#is',$url,$matches)) // if the url matches the pattern
    {
      if(!$create_get) // no $_GET[] to create
      {
        return true;
      }
      else // creating the $_GET[]
      {
        foreach($varname[0] as $k => $v)
        {
          $v = str_replace('{','',$v);
          $v = str_replace('}','',$v);
          $v = str_replace('[','',$v);
          $v = str_replace(']','',$v);
          $_GET[$v] = $matches[$k+1][0]; // $_GET[] created
        }
        return true;
      }
    }
    return false;
  }
  public function set_files($files) // set files to load
  {
    $this->files = $files;
  }
  public function add_files() // add files to load
  {
    $files = func_get_args();
    foreach($files as $file)
    {
      $this->files[] = $file;
    }
  }
  public function test($url) // compares $url to patterns in the route
  {
    foreach($this->pattern as $key => $pattern)
    {
      if(route::compare_url_to_pattern($url,$pattern)) // a match
      {
        if(array_key_exists($key,$this->patternFiles)) // files associated to the pattern being read
        {
          $toLoad = $this->patternFiles[$key];
          foreach($toLoad as $file)
          {
            $this->files[] = $file; // we add the files
          }
        }
        $filesBefore = $this->load_linked_before();
        $filesAfter = $this->load_linked_after();
        $files = array($this->module => $this->files);
        $GLOBALS['modules_loaded'][$this->module] = array(); // the array contains the modules linked
        return array_merge($filesBefore,$files,$filesAfter); // returning an array containing the files to load
      }
    }
    return false;
  }
  protected function load_linked_before() // load the linked modules
  {
    $files = array();
    foreach($this->linked_routes_before as $link)
    {
      $GLOBALS['modules_loaded'][$this->module][$link->get_module_name()] = true;
      $files[$link->get_module_name()] = $link->load_files();
    }
    return $files;
  }
  protected function load_linked_after() // load the linked modules
  {
    $files = array();
    foreach($this->linked_routes_after as $link)
    {
      $GLOBALS['modules_loaded'][$this->module][$link->get_module_name()] = true;
      $files[$link->get_module_name()] = $link->load_files();
    }
    return $files;
  }
  public function load_files() // returns the files to load
  {
    return $this->files;
  }
  protected function create_object() // creates the object associated to the module
  {
    if(!array_key_exists($mod,$GLOBALS)) // if the object doesn't exists
    {
      $mod = $this->module;
      $GLOBALS[$mod] = new module($mod);
    }
  }
}
?>
