<?php
/*
  Static Class
  Launches handlers/loaders and launchers
*/

namespace launchers;

class Launcher
{
  public static function can_boot($object) // If the object can be booted
  {
    return ($object instanceof \ILoader) || ($object instanceof \IHandler) || ($object instanceof \ILauncher);
  }
  public static function boot($object) // "Boots" an object -> executes an action depending on type
  {
    if($object instanceof \ILoader) // Loader
    {
      return self::boot($object->load());
    }
    elseif($object instanceof \IHandler) // Handler
    {
      return self::boot($object->get());
    }
    elseif($object instanceof \ILauncher) // Launcher
    {
      $object->exec();
    }
    return $object; // Anything else
  }
  public static function valid_in($elements,$callable,$args = array(),$return = true) // Returns the first element returning $return using callable
  {
    foreach($elements as $element)
    {
      $r = call_user_func_array($callable,array_merge(array($element),(is_array($args)) ? $args : array($args)));
      if($r == $return)
      {
        return $element;
      }
    }
    return NULL; // No element found
  }
  public static function valid_in_objects($objects,$method = 'valid',$args = array(),$return = true) // Returns the object returning $return to method given in objects pile
  {
    foreach($objects as $object)
    {
      $r = call_user_func_array(array($object,$method),(is_array($args)) ? $args : array($args));
      if($r == $return)
      {
        return $object;
      }
    }
    return NULL; // No object found
  }
}
?>
