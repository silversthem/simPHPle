<?php
/*
  A simple loading class
*/

namespace core;

class Loader {
  static $directories    = [];    // Root class directories
  static $error_handling = NULL; // Error handling function/method
  static $ext            = ['.trait.php','.class.php','.interface.php']; // Different extentions to pull from

  public static function register(...$env) { // Registers autoloader
    self::$directories = $env;
    spl_autoload_register(['\core\Loader','autoload']);
    if(is_null(self::$error_handling)) { // No error handling
      self::$error_handling = function($classname) { // Default error handling
        throw new \Exception('Unable to autoload class '.$classname, 1);
      };
    }
  }
  public static function load($class) { // Loads a class
    if(class_exists($class)) {
      return true;
    }
    $base = str_replace('\\','/',$class);
    foreach(self::$ext as $ext) {
      foreach(self::$directories as $directory) {
        if(file_exists($directory.'/'.$base.$ext)) {
          include_once $directory.'/'.$base.$ext;
          return true;
        }
      }
    }
    throw new \Exception('Unable to load class/interface'.$class, 1);
  }
  public static function autoload($class) { // Tries to load a class
    try {
      self::load($class);
    } catch(\Exception $e) {
      if(is_callable(self::$error_handling)) {
        $f = self::$error_handling;
        $f($class);
      } else {
        die("I couldn't find ".$class." anywhere and didn't know what to do next, so I gave up. Sorry...");
      }
    }
  }
}
