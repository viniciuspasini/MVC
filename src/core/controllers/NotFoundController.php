<?php

namespace core\controllers;


use core\library\Response;

class NotFoundController
{
    /**
     * @throws \Exception
     */
    public function index(): Response
    {
        return view('error404', ['title' => 'error - 404'], VIEW_PATH_CORE);
    }
}