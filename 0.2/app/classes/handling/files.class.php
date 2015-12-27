<?php
/* Handles a bunch of files */
namespace handling;

class files
{
  protected $list = array(); // the list of files
  protected $reversed_list = array(); // the list of files, from the bottom
  protected $groups = array(); // the groups of files, separated by names

  public function __construct() // creates the object
  {

  }
  public function __get($group) // returns a group
  {

  }
  public function __set($group,$value) // sets a new group
  {

  }
  public function add_file($file) // adds a file to the pile
  {
    $this->list[] = $file;
  }
  public function add_files() // adds multiple files to the pile
  {
    $files = func_get_args();
    foreach($files as $file)
    {
      $this->list[] = $file;
    }
  }
  public function add_files_array($a) // adds files from an array
  {
    if(is_array($a))
    {
      foreach($a as $file)
      {
        $this->list[] = $file;
      }
    }
    else
    {
      $this->list[] = $a;
    }
  }
  public function unshift_file($file) // add file at the end of the pile
  {
    $this->reversed_list[] = $file;
  }
  public function unshift_files() // add files at the end of the pile
  {
    $files = func_get_args();
    foreach($files as $file)
    {
      $this->reversed_list[] = $file;
    }
  }
  public function unshift_files_array($a) // add files at the end of the pile from an array
  {
    foreach($a as $file)
    {
      $this->reversed_list[] = $file;
    }
  }
  public function get_files() // get the files in an array
  {
    $array = array();
    $reversed_array = array_reverse($this->reversed_list);
    foreach($this->list as $file)
    {
      $array[] = $file;
    }
    foreach($reversed_array as $file)
    {
      $array[] = $file;
    }
    return $array;
  }
  public function set_group($name) // creates a group of files
  {

  }
  public function set_groups() // creates multiple groups of files
  {

  }
  public function add_file_to_group($group,$file) // add a file to a group
  {

  }
  public function add_files_to_group($group) // add multiple files to a group
  {

  }
  public function load($base_dir = '') // loads the files
  {
    $files = $this->get_files();
    foreach($files as $file)
    {
      if(file_exists($base_dir.$file))
      {
        include $base_dir.$file;
      }
    }
  }
  public function load_once($base_dir = '') // loads the files once
  {
    $files = $this->get_files();
    foreach($files as $file)
    {
      if(file_exists($base_dir.$file))
      {
        include_once $base_dir.$file;
      }
    }
  }
  public function load_group($base_dir = '') // loads the group
  {

  }
  protected function load_group_once($base_dir = '') // loads the group once
  {

  }
}
?>
