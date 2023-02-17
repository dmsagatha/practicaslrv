<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('welcome');
}); */

/* Route::get('/laravelMix', function () {
  return view('layouts.app');
}); */

Route::get('usuarios/crear', [UserController::class, 'create'])->name('users.create');
Route::post('usuarios/store', [UserController::class, 'store'])->name('users.store');
Route::post('temp-upload', [UserController::class, 'tempUplaod'])->name('tempUplaod');
Route::delete('temp-delete', [UserController::class, 'tempDelete'])->name('tempDelete');

/**
 * 𝗦𝗼𝗲𝗻𝗴 𝗦𝗼𝘂𝘆 - Search with date range in Laravel MySQL
 * https://www.youtube.com/@SoengSouy/videos
 * 
 * http://live.datatables.net/hokacefu/3/edit
 * http://live.datatables.net/ruyezofa/1/edit
 */
Route::get('usuarios',  [UserController::class, 'index'])->name('users.index');
Route::post('usuarios', [UserController::class, 'search'])->name('users.search');
Route::delete('usuarios/{user}', [UserController::class, 'destroy'])->name('users.destroy');


Route::controller(UserController::class)->group(function () {
  /**
   * Filtrar con la etiqueta select
   * http://live.datatables.net/vepedopa/10/edit
   * Restablecer filtros - https://jsfiddle.net/2k07k5ba/2/ 
   */
  Route::get('/', 'filters')->name('users.filters');

  /**
   * Eliminación masiva de datos y contador de seleccionados
   * https://www.phpzag.com/delete-multiple-rows-with-checkbox-using-jquery-php-mysql/
   * https://github.com/mbere250/Laravel-8-Ajax-CRUD-with-Yajra-Datatable
   */
  Route::post('usuarios/multipleDelete', 'multipleDelete')->name('users.multipleDelete');

  // https://docs.laravel-excel.com/
  Route::post('usuarios/importar', 'uploadData')->name('users.uploadData');

  // https://github.com/spatie/simple-excel
  Route::post("simple-excel/importar", 'simpleExcel')->name('users.simpleExcel');

  // https://medium.com/technology-hits/how-to-import-a-csv-excel-file-in-laravel-d50f93b98aa4
  // How to Import CSV File Data in Laravel 6
  // https://programmingfields.com/how-to-import-csv-file-data-in-laravel-6/
  Route::post("upload-content/importar", 'uploadContent')->name('users.uploadContent');
});