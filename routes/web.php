<?php

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

// Notifications
Route::get('/notifications', [\App\Http\Controllers\NotificationsController::class, 'notifications'])->name('notifications');
Route::post('/notification/add', [\App\Http\Controllers\NotificationsController::class, 'add'])->name('notification.add');
Route::post('/notification/{notification_id}/delete', [\App\Http\Controllers\NotificationsController::class, 'delete'])->name('notification.delete');
Route::post('/notification/{notification_id}/update', [\App\Http\Controllers\NotificationsController::class, 'update'])->name('notification.update');
