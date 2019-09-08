<?php
namespace Core\I;

use Core\Request;

Interface Middleware {
  public function handle(Request $request, $next);
}