<?php
/*
  Index file, this is where the magic happens
*/

include 'simPHPle/simPHPle.php';


$App = new App();
$App->router->load_route('example'); // Loads route in the example module (route.php file by default)
$App->exec();
?>
