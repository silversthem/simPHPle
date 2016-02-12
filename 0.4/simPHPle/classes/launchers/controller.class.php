<?php
/*
*	simPHPle 0.4 controller.class.php : Class
* Class putting together a model and a view
* Default controller
*/

namespace launchers;

class Controller implements \ILauncher
{
	public $model; // model, usually a loader
	public $view; // view, usually a loader too

	public function __construct($model,$view) // creates a controller
	{
		$this->model = $model;
		$this->view = $view;
	}
	public function set_couple($model,$view) // sets model/view couple
	{

	}
	public function set_model($model) // sets model
	{

	}
	public function set_view($view) // sets view
	{

	}
	protected function exec_model($model) // executes the model
	{
		return \Launcher::boot($model);
	}
	protected function exec_view($view) // executes the view
	{
		return \Launcher::boot($view);
	}
	public function exec() // executes the controller
	{
		$this->exec_model($this->model);
		$this->exec_view($this->view);
	}
}
?>
