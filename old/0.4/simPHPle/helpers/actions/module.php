<?php
/*
* simPHPle 0.4 module.php : Helper
* Functions to help declare while routing a module
*/
namespace actions;

function Couple($model,$view) // creates a router friendly basic model/view couple
{
  return array('model' => $model,'view' => $view,'couple' => true);
}

function Couple_Action($modelAction,$viewAction) // creates a router friendly model/view action
{
  return array('model' => Action($modelAction),'view' => Action($viewAction),'couple_action' => true);
}
?>
