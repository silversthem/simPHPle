<?php
/* The launcher is the main class of the framework, it does everything for starting the router to writing in the log */
class launcher
{
  protected $router; // the router object
  protected $sql_object; // the sql object
  protected $modules_to_load = array(); // modules loaded whether there's a router or not

  public function __construct() // creates the launcher
  {
    $GLOBALS['modules_loaded'] = array(); // the list of modules loaded
    $GLOBALS['requests'] = array(); // the array used to send/catch things between modules
  }
  public static function load_class($class) // autoloading function
  {
    if(file_exists('app/classes/'.$class.'.class.php')) // if the class file exists
    {
      include_once 'app/classes/'.$class.'.class.php';
    }
  }
  public static function start_timer() // starts a timer
  {
    $GLOBALS['timer'] = microtime(true);
  }
  public static function stop_timer() // stops the timer and returns the time
  {
    return microtime(true) - $GLOBALS['timer'];
  }
  public function set_router($router) // sets the router
  {
    $this->router = $router;
  }
  public function gen_router() // creates the router, eventually with routes
  {
    $routes = func_get_args();
    $this->router = new router(router::MAKE_URL,$routes);
  }
  public function add_route($route) // adds a route to the router
  {
    $this->router->add_route($route);
  }
  public function add_routes() // adds multiple routes
  {
    $routes = func_get_args();
    $router = $this->router;
    call_user_method_array(array($router,'add_routes'),$routes);
    $this->router = $router;
  }
  public function add_module($module_name,$file = 'index.php',$beforeRouter = true) // add a module to the execution list, file can be an array
  {

  }
  public static function open_database($type,$login,$password) // creates a sql object
  {

  }
  public function set_database($db) // sets the sql object
  {
    $this->sql_object = $db;
  }
  public function __call($method,$args) // if calling a nonexistent method, trying to use it on the router or the database
  {
    $b = NULL;
    if(method_exists($this->router,$method)) // router method
    {
      $router = $this->router;
      $b = call_user_method_array($method,$router,$args);
      $this->router = $router;
    }
    elseif(method_exists($this->sql_object,$method)) // sql object method
    {
      $sql_object = $this->sql_object;
      $b = call_user_method_array(array($sql_object,$method),$args);
      $this->sql_object = $sql_object;
    }
    if($b !== NULL)
    {
      return $b;
    }
  }
  protected function exec_modules() // starts the different modules
  {
    $toLoad = $this->modules_to_load;
    foreach($toLoad as $name => $files)
    {
      foreach($files as $file)
      {
        if(file_exists('app/modules/'.$name.'/'.$file))
        {
          include 'app/modules/'.$name.'/'.$file;
        }
        else
        {
          // error handling
        }
      }
    }
  }
  public function start() // launches the website
  {
    $this->modules_to_load = $this->router->go();
    $this->exec_modules(); // runs the modules
  }
}
?>
