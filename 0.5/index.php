<?php
/*
  Index file, this is where the magic happens
*/

include 'simPHPle/simPHPle.php';

/* Routing test ! */

$App = new App();

$App->router->add_a_route('hello/{name?}/{surname?}', // Saying hello to someone
  array(Get('name'),Get('surname')), // Getting the name
  function($name = 'John',$surname = 'Doe') { // If no name given, calling the person John Doe
    echo "Hello <b>$name $surname</b> !<br/>";
  },
  'Potatoes', // Getting what the person likes
  function($like) {
    echo "You like $like";
});
$App->exec();
?>
