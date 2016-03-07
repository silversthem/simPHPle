<?php
/*
* simPHPle 0.4 template.class.php : Class
* Creates a parser fueled template
*/

namespace views;

class Template
{
  public static function dependencies() // template dependencies
  {
    \Loader::load('view/structures','helper');
  }
}
?>
