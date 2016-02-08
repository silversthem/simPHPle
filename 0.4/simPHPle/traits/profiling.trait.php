<?php
/*
*	simPHPle 0.4 profiling.trait.php : Trait
*	Stores what objects in the code are doing, development only
*/
trait Profiling
{
	public static $PROFILER_FILE; // the file in which to write the profiling
	public static $PROFILER_CONTENT = array(); // the content that'll we save in $PROFILER_FILE
	public static $PROFILER_WRITE;


	public static function Profiler_write($method,$args) // writes something in the profiler
	{

	}
	public static function Profiler_add_to_log($file) // adds content to a logfile
	{
		
	}
	public static function Profiler_save_profile() // writes the profiler in a file, called automatically in dev but only if there's an error in production
	{

	}
}
?>
