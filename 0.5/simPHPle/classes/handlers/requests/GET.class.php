<?php
/*
  Class
  Used to make get requests
  Can also be used statically
*/

namespace handlers\requests;

class GET implements \IHandler
{
  protected $name; // Will try to get $_GET[$name]
  protected $sub; // If $_GET['name'] doesn't exist, this is the substitute given
  protected $escape; // Should the result be escaped

  public function __construct($name,$substitute = NULL,$escape = true) // Creates a get request, substitute will mean NULL
  {
    $this->name = $name;
    $this->sub = $substitute;
    $this->escape = $escape;
  }
  public function get() // Returns the variale or its substitute
  {
    $r = (array_key_exists($this->name,$_GET)) ? $_GET[$this->name] : $this->sub;
    if($this->escape && !is_null($r))
    {
      return htmlspecialchars($r); // Escaped !
    }
    else
    {
      return $r;
    }
  }
}
?>
