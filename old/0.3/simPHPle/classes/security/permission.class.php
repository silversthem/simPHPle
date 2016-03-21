<?php
/* A permission checks if certains things can be done/loaded according to certain parameters */

namespace security;

class permission
{
  protected $type; // the type of test we're doing
  protected $test; // the value, depending on what we're looking for
  protected $tokens; // the created tokens

  public function __construct() // creates a permission
  {

  }
  public function set_function($f) // sets a function to check the permission
  {
    $this->type = 'function';
    $this->test = $f;
  }
  public function token($name) // creates a token
  {
    $p = new \security\permission();
    return $p;
  }
  public function check() // tests if the permission is granted
  {
    if($this->type == 'function')
    {
      $f = $this->test;
      return $f();
    }
    return true; // by default, permission granted
  }
  public function set_not_granted_function($f) // the function to call when permission not granted
  {

  }
}
?>
