<?php
/*
*	simPHPle 0.4 object.class.php : Class
*	Executes an object
*/

namespace launchers\executors;

class Object implements \ILauncher
{
  use \Result;

	protected $object; // the object
	protected $methods = array(); // the mehods

	public function __construct($object,$method = array(),$classFile = NULL) // creates an object executor
	{
    if(is_object($object)) // object
    {
        $this->object = $object;
    }
    elseif(is_string($object)) // class
    {
        $this->object = new \loaders\Object($object,$classFile);
    }
		else // loader, most likely
		{
			$this->object = $object;
		}
    $this->add_method($method);
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
		return get_class($this->object);
	}
	public function add_method($method,$arguments = array()) // add a method, or multiple methods, as an array
	{
    if(is_array($method))
    {
        foreach($method as $key => $element)
        {
					if(is_string($key)) // key is method, element is argument array
					{
            $this->add_method($key,$element);
					}
					else // element is method
					{
						$this->add_method($element);
					}
        }
    }
    elseif(is_string($method))
    {
        $this->methods[$method] = $arguments;
    }
	}
	public function set_method_arguments($method,$arguments) // sets arguments for method
	{
		$this->methods[$method] = $arguments;
	}
	public function exec() // executes the object
	{
		if($this->object instanceof \ILoader) // loader
		{
			$this->object = \Launcher::boot($this->object);
		}
		foreach($this->methods as $method => $arguments)
		{
			if(method_exists($this->object,$method))
			{
				$return = call_user_func_array(array($this->object,$method),$arguments);
				if(!is_null($return))
				{
					$this->set_result($method,$return);
				}
			}
		}
		return array($this->name() => $this->get_results());
	}
}
?>
