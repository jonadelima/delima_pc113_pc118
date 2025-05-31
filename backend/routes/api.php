<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AllowedRolesMiddleware;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AssistantTeacherController;
use App\Http\Controllers\AssistTaskController;
use App\Http\Controllers\ProfileController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile/update', [ProfileController::class, 'update']);
});





Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);





Route::middleware('auth:sanctum','role:0')->group(function(){
    Route::get('/admin',[AdminController::class,'index']);
    Route::post('/logout', [AdminController::class, 'logout']);
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    Route::post('/create',[AdminController::class,'store']);
    Route::put('/update/{id}',[AdminController::class,'update']);
    Route::delete('/delete/{id}', [AdminController::class, 'destroy']);
    Route::get('/profile', [AdminController::class, 'profile']);
  

});




Route::middleware('auth:sanctum','role:1')->group(function(){
    Route::get('/teacher',[TeacherController::class,'index']);
    Route::post('/logout', [TeacherController::class, 'logout']);
});

Route::middleware('auth:sanctum','role:2')->group(function(){
    Route::get('/assteacher',[AssistantTeacherController::class,'index']);
    Route::post('/logout', [AssistantTeacherController::class, 'logout']);
});




Route::get('/tasks', [TaskController::class, 'index']);       // List all tasks
Route::post('/tasks', [TaskController::class, 'store']);      // Create a new task
Route::put('/tasks/{id}', [TaskController::class, 'update']); // Update task by ID (using POST instead of PUT for easier frontend use)
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']); // Delete task by ID



Route::get('/assisttasks', [AssistTaskController::class, 'index']);       // List all tasks
Route::post('/assisttasks', [AssistTaskController::class, 'store']);      // Create a new task
Route::post('/assisttasks/{id}', [AssistTaskController::class, 'update']); // Update task by ID (using POST instead of PUT for easier frontend use)
Route::delete('/assisttasks/{id}', [AssistTaskController::class, 'destroy']); // Delete task by ID


Route::get('/students', [StudentController::class, 'index']);
Route::post('/students/import', [StudentController::class, 'import']);
Route::get('/students/export', [StudentController::class, 'export']);













           