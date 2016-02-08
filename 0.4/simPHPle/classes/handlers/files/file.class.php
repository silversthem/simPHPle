<?php
/*
*	simPHPle 0.4 files.class.php : Class
*	Handles files
*/

namespace handlers\files;

class File
{
	const WRITABLE = 'writing';
	const READABLE = 'reading';
	const BOTH 		 = 'reading and writing';

	public static function dir_is($dir,$test) // tests something in a dir
	{
		if(!is_dir($dir) || ($test == self::WRITABLE && !is_writable($dir)) || ($test == self::WRITABLE && !is_readable($dir))
		 || ($test == self::BOTH && (!is_writable($dir) || !is_readable($dir))))
		{
			throw new \Exception('Couldn\'t access '.$dir. ' in '.$test.' Permission denied or non existing');
			return false;
		}
		return true;
	}
	public static function is($filename,$test) // tests if we can read/write a file
	{
		$parent = dirname($filename);
		if(!self::dir_is($parent)) return false;
		if(!file_exists($filename) || ($test == self::WRITABLE && !is_writable($filename)) || ($test == self::WRITABLE && !is_readable($filename))
		 || ($test == self::BOTH && (!is_writable($filename) || !is_readable($filename))))
		{
			throw new \Exception('Couldn\'t read in '.$filename.' in '.$test.' Permission denied or non existing');
			return false;
		}
		return true;
	}
	public static function open($filename) // reads a file
	{
		if(!self::is($filename,self::READABLE)) return false;
		return file_get_contents($filename);
	}
	public static function save($filename,$content) // writes content in a file
	{
		if(!self::is($filename,self::WRITABLE)) return false;
		file_put_contents($filename,$content);
		return true;
	}
	public static function append($filename,$content) // adds content to the end of file
	{
		$previous_content = self::open($filename);
		if($previous_content === false) return false;
		$previous_content .= $content;
		return self::save($filename,$previous_content);
	}
	public static function delete($filename) // deletes a file
	{
		if(!self::is($filename,self::BOTH)) return false;
		unlink($filename);
	}
}
?>
