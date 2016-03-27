<?php
/*
  Index file, this is where the magic happens
*/

include 'simPHPle/simPHPle.php';

class TestController // A test controller, to demonstrate this beautiful piece of technology
{
  public function say_hi($person = 'Person') // Says hi to a person
  {
    echo "<p>Hello {$person} !</p>";
  }
  public function say_bye($person = 'Person') // Says bye to the same person
  {
    echo "<p>Bye {$person} !</p>";
  }
}

/* Current test */

$app = New App(); // Creating an application

$route = new Route('test','TestController'); // Creating a route linked to a random module, and using TestController as a controller
$route->add('hello/{person?}', // Adding a route to a hello url with an optional parameter
  Get('person'), // Getting the person variable, if there isn't one, default arguments will be used
  Action('say_hi'), // Calling the say_hi method, feeding it the result of the Get
  Action('say_bye')); // Same, since the say_hi method returns nothing, it'll be fed the Get too

$app->router->add_route($route); // Adding this route to the router of the application

$app->exec(); // Executing the application

/* Final test (skeleton of what could be a real life application, not yet finished)
$App = new App();
$App->router->load_route('example'); // Loads route in the example module (route.php file by default)
$App->exec();
*/
?>
