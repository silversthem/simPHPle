<?php
/*
  Class
  Loads all kinds of stuff easily
  Contains basic autoloader
  Can use a backtracer if development
*/

namespace loaders;

class Loader
{
  public static function load($file,$ext = '') // loads a php file
  {
    $file = str_replace('\\','/',$file);
    if(file_exists($file.$ext))
    {
      include $file.$ext;
      return true;
    }
    else throw new \ErrorException('Couldn\'t load php file '.$file);
  }
  public static function load_once($file,$ext = '') // loads once a php file
  {
    $file = str_replace('\\','/',$file);
    if(file_exists($file.$ext))
    {
      include_once $file.$ext;
      return true;
    }
    else throw new \ErrorException('Couldn\'t load php file '.$file.$ext);
  }
  /* Functions to load interfaces, traits, classes and helpers easily */
  public static function load_class($class,$dir = CLASSES_FOLDER,$ext = CLASS_EXT) // loads a class
  {
    self::load_once($dir.'/'.$class,$ext);
  }
  public static function load_trait($trait,$dir = TRAITS_FOLDER,$ext = TRAIT_EXT) // loads a trait
  {
    self::load_once($dir.'/'.$trait,$ext);
  }
  public static function load_interface($interface,$dir = INTERFACES_FOLDER,$ext = INTERFACE_EXT) // loads a interface
  {
    self::load_once($dir.'/'.$interface,$ext);
  }
  public static function load_helper($helper,$dir = HELPERS_FOLDER,$ext = HELPER_EXT) // loads a helper
  {
    self::load_once($dir.'/'.$helper,$ext);
  }
  /* Autoloader */
  public static function autoload($class) // tries to autoload a class
  {
    try // trying to autoload system class
    {
      self::load_once(CLASSES_FOLDER.'/'.$class,CLASS_EXT);
    }
    catch(\ErrorException $e)
    {
      try // can't, maybe it's a user class ?
      {
        self::load_once(USER_CLASSES_FOLDER.'/'.$class,USER_CLASS_EXT);
      }
      catch(\ErrorException $e2)
      {
        die('No file containing <b>'.$class.'</b> has been found');
      }
    }
    if(!class_exists($class)) // file loaded yet class doesn't exist ?
    {
      die('<b>'.$class.'</b> : Class file loaded but not found. Namespace error ?');
    }
  }
}
?>
