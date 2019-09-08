<?php
require_once 'core/Autoloader.php';

use Core\Autoloader;
use Core\Request;
use Core\Error;

$loader = new Autoloader();

$loader->register();
$loader->addNamespace('App\Controller', __DIR__ . '/app/controller');
$loader->addNamespace('Core', __DIR__ . '/core');
$loader->addNamespace('Core\I', __DIR__ . '/core/interface');

require_once 'util/index.php';

set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

require_once 'route.php';