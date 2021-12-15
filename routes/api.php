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
#region jwt auth
        /////////////////////////////////////jwt auth //////////////////////////////////////////////////////
        Route::post('login', 'AuthController@login')->name("login");
        Route::post('register', 'AuthController@register');

        // Refresh route
        Route::get('/refresh',function(){
        })->middleware('jwt.refresh');

        // Login required routes
       // Route::group(['middleware' => 'jwt.auth'], function() {
           // Route::Resource('/product','ProductControler');
            Route::get('/faults','FaultController@index')->name('Fault.index');
            //Route::get('/faults/all','FaultController@showAll')->name('fault.showAll');
            Route::get('/faults/{fault}','FaultController@show')->name('Fault.show');
            Route::get('/faults/restore/{fault}','FaultController@restore')->name('Fault.restore');
            Route::post('/faults','FaultController@store')->name('Fault.store');
            Route::put('/faults/{fault}','FaultController@update')->name('Fault.update');
            Route::delete('/faults/{id}','FaultController@destroy')->name('Fault.destroy');

      //  });

#end region 

#region user

    Route::get('/users','UserController@index')->name('User.index');
    //Route::get('/users/all','UserController@showAll')->name('User.showAll');
    Route::get('/users/{id}','UserController@show')->name('User.show');
    //Route::get('/users/restore/{id}','UserController@restore')->name('User.restore');
    Route::post('/users','UserController@store')->name('User.store');
    Route::put('/users/{user}','UserController@update')->name('User.update');
    Route::delete('/users/{id}','UserController@destroy')->name('User.destroy');

#end region

#region Course

    Route::get('/courses','CourseController@index')->name('Course.index');
    Route::get('/courses/{id}','CourseController@show')->name('Course.show');
    Route::post('/courses','CourseController@store')->name('Course.store');
    Route::put('/courses/{Course}','CourseController@update')->name('Course.update');
    Route::delete('/courses/{id}','CourseController@destroy')->name('Course.destroy');

#end region

#region coursesession

    Route::get('/coursesession','CourseSessionController@index')->name('CourseSession.index');
    Route::get('/coursesession/{id}','CourseSessionController@show')->name('CourseSession.show');
    Route::post('/coursesession','CourseSessionController@store')->name('CourseSession.store');
    Route::put('/coursesession/{coursesession}','CourseSessionController@update')->name('CourseSession.update');
    Route::delete('/coursesession/{id}','CourseSessionController@destroy')->name('CourseSession.destroy');
    Route::post('/coursesessionAddSessions','CourseSessionController@AddSessions')->name('CourseSession.AddSessions');

#end region


#region Year

    Route::get('/years','YearController@index')->name('Year.index');
    Route::get('/years/{id}','YearController@show')->name('Year.show');
    Route::post('/years','YearController@store')->name('Year.store');
    Route::put('/years/{id}','YearController@update')->name('Year.update');
    Route::delete('/years/{id}','YearController@destroy')->name('Year.destroy');

#end region


#region Gate
    Route::get('/gates','GateController@index')->name('gate.index');
    Route::get('/gates/{id}','GateController@show')->name('gate.show');
    Route::post('/gates','GateController@store')->name('gate.store');
    Route::put('/gates/{gate}','GateController@update')->name('gate.update');
    Route::delete('/gates/{id}','GateController@destroy')->name('gate.destroy');

#end region

#region AbsencePresence
Route::get('/absencepresences','AbsencePresenceController@index')->name('AbsencePresence.index');
Route::get('/absencepresences/{id}','AbsencePresenceController@show')->name('AbsencePresence.show');
Route::post('/absencepresences','AbsencePresenceController@store')->name('AbsencePresence.store');
Route::put('/absencepresences/{absencepresence}','AbsencePresenceController@update')->name('AbsencePresence.update');
Route::delete('/absencepresences/{id}','AbsencePresenceController@destroy')->name('AbsencePresence.destroy');

#end region