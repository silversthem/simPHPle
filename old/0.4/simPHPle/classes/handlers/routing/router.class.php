<?php
/*
*	simPHPle 0.4 router.class.php : Class
*	Reads routes and finds the correct module
*/

namespace handlers\routing;

class Router implements \IHandler
{
	protected $routes = array(); // routes
	protected $url; // the url

	const MAKE_URL = 0;

	public function __construct($url = self::MAKE_URL) // creates a router
	{
		if($url == self::MAKE_URL)
		{
			$this->url = self::get_url();
		}
		else
		{
			$this->url = $url;
		}
	}
	public function dependencies() // loads router dependencies
	{
		\Loader::load('creators/controller','trait');
		\Loader::load('creators/module','trait');
	}
	public static function get_url() // returns the url, deleting BASE_DIRECTORY from the server url
	{
		return str_replace(BASE_DIRECTORY,'',$_SERVER['REQUEST_URI']);
	}
	public function add_route($route) // adds a route
	{
		$this->routes[] = $route;
	}
	public function get() // returns the right loader for the url, or false if none
	{
		foreach($this->routes as $route)
		{
			if($route->valid($this->url)) // right route
			{
				return $route->get();
			}
		}
		return false; // error
	}
}
?>
