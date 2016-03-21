<?php
/*
* simPHPle 0.4 index.php : Main file *
* This is where the magic happens    *
*/

include 'simPHPle/simPHPle.php';

class Event_A implements app\IEvent
{
	public function init()
	{

	}
	public function valid()
	{
		return true;
	}
	public function error($status)
	{

	}
	public function get()
	{
		return 'hi';
	}
}

class A implements app\IController
{
	public function init()
	{

	}
	public function sayHi($event)
	{
		if($event == 'hi')
		{
			echo 'Hi !';
		}
		elseif($event == 'bye')
		{
			echo 'Bye !';
		}
		else
		{
			echo 'Oh no ! '.$event.' isn\'t a proper event';
		}
	}
	public function error($status)
	{
		echo 'Oh no ! Module error '.$status;
	}
}

$Action = new Executors\Object('A',array('sayHi'));
$Event  = new Executors\Object('Event_A',array('valid'));

$loader = new Loaders\Controller();
$loader->add_event($Event,$Action);

$controller = $loader->load();

Launcher::boot($controller);

// @TODO - Better support of functions/files to includes/bootables as actions in helpers
// @TODO - change file names to ALL lowercases, easier to maintain (then change Get and Post class names to GET and POST, easier to read)
// @TODO - Rewrites controllers and modules, and the way the latter handle model and view
// @TODO - Rewrites router system, making it easier to use and more flexible
// @TODO - Support [permmissions, errors, queries, form] IN controllers and separate (as other objects) in modules and controllers
// @TODO - handles normal php options : ?id=1&page=3 etc... in router
// @TODO - Error handling
// @TODO - Find a way to implement libraries
/* @TODO - In core :
	- Template
	-- Parsers : html, file inclusions etc...
	- Databases (ORM)
*/
?>
