<?php
namespace Core\I;

use Core\Router;

interface RouterMiddleware {
  public function handle(Router $router, $next);
}
