<?php
/*
*	simPHPle 0.4 dirs.php : Helpers
*	Functions concerning directories : creating, handling and more...
*/

function create_dir($dir) // creates a dir, if can
{
	$parent_dir = dirname($dir);
	if(is_dir($parent_dir)) // if the parent dir is a directory
	{
		if(is_writable($parent_dir)) // if the parent is a writable directory
		{
			mkdir($dir);
		}
		else
		{
			throw new Exception("Trying to create ".$dir." but its parent ".$parent_dir." isn't a directory");
		}
	}
	else
	{
		throw new Exception("Trying to create ".$dir." but its parent ".$parent_dir." isn't a directory");
	}
}

function create_dirs_recursively($dirs) // creates dirs recursively
{
	$dirs = str_replace('\\','',$dirs);
	$dirs_array = explode('/',$dirs);
	$dir = $dirs_array[0];
	unset($dirs_array[0]);
	create_dir($dir);
	foreach($dirs_array as $d)
	{
		$dir .= '/'.$d;
		create_dir($dir);
	}
}
?>
