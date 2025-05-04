<?php

namespace core\library;

class Flash
{
    public function __construct(private Session $session)
    {

    }

    public function set(array $data): void
    {
        $this->session->set('flash', $data);
    }

    public function get(string $key, string $style = 'alert alert-danger'): ?string
    {
        if($this->session->has('flash.' . $key)){
            $message = $this->session->get('flash.' . $key);
            $this->session->remove('flash.' . $key);
            return "<div class='{$style}'>{$message}</div>";
        }
        return null;
    }
}