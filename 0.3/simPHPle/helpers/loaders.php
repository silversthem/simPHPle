<?php
/* Functions that loads : Interfaces, Traits and Helpers, also autoloads classes */

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

function path_from_root($path) // the path to a file from the framework's root
{
  return '..'.BASE_DIRECTORY.$path;
}

function include_from_root($path,$once = false) // includes a file from the framework's root
{
  $fullpath = path_from_root($path);
  if(file_exists($fullpath))
  {
    if($once)
    {
      include_once $fullpath;
    }
    else
    {
      include $fullpath;
    }
  }
  else
  {
    // error handling
  }
}

spl_autoload_register('autoload_class'); // using this function to autoload classes, with namespaces being directories
?>
