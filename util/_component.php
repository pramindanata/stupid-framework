<?php

// To long if use 'component()',`
function part($componentStr, $data = array()) {
  $explodedPath = explode('.', $componentStr);
  $componentPath = implode('/', $explodedPath) . '.php';
  $path = config('path.view') . '/' . $componentPath;

  require($path);
}