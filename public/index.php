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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Salsa&display=swap" rel="stylesheet">
    
    <title>Wavely.</title>
    <link rel="stylesheet" href="./assets/css/login.css"/>
</head>
<body>

</body>
</html>