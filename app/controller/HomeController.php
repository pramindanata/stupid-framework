<?php
namespace App\Controller;

use Core\Request;
use App\Middleware\CheckDemo;

class HomeController {
  public function index(Request $request) {
    return response()
      ->view('home.index', array(
        'name' => 'Eksa',
        // 'demo' => $request->getPayload('demo')
      ));
  }

  public function store(Request $request) {
    return response()
      ->json($request->getBody());
  }
}