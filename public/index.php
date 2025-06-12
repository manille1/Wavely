<?php
    session_start();

    $config = require_once __DIR__ . '/../app/config/config.php';
    require_once __DIR__ . '/../app/core/Database.php';
    $db = new Database($config['db']);
    $pdo = $db->getPDO();

    require_once "../app/core/functions.php";

    require_once "../app/core/router.php";
    $router = new Router($pdo);


    $router->addRoute('/', 'AuthController@showLogin');
    $router->addRoute('/login/submit', 'AuthController@login');
    $router->addRoute('/register/submit', 'AuthController@register');
    $router->addroute('/logout', 'AuthController@logout');
    
    $router->addRoute('/feed', 'Feed@showFeed');

    $router->addRoute('/profile', 'Profile@show');

    $router->dispatch($_SERVER['REQUEST_URI']);

?>
