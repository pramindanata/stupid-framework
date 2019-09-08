<?php
namespace Core;

use Core\Response;
use Core\I\RequestInterface;

class Router
{
  private $request;
  private $controllerNameSpace = 'App\Controller\\';
  private $supportedHttpMethods = array('GET', 'POST', 'PUT', 'DELETE', 'PATCH');

  function __construct(RequestInterface $request) {
    $this->request = $request;
  }

  // $name: called method name, ex: get, post
  // $args: method args, ex: closure or controller str
  function __call($name, $args) {
    list($route, $handler) = $args;

    if (!in_array(strtoupper($name), $this->supportedHttpMethods)) {
      $this->invalidMethodHandler();
    }

    // Handler can be  a string or a closure 
    if (is_string($handler)) {
      // If a string, then it will be treat as controller
      $controllerStrArr = explode('@', $handler);
      $controllerClassName = $controllerStrArr[0];
      $controllerMethodName = $controllerStrArr[1];

      $handler = array(
        'class' => $this->controllerNameSpace . $controllerClassName,
        'method' => $controllerMethodName
      );
    }

    // Register route with its handler.
    $this->{strtolower($name)}[$this->formatRoute($route)] = $handler;
  }

  function run() {
    $response = $this->resolve();

    if (!($response instanceof Response)) {
      $route = $this->request->requestMethod . ' ' . $this->request->requestUri;

      throw new \Exception('Reponse of "' . $route . '" must be instance of Core\Response !');
    }
  }

  /**
   * Removes trailing forward slashes from the right of the route.
   * @param route (string)
   */
  private function formatRoute($route) {
    // Trim and split query string 
    $result = explode('?', rtrim($route, '/'));

    if ($result[0] === '') {
      return '/';
    }

    return $result[0];
  }

  private function invalidMethodHandler() {
    header("{$this->request->serverProtocol} 405 Method Not Allowed");
  }

  private function defaultRequestHandler() {
    header("{$this->request->serverProtocol} 404 Not Found");

    echo 'Not Found';
      
    die();
  }

  /**
   * Resolves a route
   */
  private function resolve() {
    if (!isset($this->{strtolower($this->request->requestMethod)})) {
      return $this->defaultRequestHandler();
    }

    $methodDictionary = $this->{strtolower($this->request->requestMethod)};
    $formatedRoute = $this->formatRoute($this->request->requestUri);

    // Find route by targeted URI and http method
    if(!array_key_exists($formatedRoute, $methodDictionary)) {
      $this->defaultRequestHandler();
      
      return;
    }

    $handler = $methodDictionary[$formatedRoute];

    if ($handler instanceof \Closure) {
      return call_user_func_array($handler, array($this->request));
    } else {
      // Init controller class
      $controllerObj = new $handler['class']();
      return $controllerObj->{$handler['method']}($this->request);
    }
  }
}