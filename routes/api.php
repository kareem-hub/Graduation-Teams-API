<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Teams\TeamsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// public routes
Route::post('login', [AuthController::class, 'login'])
    ->name('login');
Route::post('register', [AuthController::class, 'register'])
    ->name('register');
Route::get('teams', [TeamsController::class, 'index'])
    ->name('teams');
Route::get('teams/{team_id}', [TeamsController::class, 'show'])
    ->name('teams.show');

// protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout'])
        ->name('logout');
    Route::post('teams', [TeamsController::class, 'store'])
        ->name('teams.create');
    Route::post('teams/{team}', [TeamsController::class, 'update'])
        ->name('teams.update');
    Route::delete('teams/{team}', [TeamsController::class, 'destroy'])
        ->name('teams.destroy');
});
