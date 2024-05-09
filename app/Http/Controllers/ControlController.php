<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorecontrolsRequest;
use App\Http\Requests\UpdatecontrolsRequest;
use App\Models\Control;
use App\Models\Hazard;

class ControlController extends Controller
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
  public function store(StorecontrolsRequest $request)
  {
    $request->validate([
      'hazard_id' => 'required',
      'title' => 'required'
    ]);

    $hazard = Hazard::findOrFail($request->hazard_id);

    $control = new Control([
      'title'->$request->title
    ]);

    $hazard->controls()->save($control);

    return response('Hazard created successfully', 201);
  }
  /**
   * Display the specified resource.
   */
  public function show(control $control)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(control $control)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdatecontrolsRequest $request, control $control)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(control $control)
  {
    //
  }
}
