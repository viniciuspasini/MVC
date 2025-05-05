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
        $this->session->set('csrf', bin2hex(random_bytes(32)));

        return '<input type="hidden" name="csrf" value="'.$this->session->get('csrf').'">';
    }

    public function check(Request $request): void
    {
        if(REQUEST_METHOD !== 'GET' && !in_array(REQUEST_URI, configFile('csrf.ignore'))){

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
        }
    }

}