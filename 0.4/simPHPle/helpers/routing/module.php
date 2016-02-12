<?php
/*
* simPHPle 0.4 module.php : Helper
* Functions to help declare while routing a module
*/
namespace routing\module;

function Couple($model,$view) // creates a router friendly basic model/view couple
{
  return array('model' => $model,'view' => $view);
}

function Action($action) // creates an action array
{
  if(is_array($action))
  {
    if(count($action) == 2)
    {
      return array('method' => $action[0],'arguments' => $action[1]);
    }
  }
  elseif(is_string($action))
  {
    return array('method' => $action);
  }
}

function Couple_Action($modelAction,$viewAction) // creates a router friendly model/view action
{
  return array('model' => Action($modelAction),'view' => Action($viewAction));
}
?>
