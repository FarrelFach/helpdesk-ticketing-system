<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
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

Auth::routes();

Route::resource('home', HomeController::class);
Route::get('home/{status}/show', [HomeController::class, 'show'])->name('tickets.show');
Route::get('/fetch-data/{id}', [HomeController::class, 'fetchData']);
Route::get('/fetch-dataAll/{id}', [HomeController::class, 'fetchDataAll']);
Route::get('/take/{ticket}', [TicketController::class, 'takeTicket'])->name('ticket.take');
Route::get('/confirm/{ticket}', [TicketController::class, 'confirmTicket'])->name('ticket.confirm');
Route::resource('ticket', TicketController::class);
Route::resource('user', UserController::class);
Route::resource('category', CategoryController::class);
Route::redirect('/', '/home');
