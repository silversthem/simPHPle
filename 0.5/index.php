<?php
/*
  Index file, this is where the magic happens
*/

include 'simPHPle/simPHPle.php';

/* Final test (skeleton of what could be a real life application, not yet finished) */

$App = new App();
$App->load_route('example'); // Loads route in the example module (route.php file by default)
$App->exec();
?>
