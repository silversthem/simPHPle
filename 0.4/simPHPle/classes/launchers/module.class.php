<?php
/*
*	simPHPle 0.4 module.class.php : Class
*	A module, containing a view and model
*/

namespace launchers;

class Module extends \Controller implements \ILauncher
{
	use \Result;

	protected $name; // the module's name
	protected $dir; // module directories

	public function __construct($name,$dir = MODULES_PATH) // creates a module
	{
		$this->name = $name;
		$this->dir = $dir;
	}
	public function name() // returns the module's name
	{
		return $this->name;
	}
	public static function __callStatic($method,$args) // reads a module
	{
		if(array_key_exists($method,$GLOBALS['modules'])) // if the module exists
		{
			return $GLOBALS['modules'][$method];
		}
	}
	public static function current() // reads the current module
	{
		if(array_key_exists($GLOBALS['current'],$GLOBALS['modules']))
		{
			return $GLOBALS['modules'][$GLOBALS['current']];
		}
	}
	public function set_couple($model,$view) // sets a model/view couple
	{
		$this->model = $model;
		$this->view = $view;
	}
	public function model($access,$param = NULL) // access info in a model
	/* access = what result we want
	 	 param = if result is a pile, what element of the pile we want */
	{
		$r = $this->get_pile($access);
		if(array_key_exists($access,$r)) // object results
		{
			$r = $r[$access];
		}
		if(is_array($r))
		{
			if($param === NULL)
			{
				return $r;
			}
			elseif(array_key_exists($param,$r))
			{
				return $r[$param];
			}
			else
			{
				return false;
			}
		}
		return $r;
	}
	public function exec()
	{
		$this->results_merge($this->exec_model($this->model));
		$this->exec_view($this->view);
	}
}
?>
