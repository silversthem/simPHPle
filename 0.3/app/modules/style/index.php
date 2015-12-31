<?php
/* The style module */
header('Content-Type: text/css');

if(isset($_GET['modstyle']))
{
  if(file_exists('app/assets/css/'.$_GET['modstyle'].'.css'))
  {
    readfile('app/assets/css/'.$_GET['modstyle'].'.css');
  }
  else
  {
    // error
  }
}
?>
