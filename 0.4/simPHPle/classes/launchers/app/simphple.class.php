<?php
/*
*	simPHPle 0.4 simPHPle.class.php : Class
*	Creates a router based app
*/

namespace launchers\app;

class SimPHPle extends \App implements \ILauncher
{
	public $router; // The router

	public function __construct() // creates an application
	{
		parent::__construct();
		$this->router = new \Router();
	}
	public function exec() // launches the application
	{
		$loader = $this->router->get();
		if($loader === false) // 404
		{
				self::status(404);
				return false;
		}
		\Launcher::launch($loader);
		parent::exec(); // launching modules
	}
}
?>
