<?php

namespace core\library;

use core\exceptions\CsrfTokenNotFound;

class Csrf
{
    public function __construct(private readonly Session $session)
    {
    }

    public function get(): string
    {
        if(!$this->session->has('csrf')) {
            $this->session->set('csrf', bin2hex(random_bytes(32)));
        }
        return '<input type="hidden" name="csrf" value="'.$this->session->get('csrf').'">';
    }

    private function regexIgnoreRoutes(): bool
    {
        $excepts = configFile('csrf.ignore');
        if(!empty($excepts)){
            foreach ($excepts as $except) {
                $pattern = str_replace('/', '\/', trim($except, '/'));
                if (preg_match("/^$pattern$/", trim(REQUEST_URI, '/'))){
                    return true;
                }
            }
        }
        return false;
    }

    public function check(Request $request): void
    {


        if(REQUEST_METHOD !== 'GET' && !$this->regexIgnoreRoutes()){

            if (!$request->get('csrf')){
                view(
                    'error319',
                    [
                        'title' => 'error - 319',
                        'msg' => 'The CSRF token was not provided'
                    ],
                    VIEW_PATH_CORE
                )->send();
                die;
            }

            if(!hash_equals($request->get('csrf'), $this->session->get('csrf'))){
                view(
                    'error319',
                    [
                        'title' => 'error - 319',
                        'msg' => 'The CSRF token not matched'
                    ],
                    VIEW_PATH_CORE
                )->send();
                die;
            }

            $this->session->remove('csrf');
        }
    }

}