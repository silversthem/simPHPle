<?php
/* helpers with directories */

function create_dirs($dir) // create multiple dirs at once
{
  $dirs = explode('/',$dir);
  $actual_dir = '';
  foreach($dirs as $d)
  {
    $actual_dir .= $d.'/';
    if(!is_dir($actual_dir))
    {
      mkdir($actual_dir);
    }
  }
}
?>
