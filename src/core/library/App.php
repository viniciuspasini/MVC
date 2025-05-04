<?php

namespace core\library;

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Spatie\Ignition\Ignition;
use function DI\factory;

class App
{
    public \DI\Container $container;
    public readonly Session $session;
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

    public function withSession(): static
    {
        $this->session = new Session();
        $this->session->previousUrl();
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
    public function withDependencyInjectionContainer(): static
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            Request::class => factory([
              Request::class,
              'create'
            ])->parameter('session', $this->session),

            Session::class => function () {
                return $this->session;
            },

            Redirect::class => function () {
                return new Redirect($this->session);
            }
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

    public function withServiceContainer(): static
    {
        bind(Redirect::class, function () {
            return new Redirect();
        });

        bind(Session::class, function () {
            return $this->session;
        });

        bind(Redirect::class, function () {
            return new Redirect($this->session);
        });

        return $this;
    }
}