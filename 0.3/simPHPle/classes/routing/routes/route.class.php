<?php
/* A route is something that loads a module according to parameters */

namespace routing\routes;

load_interface('route');

class route implements \iroute
{
  protected $name; // the module's name, the directory in which its files are in
  protected $path; // the path to the module's name
  protected $patterns = array(); // the patterns
  protected $first_pattern = false; // the first pattern, if one
  protected $files = array(); // the files called by default

  public function __construct($name,$path) // creates a route
  {
    $this->name = $name;
    $this->path = $path;
    $this->create_object();
  }
  public function set_first_pattern($f) // sets the first pattern
  {
    $this->first_pattern = $f;
  }
  public function add_pattern($pattern) // adds a pattern, and files to load when the pattern is met
  {
    $this->patterns[] = $pattern;
  }
  public function create_pattern_from_array($a) // creates a pattern from an array
  {
    $files = (array_key_exists('files',$a)) ? $a['files'] : false;
    $permission = (array_key_exists('permission',$a)) ? $a['permission'] : false;
    $overrides = (array_key_exists('overrides',$a)) ? $a['overrides'] : false;
    if(array_key_exists('pattern',$a))
    {
      if(is_array($a['pattern']))
      {
        foreach($a['pattern'] as $pattern)
        {
          $this->create_pattern($pattern,$files,$permission,$overrides);
        }
      }
      else
      {
        $this->create_pattern($a['pattern'],$files,$permission,$overrides);
      }
    }
  }
  public function create_pattern($pattern,$files = array(),$permission = false,$overrides = false) // creates a pattern
  {
    $p = new \routing\pattern();
    if($overrides)
    {
      $p->set_override(true);
    }
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
    if($permission != false)
    {
      $p->add_permission($permission);
    }
    $this->patterns[] = &$p;
    return $p;
  }
  public function add_files($files) // adds files
  {
    if(is_array($files))
    {
      foreach($files as $file)
      {
        $this->files[] = $file;
      }
    }
    else
    {
      $this->files[] = $files;
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
    if($this->first_pattern !== false && !$this->first_pattern->test_url($url,false))
    {
      return false;
    }
    foreach($this->patterns as $pattern)
    {
      $r = $pattern->test_url($url,true);
      if($r['result'])
      {
        $files = ($r['files'] == false) ? array() : $r['files'];
        if(!array_key_exists('overrides',$r) || $r['overrides'] != true)
        {
          foreach($this->files as $file)
          {
            if(!in_array($file,$files))
            {
              $files[] = $file;
            }
          }
          foreach($files as $file)
          {
            include $this->path().'/'.$file;
          }
        }
        elseif(array_key_exists('overrides',$r) && $r['overrides'] == true)
        {
          foreach($files as $file)
          {
            include $this->path().'/'.$file;
          }
        }
        return $this->name();
      }
    }
    return false;
  }
  public function create_object() // creates the module object associated with the route
  {
    $GLOBALS[$this->name()] = new \modules\module($this->name(),$this->path());
  }
}
?>
