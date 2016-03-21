<?php
/* A trait useful when you want to know what you're doing */
trait profiling
{
  protected $profiling_mode = MODE; // DEVELOPMENT = enabled, else not
  static $profiling_file; // the file where everything will be saved

  public function __construct() // stores the class name
  {

  }
  protected function write() // writes something in the profiler
  {
    
  }
}
?>
