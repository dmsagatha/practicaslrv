<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/laravelMix', function () {
  return view('layouts.app');
});

/* Route::controller(UserController::class)->group(function() {
  Route::get('/usuarios-filtrar', 'ajax')->name('users.ajax');
  Route::get('/usuarios', 'index')->name('users.index');
}); */

Route::get('/usuarios',  [UserController::class, 'index'])->name('users.index');
Route::post('usuarios', [UserController::class, 'search'])->name('users.search');