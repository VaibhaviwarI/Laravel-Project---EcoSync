<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RecyclingController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Member Portal (Users)
    Route::get('/dashboard', [ReportController::class, 'index'])->name('user.dashboard');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/recycle', [RecyclingController::class, 'index'])->name('user.recycle');
    Route::post('/recycle', [RecyclingController::class, 'store'])->name('recycle.store');
    Route::get('/education', [RecyclingController::class, 'education'])->name('user.education');
    Route::get('/redeem', [RecyclingController::class, 'showRedeem'])->name('user.redeem');
    Route::post('/redeem/claim', [RecyclingController::class, 'claimRedeem'])->name('user.redeem.claim');
    Route::get('/schedule', [ReportController::class, 'schedule'])->name('user.schedule');

    // Admin Portal
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/reports/{report}/status', [AdminController::class, 'updateReportStatus'])->name('admin.reports.status');
    Route::post('/admin/recycle/{recycle}/approve', [AdminController::class, 'approveRecycle'])->name('admin.recycle.approve');
});
