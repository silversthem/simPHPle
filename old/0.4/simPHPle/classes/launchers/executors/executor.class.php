<?php
/*
*	simPHPle 0.4 executor.class.php : Class
*	Executes a function or a file
*/

namespace launchers\executors;

class Executor implements \ILauncher
{
	use \Options;

	protected $execute; // Value to execute

	static $OPTIONS = array('return','type','root_dir','arguments'); // options

	const EX_FUNCTION = 'function';
	const EX_FILE     = 'file';
	const EX_BOOTABLE = 'bootable';
	const UNDEFINED   = 'undefined';

	static $TYPES = array(self::EX_FUNCTION,self::EX_FILE,self::EX_BOOTABLE); // type of things that can be executed

	public function __construct($execute,$return = true,$type = self::UNDEFINED) // Creates an executor
	/* execute = Thing to execute : File, function or bootable object
		 return  = whether to save what the execute returned
		 type    = The type of the thing, if let at UNDEFINED, it will be filled automatically
	*/
	{
		$this->create_options(self::$OPTIONS);
		$this->set_option('return',$return);
		$this->execute = $execute;
		if($type == self::UNDEFINED)
		{
			if(is_callable($execute)) // function
			{
				$this->set_option('type',self::EX_FUNCTION);
			}
			elseif(is_string($execute)) // filename
			{
				$this->set_option('type',self::EX_FILE);
			}
			else // bootable
			{
				$this->set_option('type',self::EX_BOOTABLE);
			}
		}
	}
	public function name() // name for result storage
	{
		return $this->get_option('type');
	}
	public static function create($element) // creates an executor
	{
		if(is_callable($element)) // function
		{
			return new self($element);
		}
		elseif(is_string($element)) // file or class
		{
			if(file_exists($element)) // file
			{
				return new self($element);
			}
			elseif(class_exists($element)) // class
			{
				return new \launchers\executors\Object($element);
			}
		}
		elseif(is_object($element)) // element
		{
			return new \launchers\executors\Object($element);
		}
		elseif(is_array($element)) // configured executor
		{
			$e = self::create($element[0]);
			unset($element[0]);
			$e->merge_options($element);
			return $e;
		}
	}
	protected function exec_file($filename,$return,$dir) // executes a file
	{
		$file = $dir.'/'.$filename;
		if(file_exists($file))
		{
			if($return)
			{
				return include $file;
			}
			else
			{
				include $file;
			}
		}
		else
		{
			// error
		}
	}
	protected function exec_function($func,$return,$args) // executes a function
	{
		$args = (is_null($args)) ? array() : $args;
		if($return)
		{
			return call_user_func_array($func,$args);
		}
		else
		{
			call_user_func_array($func,$args);
		}
	}
	protected function exec_bootable($boot,$return) // executes something bootable
	{
		if($return)
		{
			return \Launcher::boot($boot);
		}
		else
		{
			\Launcher::boot($boot);
		}
	}
	public function exec() // executes it
	{
		switch($this->get_option('type'))
		{
			case self::EX_FILE:
				return $this->exec_file($this->execute,$this->get_option('return'),$this->get_option('root_dir'));
			break;
			case self::EX_FUNCTION:
        return $this->exec_function($this->execute,$this->get_option('return'),$this->get_option('arguments'));
			break;
			case self::EX_BOOTABLE:
				return $this->exec_bootable($this->execute,$this->get_option('return'));
			break;
		}
	}
}
?>
