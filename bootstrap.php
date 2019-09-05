<?php
require_once 'core/Autoloader.php';

use Core\Autoloader;
use Core\Request;

$loader = new Autoloader();

$loader->register();

$loader->addNamespace('Core', __DIR__ . '/core');
$loader->addNamespace('Core\I', __DIR__ . '/core/interface');

require_once 'helper.php';
require_once 'router.php';