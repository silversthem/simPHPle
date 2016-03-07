<?php
/*
  Helpers
  Simple skeletons to create quick simple html pages and elements
  Mostly pages, tables and forms
  You probably should only use this for debug and during development
*/

function associative_table($array,$keysStyle = 'style="font-weight:bold;"',$valuesStyle = '') // creates a table to display an associative array
{
  ob_start();
  echo '<table>';
  foreach($array as $key => $value)
  {
    if(!is_null($value))
    {
      echo "\n\t".'<tr><td '.$keysStyle.'>'.$key.'</td><td '.$valuesStyle.'>'.$value.'</td></tr>';
    }
  }
  echo "\n".'</table>';
  return ob_get_clean();
}

function skeleton($inBody,$title,$style = '') // creates an quick html skeleton
{

}
?>
