<?php

function config($keyPath) {
  $config = require '../config.php';
  $keys = explode('.', $keyPath);
  $explored = array();

  foreach($keys as $key) {
    array_push($explored, $key);

    if (is_array($config)) {
      $config = $config[$key];
    } else {
      $failPath = implode('.', $explored);

      throw new \Exception('Config <code>' . $failPath . '</code> is not an array.');
    }
  }

  return $config;
} 