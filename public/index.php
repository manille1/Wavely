<?php
    $config = require_once __DIR__ . '/../app/config/config.php';
    require_once __DIR__ . '/../app/core/Database.php';
    $db = new Database($config['db']);
    $pdo = $db->getPDO();

    require_once "../app/core/router.php";
    $router = new Router();

    $router->addRoute('/login', 'Login@show');

    $router->dispatch($_SERVER['REQUEST_URI']);

?>
