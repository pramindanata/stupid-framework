<?php

require_once '_config.php';
require_once '_asset.php';
require_once '_http.php';
require_once '_component.php';
require_once '_user.php';
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
