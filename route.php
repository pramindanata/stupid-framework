<?php
use Core\Router;
use Core\Request;
use Core\Response;

$router = new Router(new Request);

$router->get('/', function() {
  $response = new Response();

  return $response
    ->view('home.index', array(
      'name' => 'Eksa'
    ))
    ->status(403);
});

$router->get('/profile', function($request) {
  $response = new Response();

  return $response->view('profile');
});

$router->get('/test', function($request) {
  $response = new Response();

  return $response->status(401);
});

$router->post('/', function($request) {
  $response = new Response();

  return $response->json($request->getBody())
    ->status(422);
});

$router->run();