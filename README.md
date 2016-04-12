# What is simPHPle ?

simPHPle is a php framework built on 4 core principles (*tetrapharmakon* as a pretentious person would say, such as myself) :
 1. Your app code should be written only once (Non redunancy principle).
 2. The flow of your code should reflect **perfectly** the way your app works, without any ugly weird bits hidden in the dark, everything is visible and transparent.
 3. Short, clean files in neatly arranged directories. No exception.
 4. The guy that has to maintain your code shouldn't try to hang himself with an ethernet cable ( = your code should be elegant, beautiful, smart, easy to read and **very** easy to maintain and change)

In short, the idea is you can go from describing your app on a whiteboard to coding it directly, without logic changes,
and that logic should appear in your code.

## Features
- [x] Routing with control over $_GET parameters
- [ ] Pattern checking on said parameters
- [ ] Default routing when url rewriting is disabled
- [ ] Memoization in flow pile for multiple parameters actions (allows multiple queries)
- [x] Controllers and flow
- [ ] Events and queries
- [ ] Custom events, queries and else
- [ ] Easy database handling
- [ ] Small template engine
- [ ] Multiple parsers
- [ ] Debugging tool
- [ ] Unit testing
- [ ] Libraries
- [ ] Visualisation and conception tools
- [x] Plenty of helpers classes for files, json and others

## Getting started
Just download the framework base folder _(not yet present, still in developpement. But you can see the progress in the 0.5 folder and cute tentatives of making it in the old folder)_ and open the file simPHPle/config.php to change the constant
`BASE_DIR` to where your app is in (it's the folder that'll appear like : localhost*/folder/*index.html).
 You can also change `BASE_FOLDER` to the absolute path of your application if you like, but the default str_replace thing
should work fine.

### Hello world

Now, let's create an app that'll say hello to us when we go to the index.html page
```php
<?php
$app = new App(); // Creating the application
$app->router->add_route('index.html', // Adding a route in the router to index.html
  function() {
    echo 'Hello !';
  }); // Adding a thing to do in the route
$app->exec(); // Running the app
```
Here you see the basic principle, you just add urls to your application and add functions telling it what to do when some
url is typed in.
The function you're adding is actually the first element of the flow pile (or collection pile) that'll be associated with
the route, it means this code :
```php
<?php
$app = new App(); // Creating the application
$app->router->add_route('index.html', // Adding a route in the router to index.html
  function() {
    echo 'Hello !';
  },function() { // This new function will be executed right after !
    echo ' Bye !';
  }
  ); // Adding things to do in the route
$app->exec(); // Running the app
```
will execute the first then the second function in the pile, when you type in "index.html". Note that
the first parameter is the route url, and can be an array, in that case, every possibility will be checked and if one
matches, the route will execute. Also note that if you have multiple routes, only one will be executed, and it'll be
the one being declared first.
#### Slightly cooler hello world
Now we've seen how the basic works, but let's try something different, we would like the hello application to print the
name of the person using the website. This is a great yet simple example of the simPHPle philosophy.
If you were asked to write such a function, you'd probably do something like this :
```php
function say_hello($person = 'person') { // Function saying hello to someone
  echo 'Hello '.$person.' !';
}
```
and that's exactly how it should be written, simple and easy. For the sake of simplicity we decide that the person's name
will be passed as a $_GET request, in a way which we'll produce `Hello mike` for the url `hello/mike`. We'll also specify
that the parameter is optional, so `hello` or `hello/` will print `Hello person`.
Now let's write the application code :
```php
<?php
$app = New App(); // Creating a app
$app->router->add_route('hello/{person?}', // Creating a route with an optional $_GET['person']
  Get('person'), // 1st action, we read the $_GET['person']
  function($person = 'person') { // If $_GET['person'] doesn't exists, it will be empty and 'person' will be used
    echo 'Hello '.$person.' !';
  }
);
$app->exec();
```
And there, it's done ! (note that $_GET person will be escaped by default, if you need to protect it for, let's say
sql queries, you can do that too).
### Controllers & Modules
Writing all your routing logic in your index.php file directly into the router is all fine and dandy, but at some
point it's going to be somewhat big. So what should you do ? You could just write functions in separates files and
load them by their names, but all that would be exhauting too, and quite ugly. We're instead going to use modules
and controllers, which are there to avoid exactly that, (Remember the third principle).
##### Modules
*Soon*
##### Controllers
*Soon*
### Pile & Routing logic
*Soon*
### Templates
*Soon*
### Databases
*Soon*
## What more ?
*Soon*
