<?php
/*
*	simPHPle 0/4 route.class.php : Class
*	A route, a collection of pattern linked to a module
*/

namespace handlers\routing;

class Route implements \IHandler
{
	protected $module; // module associated with the route
	public $handler; // loader handler
	protected $first_pattern; // first pattern, if it doesn't work, none work
	protected $patterns = array(); // patterns
	protected $pattern_loader; // loader selected by pattern

	public function __construct($module) // creates a route
	{
		$this->module = $module;
		$this->handler = new \Handler();
		$this->pattern_loader = new \Loader();
	}
	public static function create($a) // creates a route
	{
		if(array_key_exists('module',$a))
		{
			$route = new \Route($a['module']);
			if(array_key_exists('couple',$a))
			{
				$route->handler->set_default_loader(\Loaders\Module::create($a,$a['module']));
			}
			if(array_key_exists('pattern',$a))
			{
				$route->add_pattern($a['pattern']);
			}
			if(array_key_exists('first_pattern',$a))
			{
				$route->set_first_pattern($a['first_pattern']);
			}
			return $route;
		}
	}
	public function set_first_pattern($p) // sets the first pattern
	{
		if($p instanceof \Pattern)
		{
			$this->first_pattern = $p;
		}
		else
		{
			$this->first_pattern = \Pattern::create($p,$this->module);
		}
	}
	public function add_pattern($p) // adds a pattern
	{
		if($p instanceof \Pattern)
		{
			$this->patterns[] = $p;
		}
		else
		{
			$this->patterns[] = \Pattern::create($p,$this->module);
		}
	}
	public function valid($url) // check if the route is valid
	{
		// first url...
		foreach($this->patterns as $pattern)
		{
			if($pattern instanceof \Pattern)
			{
				if($pattern->valid($url))
				{
					$this->pattern_loader = $pattern->get();
					return true;
				}
			}
		}
		return false;
	}
	public function get() // returns the module loader
	{
		$loader = $this->handler->get();
		$loader->merge($this->pattern_loader);
		return $loader;
	}
}
?>
