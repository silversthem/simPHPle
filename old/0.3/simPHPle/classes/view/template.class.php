<?php
/* a template object can use and fill your templates files to display them */

namespace view;

class template implements \icachable
{
    protected $filename; // the template file
    protected $content; // the content of the file
    protected $vars = array(); // the vars to replace
    protected $parsers = array();

    public function __construct($filename,$defaultparser = true) // creates a template
    {
      $this->filename = TEMPLATES_PATH.'/'.$filename.TEMPLATES_EXT;
      if(file_exists($this->filename))
      {
        $this->content = file_get_contents($this->filename);
      }
      else
      {
        // error
      }
      if($defaultparser)
      {
        $this->add_parser(new \view\parser()); // adds the default parser
      }
    }
    public function add_vars($a) // adds vars from an array
    {
      foreach($a as $k => $v)
      {
        $this->add_var($k,$v);
      }
    }
    public function add_var($key,$value) // adds a var
    {
      $this->vars[$key] = $value;
    }
    public function get_var($key) // gets a var
    {
      if(array_key_exists($key,$this->vars))
      {
        return $this->vars[$key];
      }
      return false;
    }
    public function __set($key,$value) // same as add_var
    {
      $this->add_var($key,$value);
    }
    public function __get($key) // same as get_var
    {
      $this->get_var($key);
    }
    public function add_parser($parser) // adds a parser
    {
      $this->parsers[] = $parser;
    }
    protected function parse($content) // parses stuff
    {
      foreach($this->parsers as $parser) // uses all the available parsers
      {
        $parser->set_template($this);
        $content = $parser->parse($content);
      }
      return $content;
    }
    public function gen_cache($f) // creates a cache file
    {
      // ...
    }
    public function use_cache($f) // use the cache file instead of generating everything
    {
      // ...
    }
    public function display() // displays the template
    {
      return $this->parse($this->content);
    }
}
?>
