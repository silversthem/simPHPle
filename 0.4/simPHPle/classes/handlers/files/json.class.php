<?php
/*
*	simPHPle 0.4 json.class.php : Class
*	Handles json files
*/

namespace handlers\files;

class Json extends \File
{
	public static function open($file) // opens a json file
	{
		$content = parent::open($file);
		if($content === false) return false;
		return json_decode($content,true);
	}
	public static function save($file,$content,$erasing = true,$prettyprint = true) // saves content in a json file
	/* erasing = if true, $file exists and $content is an array, will add $content to the file, without touching the rest
	 	 prettyprint = if true, uses the json flag JSON_PRETTY_PRINT which makes files slightly heavier but indents then so they're easier to read */
	{
		if(!$erasing)
		{
			$original = self::open($file);
			if($original === false) return false;
			foreach($content as $key => $value)
			{
				$original[$key] = $value;
			}
		}
		if($prettyprint)
		{
			$result = json_encode($content,JSON_PRETTY_PRINT);
		}
		else
		{
			$result = json_encode($content);
		}
		return parent::save($file,$result);
	}
	public static function get($file,$key) // gets a key, if key is an array, recursively
	{
		$array = self::open($file);
		if($array === false) return false;
		if(is_string($key) || is_int($key))
		{
			if(array_key_exists($key))
			{

			}
			return false;
		}
		elseif(is_array($key))
		{
			return get_recursively($array,$key);
		}
	}
	public static function set($file,$key,$value) // sets a key with value, if key is an array, recursively
	{
		$array = self::open($file);
		if($array === false) // non existant file, creating it
		{
			$value = set_recursively(array(),$key,$value);
			return self::save($file,$value);
		}
		else
		{
			if(is_string($key))
			{
				$array[$key] = $value;
			}
			elseif(is_array($key))
			{
				$array = set_recursively($array,$key,$value);
			}
		}
		return self::save($file,$array);
	}
	public static function delete($file,$keys) // deletes a key in a json array
	{
		function del(&$array,$recursive,$i) // recursive function
		{
			if(array_key_exists($recursive[$i],$array))
			{
				$y = $i + 1;
				if($y == count($recursive)) // i is the last
				{
					unset($array[$recursive[$i]]);
					return true;
				}
				elseif(is_array($array[$i]))
				{
					$i++;
					del($array[$i],$recursive,$i);
				}
				else
				{
					return false; // no need to continue farther
				}
			}
		}
		$array = Json::open($file);
		if($array === false) return false;
		$test = del($array,$keys,0);
		if($test) return Json::save($file,$array);
		return false;
	}
	public static function add($file,$value,$recursiveKey = NULL) // adds a value to a non associative array, if key is an array, recursively
	{
		$array = self::open($file);
		if($array === false) // no file, creating one and adding value
		{
			$value = set_recursively(array(),$recursiveKey,$value,true);
			return self::save($file,$value);
		}
		else
		{
			if($recursiveKey === NULL)
			{
				$array[] = $value;
				return self::save($file,$array);
			}
			elseif(is_string($recursiveKey))
			{
				if(array_key_exists($recursiveKey,$array) && is_array($array[$recursiveKey]))
				{
					$array[$recursiveKey][] = $value;
				}
				else
				{
					$array[$recursiveKey] = $value;
				}
			}
			elseif(is_array($recursiveKey))
			{
				$array = set_recursively($array,$recursiveKey,$value,true);
			}
		}
		return self::save($file,$array);
	}
}
