<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/laravelMix', function () {
  return view('layouts.app');
});

/**
 * 𝗦𝗼𝗲𝗻𝗴 𝗦𝗼𝘂𝘆 - Search with date range in Laravel MySQL
 * https://www.youtube.com/@SoengSouy/videos
 * 
 * http://live.datatables.net/hokacefu/3/edit
 * http://live.datatables.net/ruyezofa/1/edit
 */
Route::get('usuarios',  [UserController::class, 'index'])->name('users.index');
Route::post('usuarios', [UserController::class, 'search'])->name('users.search');

/**
 * Filtrar con la etiqueta select
 * http://live.datatables.net/vepedopa/10/edit
 * Restablecer filtros - https://jsfiddle.net/2k07k5ba/2/ 
 */
Route::get('filtro-select',  [UserController::class, 'filters'])->name('users.filters');