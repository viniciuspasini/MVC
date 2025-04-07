<?php

namespace core\controllers;

class NotFoundController
{
    /**
     * @throws \Exception
     */
    public function index(): void
    {
        view('error404', ['title' => 'error - 404'], VIEW_PATH_CORE);
    }
}