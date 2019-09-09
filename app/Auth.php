<?php
namespace App;

use Core\I\RouterMiddleware;

class Auth implements RouterMiddleware {
  public function handle($router, $next) {
    if (isset($_SESSION['user']['id'])) {
      $user = $_SESSION['user'];
      $router->auth = array(
        'id' => $user['id'],
        'username' => $user['username']
      );
    } else {
      unset($_SESSION['user']);
    }

    return $next();
  }

  public static function user($key = null) {
    if ($key === null) {
      return $_SESSION['user'];
    }

    return $_SESSION['user'][$key];
  }

  public static function check() {
    if (isset($_SESSION['user'])) {
      return true;
    }

    return false;
  }
}