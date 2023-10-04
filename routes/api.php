<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserTask;
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

Route::post('/user/register',[userController::class,'register']);

Route::post('/user/login',[userController::class,'login']);

Route::get('/user/getUser/{id}',[userController::class,'getUser']);

Route::group(['middleware' => 'UserCheck'], function(){

    Route::get('/task/userTasks/{user_id}', [TasksController::class,'getUserTasks']);

    Route::delete('/task/deleteTask/{id}',[TasksController::class,'deleteTask']);

    Route::post('/task/createTask',[TasksController::class,'createTask']);

    Route::put('/task/updateTask/{id}',[TasksController::class,'updateTask']);

    Route::get('/task/getTask/{id}',[TasksController::class,'getTask']);

});

