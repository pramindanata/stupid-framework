<?php
use Core\Router;
use Core\Request;
use App\Auth;

$router = new Router(new Request);

$router->apply(new Auth());

$router->get('/', array('Auth'), 'HomeController@index');
$router->post('/', null, 'HomeController@store');

$router->get('/login', array('Auth'), 'AuthController@index');
$router->post('/login', array('Auth'), 'AuthController@login');
$router->post('/logout', array('Auth'), 'AuthController@logout');

$router->get('/profile', null, function($request) {
  return response()->view('profile');
});

$router->run();