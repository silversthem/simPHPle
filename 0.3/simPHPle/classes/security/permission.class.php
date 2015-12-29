<?php
/* A permission checks if certains things can be done/loaded according to certain parameters */

namespace security;

class permission
{
  protected $type; // the type of test we're doing
  protected $test; // the value, depending on what we're looking for

  public function __construct()
  {

  }
  public function set_function($f) // sets a function to check the permission
  {

  }
  public function token($name)
  {

  }
  public function check() // tests if the permission is granted
  {

  }
  public function set_not_granted_function($f) // the function to call when permission not granted
  {

  }
}
?>
