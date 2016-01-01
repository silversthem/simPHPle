<?php
/* A class handling forms */

namespace controllers;

load_interface('form');

class form implements \iform
{
  protected $elements = array(); // the vars inside the global variable
  protected $errors = array(); // all the errors
  protected $type; // the type of form get/post
  protected $upload_handler = NULL; // if something is expected to be uploaded, this object will take care of it
  protected $constructor = array('init' => NULL,'valid' => NULL,'error' => NULL);

  protected $escapes = true; // protection against XSS

  const POST = 'POST';
  const GET = 'GET';
  const VALID = 'valid';
  const INIT = 'init';
  const ERROR = 'error';

  public function __construct($type = \controllers\form::POST) // creates a form
  {
    $this->type = $type;
  }
  public function toggle_security($t = false) // toggles the security on the form
  {
    $this->escapes = false;
  }
  public function set_upload_handler($h) // sets the upload handler
  {
    $this->upload_handler = $h;
  }
  public function set_constructor($case,$constructor) // sets the constructor
  {
    $this->constructor[$case] = $constructor;
  }
  public function configure_constructor($case,$a) // sets up a constructor from an array
  {

  }
  public function configure($a) // sets the whole form with one array
  {

  }
  public function add_element($e) // adds an element from an array
  {

  }
  public function get_result($case) // returns the corresponding constructor
  {
    if(array_key_exists($case,$this->constructor))
    {
      return $this->constructor[$case];
    }
  }
  public function valid() // checks if the form is correctly completed
  {

  }
}
?>
