<?php

return array(
  'mode' => 'development',
  'debug' => true,
  'app_url' => 'http://localhost',
  // For Webpack Dev Server
  'asset_url' => 'http://localhost:8080',
  'path' => array(
    'root' => __DIR__,
    'view' => __DIR__ . '/view'
  ),
  'db' => array(
    'host' => 'localhost',
    'name' => 'stupid',
    'username' => 'root',
    'password' => ''
  )
);
