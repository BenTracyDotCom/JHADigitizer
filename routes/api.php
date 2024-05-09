<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JhaController;

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