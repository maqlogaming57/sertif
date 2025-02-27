<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ChangePasswordController;

// Route untuk tamu (belum login)
Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Route untuk user yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/sertif', function () {
        return view('sertif');
    })->name('sertif');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Route khusus admin
Route::middleware([\App\Http\Middleware\CheckAdmin::class])->group(function () {
    Route::get('/profile', function () {
        return view('admin.profile'); // Halaman ini hanya bisa diakses oleh admin
    })->name('profile');
});

// Route untuk perubahan password
Route::middleware('auth')->group(function () {
    Route::get('/password/change', [ChangePasswordController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/password/change', [ChangePasswordController::class, 'changePassword'])->name('password.change.post');
});
