<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoachController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('/auth')
    ->name('auth.')
    ->group(function () {

        Route::post("/login", [AuthController::class, 'Login']);
        Route::post("/register", [AuthController::class, 'Register']);

    });

Route::prefix('coach')
    ->name('coach.')
    ->group(function () {

        Route::post('/register', [CoachController::class, 'register'])
            ->middleware('auth:sanctum')
            ->name('register');

//        Route::get('/getPage', [CoachController::class, 'index'])->name('getPage');

    });
