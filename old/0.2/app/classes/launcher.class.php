<?php
/* Launches the website */
class launcher
{
  public $router; // the router
  public $database; // the database
  protected $url; // the url actually read
  protected $modules_dir = 'app/modules/'; // the directory in which the modules are loaded
  protected $modules_to_load = array('BEFORE_ROUTING' => array(),'AFTER_ROUTING' => array()); // modules to load everytime, like the style module, can also be a route
  protected $whitelist = array(); // the whitelist (not implemented)

  const BEFORE_ROUTING = 1; // the module should be loaded before the routing
  const AFTER_ROUTING = 2; // same, but after the routing

  public function __construct($router = false,$database = false) // creates a launcher
  {
    /* Defining some globals used, to implement */
    $GLOBALS['module_loaded'] = ''; // module loaded by the router
    $GLOBALS['modules_called'] = ''; // modules called by the call class
    $GLOBALS['modules_loaded'] = ''; // modules loaded by the launcher
    $GLOBALS['module_display_loaded'] = ''; // the module used as display
    if(!$router) // no router defined
    {
      $this->router = new \routing\router();
    }
    else
    {
      $this->router = $router;
    }
    if(!$database) // no database defined
    {
      //$this->database = new
    }
    else
    {
      $this->database = $database;
    }
  }
  public function set_modules_dir($directory) // sets the module directory
  {
    $this->modules_dir = $directory;
  }
  public function get_modules_dir($directory) // gets the module directory
  {
    return $this->modules_dir;
  }
  public static function write_in_log($content,$messageType) // writes something in the log, if enabled, else shows it if it's an error
  {

  }
  public static function autoload($class) // autoloading function
  {
    $class = str_replace('\\','/',$class);
    $name = 'app/classes/'.$class.'.class.php';
    if(file_exists($name))
    {
      include_once $name;
      return true;
    }
    $userName = 'app/classes/user/'.$class.'class.php';
    if(file_exists($userName))
    {
      include_once $userName;
      return true;
    }
    return false;
  }
  public static function start_timer() // starts the timer
  {
    $GLOBALS['timer'] = microtime();
  }
  public static function stop_timer() // stops the timer, returns execution time
  {
    $end = microtime();
    return ($end - $GLOBALS['timer']) * 1000;
  }
  public static function get_url() // tells what the current url is
  {
    if(defined('BASE_DIRECTORY'))
    {
      $url = preg_replace('#'.preg_quote(BASE_DIRECTORY).'#','',$_SERVER['REQUEST_URI']);
      if($url == '/')
      {
        return '';
      }
      else
      {
        return ltrim($url,'/');
      }
    }
  }
  public function load_module($when,$type,$files = false) // add module to load before or after the routing
  {
    if($when == launcher::BEFORE_ROUTING) // before the router searches
    {
      if(is_string($type)) // just a file from a module
      {
        $this->modules_to_load['BEFORE_ROUTING'][] = array('type' => 'module','file' => $this->modules_dir.$type.'/'.$files);
      }
      elseif(get_class($type) == 'routing\route') // a route
      {
        $this->modules_to_load['BEFORE_ROUTING'][] = array('type' => 'route','route' => $type);
      }
    }
    if($when == launcher::AFTER_ROUTING) // after the router searches
    {
      if(is_string($type)) // just a file from a module
      {
        $this->modules_to_load['AFTER_ROUTING'][] = array('type' => 'module','file' => $this->modules_dir.$type.'/'.$files);
      }
      elseif(get_class($type) == 'routing\route') // a route
      {
        $this->modules_to_load['AFTER_ROUTING'][] = array('type' => 'route','route' => $type);
      }
    }
  }
  protected function load_modules($group) // loads specific modules in $this->modules_to_load
  {
    if(!array_key_exists($group,$this->modules_to_load))
    {
      return false;
    }
    foreach($this->modules_to_load[$group] as $module)
    {
      if($module['type'] == 'module') // a module
      {
        if(file_exists($module['file'])) // the file to load
        {
          include $module['file'];
        }
      }
      elseif($module['type'] == 'route') // a route
      {
        $module['route']->files->load($this->modules_dir);
      }
    }
  }
  protected function load_before_modules() // loads the modules before the routing
  {
    $this->load_modules('BEFORE_ROUTING');
  }
  protected function load_after_modules() // loads the modules after the routing
  {
    $this->load_modules('AFTER_ROUTING');
  }
  public function whitelist($list,$applyTo) // applies a whitelist, either to the before modules, the after ones or the routing ones
  {

  }
  public function run() // reads the router, then loads the files
  {
    $router_route = $this->router->read_routes(launcher::get_url());
    if(array_key_exists('route',$router_route)) // if a route was returned
    {
      $route = $router_route['route'];
      if($route->get_allow_display_module() && array_key_exists('display_route',$router_route)) // if display module object should be created
      {
        $router_route['display_route']['route']->create_object();
        $GLOBALS[$router_route['display_route']['route']->get_module_name()]->set_dir($this->modules_dir.$router_route['display_route']['route']->get_module_name());
      }
      if($route->get_allow_non_routing_modules() || $route->get_allow_non_routing_modules() == \routing\route::BEFORE_ONLY) // loads the before modules
      {
        $this->load_before_modules();
      }
      $dir = $this->modules_dir.$route->get_module_name();
      $GLOBALS[$route->get_module_name()]->set_dir($dir); // tells the module object its directory
      $route->files->load($dir.'/'); // loads the files, giving the directory in which the files to load are
      if($route->get_allow_non_routing_modules() || $route->get_allow_non_routing_modules() == \routing\route::AFTER_ONLY) // loads the modules once the routing is done
      {
        $this->load_after_modules();
      }
      if($route->get_allow_display_module() && array_key_exists('display_route',$router_route)) // if display module should load
      {
        $display_dir = $this->modules_dir.$router_route['display_route']['route']->get_module_name().'/';
        $file = $display_dir.$router_route['display_route']['files'];
        if(file_exists($file))
        {
          include $file;
        }
      }
    }
    elseif(array_key_exists('module',$router_route)) // if a file from a module was returned, either the 404 error page location or permission error page location
    {
      // shows it
    }
    else // no route returned, well, nothing to be done then
    {
      // add warning : Script did nothing
    }
  }
}
?>
