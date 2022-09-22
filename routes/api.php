<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\TeacherController;

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
Route::post('/users','UserController@store')->name('User.store');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
    Route::post('/login', [ApiController::class, 'authenticate'])->name("login");
    Route::post('/register', [ApiController::class, 'register'])->name("register");
   // Route::get('/logout', [ApiController::class, 'logout']);
#region jwt auth
        /////////////////////////////////////jwt auth //////////////////////////////////////////////////////
        // Route::post('/Auth/login', 'AuthController@login')->name("login");
        // Route::post('/Auth/logout', 'AuthController@logout')->name("logout");
        // Route::post('Auth/register', 'AuthController@register');

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

Route::get('/users2','UserController@index2')->name('User.index2');

#region user
Route::group(["middleware" => ["jwt.verify"]], function(){

    Route::get('/users','UserController@index')->name('User.index');
    //Route::get('/users/all','UserController@showAll')->name('User.showAll');
    Route::get('/users/{id}','UserController@show')->name('User.show');
    //Route::get('/users/restore/{id}','UserController@restore')->name('User.restore');
    Route::post('/users','UserController@store')->name('User.store');
    Route::put('/users/{user}','UserController@update')->name('User.update');
    Route::delete('/users/{id}','UserController@destroy')->name('User.destroy');
});
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

#region AbsencePresence
Route::group(['middleware' => ['jwt.verify'],"prefix"=>"abspre"], function() {
   Route::get('/logout', [ApiController::class, 'logout']);
    //Route::get('/get_user', [ApiController::class, 'get_user']);
        Route::get('/absencepresences','AbsencePresenceController@index')->name('AbsencePresence.index');
        Route::get('/absencepresences/{id}','AbsencePresenceController@show')->name('AbsencePresence.show');
        Route::post('/absencepresences','AbsencePresenceController@store')->name('AbsencePresence.store');
        Route::put('/absencepresences/{absencepresence}','AbsencePresenceController@update')->name('AbsencePresence.update');
        Route::delete('/absencepresences/{id}','AbsencePresenceController@destroy')->name('AbsencePresence.destroy');
});
#end region

#region Azmoon
//Route::group(['middleware' => ['jwt.verify'],"prefix"=>"azmoon"], function() {
    //Route::get('/logout', [ApiController::class, 'logout']);
   // Route::get('/get_user', [ApiController::class, 'get_user']);
    Route::get('/azmoon','AzmoonController@index')->name('Azmoon.index');
    Route::get('/azmoon/{id}','AzmoonController@show')->name('Azmoon.show');
    Route::post('/azmoon','AzmoonController@store')->name('Azmoon.store');
    Route::put('/azmoon/{azmoon}','AzmoonController@update')->name('Azmoon.update');
    Route::delete('/azmoon/{id}','AzmoonController@destroy')->name('Azmoon.destroy');
//});
#end region

#region coursestudent
Route::get('/coursestudent','CourseStudentController@index')->name('CourseStudent.index');
Route::get('/coursestudent/{id}','CourseStudentController@show')->name('CourseStudent.show');
Route::post('/coursestudent','CourseStudentController@store')->name('CourseStudent.store');
Route::put('/coursestudent/{coursestudent}','CourseStudentController@update')->name('CourseStudent.update');
Route::delete('/coursestudent/{id}','CourseStudentController@destroy')->name('CourseStudent.destroy');
#end region

#region studentContact
Route::get('/studentcontact','StudentContactController@index')->name('StudentContact.index');
Route::get('/studentcontact/{id}','StudentContactController@show')->name('StudentContact.show');
Route::post('/studentcontact','StudentContactController@store')->name('StudentContact.store');
Route::put('/studentcontact/{studentcontact}','StudentContactController@update')->name('StudentContact.update');
Route::delete('/studentcontact/{id}','StudentContactController@destroy')->name('StudentContact.destroy');
#end region

#region studentFault
Route::get('/studentfault','StudentFaultController@index')->name('StudentFault.index');
Route::get('/studentfault/{id}','StudentFaultController@show')->name('StudentFault.show');
Route::post('/studentfault','StudentFaultController@store')->name('StudentFault.store');
Route::put('/studentfault/{studentfault}','StudentFaultController@update')->name('StudentFault.update');
Route::delete('/studentfault/{id}','StudentFaultController@destroy')->name('StudentFault.destroy');
#end region

#region GroupGate
Route::get('/groupgate','GroupGateController@index')->name('GroupGate.index');
Route::get('/groupgate/{id}','GroupGateController@show')->name('GroupGate.show');
Route::post('/groupgate','GroupGateController@store')->name('GroupGate.store');
Route::put('/groupgate/{groupgate}','GroupGateController@update')->name('GroupGate.update');
Route::delete('/groupgate/{id}','GroupGateController@destroy')->name('GroupGate.destroy');
#end region

#region Gate
Route::get('/gates','GateController@index')->name('gate.index');
Route::get('/gates/{id}','GateController@show')->name('gate.show');
Route::post('/gates','GateController@store')->name('gate.store');
Route::put('/gates/{gate}','GateController@update')->name('gate.update');
Route::delete('/gates/{id}','GateController@destroy')->name('gate.destroy');

#end region

#region Group
Route::get('/groups','GroupController@index')->name('group.index');
Route::get('/groups/{id}','GroupController@show')->name('group.show');
Route::post('/groups','GroupController@store')->name('group.store');
Route::put('/groups/{group}','GroupController@update')->name('group.update');
Route::delete('/groups/{id}','GroupController@destroy')->name('group.destroy');

#end region

#region teacher 

    Route::apiResource("teacher",'TeacherController');

#end region

#region  Student  
    
   // Route::apiResource("students",'StudentController');

Route::get('/student','StudentController@index')->name('Student.index');
Route::get('/student/{id}','StudentController@show')->name('Student.show');
Route::post('/student','StudentController@store')->name('Student.store');
Route::put('/student/{student}','StudentController@update')->name('Student.update');
Route::delete('/student/{id}','StudentController@destroy')->name('Student.destroy');

#end region



Route::get('/user_group/{id}','UserController@getUserType');//->middleware('IsAdmin'); 