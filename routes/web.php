<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingsController;

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


Route::middleware(['web', 'impersonate'])->group(function() {

    Route::get('/', function(){
        return view('home');
    })->name('home');

    // Admin users list & impersonation (protect with auth & admin middleware in real app)
    Route::get('/admin/users', [UsersController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/{user}/impersonate', [UsersController::class, 'impersonate'])->name('admin.impersonate');
    Route::post('/admin/users/stop-impersonate', [UsersController::class, 'stopImpersonate'])->name('admin.stop.impersonate');

    // Notifications posting & listing
    Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');

    // user settings
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});
