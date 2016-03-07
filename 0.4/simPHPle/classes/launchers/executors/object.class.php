<?php
/*
*	simPHPle 0.4 object.class.php : Class
*	Executes an object
*/

namespace launchers\executors;

class Object implements \ILauncher
{
  use \Result;
  use \Options;

	protected $object; // the object

	public function __construct($object,$method = array(),$classFile = NULL) // creates an object executor
	{
    $this->create_options(array('methods' => array(),'bootable' => false));
    if(is_object($object)) // object
    {
        $this->object = $object;
    }
    elseif(is_string($object)) // class
    {
        $this->object = new \loaders\Object($object,$classFile);
        $this->set_option('bootable',true);
    }
		else // loader, most likely
		{
			$this->object = $object;
      $this->set_option('bootable',true);
		}
    $this->set_option('methods',$method);
	}
	public function set_class_file($dir,$ext = CLASS_EXT) // sets class root directory
	{
		if($object instanceof \loaders\Object)
		{
			$object->set_class_file($dir,$ext);
		}
	}
	public function name() // returns object class name
	{
    if($this->object instanceof \Loaders\Object)
    {
      return $this->object->name();
    }
    elseif(method_exists($this->object,'name'))
    {
      return $this->object->name();
    }
		return get_class($this->object);
	}
  public function set_method($methods) // sets/adds a method for the object, with eventual arguments, in array
  {
    if(is_array($methods))
    {
      foreach($methods as $key => $value)
      {
        if(is_int($key)) // value is the method
        {
          $this->set_option_pile('methods',$value);
        }
        elseif(is_string($key)) // key is the method
        {
          if(is_array($value)) // value is arguments
          {
            $this->set_option_pile('methods',$key,$value);
          }
          elseif(!is_null($value)) // value is an argument
          {
            $this->set_option_pile('methods',$key,array($value));
          }
          else // no arguments
          {
            $this->set_option_pile('methods',$key);
          }
        }
      }
    }
    elseif(is_string($methods))
    {
      $this->set_option_pile('methods',$methods);
    }
  }
	public function exec() // executes the object
	{
		if($this->get_option('bootable')) // object has to be booted
    {
      $this->object = \Launcher::boot($this->object);
    }
		foreach($this->get_option('methods') as $key => $value)
		{
      if(is_int($key))
      {
        if(is_string($value)) // value is method
        {
          $this->set_result($value,call_user_func(array($this->object,$value)));
        }
      }
      elseif(is_string($key)) // key is method
      {
          $this->set_result($key,call_user_func_array(array($this->object,$key),$value));
      }
    }
		return array($this->name() => $this->get_results());
	}
}
?>
