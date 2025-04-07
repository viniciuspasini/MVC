<?php

use core\library\App;

$app = App::create()
    ->withEnv()
    ->withTemplateEngine(\core\templates\Plates::class)
    ->withErrorPage()
    ->withContainer();

