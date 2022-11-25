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
 * https://www.youtube.com/watch?v=jtNt5_msfvw&list=PLyNTduYoTjqAgvb5GsyG85gj-7RfMCshB&index=33&ab_channel=%F0%9D%97%A6%F0%9D%97%BC%F0%9D%97%B2%F0%9D%97%BB%F0%9D%97%B4%F0%9D%97%A6%F0%9D%97%BC%F0%9D%98%82%F0%9D%98%86
 */
Route::get('usuarios',  [UserController::class, 'index'])->name('users.index');
Route::post('usuarios', [UserController::class, 'search'])->name('users.search');