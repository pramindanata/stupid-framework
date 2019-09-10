<?php
namespace App\Middleware;

use Core\Request;
use Core\I\Middleware;

class CheckDemo implements Middleware {
  public function handle(Request $request, $next) {
    $request->addPayload('demo', 'Yay it works :D');

    return $next();
  }
}
