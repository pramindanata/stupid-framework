<?php
include_once 'core/Request.php';
include_once 'core/Router.php';

use Core\Router;
use Core\Request;

$router = new Router(new Request);

$router->get('/', function() {
  return <<<HTML
  <h1>Hello world</h1>
HTML;
});

$router->get('/profile', function($request) {
  return <<<HTML
  <h1>Profile</h1>
HTML;
});

$router->get('/test', function($request) {
  return responseJson($request->getParams());
});

$router->post('/data', function($request) {
  return responseJson($request->getBody());
});