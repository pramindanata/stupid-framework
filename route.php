<?php
use Core\Router;
use Core\Request;

$router = new Router(new Request);

$router->get('/', 'HomeController@index');
$router->post('/', 'HomeController@store');

$router->get('/profile', function($request) {
  return response()->view('profile');
});

$router->get('/test', function($request) {
  $db = config('db.host');

  return response()->text($db);
});

$router->run();