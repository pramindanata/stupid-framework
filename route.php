<?php
use Core\Router;
use Core\Request;

$router = new Router(new Request);

$router->get('/', array('CheckDemo'), 'HomeController@index');
$router->post('/', null, 'HomeController@store');

$router->get('/profile', null, function($request) {
  return response()->view('profile');
});

$router->run();