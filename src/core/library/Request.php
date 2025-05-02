<?php

namespace core\library;

class Request
{
    public function __construct(
        public readonly array $server,
        public readonly array $get,
        public readonly array $post,
        public readonly array $session,
        public readonly array $cookies,
        public readonly array $headers,
    )
    {
    }

    public static function create(): static
    {
        return new static($_SERVER, $_GET, $_POST, $_SESSION, $_COOKIE, getallheaders());
    }

    public function validate(array $rules): Validate
    {
        return (new Validate())->validate($rules, $this);
    }

    public function get(string $name): ?string
    {
        $httpMethod = strtolower($this->server['REQUEST_METHOD']);

        if($httpMethod){
            return strip_tags($this->$httpMethod[$name]);
        }

        return null;
    }

    public function getAll(): array
    {
        $httpMethod = strtolower($this->server['REQUEST_METHOD']);

        return array_map(function ($value) {
            return strip_tags($value);
        }, $this->$httpMethod);
    }
}