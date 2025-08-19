<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/login');
});

// Test route to verify staff management (commented out for production)
// Route::get('/test-staff', function () {
//     if (Auth::check()) {
//         $user = Auth::user();
//         return response()->json([
//             'user' => $user->name,
//             'role' => $user->role,
//             'can_manage_staff' => $user->canManageStaff(),
//             'is_manager' => $user->isManager(),
//             'is_pharmacist' => $user->isPharmacist(),
//         ]);
//     }
//     return response()->json(['error' => 'Not authenticated']);
// });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Drug management routes - Managers only
    Route::resource('drugs', DrugController::class);
    Route::get('/drugs/export/excel', [DrugController::class, 'exportExcel'])->name('drugs.export.excel');
    Route::get('/drugs/export/pdf', [DrugController::class, 'exportPdf'])->name('drugs.export.pdf');
    

    
    // Sales routes - All authenticated users
    Route::resource('sales', SaleController::class);
    Route::get('/pos', [SaleController::class, 'pos'])->name('sales.pos');
    Route::post('/pos/process', [SaleController::class, 'processSale'])->name('sales.process');
    Route::get('/sales/{sale}/receipt', [SaleController::class, 'receipt'])->name('sales.receipt');
    Route::get('/api/drug/{drug}', [SaleController::class, 'getDrugInfo'])->name('api.drug.info');
    
    // Analytics routes - Managers only
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/sales', [AnalyticsController::class, 'sales'])->name('analytics.sales');
    Route::get('/analytics/inventory', [AnalyticsController::class, 'inventory'])->name('analytics.inventory');
    
    // Reports routes - Managers only
    Route::redirect('/reports', '/reports/sales')->name('reports.index');
    Route::get('/reports/sales', [ReportsController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/inventory', [ReportsController::class, 'inventory'])->name('reports.inventory');
    Route::get('/reports/financial', [ReportsController::class, 'financial'])->name('reports.financial');
    Route::get('/reports/performance', [ReportsController::class, 'performance'])->name('reports.performance');
    Route::get('/reports/export', [ReportsController::class, 'export'])->name('reports.export');
    
    // Staff management routes - Managers only
    Route::resource('staff', StaffController::class);
    Route::patch('/staff/{staff}/toggle-status', [StaffController::class, 'toggleStatus'])->name('staff.toggle-status');
    Route::patch('/staff/{staff}/reset-password', [StaffController::class, 'resetPassword'])->name('staff.reset-password');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
