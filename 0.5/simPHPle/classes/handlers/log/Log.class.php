<?php
/*
  Class
  writes log and backtrace in a file
  In development, shows errors and everything else and writes backtrace
  In production, stores errors and redirects to a 500 error page
*/

namespace handlers\log;

class Log implements \log\IWriter
{
  protected $file; // log file
  public function __construct() // creates a log
  {
    $this->file = new \File(BASE_FOLDER.LOG_DIR.'/'.Journal::getDailyLog().'.log');
    $this->write('-- Execution started --');
  }
  public function write($line) // writes stuff in log
  {
    $this->file->prepend($line."\n");
  }
  public function error($type,$str,$file,$line,$context) // either write the error in log or shows it
  {

  }
  public function framework_error($component,$type,$str) // stores a framework error
  {

  }
  public function library_error($lib,$type,$str) // stores an error emitted by a library
  {

  }
  public function log($str) // writes text in the log
  {

  }
  public function backtrace($type,$str) // stores backtrace
  {

  }
  public function catch_exception($exception) // handles exceptions
  {

  }
  public function catch_framework_exception($exception) // handles framework exceptions
  {

  }
}
?>
