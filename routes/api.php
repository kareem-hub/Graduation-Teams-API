<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Teams\TeamsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// public routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/teams', [TeamsController::class, 'index'])->name('teams');
Route::get('/teams/{team}', [TeamsController::class, 'show'])->name('teams.show');
Route::get('/users', function (){
    return response()->json([
        'users' => \App\Models\User::all()
    ]);
})->name('users');

// protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/teams', TeamsController::class, ['except' => ['index', 'show']]);
});
