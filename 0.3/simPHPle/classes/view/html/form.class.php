<?php
/* A class to quickly create simple forms */

namespace view\html;

class form implements icachable
{
  protected $method; // the method GET/POST
  protected $action; // the action page
  protected $hasUpload; // upload special tag
  protected $indentation = true; // indents things nicely
  protected $elements = array(); // the form elements

  public function __construct($method,$action,$upload = false) // creates a form
  {

  }
  public function toggle_indentation($r = false) // toggles form indentation
  {

  }
  public function init($values) // gives values to form elements
  {

  }
  public function use_cache($f) // use the cache instead of loading things one by one
  {

  }
  public function gen_cache($f) // creates a cache file containing the html content of the form
  {

  }
  protected function gen_tab() // useful for indentation
  {
    
  }
  public function display($init_tab = 0) // displays the form, can also save it in cache
  {

  }
}
?>
