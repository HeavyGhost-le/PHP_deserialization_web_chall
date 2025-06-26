<?php
require_once 'config.php';

ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../assets/php_errors.log');

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    error_log("Error [$errno] $errstr in $errfile on line $errline");
    // Do not throw exception here to avoid breaking flow
}, E_WARNING | E_NOTICE);

ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_strict_mode', 1);
