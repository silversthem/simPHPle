<?php
/*
*	simPHPle 0.4 walker.php : Helper
*	Like array walk but checks what the function returns
*/

function walker($array,$func,$keys = false) // Applies a function to all array elements
/* keys =  The keys are also an argument to pass to the function */
{
	$r = true; // the result of each function
	foreach($array as $key => $element)
	{
		if($keys)
			$r = (!$func($key,$element)) ? false : $r; // if one elements returns false, we'll know it
		else
			$r = (!$func($element)) ? false : $r; // same
	}
	return $r;
}

function set_recursively($array,$keys,$value,$add = false) // sets the value in an array at the end of keys
/* add = if true, adds the value to the pile, if last key is an array instead of replacing it */
{
	$reversedKeys = array_reverse($keys);
	$element = $value;
	foreach($reversedKeys as $key)
	{
		$element = array($key => $element);
	}
	if($add) $array = array_merge_recursive($array,$element);
	else $array = array_replace_recursive($array,$element);
	return $array();
}

function get_recursively($array,$keys) // returns the value in an array at the end of keys
{
	foreach($keys as $key)
	{
		if(is_array($array) && array_key_exists($key,$array))
		{
			$array = $array[$key];
		}
		else
		{
			return false; // if it stops finding at some point, it returns false
		}
	}
	return $array[$key];
}
