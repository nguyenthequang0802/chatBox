<?php

use App\Http\Controllers\BoxChatController;
use App\Http\Controllers\RoomController;
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
Auth::routes();
Route::group(['prefix' => 'chat-room'], function () {
    Route::get('/',[RoomController::class, 'index'])->name('room.index');
    Route::post('/create-room',[RoomController::class, 'storeRoom'])->name('room.store');
    Route::post('/search', [RoomController::class, 'searchRoom'])->name('room.search');
    Route::post('/join', [RoomController::class, 'join'])->name('room.join');
    Route::get('/showRoom', [RoomController::class, 'showRoom'])->name('room.show');
    Route::get('/boxChat/{id}', [BoxChatController::class, 'index'])->name('room.boxChat');
    Route::post('/sendMess', [BoxChatController::class, 'sendMess'])->name('room.sendMess');
    Route::post('/sendImage', [BoxChatController::class, 'sendImage'])->name('room.sendImage');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
