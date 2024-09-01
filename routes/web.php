<?php

use App\Http\Controllers\AffiliationController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get("/users", [UserController::class, 'index'])->name('users');
Route::get("/positions", [PositionController::class, 'index'])->name('positions');
Route::post("/positions", [PositionController::class, 'store'])->name('positions.store');
Route::delete("/positions/{position}", [PositionController::class, 'destroy'])->name('positions.destroy');
Route::patch("/positions/{position}", [PositionController::class, 'update'])->name('positions.update');

Route::get("/affiliations", [AffiliationController::class, 'index'])->name('affiliations');
Route::post("/affiliations", [AffiliationController::class, 'store'])->name('affiliations.store');
Route::delete("/affiliations/{affiliation}", [AffiliationController::class, 'destroy'])->name('affiliations.destroy');
Route::patch("/affiliations/{affiliation}", [AffiliationController::class, 'update'])->name('affiliations.update');

Route::get("/locations", [LocationController::class, 'index'])->name('locations');
Route::post("/locations", [LocationController::class, 'store'])->name('locations.store');
Route::delete("/locations/{location}", [LocationController::class, 'destroy'])->name('locations.destroy');
Route::patch("/locations/{location}", [LocationController::class, 'update'])->name('locations.update');

// useless routes
// Just to demo sidebar dropdown links active states.
Route::get('/buttons/text', function () {
    return view('buttons-showcase.text');
})->middleware(['auth'])->name('buttons.text');

Route::get('/buttons/icon', function () {
    return view('buttons-showcase.icon');
})->middleware(['auth'])->name('buttons.icon');

Route::get('/buttons/text-icon', function () {
    return view('buttons-showcase.text-icon');
})->middleware(['auth'])->name('buttons.text-icon');

require __DIR__ . '/auth.php';
