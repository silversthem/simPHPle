<?php
/* A module is a piece of the application */

namespace modules;

class module
{
  protected $views = array(); // the views linked
  protected $models = array(); // the models of the module
  protected $links = array(); // the models/views linked
  protected $name; // the directory name
  protected $path; // the path to the module's dir

  public function __construct($name,$path) // creates a module
  {
    $this->name = $name;
    $this->path = $path;
  }
  public function model($name) // access a model
  {

  }
  public function view($name) // access a view
  {

  }
  public function use_model($model) // registers a model for the module to use
  {

  }
  public function use_view($view) // registers a view for the module to use
  {

  }
  public function exec() // executes the module, loading the views, models and so on
  {

  }
}
?>
