<?php

namespace app\midlewares;

use Closure;
use core\interfaces\MiddlewareInterface;
use core\library\Request;

class TesteMidleWare implements MiddlewareInterface
{

    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}