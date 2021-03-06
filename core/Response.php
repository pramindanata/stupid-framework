<?php
namespace Core;

class Response
{
  private $type = null;
  public $statusCode = 200;

  // View
  private $viewFilePath;
  private $viewData = array();

  // JSON
  private $jsonData;

  // Text
  private $textData;

  /**
   * Return view
   *
   * @param String $fileName
   * @param Array $data
   *
   * @return Response
   */
  public function view($fileName, array $data = array()) {
    $this->type = 'view';
    $this->viewFilePath = str_replace('.', '/', $fileName) . '.php';
    $this->viewData = $data;

    return $this;
  }

  /**
   * Return json
   *
   * @param Array $data
   * @return Response
   */
  public function json(array $data) {
    $this->type = 'json';
    $this->jsonData = json_encode($data);

    return $this;
  }

  /**
   * Return text
   *
   * @param String $text
   * @return Response
   */
  public function text($text) {
    $this->type = 'text';
    $this->textData = $text;

    return $this;
  }

  /**
   * Set response status
   *
   * @param Number $code
   * @return Response
   */
  public function status($code) {
    if ($this->type === null) {
      $this->type = 'status';
    }

    $this->statusCode = $code;

    return $this;
  }

  /**
   * Redirect request
   *
   * @param String $route
   * @return void
   */
  public function redirect($route) {
    // Immediately redirect
    $url = null;
    $parsedUrl = parse_url($route);

    if (isset($parsedUrl['scheme']) && ($parsedUrl['scheme'] === 'http' || $parsedUrl['scheme' === 'https'])) {
      $url = $route;
    } else {
      $url = route($route);
    }


    header('location:' . $url);

    die();
  }

  private function handleView() {
    $data = $this->viewData;

    require_once config('path.root') . '/view/' . $this->viewFilePath;
  }

  private function handleJson() {
    header('Content-Type: application/json');

    echo $this->jsonData;
  }

  private function handleText() {
    echo $this->textData;
  }

  private function handleStatus() {
    echo getHttpCodeMessage($this->statusCode);
  }

  private function resolve() {
    if ($this->type === null) {
      throw new \Exception('No response type choosed');
    } else if ($this->type === 'view') {
      $this->handleView();
    } else if ($this->type === 'json') {
      $this->handleJson();
    } else if ($this->type === 'text') {
      $this->handleText();
    } else {
      $this->handleStatus();
    }

    return $this;
  }

  function __destruct() {
    return $this->resolve();
  }
}
