<?php
/*
*	simPHPle 0.4 launcher.class.php : Class
*	Calls handler and executes or returns object
*/

namespace launchers;

class Launcher implements \ILauncher
{
	public $handler;

	public function __construct($handler = NULL) // creates Launcher
	{
		if($handler instanceof \IHandler)
		{
			$this->handler = $handler;
		}
		elseif($handler === NULL)
		{
			$this->handler = new \Handler();
		}
		else
		{
			// ...
		}
	}
	public static function launch(&$object) // executes the correct method to launche the object
	{
		if($object instanceof \IHandler) // result is a handler
		{
			$object->get();
		}
		elseif($object instanceof \ILoader) // result is a loader
		{
			$object->load();
		}
		elseif($object instanceof \ILauncher) // result is a launcher
		{
			$object->exec();
		}
		elseif(is_string($object)) // result is a string
		{
			echo $object;
		}
	}
	public static function boot($object) // boots an object, depending on what it is
	{
		if($object instanceof \IHandler) // result is a handler
		{
			return $object->get();
		}
		elseif($object instanceof \ILoader) // result is a loader
		{
			return $object->load();
		}
		elseif($object instanceof \ILauncher) // result is a launcher
		{
			return $object->exec();
		}
		else // returning what we got
		{
			return $object;
		}
	}
	public function exec() // runs the launcher, calls the handler and takes care of the handler
	{
		$object = $this->handler->get();
		return self::boot($object);
	}
}
?>
