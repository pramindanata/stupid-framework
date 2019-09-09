<?php
namespace Core\I;
  
interface RouterMiddleware {
  public function handle($router, $next);
}