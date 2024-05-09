<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorehazardsRequest;
use App\Http\Requests\UpdatehazardsRequest;
use Illuminate\Http\Request;
use App\Models\Hazard;
use App\Models\Step;

class HazardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      $id = $request->step_id;

      $hazards = Step::with('hazards')->findOrFail($id)->hazards;

      return $hazards;
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
    public function store(StorehazardsRequest $request)
    {
        $request->validate([
          'step_id' => 'required',
          'title' => 'required'
        ]);

        $step = Step::findOrFail($request->step_id);

        $hazard = new Hazard([
          'title' -> $request->title
        ]);

        $step->hazards()->save($hazard);

      return response('Hazard created successfully', 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(hazard $hazard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(hazard $hazard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatehazardsRequest $request, hazard $hazard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(hazard $hazard)
    {
        //
    }
}
