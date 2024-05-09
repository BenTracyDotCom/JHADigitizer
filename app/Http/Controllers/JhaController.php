<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorejhasRequest;
use App\Http\Requests\UpdatejhasRequest;
use Inertia\Inertia;
use App\Models\jha;

class JhaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Welcome');
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
    public function store(StorejhasRequest $request)
    {

      $request->validate([
        'title' => 'required',
        'author' => 'required',
      ]);
      error_log('Validated!');
    }

    /**
     * Display the specified resource.
     */
    public function show(jha $jha)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(jha $jha)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatejhasRequest $request, jha $jha)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(jha $jha)
    {
        //
    }
}
