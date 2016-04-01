<?php
/*
  Class
  Handles errors, uncaught exceptions and backtrace,warning,notices in development
*/

namespace handlers\log;

class Journal
{
  static $writer; // the object in which errors should be written
  static $timers; // timers created throughout the program
  static $timer_level = 0; // how many timers have been started

  public function __construct(\log\IWriter $writer = NULL) // sets up the Journal, giving it a writer to write into
  {
    self::$timers = array(microtime(true));
    self::$writer = (is_null($writer)) ? new Log() : $writer;
  }
  public static function dependencies() // Journal dependencies
  {
    \loaders\Loader::load_helper('view/skeletons');
  }
  /* Trivial */
  public static function getDailyLog() // returns a YYYY-MM-DD string that can be used to store log in a file
  {
    return date('Y-m-d');
  }
  /* Execution time */
  public static function start_timer() // starts a timer
  {
    self::$timer_level++;
    self::$timers[] = microtime(true);
  }
  public static function end_timer() // returns time since last timer was started
  {
    return (microtime(true) - end(self::$timers));
  }
  public static function timeline() // returns an array to see where we are in relation to the timers
  {
    return array(self::$timer_level,self::end_timer());
  }
  public static function total_timers() // returns an float containing total execution time
  {
    return (microtime(true) - self::$timers[0]);
  }
  /* Error handling */
  public static function register_error($type,$str,$file,$line,$context) // calls the writer to register an error
  {
    self::$writer->error($type,$str,$file,$line,$context);
  }
  public static function uncaught_exception($exception) // calls the writer to give it an uncaught exception
  {
    if($exception instanceof \fException)
    {
      self::$writer->catch_framework_exception($exception);
    }
    else
    {
      self::$writer->catch_exception($exception);
    }
  }
  /* Backtracing */
  public static function write($content) // Writes stuff in the writer used
  {
    self::$writer->log($content);
  }
  public static function profile($type,$element) // handles element to be profiled, by type
  {
    self::$writer->backtrace($type,$element);
  }
}
?>
