<?php

namespace core\library;

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Spatie\Ignition\Ignition;

class App
{
    public \DI\Container $container;
    public static function create():self
    {
        return new self();
    }

    public function withEnv(): static
    {
        $dotenv = Dotenv::createImmutable(dirname(__FILE__, 3));
        $dotenv->load();
        return $this;
    }

    public function withErrorPage(): static
    {
        Ignition::make()
            ->setTheme('dark')
            ->shouldDisplayException(env('ENV') === 'DEV')
            ->register();

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function withContainer(): static
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            Request::class => function(){
                return Request::create();
            },
        ]);
        $this->container=$builder->build();
        return $this;
    }

    public function withTemplateEngine(string $engineTemplate): static
    {
        bind('engineTemplate', $engineTemplate);
        return $this;
    }

    public function withMiddleware(array $middlewares): static
    {
        bind('middleware', $middlewares);

        return $this;

    }
}