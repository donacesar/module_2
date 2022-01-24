<?php
require __DIR__ . '/../vendor/autoload.php';
use League\Plates\Engine;
use App\PdoForAuth;
use Delight\Auth\Auth;

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\Controllers\HomeController', 'index']);
    $r->addRoute('GET', '/about/{amount:\d+}', ['App\Controllers\HomeController', 'about']);
    $r->addRoute('GET', '/verification', ['App\Controllers\HomeController', 'email_verification']);
    $r->addRoute('GET', '/login', ['App\Controllers\HomeController', 'login']);
    // {id} must be a number (\d+)
    //$r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
    //$r->addRoute('GET', '/user/{id:\d+}/company/classes/school/{number:\d+}', ['App\Controllers\HomeController', 'about']);
    // The /{title} suffix is optional
    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        //echo '404. Страница не найдена.';
        $templates = new Engine(__DIR__ . '/../app/views');
        echo $templates->render('404');
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo '405. Метод не разрешен.';
        break;
    case FastRoute\Dispatcher::FOUND:
        $containerBuilder = new \DI\ContainerBuilder();
       $containerBuilder->addDefinitions( [
            Engine::class => function () {
                return new Engine(__DIR__ . '/../app/views');
            },
            PDO::class => function() {
                return new PDO('mysql:host=localhost;dbname=my_database;charset=utf8', 'root', 'root');
            },
            Auth::class => function($container){
                return new Auth($container->get('PDO'));
            }
        ]);
        $container = $containerBuilder->build();

        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $container->call($routeInfo[1], $routeInfo[2]);
        // ... call $handler with $vars
        break;
}
