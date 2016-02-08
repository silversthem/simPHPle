<?php
/*
*	simPHPle 0.4 loader.class.php : Class
*	Loads things
*/

namespace loaders;

class Loader
{
	static $DIRS =
		array('CLASS' => CLASS_DIRECTORY,'TRAITS' => TRAITS_DIRECTORY,'INTERFACES' => INTERFACES_DIRECTORY,'HELPER' => HELPERS_DIRECTORY,
					'USER_CLASS' => USER_CLASS_DIRECTORY);
	static $EXT  =
		array('CLASS' => CLASS_EXT      ,'TRAITS' => TRAIT_EXT       ,'INTERFACES' => INTERFACE_EXT       ,'HELPER' => HELPER_EXT);

	public static function Including($file) // includes a file
	{
		if(file_exists($file))
		{
			include $file;
			return true;
		}
		return false;
	}
	public static function Including_once($file) // includes once a file
	{
		if(file_exists($file))
		{
			include_once $file;
			return true;
		}
		return false;
	}
	public static function autoload($class) // autoloads a class
	{
		$name = '/'.implode('/',array_map('lcfirst',explode('\\',$class))).self::$EXT['CLASS'];
		if(!self::Including_once(self::$DIRS['CLASS'].$name))
		{
			if(!self::Including_once(self::$DIRS['USER_CLASS'].$name))
			{
				die("Couldn't load $class");
			}
		}
	}
	public static function load_class($class,$otherDir = NULL) // loads a class
	{
		if(!is_null($otherDir))
		{
			return self::Including_once($otherDir.'/'.$class.self::$EXT['CLASS']);
		}
		else
		{
			self::autoload($class);
		}
	}
	public static function load_trait($trait,$otherDir = NULL) // loads a trait
	{
		if(!is_null($otherDir))
		{
			return self::Including_once($otherDir.'/'.$trait.self::$EXT['TRAITS']);
		}
		else
		{
			return self::Including_once(self::$DIRS['TRAITS'].'/'.$trait.self::$EXT['TRAITS']);
		}
	}
	public static function load_interface($interface,$otherDir = NULL) // loads a interface
	{
		if(!is_null($otherDir))
		{
			return self::Including_once($otherDir.'/'.$interface.self::$EXT['INTERFACES']);
		}
		else
		{
			return self::Including_once(self::$DIRS['INTERFACES'].'/'.$interface.self::$EXT['INTERFACES']);
		}
	}
	public static function load_helper($helper,$otherDir = NULL) // loads a helper
	{
		if(!is_null($otherDir))
		{
			return self::Including_once($otherDir.'/'.$helper.self::$EXT['HELPER']);
		}
		else
		{
			return self::Including_once(self::$DIRS['HELPER'].'/'.$helper.self::$EXT['HELPER']);
		}
	}
	public static function load_library($lib,$otherDir = NULL) // loads a library
	{
		// ...
	}
}
?>
