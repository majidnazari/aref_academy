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
#regin jwt auth
        /////////////////////////////////////jwt auth //////////////////////////////////////////////////////
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');

        // Refresh route
        Route::get('/refresh',function(){
        })->middleware('jwt.refresh');

        // Login required routes
        Route::group(['middleware' => 'jwt.auth'], function() {
           // Route::Resource('/product','ProductControler');
             Route::get('/faults','FaultController@index')->name('fault.index');
            //Route::get('/faults/all','FaultController@showAll')->name('fault.showAll');
            Route::get('/faults/{fault}','FaultController@show')->name('fault.show');
            Route::get('/faults/restore/{fault}','FaultController@restore')->name('fault.restore');
            Route::post('/faults','FaultController@store')->name('fault.store');
            Route::put('/faults/{fault}','FaultController@update')->name('fault.update');
            Route::delete('/faults/{id}','FaultController@destroy')->name('fault.destroy');

        });

#end regin 

#regin user

Route::get('/users','UserController@index')->name('User.index');
Route::get('/users/all','UserController@showAll')->name('User.showAll');
Route::get('/users/{id}','UserController@show')->name('User.show');
Route::get('/users/restore/{id}','UserController@restore')->name('User.restore');
Route::post('/users','UserController@store')->name('User.store');
Route::put('/users/{user}','UserController@update')->name('User.update');
Route::delete('/users/{id}','UserController@destroy')->name('User.destroy');

#end regin


Route::get('/gates','GateController@index')->name('gate.index');
Route::get('/gates/all','GateController@showAll')->name('gate.showAll');
Route::get('/gates/{id}','GateController@show')->name('gate.show');
Route::get('/gates/restore/{id}','GateController@restore')->name('gate.restore');
Route::post('/gates','GateController@store')->name('gate.store');
Route::put('/gates/{gate}','GateController@update')->name('gate.update');
Route::delete('/gates/{id}','GateController@destroy')->name('gate.destroy');