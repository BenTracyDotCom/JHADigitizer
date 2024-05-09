<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JhaController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\HazardController;
use App\Http\Controllers\ControlController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('jhas', JhaController::class);
/* Routes to the following Jha controller methods:
GET '/jhas' -> index
GET '/jhas' -> create
POST '/jhas' -> store
GET '/jhas/{jha}' -> show
GET '/jhas/{jha}/edit' -> edit
PUT/PATCH '/jhas/{jha}' -> update
DELETE '/jhas/{jha}' -> destroy
*/

Route::resource('steps', StepController::class);

Route::resource('hazards', HazardController::class);

Route::resource('controls', ControlController::class);