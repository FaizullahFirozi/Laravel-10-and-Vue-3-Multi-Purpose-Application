<?php

use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/admin/dashboard', function () {
//     return view('dashboard');
// });

Route::get('/api/users', [UserController::class, 'index']);
Route::post('/api/users', [UserController::class, 'store']);
Route::delete('/api/users/{user}', [UserController::class, 'destroy']);

 

Route::get('/api/appointments', [AppointmentController::class, 'index']);
Route::post('/api/appointments/create', [AppointmentController::class, 'store']);


Route::get('/api/products', [ProductController::class, 'index']);
Route::delete('/api/products/{product}', [ProductController::class, 'destroy']);



Route::get('{view}', ApplicationController::class)->where('view', '.*');