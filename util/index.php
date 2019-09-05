<?php

require_once '_config.php';
require_once '_http.php';
require_once '_response.php';

function dd($data) {
  header('Content-Type: application/json');

  if (is_object($data)) {
    $data = serialize($data);
  }

  echo json_encode(array(
    'greet' => 'This is DD mode',
    'dd_data' => $data
  ));

  die();
}

function responseJson($data) {
  header('Content-Type: application/json');

  return json_encode($data);
}
