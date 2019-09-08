<?php
namespace App\Middleware;

use Core\Request;
use Core\I\Middleware;

class Auth implements Middleware {
  public function handle(Request $request, $next) {
    $auth = true;

    if ($auth) {
      return $next();
    } else {
      return response()->text('Unauthorized')->status(401);
    }
  }
}