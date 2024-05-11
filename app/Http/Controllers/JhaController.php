<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorejhasRequest;
use App\Http\Requests\UpdatejhasRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\jha;

class JhaController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $jhas = Jha::with('steps.hazards.controls')->get();
    return $jhas;
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

    $desc = $request->description;

    $jha = new Jha([
      'title' => $request->title,
      'author' => $request->author,
      'description' => $desc ? $desc : null
    ]);

    $jha->save();

    return response('JHA created successfully', 201);

  }

  /**
   * Display the specified resource.
   */
  public function show(jha $jha)
  {
    // $jha is the literal record
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
    $title = $request->title;
    $author = $request->author;
    $description = $request->description;

    $jha->title = $title ? $title : $jha->title;
    $jha->author = $author ? $author : $jha->author;
    $jha->description = $description ? $description : $jha->description;
    $jha->save();

    return response('Record updated successfully', 200);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(jha $jha)
  {
    if($jha){
      $jha->delete();
    }
    return Jha::all();
  }
}
