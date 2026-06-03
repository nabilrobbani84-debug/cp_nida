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

    Route::resource('users', UserController::class);

    Route::resource('roles', RoleController::class)
        ->only(['index'])
        ->middleware('super_admin');

    Route::resource('branches', BranchController::class)
        ->middleware('super_admin');

    Route::resource('product-types', ProductTypeController::class)
        ->middleware('super_admin');

    Route::resource('units', UnitController::class)
        ->middleware('super_admin');

    Route::resource('products', ProductController::class)
        ->middleware('super_admin');

    Route::middleware('operator_produksi')->group(function () {
        Route::get('branch-productions/create', [BranchProductionController::class, 'create'])
            ->name('branch-productions.create');
        Route::post('branch-productions', [BranchProductionController::class, 'store'])
            ->name('branch-productions.store');
    });

    Route::middleware('branch_production_access')->group(function () {
        Route::get('branch-productions', [BranchProductionController::class, 'index'])
            ->name('branch-productions.index');
        Route::get('branch-productions/{branchProduction}', [BranchProductionController::class, 'show'])
            ->name('branch-productions.show');
    });

    Route::middleware('admin_pusat')->prefix('branch-production-verifications')->name('branch-production-verifications.')->group(function () {
        Route::get('/', [BranchProductionVerificationController::class, 'index'])->name('index');
        Route::patch('{branchProduction}/validate', [BranchProductionVerificationController::class, 'validate'])
            ->name('validate');
        Route::patch('{branchProduction}/reject', [BranchProductionVerificationController::class, 'reject'])
            ->name('reject');
    });

    // machining process
    Route::prefix('machining')->name('machining.')->group(function () {

        // monitoring
        Route::prefix('monitoring')->name('monitoring.')->group(function () {

            Route::get('/', function () {
                return view('machining.monitoring.index');
            })->name('index');

        });

    });

});