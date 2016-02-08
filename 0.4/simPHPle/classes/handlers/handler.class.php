<?php
/*
* simPHPle 0.4 handler.class.php : Class
* Handles loaders
*/

namespace handlers;

class Handler implements \IHandler
{
	protected $loaders = array(); // the loaders
	protected $default; // default loader name
	protected $loaded; // the loader object found

	const UNDEFINED = 'undefined';

	public function __construct($defaultName = 'default',$default = NULL) // creates a handler
	/* defaultName = default loader, in case nothing was found
	 	 default = Loader object set to the default case */
	{
		$this->default = $defaultName;
		if(!is_null($default))
		{
			$this->loaders[$defaultName] = $default;
		}
		else
		{
			$this->loaders[$defaultName] = new \Loader();
		}
		$this->loaded = NULL;
	}
	public function set_default_loader($l) // sets default loader
	{
		$this->loaders[$this->default] = $l;
	}
	public function get_loader($name) // returns a loader
	{
		if(array_key_exists($name,$this->loaders))
		{
			return $this->loaders[$name];
		}
		return false;
	}
	public function set_loader($key,$loader) // sets a loader
	{
		$this->loaders[$key] = $loader;
	}
	public function select($selected = self::UNDEFINED) // choose which handler to return
	/* selected = selected loader */
	{
		if($selected == self::UNDEFINED)
		{
			$this->loaded = $this->get_loader($this->default);
		}
		else
		{
			$this->loaded = $this->get_loader($selected);
		}
	}
	public function get() // returns the object loaded
	{
		if(is_null($this->loaded))
		{
			$this->select();
		}
		return $this->loaded;
	}
}
?>
