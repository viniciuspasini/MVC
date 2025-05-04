<?php

use core\library\Container;
use core\library\Response;
use core\library\Template;

/**
 * @throws Exception
 */
function view($view, $data = [], $viewPath = VIEW_PATH): Response
{
    return Template::render($view, $data, $viewPath);
}

function bind(string $key, mixed $value): void
{
    Container::bind($key, $value);
}

function resolve(string $key)
{
    return Container::resolve($key);
}

function response(string $content = '', int $statusCode = 200, array $headers = []): Response
{
    return new Response($content, $statusCode, $headers);
}

function session(): \core\library\Session
{
    return Container::resolve(\core\library\Session::class);
}

function redirect(string $to = ""): Response
{
    return resolve(\core\library\Redirect::class)->to($to);
}

function back(): Response
{
    return resolve(\core\library\Redirect::class)->back();

}
