<?php
/*  The template class */
namespace view;

class template
{
  public $object = NULL; // html/css/js/other
  public $element; // the object created
  public $xml; // the xml object associated to the template file
  protected $type = NULL; // the type of page loaded html/css/js/other
  protected $parameters = array(); // parameters about the object page type
  protected $vars = array(); // the vars in the display
  protected $file; // the main template file
  protected $tid = false; // only load a specific tid in the template file

  const HTML = 0; // a type of template
    const FULL_PAGE = 10; // related parameters
    const ELEMENT = 11; // same
  const CSS  = 1; // another type of template
    const COMPRESSED = 12; // same
  const JS = 2; // another type of template

  public function __construct() // creates a new template object
  {
    $this->xml = new \handling\files\xml();
  }
  public function __set($k,$e) // adds $e to the vars
  {
    $this->set_var($k,$e);
  }
  public function __get($k) // reads a var
  {
    return $this->get_var($k);
  }
  public function set_type($type) // set the type : html/css/js and configures it
  {
    $this->type = $type;
    $specifics = func_get_args();
    unset($specifics[0]);
    $this->parameters = $specifics;
  }
  public function set_file($file) // set the template main file, and opens it
  {
    $this->xml->load($file);
    $this->xml->set_main_node('template');
    $this->file = $file;
  }
  public function set_vars($vars) // sets the vars
  {
    foreach($vars as $key => $var)
    {
      $this->vars[$key] = $var;
    }
  }
  public function set_var($key,$element) // adds $element to the vars
  {
    $this->vars[$key] = $element;
  }
  public function get_var($key) // reads $key
  {
    if(array_key_exists($key,$this->vars))
    {
      return $this->vars[$key];
    }
  }
  public function create_page_object() // creates the page object
  {
    switch($this->type) // the type of template needed
    {
      case \view\template::HTML: // html page
        if(count($this->parameters) == 0) // just a page
        {
          $this->object = new \view\html\page($this);
        }
        elseif($this->parameters[1] == \view\template::ELEMENT) // an element
        {
          $this->object = new \view\html\element($this);
        }
      break;
      case \view\template::CSS: // css page
        // css
      break;
      case \view\template::JS: // js script
        // js
      break;
    }
  }
  public function parse($code = false) // parses basic template code
  {
    if(preg_match_all('#\{\{(.+)\}\}#isU',$code,$matches,PREG_SET_ORDER)) // vars
    {
      foreach($matches as $match)
      {
        if(array_key_exists($match[1],$this->vars)) // if the var exists
        {
          $code = preg_replace('#'.preg_quote($match[0]).'#isU',$this->vars[$match[1]],$code);
        }
        else // if it doesn't
        {
          $code = preg_replace('#'.preg_quote($match[0]).'#isU','',$code);
        }
      }
    }
    return $code;
  }
  public function set_template_id($id) // tells what tid should be loaded
  {
    $this->tid = $id;
  }
  public function read_template_id($id) // reads the element with the tid corresponding to $id in the template
  {
    $e = $this->xml->get_elements_by_attribute('tid',$id);
    if(is_object($e)) // if the xml element was found
    {
      $this->xml = $e;
      return true;
    }
    return false;
  }
  public function display_template_id($tid) // displays tid of the template
  {
    $xml = $this->xml;
    if($this->read_template_id($tid))
    {
      $c = $this->display();
      $this->xml = $xml;
      return $c;
    }
    return false;
  }
  public function display() // displays the template
  {
    if($this->object === NULL)
    {
      $this->create_page_object();
    }
    if($this->type === NULL) // not a specific template type
    {

    }
    return $this->object->display();
  }
}
?>
