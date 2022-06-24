<?php

use App\Http\Controllers\App\Auth\LoginController;
use App\Http\Controllers\App\Auth\RegisterController;
use App\Http\Controllers\App\AvistamentosController;
use App\Http\Controllers\App\FoundController;
use App\Http\Controllers\App\PetsController;
use App\Http\Controllers\App\UserController;
use Illuminate\Support\Facades\Route;

/* Auth */

Route::prefix('auth')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth:sanctum')->group(function () {

    /* User */
    Route::prefix('users')->group(function () {
        Route::get('/profile', [UserController::class, 'getProfile']);
        Route::post('/profile', [UserController::class, 'postProfile']);
        Route::post('/logout', [UserController::class, 'logout']);
    });

    /* Pets */
    Route::prefix('pets')->group(function () {
        Route::get('/recents', [PetsController::class, 'petRecents']);
        Route::get('/my', [PetsController::class, 'myPets']);
        Route::get('/lost', [PetsController::class, 'petsLost']);
        Route::get('/details/{id}', [PetsController::class, 'petsDetails']);
        Route::post('/store', [PetsController::class, 'petsStore']);
    });

    /* Avistamento */
    Route::prefix('pets')->group(function () {
        Route::get('/avistados', [AvistamentosController::class, 'petsAvistados']);
        Route::get('/avistamentos/{id}', [AvistamentosController::class, 'petsAvistamentos']);
        Route::post('/avistamentos/store', [AvistamentosController::class, 'petsAvistamentosStore']);
    });

    /* Encontrado */
    Route::prefix('pets')->group(function () {
        Route::put('/encontrados/{id}', [FoundController::class, 'petsEncontrados']);
    });
});
