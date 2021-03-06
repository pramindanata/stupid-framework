<?php
namespace Core;

use Core\I\RequestInterface;

class Request implements RequestInterface
{
  /**
   * Store additional request data here.
   * Ex: auth
   */
  private $payload = array();

  function __construct() {
    $this->bootstrapSelf();
  }

  private function bootstrapSelf() {
    foreach ($_SERVER as $key => $value) {
      $this->{$this->toCamelCase($key)} = $value;
    }
  }

  private function toCamelCase($string) {
    $result = strtolower($string);

    preg_match_all('/_[a-z]/', $result, $matches);

    foreach($matches[0] as $match) {
      $c = str_replace('_', '', strtoupper($match));
      $result = str_replace($match, $c, $result);
    }

    return $result;
  }

  public function addPayload($key, $value) {
    $this->payload[$key] = $value;
  }

  public function getPayload($key = null) {
   if ($key === null) {
     return $this->payload;
   }

   return $this->payload[$key];
  }

  public function getParams() {
    if (isset($this->queryString)) {
      $result = array();

      parse_str($this->queryString, $result);

      $result = array_map('trim', $result);

      return $result;
    }

    return null;
  }

  public function getBody() {
    if ($this->requestMethod === 'GET') {
      return;
    }

    if ($this->requestMethod === 'POST') {
      $body = array();

      foreach ($_POST as $key => $value) {
        $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }

      return $body;
    }
  }
}
