<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Create new Plates instance
$templates = new League\Plates\Engine(__DIR__ . '/../app/views');

$routes = [
    '/' => 'homepage',
    '/about' => 'about'
];
$route = $_SERVER['REQUEST_URI'];

/* Пока шаблоны вызываются сразу, минуя контроллер. */
if(array_key_exists($route, $routes)) {
    // Render a template
    echo $templates->render($routes[$route], ['name' => 'Jonathan']);
} else {
    // Render a template
    echo $templates->render('404');
}



