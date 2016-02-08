<?php
/*
*	simPHPle 0.4 app.class.php : Class
*	Handles module based apps
*/

namespace launchers\app;

class App extends \Launcher implements \ILauncher
{
	static $STATUS = array(404 => NULL,403 => NULL,500 => NULL); // error statuses

	public function __construct($mode = MODE) // creates an app, in production/development
	{
		$GLOBALS['modules'] = array(); // array to store the modules
		$GLOBALS['current'] = ''; // current module
	}
	public function set_handler($handler) // sets the app handler
	{
		$this->handler = $handler;
	}
	public static function set_error_status($status,$exec) // sets an executor when hitting an error
	{
		self::$STATUS[$status] = $exec;
	}
	public static function status($status) // executes the error status
	{
		if(is_null(self::$STATUS[404]))
		{
			echo '<h1>Error 404</h1><hr/><p>No page with this url</p>';
		}
		else
		{
			\Launcher::launch(self::$STATUS[404]);
		}
	}
	public function add_module($module) // adds a module to load
	{
		if($module instanceof \Module)
		{
			$GLOBALS['modules'][$module->name()] = $module;
		}
		else
		{
			$mod = \Launcher::boot($module);
			if($mod instanceof \Module)
			{
				$GLOBALS['modules'][$mod->name()] = $mod;
			}
		}
	}
	public function exec() // runs the app
	{
		foreach($GLOBALS['modules'] as $key => $module)
		{
			$GLOBALS['current'] = $module->name();
			\Launcher::launch($GLOBALS['modules'][$key]);
		}
	}
}
?>
