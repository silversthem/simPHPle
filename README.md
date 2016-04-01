# What is simPHPle ?

simPHPle is a php framework built on 4 core principles :
* Your app code should be written only once (Non redunancy principle)
* The flow of your code should reflect *perfectly* the way your app works (like REST, but even further)
* Short, clean files in neatly arranged directories. No exception.
* The guy that has to maintain your code shouldn't try to hang himself with an ethernet cable

In short, the idea is you can go from describing your app on a whiteboard to coding it directly, without logic changes,
and that logic should appear in your code.

## Features
- [x] Routing with control over $_GET parameters
- [ ] Default routing when url rewriting is disabled
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
, you can also change `BASE_FOLDER` to the absolute path of your application if you like, but the default str_replace
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
*Soon*
### Controllers
*Soon*
### Pile & routing logic
*Soon*
### Templates
*Soon*
### Databases
*Soon*
## What more ?
*Soon*
