<?php

namespace core\library;

class Request
{
    public function __construct(
        public readonly array $server,
        public readonly array $get,
        public readonly array $post,
        public readonly Session $session,
        public readonly array $cookies,
        public readonly array $headers,
    )
    {
        $this->session->csrf()->check($this);
    }

    public static function create(Session $session): static
    {
        return new static($_SERVER, $_GET, $_POST, $session, $_COOKIE, getallheaders());
    }

    public function validate(array $rules): Validate
    {
        return new Validate()->validate($rules, $this);
    }

    public function get(string $name): ?string
    {
        $httpMethod = strtolower($this->server['REQUEST_METHOD']);

        if($httpMethod && isset($this->$httpMethod[$name])){
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

    public function isAjax(): bool
    {
        return isset($this->headers['X_REQUESTED_WITH']) && $this->headers['X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
}