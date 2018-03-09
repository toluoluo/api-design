<?php
define('APP_PATH', str_replace('\\', '/', __DIR__));
define('NAMESPACE_PATH', str_replace('\\', '/', dirname(__DIR__)));
include 'load.php';
use app\App;
App::run();