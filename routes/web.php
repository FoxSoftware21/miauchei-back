<?php

use App\Http\Controllers\AvistamentosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PetsController;
use App\Http\Controllers\PetsFoundController;
use App\Http\Controllers\PetsLostController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home.index');

    /* Usuários */
    Route::prefix('users')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{id}/update', [UserController::class, 'update'])->name('users.update');
        Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
        Route::delete('/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/search', [UserController::class, 'search'])->name('users.search');
    });

    /* Status */
    Route::prefix('status')->group(function () {
        Route::get('', [StatusController::class, 'index'])->name('status.index');
        Route::get('/create', [StatusController::class, 'create'])->name('status.create');
        Route::post('/store', [StatusController::class, 'store'])->name('status.store');
        Route::get('/{id}/edit', [StatusController::class, 'edit'])->name('status.edit');
        Route::put('/{id}/update', [StatusController::class, 'update'])->name('status.update');
        Route::get('/{id}', [StatusController::class, 'show'])->name('status.show');
        Route::delete('/{id}/delete', [StatusController::class, 'destroy'])->name('status.destroy');
        Route::post('/search', [StatusController::class, 'search'])->name('status.search');
    });

    /* Pets */
    Route::prefix('pets')->group(function () {
        /* Pets Encontrados */
        Route::get('/found', [PetsFoundController::class, 'foundIndex'])->name('pets.found.index');
        Route::post('/found/search', [PetsFoundController::class, 'foundSearch'])->name('pets.found.search');
        Route::get('/found/{id}', [PetsFoundController::class, 'lostPet'])->name('pets.found.lost');

        /* Pets Perdidos */
        Route::get('/lost', [PetsLostController::class, 'lostIndex'])->name('pets.lost.index');
        Route::get('/lost/create', [PetsLostController::class, 'lostCreate'])->name('pets.lost.create');
        Route::post('/lost/store', [PetsLostController::class, 'lostStore'])->name('pets.lost.store');
        Route::post('/lost/search', [PetsLostController::class, 'lostSearch'])->name('pets.lost.search');
        Route::get('/lost/{id}', [PetsLostController::class, 'foundPet'])->name('pets.lost.found');

        /* Pets Comum */
        Route::get('/{id}/edit', [PetsController::class, 'edit'])->name('pets.edit');
        Route::get('/{id}', [PetsController::class, 'show'])->name('pets.show');
        Route::put('/{id}/update', [PetsController::class, 'update'])->name('pets.update');
        Route::delete('/{id}/delete', [PetsController::class, 'destroy'])->name('pets.destroy');
    });

      /* Avistamentos */
      Route::prefix('avistamentos')->group(function () {
        Route::get('', [AvistamentosController::class, 'index'])->name('avistamento.index');
        Route::post('', [AvistamentosController::class, 'store'])->name('avistamento.store');
        Route::post('/{id}', [AvistamentosController::class, 'show'])->name('avistamento.show');
    });
});
