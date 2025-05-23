<?php

namespace app\controllers;

use app\rules\Cpf;
use core\library\Redirect;
use core\library\Request;

class LoginController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('login', ['title' => 'Login']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validate = $request->validate([
            "email" => "required|email|max:255",
            "password" => "required|".Cpf::class
        ]);

        if($validate->hasErrors()){
            return back()->with($validate->getErrors());
        }

        return $validate->data;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}