<?php
namespace App\Middleware;

use App\Auth as AuthService;
use Core\Request;
use Core\I\Middleware;

class Auth implements Middleware {
  public function handle(Request $request, $next) {
    if ($request->requestUri === '/login') {
      if (AuthService::check()) {
        return response()->redirect('/');
      } else {
        return $next();
      }
    }

    if (AuthService::check()) {
      return $next();
    } else {
      return response()->redirect('login')->status(401);
    }
  }
}