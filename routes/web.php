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

//homecontroller
Route::resource('home', HomeController::class);
Route::get('home/{status}/show', [HomeController::class, 'show'])->name('tickets.show');
Route::get('/fetch-data/{id}', [HomeController::class, 'fetchData']);
Route::get('/fetch-dataAll/{id}', [HomeController::class, 'fetchDataAll']);
Route::post('/update-ticket/{id}', [HomeController::class, 'updateTicket'])->name('home.update');
Route::get('/fetch-data-ticket-home/{id}', [HomeController::class, 'fetchTicket'])->name('users.show');
Route::redirect('/', '/home');

//ticketcontroller
Route::resource('ticket', TicketController::class);
Route::get('/fetch-data-ticket/{id}', [TicketController::class, 'fetchTicket']);
Route::get('/edit/{ticket}', [TicketController::class, 'edit'])->name('ticket.edit');
Route::get('/openAll', [TicketController::class, 'openAll'])->name('ticket.openAll');
Route::get('/empty', [TicketController::class, 'empty'])->name('ticket.empty');
Route::post('/updateticket/{ticket}', [TicketController::class, 'updateTicket'])->name('ticket.update');

//categorycontroller
Route::resource('category', CategoryController::class);
Route::post('/insert-data', [CategoryController::class, 'store'])->name('insert.data');

//misc
Route::resource('user', UserController::class);
Route::resource('test', testController::class);
