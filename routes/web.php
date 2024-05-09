<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JhaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
