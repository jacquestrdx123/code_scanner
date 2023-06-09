<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('scan', App\Http\Controllers\ScanController::class);
Route::post('update-scan', 'App\Http\Controllers\ScanController@updateScan');
Route::get('update-scan/{id}', 'App\Http\Controllers\ScanController@showUpdate');
Route::post('export', 'App\Http\Controllers\ScanController@exportToExcel');

