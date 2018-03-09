<?php
/*

*/

namespace routing;

class Route {
  /* Attributes */
  protected $pattern; // URLPattern to access the route
  protected $action;  // Callable representing the action
  protected $env;     // Eventual Object/Class Environment for method calling

  public function __construct($pattern,$action,$env = NULL) { // Creating a route
    $this->pattern = $pattern;
    $this->action  = $action;
    $this->env     = $env;
  }
  public function match($request) { // if request matches route
    return $request->apply($this->pattern);
  }
  public function call(...$args) { // Calls route
    if(!is_null($this->env) && is_callable([$this->env,$this->action],true)) {
      return call_user_func([$this->env,$this->action],...$args);
    } elseif(is_callable($this->action)) {
      return call_user_func($this->action,...$args);
    }
  }
}
