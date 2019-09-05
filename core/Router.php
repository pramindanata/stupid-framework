<?php
namespace Core;
include_once '../core/interface/RequestInterface.php';

use Core\I\RequestInterface;

class Router
{
  private $request;
  private $supportedHttpMethods = ['GET', 'POST'];

  function __construct(RequestInterface $request) {
   $this->request = $request;
  }

  function __call($name, $args) {
    list($route, $method) = $args;

    if (!in_array(strtoupper($name), $this->supportedHttpMethods)) {
      $this->invalidMethodHandler();
    }

    $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
  }

  /**
   * Removes trailing forward slashes from the right of the route.
   * @param route (string)
   */
  private function formatRoute($route) {
    // Trim and split query string 
    $result = explode('?', rtrim($route, '/'))[0];

    if ($result === '') {
      return '/';
    }

    return $result;
  }

  private function invalidMethodHandler() {
    header("{$this->request->serverProtocol} 405 Method Not Allowed");
  }

  private function defaultRequestHandler() {
    header("{$this->request->serverProtocol} 404 Not Found");

    echo 'Not Found';
  }

  /**
   * Resolves a route
   */
  function resolve() {
    $methodDictionary = $this->{strtolower($this->request->requestMethod)};
    $formatedRoute = $this->formatRoute($this->request->requestUri);

    if(!array_key_exists($formatedRoute, $methodDictionary)) {
      $this->defaultRequestHandler();
      
      return;
    }

    $method = $methodDictionary[$formatedRoute];

    echo call_user_func_array($method, array($this->request));
  }

  function __destruct() {
    $this->resolve();
  }
}