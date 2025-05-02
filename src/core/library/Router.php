<?php

namespace core\library;

use core\controllers\NotFoundController;
use core\exceptions\ControllerNotFoundException;
use core\exceptions\MiddlewareNotFoundException;
use DI\Container;

class Router
{
    protected array $routes = [];
    protected string $controller;
    protected string $action;
    protected array $params = [];
    protected Response $response;
    protected array|string $middleware = [];

    public function __construct(private readonly Container $container, private readonly Request $request)
    {

    }

    public function add(string $method, string $uri, array $route): static
    {
        $route[2] = [];
        $this->routes[$method][$uri] = $route;

        return $this;
    }

    public function middleware(string|array $middlewares): void
    {
        if(isset($this->routes[REQUEST_METHOD])){
            $this->routes[REQUEST_METHOD][array_key_last($this->routes[REQUEST_METHOD])][2] = $middlewares;
        }
    }

    /**
     * @throws MiddlewareNotFoundException
     * @throws ControllerNotFoundException
     */
    public function execute(): void
    {
        foreach ($this->routes as $method => $routes) {
            if($method === $this->request->server['REQUEST_METHOD']) {
                $this->handleUri($routes);
            }
        }
    }

    /**
     * @throws ControllerNotFoundException
     * @throws MiddlewareNotFoundException
     * @throws \Exception
     */
    private function handleUri(array $routes): void
    {
        foreach ($routes as $uri => $route) {

            if ($uri === $this->request->server['REQUEST_URI']) {
                [$this->controller, $this->action, $this->middleware] = $route;
                break;
            }

            $pattern = str_replace('/', '\/', trim($uri, '/'));
            if ($uri !== '/' && preg_match("/^$pattern$/", trim(REQUEST_URI, '/'), $this->params)) {
                [$this->controller, $this->action, $this->middleware] = $route;
                unset($this->params[0]);
                break;
            }
        }
        if ($this->controller){
            $this->handleMiddleware();
            $this->handleController();
            return;
        }

        $this->handleNotFound();
        
    }

    /**
     * @throws MiddlewareNotFoundException
     */
    private function handleMiddleware(): void
    {
        $middleWares = [
            ...(array)resolve("middleware"),
            ...(array)$this->middleware
        ];

        if($middleWares){
            new Middleware($this->request)->handle($middleWares);
        }
    }

    /**
     * @throws ControllerNotFoundException
     */
    private function handleController(): void
    {
        if(!class_exists($this->controller) || !method_exists($this->controller, $this->action)) {
            throw new ControllerNotFoundException("[$this->controller::$this->action] not found");
        }
        $controller = $this->container->get($this->controller);
        $this->response = $this->handleResponse($this->container->call([$controller, $this->action], [...$this->params]));
        $this->response->send();
    }

    /**
     * @throws \Exception
     */
    private function handleNotFound(): void
    {
        $notFoundController = new NotFoundController();
        $notFoundController->index();
    }

    private function handleResponse(Response|array|string $response): Response
    {

        if(is_array($response)) {
            $response = response(
                headers: ['Content-Type' => 'application/json'],
            )->json($response);
        }

        if (is_string($response)) {
            $response = response($response);
        }

        return $response;
    }
}