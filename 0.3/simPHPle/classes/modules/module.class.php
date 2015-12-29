<?php
/* A module is a piece of the application */

namespace modules;

load_interface('model');
load_interface('view');

class module
{
  protected $links = array(); // the models/views linked
  protected $models = array(); // the results of models execution
  protected $name; // the directory name
  protected $path; // the path to the module's dir

  public function __construct($name,$path) // creates a module
  {
    $this->name = $name;
    $this->path = $path;
  }
  public function link($model,$view) // creates a link
  {
    $this->links[] = array('model' => $model,'view' => $view);
  }
  protected function exec_view($view,$r) // launches a view
  {
    if($view instanceof \iview)
    {
      $view->exec($r);
    }
    elseif(is_callable($view))
    {
      $view($r);
    }
  }
  protected function exec_model($model) // launches a model
  {
    if($model instanceof \imodel)
    {
      return $model->exec();
    }
    elseif(is_callable($model))
    {
      return $model();
    }
  }
  public function exec() // executes the module, loading the views, models and so on
  {
    foreach($this->links as $link)
    {
      if(array_key_exists('model',$link) && array_key_exists('view',$link))
      {
        $r = $this->exec_model($link['model']);
        $this->exec_view($link['view'],$r);
      }
    }
  }
}
?>
