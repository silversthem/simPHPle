<?php
/* A static class to handle json files */
abstract class json
{
	public static function open($file) // opens a json file and returns an array
	{
		if(file_exists($file))
		{
			$a = json_decode(file_get_contents($file),true);
			if(!is_array($a))
			{
				return false;
			}
			return $a;
		}
		return false;
	}
	public static function save($file,$content,$erase = true) // save an array into a file
	{
		if($erase)
		{
			return file_put_contents($file, json_encode($content,JSON_PRETTY_PRINT));
		}
		else
		{
			$a = json::open($file);
			foreach ($content as $key => $value)
			{
				$a[$key] = $value;
			}
			return file_put_contents($file, json_encode($a,JSON_PRETTY_PRINT));
		}
	}
	public static function get($file,$key) // only reads one parameter in an array
	{
		$a = json::open($file);
		if(array_key_exists($key, $a))
		{
			return $a[$key];
		}
		return false;
	}
	public static function set($file,$key,$content) // sets parameters in an array
	{
		$a = json::open($file);
		if(is_array($a))
		{
			if($content == NULL && array_key_exists($key,$a))
			{
				unset($a[$key]);
				return json::save($file,$a);
			}
			$a[$key] = $content;
			return json::save($file,$a);
		}
		return false;
	}
	public static function add($file,$content) // adds content to a numeric array
	{
		$a = json::open($file);
		if(is_array($a))
		{
			$a[] = $content;
			return json::save($file,$a);
		}
		return false;
	}
}
?>
