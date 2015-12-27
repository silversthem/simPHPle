<?php
/* Used to validate forms */
class validform
{
  protected $content; // post or get depending on user
  protected $vars = array(); // vars to test
  protected $complex = false; // if the validform is complex

  const GET = 0; // get method
  const POST = 1; // post method
  const EXISTS = 2; // if the var exists
  const EQUAL = 3; // if the var is equal to $test
  const NOT_EQUAL = 4; // if the var is NOT equal to $test
  const HASH_EQUAL = 5; // if the thing is equal to hashed $test

  public function __construct($method) // creates a validform object
  {
    if($method == validform::GET)
    {
      $this->content = $_GET;
    }
    elseif($method == validform::POST)
    {
      $this->content = $_POST;
    }
  }
  public function add($var,$typeTest = validform::EXISTS,$test = '') // add something to test
  {
    if(array_key_exists($var,$this->vars)) // if there's already conditions
    {
      $this->vars[$var][] = array($typeTest => $test);
    }
    else // new one
    {
      $this->vars[$var] = array(array($typeTest => $test));
    }
  }
  protected function test_var($v,$name) // test a var, if complex returns an array with the errors
  {
    $errors = array();
    $isCorrect = true;
    foreach($v as $tests)
    {
      foreach($tests as $type => $test)
      {
        if(!array_key_exists($name,$this->content)) // if the thing doesn't exist
        {
          $isCorrect = false;
          $errors[] = array($name => 'inexistant');
        }
        elseif($type == validform::EQUAL) // if the thing is equal to $test
        {
          if($this->content[$name] != $test)
          {
            $isCorrect = false;
            $errors[] = array($name => 'not equal');
          }
        }
        elseif($type == validform::NOT_EQUAL) // if the thing is not equal to $test
        {
          if($this->content[$name] == $test)
          {
            $isCorrect = false;
            $errors[] = array($name => 'equal');
          }
        }
        elseif($type == validform::HASH_EQUAL) // if the thing is equal to hashed $test
        {
          if(crypt($this->content[$name],SALT) != $test)
          {
            $isCorrect = false;
            $errors[] = array($name => 'not equal');
          }
        }
      }
    }
  }
  public function complex() // a complex validform returns what was wrong instead of false
  {
    $this->complex = true;
  }
  public function test() // runs the test
  {
    $errors = array();
    foreach($this->vars as $name => $v)
    {
      
    }
  }
}
?>
