<?php
use Core\Router;
use Core\Request;

$router = new Router(new Request);

$router->get('/', function() {
  return response()
    ->view('home.index', array(
      'name' => 'Eksa'
    ))
    ->status(403);
});

$router->get('/profile', function($request) {
  return response()->view('profile');
});

$router->get('/test', function($request) {
  $db = config('db.host');

  return response()->text($db);
});

$router->post('/', function($request) {
  return response()
    ->json($request->getBody())
    ->status(422);
});

$router->run();