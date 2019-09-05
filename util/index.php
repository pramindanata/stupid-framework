<?php

require_once '_http.php';

function dd($data) {
  header('Content-Type: application/json');

  echo json_encode($data);
  die();
}

function responseJson($data) {
  header('Content-Type: application/json');

  return json_encode($data);
}
