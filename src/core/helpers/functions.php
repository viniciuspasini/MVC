<?php

use core\library\Container;
use core\library\Flash;
use core\library\Response;
use core\library\Template;

/**
 * @throws Exception
 */
function view(string $view, array $data = [], string $viewPath = VIEW_PATH, int $status = 200): Response
{
    return Template::render($view, $data, $viewPath, $status);
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

function flash(string $key, string $style = 'alert alert-danger'): ?string
{
    return session()->flash()->get($key, $style);
}

function csfr(): string
{
    return session()->csrf()->get();
}

function configFile(string $key): array
{
    $file = BASE_PATH . '/app/config/config.php';

    if(!file_exists($file)){
        return [];
    }

    $config = require $file;

    if(str_contains($key, '.')){
        [$key1, $key2] = explode('.', $key);
        return $config[$key1][$key2] ?? [];
    }

    return $config[$key] ?? [];
}

function method(string $method): string
{
    return '<input type="hidden" name="_method" value="'.$method.'">';
}
