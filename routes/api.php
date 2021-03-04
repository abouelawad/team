<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaffController;
use App\Models\Group;
use Illuminate\Routing\RouteGroup;

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
});