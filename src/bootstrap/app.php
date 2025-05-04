<?php

use core\library\App;

$app = App::create()
    ->withEnv()
    ->withSession()
    ->withTemplateEngine(\core\templates\Plates::class)
    ->withMiddleware([
        \core\middlewares\GlobalMiddleware::class,
    ])
    ->withErrorPage()
    ->withDependencyInjectionContainer()
    ->withServiceContainer();

