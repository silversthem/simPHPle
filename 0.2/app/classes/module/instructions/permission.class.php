<?php
/* Handles whether something can be done, like loading a file */
namespace module\instructions;

class permission
{
  protected $condition; // the thing to test
  protected $info; // an info relative to the test
  protected $data; // if neccessary, the data to match
  protected $parents = array(); // the parents permission, this permission will only be true if all parents are too
  protected $friends = array(); // the friends permission, if one of the friend is true, this permission will be

  const SESSION_EXISTS = 1; // test if the var exists in $_SESSION
  const SESSION_MATCHES = 2; // test if $info matches the $_SESSION var
  const SOMETHING_ELSE = 3; // test if $data matches the user var directly

  public function __construct($condition,$info,$data = false) // creates a permission
  {

  }
  public function add_parents() // adds parents permission
  {

  }
  public function add_friends() // adds friends permission
  {

  }
  public function add_parent($p) // adds a parent permission
  {

  }
  public function add_friend($f) // adds a friend permission
  {

  }
  public function test($u = false) // see if we can continue
  {

  }
}
?>
