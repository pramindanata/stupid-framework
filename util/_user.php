<?php
use App\Auth;

function user($key = null) {
  return Auth::user($key);
}
