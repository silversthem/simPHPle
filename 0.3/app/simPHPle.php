<?php
/* Everything you need is here */

include_once 'config.php';

function load_interface($interface) // loads an interface
{
  include_once INTERFACES_DIRECTORY.'/'.$interface.INTERFACE_EXT;
}

function load_trait($trait) // loads a trait
{
  include_once TRAITS_DIRECTORY.'/'.$trait.TRAIT_EXT;
}

function redirects($url,$delay = 0) // redirects the user to a specific page
{
  if($delay > 0)
  {
    sleep($delay);
  }
  header('Location: '.$url);
}

function load_helper($helper)
{
  include_once HELPERS_DIRECTORY.'/'.$helper.'.php';
}

function autoload_class($class) // autoloads a class
{
  $class = str_replace('\\','/',$class);
  $name = CLASS_DIRECTORY.'/'.$class.CLASS_EXT;
  if(file_exists($name))
  {
    include_once $name;
  }
  $userName = CLASS_DIRECTORY.'/user/'.$class.CLASS_EXT;
  if(file_exists($userName))
  {
    include_once $userName;
  }
  return false;
}

spl_autoload_register('autoload_class'); // using this function to autoload classes, with namespaces being directories

load_helper('dirs');

$journal = new \handling\log\journal(LOG_DIRECTORY,LOG);

//set_error_handler(function($error,$message,$file,$line,$context){
//  \handling\log\journal::write_error_message($error,$message,$file,$line,$context);}); // using this function to write errors

class simPHPle extends \controllers\launcher
{
  public $database;
  public $router;

  public function __construct()
  {
    $this->router = new \routing\router(\routing\router::MAKE_URL);
  }
  public function create_route($module) // creates a route
  {
    $route = new routing\routes\route($module,MODULES_PATH);
    $datas = func_get_args();
    $routing = $datas[1];
    $first_pattern = (array_key_exists('first_pattern',$routing)) ? $routing['first_pattern'] : false;
    if($first_pattern !== false)
    {
      $f = new routing\pattern();
      $f->add_regex($first_pattern);
      $route->set_first_pattern($f);
    }
    if(array_key_exists('files',$routing))
    {
      $route->add_files($routing['files']);
    }
    if(array_key_exists('pattern',$routing))
    {
      if(is_array($routing['pattern']))
      {
        foreach($routing['pattern'] as $pattern)
        {
          if(is_array($pattern))
          {
            $route->create_pattern_from_array($pattern);
          }
          else
          {
            $route->create_pattern($pattern,array(),array());
          }
        }
      }
      else
      {
        $route->create_pattern($routing['pattern'],array(),array());
      }
    }
    $this->router->add_route($route);
  }
  public function exec() // starts the application
  {
    $this->init();
    $this->start();
  }
}
?>
