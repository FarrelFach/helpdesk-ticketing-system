<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\testController;
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
Route::post('/insert-data', [CategoryController::class, 'store'])->name('insert.data');
Route::get('/fetch-data/{id}', [HomeController::class, 'fetchData']);
Route::get('/fetch-dataAll/{id}', [HomeController::class, 'fetchDataAll']);
Route::get('/openAll', [TicketController::class, 'openAll'])->name('ticket.openAll');
Route::post('/update-ticket-status/{ticket}', [TicketController::class, 'updateTicket'])->name('ticket.update');
Route::post('/update-ticket-status/{ticket}', [HomeController::class, 'updateTicket'])->name('home.update');
Route::resource('ticket', TicketController::class);
Route::resource('user', UserController::class);
Route::resource('test', testController::class);
Route::resource('category', CategoryController::class);
Route::redirect('/', '/home');
