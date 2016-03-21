<?php
/* A module is a piece of the application */

namespace modules;

load_interface('model');
load_interface('view');

class module
{
  public $view; // the view
  public $model; // the model
  protected $model_result = array(); // the result of the model
  protected $actions = array('model' => 'exec','view' => 'exec'); // the method if the view and model are objects
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
  public function model($specific) // reads the model
  {
    if(array_key_exists($specific,$this->model_result))
    {
      return $this->model_result[$specific];
    }
    return false;
  }
  protected function exec_object($object,$action) // executes methods from an object
  {
    if(is_array($action)) // multiple methods
    {
      $results = array(); // the result of each action will be saved separately
      foreach($action as $method)
      {
        if(is_string($method))
        {
          $results[$method] = $object->$method();
        }
      }
      return $results;
    }
    elseif(is_string($action)) // one method
    {
      return $object->$action();
    }
  }
  protected function init_array($type,$array) // inits a view/method array
  {
    if($type == 'view')
    {
      $this->view = array();
    }
    elseif($type == 'model')
    {
      $this->model = array();
    }
    foreach($array as $element)
    {
      if(is_array($element))
      {
        $this->init_array($type,$element);
      }
      elseif($element instanceof \view\view)
      {
        $this->view[$this->element->name()] = $element->load();
      }
      elseif($element instanceof \model\model)
      {
        $this->model[$this->element->name()] = $element->load();
      }
      else
      {
        if($type == 'view')
        {
          $this->view[] = $element;
        }
        elseif($type == 'model')
        {
          $this->model[] = $element;
        }
      }
    }
  }
  protected function exec_array($type,$array) // executes a view/method array
  {
    if($type == 'view')
    {
      foreach($array as $element)
      {
        $this->exec_view($element);
      }
    }
    elseif($type == 'model')
    {
      $results = array();
      foreach($array as $element)
      {
        if(is_object($element))
        {
          $results[get_class($element)] = $this->exec_model($element);
        }
        else
        {
          $results[] = $this->exec_model($element);
        }
      }
      return $results;
    }
  }
  protected function init_view($view) // inits the view, if it's an object
  {
    if($view instanceof \view\view)
    {
      $this->view = $view->load();
    }
    elseif(is_array($view)) // multiple views
    {
      $this->init_array('view',$view);
    }
  }
  protected function init_model($model) // inits the model, if it's an object
  {
    if($model instanceof \model\model)
    {
      $this->model = $model->load();
    }
    elseif(is_array($model)) // multiple models
    {
      $this->init_array('model',$model);
    }
  }
  protected function exec_view($view) // launches a view
  {
    if(is_array($view)) // multiple views
    {
      $this->exec_array('view',$view);
    }
    elseif(is_callable($view))
    {
      $view();
    }
    elseif(is_object($view))
    {
      if(array_key_exists('view',$this->actions)) // reading what method(s) to call
      {
        $this->exec_object($view,$this->actions['view']);
      }
      else
      {
        // error
      }
    }
    elseif(is_string($view))
    {
      load_view($view);
    }
  }
  protected function exec_model($model) // launches a model
  {
    if(is_array($model))
    {
      return $this->exec_array('model',$model);
    }
    elseif(is_callable($model))
    {
      return array('function' => $model());
    }
    elseif(is_object($model))
    {
      if(array_key_exists('model',$this->actions))
      {
        return array(get_class($model) => $this->exec_object($model,$this->actions['model']));
      }
      else
      {
        // error
      }
    }
    elseif(is_string($model))
    {
      return array($model => load_model($model));
    }
  }
  public function exec() // executes the module, loading the views, models and so on
  {
    $this->init_model($this->model);
    $this->init_view($this->view);
    $this->model_result = $this->exec_model($this->model);
    $this->exec_view($this->view);
  }
}
?>
