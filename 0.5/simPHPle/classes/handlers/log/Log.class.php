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
    if(MODE == 'DEVELOPMENT')
    {
      // Creating backtrace file, needs router
    }
    else
    {
      $this->file = new \File(BASE_FOLDER.LOG_DIR.'/'.Journal::getDailyLog().'.log');
      $this->file->append('-- Execution started --');
    }

  }
  public function error($type,$str,$file,$line,$context) // either write the error in log or shows it
  {
    if(MODE == 'DEVELOPMENT')
    {
      // ... Generation
    }
    else
    {
      $this->file->append('[Error '.$type.' in '.$file.' (line '.$line.')] : '.$str.' '.print_r($context));
    }
  }
  public function log($str) // writes text in the log
  {
    $this->file->append('Entry in log : '.$str);
  }
  public function backtrace($type,$str) // stores backtrace
  {
    if(MODE == 'DEVELOPMENT')
    {
      // Need router to backtrace -> storing backtrace in url_backtrace.json
    }
  }
  public function catch_exception($exception) // handles exceptions
  {
    if(MODE == 'DEVELOPMENT')
    {
      // ... Generation
    }
    else
    {
      $this->file->append('Exception : '.$exception);
    }
  }
  public function catch_framework_exception($exception) // handles framework exceptions
  {
    if(MODE == 'DEVELOPMENT')
    {
      // ... Generation
    }
    else
    {
      $this->file->append('Framework exception : '.$exception);
    }
  }
}
?>
