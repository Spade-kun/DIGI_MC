<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\User\UserRegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    // If user is already authenticated, redirect to their dashboard
    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }
    
    if (Auth::guard('web')->check()) {
        return redirect()->route('dashboard');
    }
    
    // For unauthenticated users, redirect to appropriate login
    // Check server type set in server-admin.php or server-user.php
    $serverType = $_SERVER['SERVER_TYPE'] ?? null;
    
    if ($serverType === 'admin') {
        return redirect()->route('admin.login');
    }
    
    // Check port as fallback
    $port = request()->getPort();
    if ($port == 8001 || str_contains(request()->getHost(), ':8001')) {
        return redirect()->route('admin.login');
    }
    
    // Default to user login
    return redirect()->route('user.login');
})->name('home');

// User Routes
Route::middleware('guest')->group(function () {
    Route::get('/user/login', [UserAuthController::class, 'showLogin'])->name('user.login');
    Route::post('/user/login', [UserAuthController::class, 'login']);
    Route::get('/user/register', [UserRegisterController::class, 'showRegistrationForm'])->name('user.register');
    Route::post('/user/register', [UserRegisterController::class, 'register']);
    
    // Google OAuth Routes
    Route::get('/auth/google/redirect', [App\Http\Controllers\User\GoogleAuthController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('/auth/google/callback', [App\Http\Controllers\User\GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');
});

Route::middleware('auth')->group(function () {
    Route::post('/user/logout', [UserAuthController::class, 'logout'])->name('user.logout');
    Route::get('/user/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Documents Routes
    Route::prefix('user/documents')->name('user.documents.')->group(function () {
        Route::get('/', [App\Http\Controllers\UserDocumentsController::class, 'index'])->name('index');
        Route::get('/{folderId}', [App\Http\Controllers\UserDocumentsController::class, 'show'])->name('show');
        Route::post('/{folderId}/attempt-access', [App\Http\Controllers\UserDocumentsController::class, 'attemptAccess'])->name('attempt-access');
    });
    
    // User Gazette Routes
    Route::prefix('user/gazette')->name('user.gazette.')->group(function () {
        Route::get('/', [App\Http\Controllers\User\UserGazetteController::class, 'index'])->name('index');
        Route::get('/{gazette}', [App\Http\Controllers\User\UserGazetteController::class, 'show'])->name('show');
    });
    
    // Dialogflow Chatbot API
    Route::post('/api/dialogflow', [App\Http\Controllers\Api\DialogflowController::class, 'handleMessage'])->name('api.dialogflow');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
        Route::post('login', [AdminAuthController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        // User Management Routes
        Route::get('users/pending', [App\Http\Controllers\Admin\PendingRegistrationController::class, 'pending'])->name('admin.registrations.pending');
        Route::get('users/approved', [App\Http\Controllers\Admin\PendingRegistrationController::class, 'approved'])->name('admin.registrations.approved');
        Route::get('users/rejected', [App\Http\Controllers\Admin\PendingRegistrationController::class, 'rejected'])->name('admin.registrations.rejected');
        Route::put('users/{id}/approve', [App\Http\Controllers\Admin\PendingRegistrationController::class, 'approve'])->name('admin.registrations.approve');
        Route::put('users/{id}/reject', [App\Http\Controllers\Admin\PendingRegistrationController::class, 'reject'])->name('admin.registrations.reject');
        
        // User Privileges Management Routes
        Route::prefix('privileges')->name('admin.privileges.')->group(function () {
            Route::get('/', [App\Http\Controllers\AdminPrivilegeController::class, 'index'])->name('index');
            Route::get('/users/{user}/edit', [App\Http\Controllers\AdminPrivilegeController::class, 'edit'])->name('edit');
            Route::put('/users/{user}', [App\Http\Controllers\AdminPrivilegeController::class, 'update'])->name('update');
            Route::post('/users/{user}/toggle-access', [App\Http\Controllers\AdminPrivilegeController::class, 'toggleAccess'])->name('toggle-access');
            Route::get('/folders', [App\Http\Controllers\AdminPrivilegeController::class, 'getFolders'])->name('folders');
        });
        
        // Role & Privilege Management Routes
        Route::prefix('roles')->name('admin.roles.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('index');
            Route::get('/{user}/edit', [App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('edit');
            Route::put('/{user}', [App\Http\Controllers\Admin\RoleController::class, 'update'])->name('update');
        });
        
        // Gazette Management Routes
        Route::prefix('gazette')->name('admin.gazette.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\GazetteController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\Admin\GazetteController::class, 'store'])->name('store');
            Route::delete('/{gazette}', [App\Http\Controllers\Admin\GazetteController::class, 'destroy'])->name('destroy');
            Route::get('/{gazette}/download', [App\Http\Controllers\Admin\GazetteController::class, 'download'])->name('download');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
