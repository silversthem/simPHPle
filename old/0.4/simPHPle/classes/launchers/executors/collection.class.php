<?php
/*
*	simPHPle 0.4 collection.class.php : Class
*	Collection of executors to be executed
*/

namespace launchers\executors;

class Collection implements \ILauncher
{
	use \Result;
	use \Options;

	protected $executors = array(); // executors array

	public function __construct() // creates a collection
	{
		$this->set_up(\launchers\executors\Executor::$TYPES);
		$this->create_options(\launchers\executors\Executor::$OPTIONS);
	}
	public static function create($a,$options = array()) // creates a executors collection
	{
		$collection = new self();
		$collection->merge_options($options);
		if(is_array($a))
		{
			foreach($a as $executor)
			{
				$collection->add(\launchers\executors\Executor::create($executor));
			}
		}
		return $collection;
	}
	public function add($executor) // adds an executor to the collection
	{
		$this->executors[] = $executor;
	}
	public function exec() // runs the executors
	{
		foreach($this->executors as $executor)
		{
			$executor->merge_options($this->get_options,false);
			$this->add_to_pile($executor->name(),$executor->exec());
		}
	}
}
?>
