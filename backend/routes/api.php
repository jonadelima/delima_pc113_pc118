<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserController;




// Login Route (no auth)
Route::post('/login', [AuthController::class, 'login']);

// Public route — anyone can fetch
Route::get('/users', [UserController::class, 'index']);

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
});


Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/students', [StudentController::class, 'index']);

Route::post('/employees', [EmployeeController::class, 'create']);
Route::post('/students', [StudentController::class, 'create']);

Route::put('/employees/{id}', [EmployeeController::class, 'update']);
Route::put('/students/{id}', [StudentController::class, 'update']);

Route::delete('/employees/{id}', [EmployeeController::class, 'delete']);
Route::delete('/students/{id}', [StudentController::class, 'delete']);




// Route::post('/login', [AuthController::class, 'login']);


// Route::middleware(['auth:sanctum', 'role:0'])->get('/users', [AuthController::class, 'index']);
// Route::middleware(['auth:sanctum', 'role:1'])->get('/udashboard', [UserDashboardController::class, 'index']);


// Route::get('unknown', function () {
//     return response()->json(['message' => 'ok']);
// });

// Route::get('/users', [UserController::class, 'index']);
// Route::post('/users', [UserController::class, 'store']);
// Route::put('/users/{id}', [UserController::class, 'update']);
// Route::delete('/users/{id}', [UserController::class, 'delete']);
 