<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\authenticate\AuthLogin;
use App\Http\Controllers\Auth\LoginRegistrationController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\User\UserController;

date_default_timezone_set('Asia/Kolkata');
Route::get('/refresh', function () {
    Artisan::call('key:generate');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');
    return 'Refresh Done';
});

Route::controller(LoginRegistrationController::class)->group(function () {
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::post('/store', 'store')->name('store');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('auth/google', 'redirectToGoogle')->name('redirectToGoogle');
    Route::get('auth/google/callback', 'handleGoogleCallback')->name('handleGoogleCallback');
});

Route::get('/authenticate/login', [AuthLogin::class, 'login'])->name('authenticate-login');
Route::get('/authenticate/register', [AuthLogin::class, 'register'])->name('authenticate-register');

Route::middleware([EnsureTokenIsValid::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard-blank');
    Route::get('/dashboard', [DashboardController::class, 'crm'])->name('dashboard-crm');


    Route::get('/users/{role}', [UserController::class, 'index'])->name('users');
    Route::post('/getUsers', [UserController::class, 'getUsers'])->name('getUsers');
    Route::post('/changeUserStatus', [UserController::class, 'changeUserStatus'])->name('changeUserStatus');
    Route::resource('users', UserController::class);
});