<?php

use core\library\App;

$app = App::create()
    ->withEnv()
    ->withTemplateEngine(\core\templates\Plates::class)
    ->withMiddleware([
        \core\middlewares\GlobalMiddleware::class,
    ])
    ->withErrorPage()
    ->withDependencyInjectionContainer()
    ->withServiceContainer([
        \core\library\Redirect::class,
    ]);

