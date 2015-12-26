<?php
/* A route is something that loads a module according to parameters */

namespace routing\routes;

load_interface('route');

class route implements \iroute
{
  protected $name; // the module's name, the directory in which its files are in
  protected $path; // the path to the module's name
  protected $patterns = array(); // the patterns
  protected $files = array(); // the files called by default

  public function __construct($name,$path) // creates a route
  {
    $this->name = $name;
    $this->path = $path;
  }
  public function add_pattern($pattern) // adds a pattern, and files to load when the pattern is met
  {
    $this->patterns[] = $pattern;
  }
  public function create_pattern($pattern,$files = array(),$options = array(),$first_regex = false) // creates a pattern
  {
    $p = new \routing\pattern();
    if(is_array($pattern))
    {
      foreach($pattern as $pa)
      {
        $p->add_regex($pa);
      }
    }
    else
    {
      $p->add_regex($pattern);
    }
    if(is_array($files))
    {
      foreach($files as $file)
      {
        $p->add_files($file);
      }
    }
    else
    {
      $p->add_files($files);
    }
    $p->add_option($options);
    $this->patterns[] = &$p;
    return $p;
  }
  public function add_files($files) // adds files
  {
    foreach($files as $file)
    {
      $this->files[] = $file;
    }
  }
  public function name() // returns the modules name
  {
    return $this->name;
  }
  public function path() // returns the path to the module's files
  {
    return $this->path.'/'.$this->name;
  }
  public function test_url($url) // compares the url to the patterns, returning the files needed to be loaded
  {
    foreach($this->patterns as $pattern)
    {
      $r = $pattern->test_url($url,$this,true);
      if($r['result'])
      {
        if(!array_key_exists('overrides',$r) || $r['overrides'] != true)
        {
          foreach($this->files as $file)
          {
            if(!in_array($file,$r['files']))
            {
              $r['files'][] = $file;
            }
          }
        }
        return array('result' => true,'files' => $r['files']);
      }
    }
    return array('result' => false);
  }
  public function create_object() // creates the module object associated with the route
  {
    $GLOBALS[$this->name()] = new \modules\module($this->name(),$this->path());
  }
}
?>
