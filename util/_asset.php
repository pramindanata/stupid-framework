<?php

// Root is public folder
function asset($name) {
  $url;

  if (config('mode') === 'development') {
    $url = config('asset_url') . $name;
  } else {
    $url = config('app_url') . $name;
  }

  return $url;
}
