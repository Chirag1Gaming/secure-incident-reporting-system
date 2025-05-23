<?php

use App\Http\Controllers\Admin\IncidentManagementController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\SuperAdminDashboardController;
use App\Http\Controllers\Dashboard\UserDashboardController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\SuperAdmin\UserManagementController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:User'])->group(function(){
        Route::prefix('dashboard/user')->name('dashboard.user.')->group(function () {
            Route::get('/', [UserDashboardController::class, 'index'])->name('index');
        });

        Route::prefix('user/incidents')->name('user.incidents.')->group(function () {
            Route::get('/', [IncidentController::class, 'index'])->name('index');
            Route::get('/create', [IncidentController::class, 'create'])->name('create');
            Route::post('/', [IncidentController::class, 'store'])->name('store');
        });
    });

    Route::middleware(['role:Admin'])->group(function () {
        Route::prefix('dashboard/admin')->name('dashboard.admin.')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'index'])->name('index');
        });

        Route::prefix('admin/incidents')
            ->name('admin.incidents.')
            ->group(function () {
                Route::get('/', [IncidentManagementController::class, 'index'])->name('index');
                Route::post('/bulk-update', [IncidentManagementController::class, 'bulkUpdate'])->name('bulkUpdate');
                Route::post('/assign/{incident}', [IncidentManagementController::class, 'assign'])->name('assign');
                Route::post('/update-status/{incident}', [IncidentManagementController::class, 'updateStatus'])->name('updateStatus');
        });

        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    });

    Route::middleware(['role:Super Admin'])->group(function () {
        Route::prefix('dashboard/superadmin')->name('dashboard.superadmin.')->group(function () {
            Route::get('/', [SuperAdminDashboardController::class, 'index'])->name('index');
        });

        Route::prefix('super-admin/users')
            ->name('superadmin.users.')
            ->group(function () {
                Route::get('/', [UserManagementController::class, 'index'])->name('index');
                Route::get('/create', [UserManagementController::class, 'create'])->name('create');
                Route::post('/', [UserManagementController::class, 'store'])->name('store');
                Route::get('/{user}/edit', [UserManagementController::class, 'edit'])->name('edit');
                Route::put('/{user}', [UserManagementController::class, 'update'])->name('update');
                Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
                Route::patch('/{user}/toggle-block', [UserManagementController::class, 'toggleBlock'])->name('toggleBlock');
        });

        Route::prefix('superadmin')->name('superadmin.')->group(function () {
            Route::resource('users', UserController::class);
            // Route::patch('users/{user}/toggle-block', [SuperAdmin\UserController::class, 'toggleBlock'])->name('users.toggleBlock');

            // Route::get('audit-logs', [SuperAdmin\AuditLogController::class, 'index'])->name('auditlogs.index');
        });
    });
});

require __DIR__.'/auth.php';
