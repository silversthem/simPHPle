<?php
/* Handles the error in the framework */
class errorHandler
{
  protected $errors = array(); // the list of errors made
  const REGULAR = 1; // a type of error, the default one

  public function __construct() // creates an errorHandler object
  {

  }
  public function add($e,$type = errorHandler::REGULAR)
  {

  }
  public function gen_filename() // creates a filename for the log, format YYYY-MM-DD.log
  {

  }
  public function php_error($errno,$errstr,$errfile,$errline) // an error in the code
  {

  }
  public function save($filename) // save the errors
  {

  }
}
?>
