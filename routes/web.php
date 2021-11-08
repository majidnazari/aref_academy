<?php

use Illuminate\Support\Facades\Route;

use APP\HTTP\Controllers;
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
//Route::get('/faults','FaulstController@index')->name('fault.index');
//Route::get('/faults', [FaulstController::class, 'index'])->name('fault.index');
//Route::get('/fault','FaultController@index');

