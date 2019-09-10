<?php
session_start();

require_once 'core/Autoloader.php';

use Core\Autoloader;

$loader = new Autoloader();

$loader->register();

// Register all class here.
$loader->addNamespace('App', __DIR__ . '/app');
$loader->addNamespace('App\Controller', __DIR__ . '/app/controller');
$loader->addNamespace('App\Middleware', __DIR__ . '/app/middleware');
$loader->addNamespace('Core', __DIR__ . '/core');
$loader->addNamespace('Core\I', __DIR__ . '/core/interface');

require_once 'util/index.php';

set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

require_once 'app.php';