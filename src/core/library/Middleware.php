<?php

namespace core\library;

use core\exceptions\MiddlewareNotFoundException;
use core\interfaces\MiddlewareInterface;

class Middleware
{
    private MiddlewareInterface $middleware;
    public function __construct(private readonly Request $request)
    {
    }

    private function  isMiddleware($middleware): bool
    {
        return (class_exists($middleware) && is_subclass_of($middleware, MiddlewareInterface::class));
    }

    public function handle(array $middleWares): void
    {
        $middleware = array_shift($middleWares);

        if(!$middleware){
            return;
        }

        if(!$this->isMiddleware($middleware)){
            throw new MiddlewareNotFoundException("Middleware doesn't exist: {$middleware}");
        }

        $this->middleware = new $middleware();

        $this->middleware->handle($this->request, function () use ($middleWares) {
            $this->handle($middleWares);
        });
    }
}