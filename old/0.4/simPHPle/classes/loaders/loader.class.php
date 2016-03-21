<?php
/*
*	simPHPle 0.4 loader.class.php : Class
*	Loads things
*/

namespace loaders;

class Loader
{
	static $DIRS = // Dirs for loading things
		array('CLASS' => CLASS_DIRECTORY,'TRAITS' => TRAITS_DIRECTORY,'INTERFACES' => INTERFACES_DIRECTORY,'HELPER' => HELPERS_DIRECTORY,
					'USER_CLASS' => USER_CLASS_DIRECTORY);
	static $EXT  = // File extensions
		array('CLASS' => CLASS_EXT      ,'TRAITS' => TRAIT_EXT       ,'INTERFACES' => INTERFACE_EXT       ,'HELPER' => HELPER_EXT);
	static $LOADED = array('classes' => array(),'traits' => array(),'interfaces' => array(),'helpers' => array(),'libraries' => array()); // things loaded

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
		$name = '/'.str_replace('\\','/',strtolower($class)).self::$EXT['CLASS'];
		self::$LOADED['classes'][] = $class;
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
		self::$LOADED['classes'][] = $class;
		if(!is_null($otherDir))
		{
			return self::Including_once($otherDir.'/'.strtolower($class).self::$EXT['CLASS']);
		}
		else
		{
			self::autoload($class);
		}
	}
	public static function load_trait($trait,$otherDir = NULL) // loads a trait
	{
		self::$LOADED['traits'][] = $trait;
		if(!is_null($otherDir))
		{
			return self::Including_once($otherDir.'/'.strtolower($trait).self::$EXT['TRAITS']);
		}
		else
		{
			return self::Including_once(self::$DIRS['TRAITS'].'/'.strtolower($trait).self::$EXT['TRAITS']);
		}
	}
	public static function load_interface($interface,$otherDir = NULL) // loads a interface
	{
		self::$LOADED['interfaces'][] = $interface;
		if(!is_null($otherDir))
		{
			return self::Including_once($otherDir.'/'.strtolower($interface).self::$EXT['INTERFACES']);
		}
		else
		{
			return self::Including_once(self::$DIRS['INTERFACES'].'/'.strtolower($interface).self::$EXT['INTERFACES']);
		}
	}
	public static function load_helper($helper,$otherDir = NULL) // loads a helper
	{
		self::$LOADED['helpers'][] = $helper;
		if(!is_null($otherDir))
		{
			return self::Including_once($otherDir.'/'.strtolower($helper).self::$EXT['HELPER']);
		}
		else
		{
			return self::Including_once(self::$DIRS['HELPER'].'/'.strtolower($helper).self::$EXT['HELPER']);
		}
	}
	public static function load($file,$type)
	{
		switch($type)
		{
			case 'class':
				self::load_class($file);
			break;
			case 'trait':
				self::load_trait($file);
			break;
			case 'interface':
				self::load_interface($file);
			break;
			case 'helper':
				self::load_helper($file);
			break;
			case 'library':
				self::load_library($file);
			break;
		}
	}
	public static function load_library($lib,$otherDir = NULL) // loads a library
	{
		self::$LOADED['libraries'][] = $lib;
		// ...
	}
}
?>
