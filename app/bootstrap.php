<?php

/**
 * Bootstrap file
 *
 * @package FilmApi
 */

use FilmAPI\Router;

const BASE_PATH = __DIR__ . "/../";

// load config file
require_once BASE_PATH . "/app/config.php";

// load all classes
$includeDirs = [
    'src/classes',
    'src/controller',
    'src/exception',
    'src/model',
    'src/repository',
    'src/validator',
];
foreach ($includeDirs as $path) {
    $files = glob(BASE_PATH . $path . '/*.php');

    // Make sure that Base files will load first.
    usort($files, function ($file1, $file2) {
        return str_starts_with(basename($file2), 'Base') ? 1 : -1;
    });

    foreach ($files as $file) {
        require_once $file;
    }
}

// Add routes
require_once BASE_PATH . "/app/routes.php";

$router = Router::getInstance();
$router->run('api');
