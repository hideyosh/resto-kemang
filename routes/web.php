<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// ============================================
// PUBLIC ROUTES - Bisa diakses siapa saja
// ============================================

// Homepage
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Menu routes - Public
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/filter/{category}', [MenuController::class, 'filterByCategory'])->name('menu.filter');

// ============================================
// USER ROUTES - Hanya untuk authenticated users
// ============================================

Route::middleware(['auth'])->group(function () {
    // Order routes
    Route::get('/order/create', function () {
        return view('order.create');
    })->name('order.create');
    Route::post('/api/orders', [OrderController::class, 'store'])->name('order.store');

    // Reservation routes
    Route::get('/reservation', function () {
        return view('reservation.create');
    })->name('reservation.create');
    Route::post('/api/reservations', [ReservationController::class, 'store'])->name('reservation.store');
});

// ============================================
// ADMIN ROUTES - Hanya untuk admin
// ============================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminController::class, 'userIndex'])->name('index');
        Route::get('/create', [AdminController::class, 'userCreate'])->name('create');
        Route::post('/', [AdminController::class, 'userStore'])->name('store');
        Route::get('/{user}/edit', [AdminController::class, 'userEdit'])->name('edit');
        Route::put('/{user}', [AdminController::class, 'userUpdate'])->name('update');
        Route::delete('/{user}', [AdminController::class, 'userDestroy'])->name('destroy');
    });

    // Order Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminController::class, 'orderIndex'])->name('index');
        Route::get('/{order}', [AdminController::class, 'orderShow'])->name('show');
        Route::put('/{order}/status', [AdminController::class, 'orderUpdateStatus'])->name('update-status');
    });

    // Reservation Management
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [AdminController::class, 'reservationIndex'])->name('index');
        Route::get('/{reservation}', [AdminController::class, 'reservationShow'])->name('show');
        Route::put('/{reservation}/status', [AdminController::class, 'reservationUpdateStatus'])->name('update-status');
    });

    // Menu Management (Admin Only)
    Route::prefix('menu')->name('menu.')->group(function () {
        // Admin menu list
        Route::get('/', [MenuController::class, 'adminIndex'])->name('index');
        // Edit form
        Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('edit');
        Route::get('/create', [MenuController::class, 'create'])->name('create');
        Route::post('/', [MenuController::class, 'store'])->name('store');
        Route::put('/{menu}', [MenuController::class, 'update'])->name('update');
        Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('destroy');
    });
});

