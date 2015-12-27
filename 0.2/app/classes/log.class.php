<?php
/* The log stores what happens */
class log
{
  const FATAL_ERROR = 1; // error that stops everything
  const ERROR = 2; // weird error

  public static function gen_log_file() // gets the log file name to be used
  {

  }
  public static function error($eMessage,$eType = log::ERROR) // registers an error
  {

  }
  public static function php_error($eType,$eString,$eFile,$eLine,$eContext) // registers a php error
  {
    switch($eTYpe)
    {
      case E_USER_ERROR: // fatal error

      break;
      case E_USER_WARNING: // warning

      break;
      case E_USER_NOTICE: // notice

      break;
      default: // other

      break;
    }
  }
  public static function write($text) // write something in the log
  {

  }
}
?>
