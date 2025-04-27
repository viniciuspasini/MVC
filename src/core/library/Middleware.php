<?php

namespace core\library;

use core\exceptions\MiddlewareNotFoundException;
use core\interfaces\MiddlewareInterface;

class Middleware
{
    public function __construct(private Request $request)
    {
    }

    private function  isMiddleware($middleware)
    {
        return (class_exists($middleware) && is_subclass_of($middleware, MiddlewareInterface::class));
    }

    public function handle(array $middleWares)
    {
        $middleware = array_shift($middleWares);

        if(!$middleware){
            return;
        }

        if(!$this->isMiddleware($middleware)){
            throw new MiddlewareNotFoundException("Middleware doesn't exist: {$middleware}");
        }

        $middleware = new $middleware();

        $middleware->handle($this->request, function () use ($middleWares) {
            $this->handle($middleWares);
        });
    }
}