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
        return '<input type="hidden" name="_csrf" value="'.$this->session->get('csrf').'">';
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


    private function csrfNotFound(Request $request, $view, array $data): void
    {
        if($request->isAjax()){
            response(
                statusCode: 419,
                headers: ['Content-Type' => 'application/json']
            )->json([$data['msg']])->send();
        }else{
            view(
                $view,
                $data,
                VIEW_PATH_CORE
            )->send();
        }
        die;
    }

    public function check(Request $request): void
    {


        if(REQUEST_METHOD !== 'GET' && !$this->regexIgnoreRoutes()){

            if (!$request->get('_csrf')){
                $this->csrfNotFound(
                    $request,
                    'error319',
                    ['title' => 'error - 319', 'msg' => 'The CSRF token was not provided'],
                );
            }

            if(!hash_equals($request->get('_csrf'), $this->session->get('csrf'))){
                $this->csrfNotFound(
                    $request,
                    'error319',
                    ['title' => 'error - 319', 'msg' => 'The CSRF token not matched'],
                );
            }

            $this->session->remove('csrf');
        }
    }

}