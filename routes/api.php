<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/faults','FaultController@index')->name('fault.index');
Route::get('/faults/all','FaultController@showAll')->name('fault.showAll');
Route::get('/faults/{id}','FaultController@show')->name('fault.show');
Route::get('/faults/restore/{id}','FaultController@restore')->name('fault.restore');
Route::post('/faults','FaultController@store')->name('fault.store');
Route::put('/faults/{fault}','FaultController@update')->name('fault.update');
Route::delete('/faults/{id}','FaultController@destroy')->name('fault.destroy');