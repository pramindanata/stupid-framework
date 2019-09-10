<?php
namespace App\Controller;

use Core\Request;

class AuthController {
  public function index() {
    return response()->view('login');
  }

  public function login(Request $request) {
    $body = $request->getBody();
    $username = $body['username'];

    $_SESSION['user'] = array(
      'id' => 1,
      'username' => $username
    );

    return response()->redirect('/');
  }

  public function logout() {
    unset($_SESSION['user']);

    return response()->redirect('login');
  }
}
