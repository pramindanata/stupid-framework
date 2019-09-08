<?php
namespace App\Controller;

use Core\Request;

class HomeController {
  public function index() {
    return response()
      ->view('home.index', array(
        'name' => 'Eksa'
      ));
  }

  public function store(Request $request) {
    return response()
      ->json($request->getBody());
  }
}