<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\AddTaskController;
use App\Http\Controllers\GetTaskController;
use App\Http\Controllers\GetUserController;
use App\Http\Controllers\AddResultController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DeleteTaskController;
use App\Http\Controllers\UpdateTaskController;
use App\Http\Middleware\InternalApiMiddleware;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DeleteAnswerController;
use App\Http\Controllers\GetTasksListController;
use App\Http\Controllers\GetUserTasksController;
use App\Http\Controllers\AddTaskOutputController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SetAnswerMarkController;
use App\Http\Controllers\AssignUserRoleController;
use App\Http\Controllers\GetTaskAnswersController;
use App\Http\Controllers\RemoveUserRoleController;
use App\Http\Controllers\AddAnswerOutputController;
use App\Http\Controllers\GetUserTaskAnswerController;
use App\Http\Controllers\UpdateUserPasswordController;

Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('/user', GetUserController::class);
    Route::post('/logout', LogoutController::class);
    Route::patch('/user/password', UpdateUserPasswordController::class);

    Route::post('/task/add', AddTaskController::class);
    Route::get('/tasks', GetTasksListController::class);
    Route::get('/task/{task}', GetTaskController::class);
    Route::put('/task/{task}', UpdateTaskController::class);
    Route::delete('/task/{task}', DeleteTaskController::class);
    Route::get('/user/{user}/tasks', GetUserTasksController::class);
    Route::post('/task/{task}/answer', AddResultController::class);
    Route::get('/task/{task}/answers', GetTaskAnswersController::class);
    Route::get('/task/{task}/answer/my', GetUserTaskAnswerController::class);
    Route::post('/answer/{result}/mark', SetAnswerMarkController::class);
    Route::delete('/answer/{result}', DeleteAnswerController::class)->middleware('permission:delete answers');
    Route::middleware('permission:manage roles')->group(function () {
        Route::post('/user/{user:email}/assign-role', AssignUserRoleController::class);
        Route::delete('/user/{user:email}/role/{role}', RemoveUserRoleController::class);
    });
});

Route::middleware([InternalApiMiddleware::class])->group(function () {
    Route::patch('/task/{task}', AddTaskOutputController::class);
    Route::patch('/answer/{result}', AddAnswerOutputController::class);
});

