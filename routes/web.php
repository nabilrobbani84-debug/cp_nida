<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\BranchProductionController;
use App\Http\Controllers\BranchProductionVerificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\AuthViewController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('home.main');
});

require __DIR__.'/auth.php';

// ============================================
// GUEST ROUTES (belum login)
// ============================================
Route::middleware('guest')->group(function () {

    // GET - Show Forms (Custom Views)
    Route::get('login', [AuthViewController::class, 'showLogin'])
        ->name('login');

    Route::get('register', [AuthViewController::class, 'showRegister'])
        ->name('register');

    Route::get('forgot-password', [AuthViewController::class, 'showForgotPassword'])
        ->name('password.request');

    Route::get('reset-password/{token}', [AuthViewController::class, 'showResetPassword'])
        ->name('password.reset');

    // POST - Handle Logic (Breeze Controllers)
    Route::post('register', [RegisteredUserController::class, 'store'])
        ->name('register.store');

    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->name('login.store');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');

    Route::prefix('home')->group(function () {

        Route::get('/', function () {
            return view('home.main');
        })->name('home.main');

        Route::get('/products', function () {
            return view('home.products');
        })->name('home.products');

        Route::get('/divisions', function () {
            return view('home.divisions');
        })->name('home.divisions');

        Route::get('/facilities', function () {
            return view('home.facilities');
        })->name('home.facilities');

        Route::get('/gallery', function () {
            return view('home.galleries');
        })->name('home.gallery');

    });
});

// ============================================
// Auth ROUTES (sudah login)
// ============================================

Route::middleware(['auth'])->group(function () {

    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/document-archive', [DashboardController::class, 'archive'])->name('document-archive');

    // User management (optional/accessible to all for testing, or just dashboard)
    Route::resource('users', UserController::class);

    // ── Divisi PPC ──────────────────────────────────────────────
    Route::middleware('divisi_ppc')->group(function () {
        Route::resource('shipping-plans', \App\Http\Controllers\ShippingPlanController::class);
    });

    // ── Divisi Gudang ───────────────────────────────────────────
    Route::middleware('divisi_gudang')->group(function () {
        Route::resource('packing-lists', \App\Http\Controllers\PackingListController::class);
    });

    // ── Divisi Ekspor ───────────────────────────────────────────
    Route::middleware('divisi_ekspor')->group(function () {
        Route::resource('export-invoices', \App\Http\Controllers\ExportInvoiceController::class);
        Route::resource('vessel-bookings', \App\Http\Controllers\VesselBookingController::class);
    });

});