<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorestepsRequest;
use App\Http\Requests\UpdatestepsRequest;
use App\Models\Step;
use App\Models\Jha;

class StepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StorestepsRequest $request)
    {
        $request->validate([
          'jha_id' => 'required',
          'title' => 'required'
        ]);
        
        $img = $request->image;

        $jha = Jha::findOrFail($request->jha_id);
        
        $step = new Step([
          'title' => $request->title,
          'image' => $img ? $img : null
        ]);

        $jha->steps()->save($step);

      return response('Step created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(step $step)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(step $step)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatestepsRequest $request, step $step)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(step $step)
    {
        //
    }
}
