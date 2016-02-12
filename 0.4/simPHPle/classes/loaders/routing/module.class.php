<?php
/*
*	simPHPle 0.4 module.class.php : Class
*	Creates a module
*/

namespace loaders\routing;

class Module implements \ILoader
{
	protected $name; // the modules's name
	public $model; // the model
	public $view; // the view

	public function __construct($name) // creates a module loader
	{
		$this->name = $name;
	}
	public function name() // returns module name
	{
		return $this->name;
	}
	public static function create($a,$name = NULL) // creates a module loader from an array
	{
		if(!is_null($name))
		{
			$a['module'] = $name;
		}
		if(array_key_exists('module',$a)) // module name
		{
			$module = new \Loaders\Module($a['module']);
			if(array_key_exists('couple',$a)) // model view loader couple
			{
				$model = $a['couple'][0];
				$view = $a['couple'][1];
				if(array_key_exists('action',$a)) // methods for objects
				{
					if(!is_null($model))
					{
						$model = \Loader::create($model,$a['action'][0]);
					}
					if(!is_null($view))
					{
						$view = \Loader::create($view,$a['action'][1]);
					}
				}
				else
				{
					if(!is_null($model))
					{
						$model = \Loader::create($model);
					}
					if(!is_null($view))
					{
						$view = \Loader::create($view);
					}
				}
				$module->set_couple($model,$view);
			}
			return $module;
		}
		// error
		return false;
	}
	public function set_couple($model,$view) // sets the model/view couple
	{
		$this->model = $model;
		$this->view = $view;
	}
	public function merge($moduleLoader,$replace = true) // merges two module loaders
	{
		if($moduleLoader instanceof \Loaders\Module)
		{
			if($this->model instanceof \Loader)
			{
				$this->model->merge($moduleLoader->model,$replace);
			}
			elseif($replace)
			{
				$this->model = $moduleLoader->model;
			}
			if($this->view instanceof \Loader)
			{
				$this->view->merge($moduleLoader->view,$replace);
			}
			elseif($replace)
			{
				$this->view = $moduleLoader->view;
			}
		}
	}
	protected function create_module() // creates the module
	{
		$GLOBALS['modules'][$this->name] = new \Module($this->name);
		$GLOBALS['modules'][$this->name]->set_couple($this->model,$this->view);
	}
	public function load() // loads the module
	{
		$this->create_module();
		return $this->name;
	}
}
?>
