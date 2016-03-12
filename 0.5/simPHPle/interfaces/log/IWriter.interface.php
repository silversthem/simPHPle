<?php
/*
  interface
  Basic methods for classes used to handle log
*/

namespace log;

interface IWriter
{
  public function error($type,$str,$file,$line,$context); // function called when an error is emitted
  public function log($str); // handles a text
  /* Development */
  public function backtrace($type,$str); // handles backtraces
  /* Exception handling */
  public function catch_exception($exception); // when an exception goes uncaught
  public function catch_framework_exception($exception); // when a framework exception goes uncaught
}
?>
