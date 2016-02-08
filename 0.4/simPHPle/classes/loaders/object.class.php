<?php
/*
*	simPHPle 0.4 object.class.php : Class
*	Creates a loader for an object
* Loads an instance of class when load() method called
*/

namespace loaders;

class Object implements \ILoader
{
	protected $className; // class name
	protected $classFile; // class file

	public function __construct($className,$classFile = NULL) // creates a loader
	{
		$this->className = $className;
		$this->classFile = $classFile;
	}
	public function set_class_file($dir,$ext = CLASS_EXT) // createes a class file from a directory, the class name and an extension
	{
		$this->classFile = $dir.'/'.strtolower($this->className).$ext;
	}
	public function load() // returns the object instance
	{
		if(!class_exists($this->className))
		{
			if(file_exists($this->classFile))
			{
				include_once $this->classFile;
			}
		}
		$class = $this->className;
		if(class_exists($class))
		{
			return new $class();
		}
		return NULL;
	}
}
?>
