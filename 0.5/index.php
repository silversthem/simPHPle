<?php
/*
  Index file, this is where the magic happens
*/

include 'simPHPle/simPHPle.php';

/* Current test */

$app = New App();            // Creating an application

$route = new Route();        // Creating a route linked to no module
$route->add('hello/{name?}', // When accessing the hello/ url with an optional parameter
function(){                  // First, executing this function returning the name to display
  return (array_key_exists('name',$_GET)) ? $_GET['name'] : 'Person';},
function($name){            // Then, this function gets the name and displays it in bold, because this person matters !
  echo "Hello <b>{$name}</b>";
});

$app->router->add_route($route); // Adding this route to the router of the application

$app->exec(); // Executing the application

/* Final test (skeleton of what could be a real life application, not yet finished)
$App = new App();
$App->router->load_route('example'); // Loads route in the example module (route.php file by default)
$App->exec();
*/
?>
