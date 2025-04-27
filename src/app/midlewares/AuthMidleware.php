<?php

namespace app\midlewares;

use Closure;
use core\interfaces\MiddlewareInterface;
use core\library\Request;

class AuthMidleware implements MiddlewareInterface
{

    public function handle(Request $request, Closure $next)
    {
        dump("AuthMidleware");
        return $next($request);
    }
}