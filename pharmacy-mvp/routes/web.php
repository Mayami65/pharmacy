<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\SaleController;
use App\Http\Controllers\AnalyticsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Drug management routes
    Route::resource('drugs', DrugController::class);
    Route::get('/drugs/export/excel', [DrugController::class, 'exportExcel'])->name('drugs.export.excel');
    Route::get('/drugs/export/pdf', [DrugController::class, 'exportPdf'])->name('drugs.export.pdf');
    

    
    // Sales routes
    Route::resource('sales', SaleController::class);
    Route::get('/pos', [SaleController::class, 'pos'])->name('sales.pos');
    Route::post('/pos/process', [SaleController::class, 'processSale'])->name('sales.process');
    Route::get('/sales/{sale}/receipt', [SaleController::class, 'receipt'])->name('sales.receipt');
    Route::get('/api/drug/{drug}', [SaleController::class, 'getDrugInfo'])->name('api.drug.info');
    
    // Analytics routes
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/sales', [AnalyticsController::class, 'sales'])->name('analytics.sales');
    Route::get('/analytics/inventory', [AnalyticsController::class, 'inventory'])->name('analytics.inventory');
    Route::get('/reports', [AnalyticsController::class, 'reports'])->name('reports.index');

    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
