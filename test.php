<?php

// Remove query string
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove trailing slashes
$uri = rtrim($uri, '/');

echo $uri;

switch ($uri) {
    case '':
    case '/test':
        echo $uri;
        // require 'controllers/HomeController.php';
        // home(); // Call function or method
        break;

    case '/user':
        // require 'controllers/UserController.php';
        // user();
        break;

    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}