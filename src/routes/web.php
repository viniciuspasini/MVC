<?php

use app\controllers\HomeController;
use app\controllers\LoginController;
use app\controllers\ProductController;
use app\controllers\UserController;
use core\library\Router;

$router = $app->container->get(Router::class);

//GET

$router->add('GET', '/', [HomeController::class, 'index']);

$router->add('GET', '/product', [ProductController::class, 'index']);

$router->add('GET', '/product/([a-z\-]+)', [ProductController::class, 'show']);

$router->add('GET', '/login', [LoginController::class, 'index'])->middleware([
    \app\midlewares\TesteMidleWare::class,
    \app\midlewares\AuthMidleware::class
]);

//POST

$router->add('POST', '/login', [LoginController::class, 'store']);

//PUT

//DELETE

$router->add('DELETE', '/user/([0-9\-]+)', [UserController::class, 'store']);


$router->execute();
