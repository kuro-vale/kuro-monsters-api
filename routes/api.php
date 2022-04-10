<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MonsterController;
use App\Http\Controllers\Tokens\TokenController;
use App\Http\Controllers\Tokens\LogoutController;
use Illuminate\Support\Facades\Route;

// Auth Routes

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
// Show user tokens
Route::get('/tokens', [TokenController::class, 'show'])->middleware('auth:sanctum');
// Delete current access token
Route::delete('/logout', [LogoutController::class, 'logout'])->middleware('auth:sanctum');

// Monsters Routes

Route::apiResource('/monsters', MonsterController::class);