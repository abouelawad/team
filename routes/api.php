<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('test/{name}' , [ApiController::class, 'testApi']);

Route::post('testrequest' , [ApiController::class, 'testApirequest']);

Route::post('try/{para}' , [AuthController::class , 'try']);


Route::group([
  'middleware' => 'api',
  'prefix' => 'auth'
], function ($router) {
  
  Route::post('login', [AuthController::class,'login']);
  Route::post('add/test' , [AuthController::class , 'addUserTester']);
});

Route::group(['prefix'=> 'admin'], function(){
  // * Staff Routes
  Route::post('staff/add' , [StaffController::class , 'addStaff']);
  Route::get('staff/show' , [StaffController::class , 'allStaff']);
  Route::get('staff/select' , [StaffController::class , 'specificStaff']);
  Route::post('staff/delete' , [StaffController::class , 'deleteStaff']);
  Route::post('staff/update' , [StaffController::class , 'updateStaff']);
  // * Teacher Routes
  Route::post('teacher/add' , [TeacherController::class , 'addTeacher']);
  Route::get('teachers/all' , [TeacherController::class , 'allTeachers']);
  Route::get('teacher/select' , [TeacherController::class , 'specificTeacher']);
  Route::post('teacher/delete' , [TeacherController::class , 'deleteTeacher']);
  Route::post('teacher/update' , [TeacherController::class , 'updateTeacher']);

  // * Group Routes
  Route::post('group/add' , [GroupController::class , 'addGroup']);
  Route::get('groups/all' , [GroupController::class , 'allGroups']);
  Route::get('group/select' , [GroupController::class , 'specificGroup']);
  Route::post('group/delete' , [GroupController::class , 'deleteGroup']);
  Route::post('group/update' , [GroupController::class , 'updateGroup']);

  //* Student Routes
  Route::post('student/add' , [StudentController::class , 'addStudent']);
  Route::get('students/all' , [StudentController::class , 'allStudents']);
  Route::get('student/select' , [StudentController::class , 'specificStudent']);
  Route::post('student/delete' , [StudentController::class , 'deleteStudent']);
  Route::post('student/update' , [StudentController::class , 'updateStudent']);
});