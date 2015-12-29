<?php
/* The class to use when starting an app */

class simPHPle extends \controllers\launcher
{
  public $database;
  public $router;

  public function __construct()
  {
    $this->router = new \routing\router(\routing\router::MAKE_URL);
  }
  public function create_route($module) // creates a route
  {
    $route = new routing\routes\route($module,MODULES_PATH);
    $datas = func_get_args();
    $routing = $datas[1];
    $route->constructor->configure($routing); // configuring the constructor with things it can get
    $first_pattern = (array_key_exists('first_pattern',$routing)) ? $routing['first_pattern'] : false;
    if($first_pattern !== false)
    {
      $f = new routing\pattern();
      $f->add_regex($first_pattern);
      $route->set_first_pattern($f);
    }
    if(array_key_exists('pattern',$routing))
    {
      if(is_array($routing['pattern']))
      {
        foreach($routing['pattern'] as $pattern)
        {
          if(is_array($pattern))
          {
            $route->create_pattern_from_array($pattern);
          }
          else
          {
            $route->create_pattern($pattern,array(),false);
          }
        }
      }
      else
      {
        $route->create_pattern($routing['pattern'],array(),array());
      }
    }
    $this->router->add_route($route);
  }
  public function exec() // starts the application
  {
    $this->init();
    $this->start();
  }
}
?>
