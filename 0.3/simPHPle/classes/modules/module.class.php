<?php
/* A module is a piece of the application */

namespace modules;

load_interface('model');
load_interface('view');

class module
{
  public $view; // the view
  public $model; // the model
  protected $model_result = NULL; // the result of the model
  protected $actions = array(); // the method if the view and model are objects
  protected $name; // the directory name
  protected $path; // the path to the module's dir

  public function __construct($name,$path) // creates a module
  {
    $this->name = $name;
    $this->path = $path;
  }
  public function set_couple($model,$view,$actions = array()) // creates a link
  {
    $this->model = $model;
    $this->view = $view;
    $this->actions = $actions;
  }
  public function model() // reads the model
  {
    return $this->model_result;
  }
  protected function exec_view($view) // launches a view
  {
    if($view instanceof \view\view)
    {
      if(array_key_exists('view',$this->actions))
      {
        $method = $this->actions['view'];
        $view->$method();
      }
      else
      {
        $view->exec();
      }
    }
    elseif(is_callable($view))
    {
      $view();
    }
    elseif(is_string($view))
    {
      load_view($view);
    }
  }
  protected function exec_model($model) // launches a model
  {
    if($model instanceof \imodel)
    {
      if(array_key_exists('model',$this->actions))
      {
        $method = $this->actions['model'];
        $model->$method();
      }
      else
      {
        $view->exec();
      }
    }
    elseif(is_callable($model))
    {
      return $model();
    }
    elseif(is_string($model))
    {
      return load_model($model);
    }
  }
  public function exec() // executes the module, loading the views, models and so on
  {
    $this->model_result = $this->exec_model($this->model);
    $this->exec_view($this->view);
  }
}
?>
