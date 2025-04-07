<?php

namespace app\controllers;

use app\library\Email;
use core\library\Response;
use Product;

class ProductController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('product', ['title'=>'Products', 'product' => '']);

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
    public function store($request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $product)
    {
        return view('product', ['title'=>$product, 'product'=>$product]);
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