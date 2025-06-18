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
    
    $router->addRoute('/feed', 'FeedController@showFeed');
    $router->addRoute('/user-profile', 'Profile@showOtherProfile');

    $router->addRoute('/profile', 'Profile@show');
    $router->addRoute('/create-album', 'AlbumController@showCreate');
    $router->addRoute('/create-album-send', 'AlbumController@create');
    $router->addRoute('/album', 'AlbumController@showAlbum');
    $router->addRoute('/delete-album', 'AlbumController@delete');

    $router->addRoute('/create-photo', 'PhotoController@showCreate');
    $router->addRoute('/create-photo-send', 'PhotoController@create');
    $router->addRoute('/photo', 'PhotoController@showPhoto');
    $router->addRoute('/delete-photo', 'PhotoController@delete');

    $router->dispatch($_SERVER['REQUEST_URI']);

?>
