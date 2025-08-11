<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewPageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\OrderController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', [NewPageController::class, 'index'])->name('home');
Route::get('/', [OrderController::class, 'dashboard'])->name('dashboard');

// Add a route for the dashboard page

Route::get('/newpage', [NewPageController::class, 'index'])->name('newpage');
Route::get('/tiket', [NewPageController::class, 'tiket'])->name('tiket');
Route::get('/calender', [NewPageController::class, 'tampiltiket'])->name('calender');
Route::get('/api/tasks', [NewPageController::class, 'getTasksApi']);




Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/dashboard', [OrderController::class, 'dashboard'])->name('dashboard');

Route::get('/orders', [OrderController::class, 'dashboard']);
Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');



