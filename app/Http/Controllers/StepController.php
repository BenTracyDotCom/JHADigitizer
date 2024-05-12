<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorestepsRequest;
use App\Http\Requests\UpdatestepsRequest;
use Illuminate\Http\Request;
use App\Models\Step;
use App\Models\Jha;

class StepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id = $request->jha_id;

        //This uses Eloquent functionality to return all 'steps' associated with a Jha with a given ID
        $steps = Jha::with('steps')->findOrFail($id)->steps;

        return $steps;
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

      return $step;
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
        $title = $request->title;
        $image = $request->image;

        $step->title = $title ? $title : $step->title;
        $step->image = $image ? $image : $step->image;

        $step->save();

        return response('Record updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(step $step)
    {
      if($step){
        $step->delete();
      }
      return response('Record successfully removed', 200);
    }
}
