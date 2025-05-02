<?php

namespace core\middlewares;


use Closure;
use core\interfaces\MiddlewareInterface;
use core\library\Request;

class GlobalMiddleware implements MiddlewareInterface
{

    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}