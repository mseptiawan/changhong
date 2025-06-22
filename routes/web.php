<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    UploadController,
    TargetController,
    SpgmController,
    ProductController,
    ModelIncentiveController,
    DiscontinuedProductController,
    StoreController,
    DataImportController,
    SalesTransactionController,
    ProfileController
};

// Redirect root to login
Route::get('/', fn() => redirect()->route('login'));

// Redirect /dashboard ke dashboards.index setelah login
Route::get('/dashboard', fn() => redirect()->route('dashboards.index'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Semua route di bawah ini hanya bisa diakses setelah login
Route::middleware(['auth'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard
    Route::resource('dashboards', DashboardController::class);

    // Upload & Import
    Route::resource('uploads', UploadController::class);
    Route::get('/data-import', [DataImportController::class, 'index'])->name('data.import.index'); 
    Route::post('/data-import', [DataImportController::class, 'store'])->name('data.import.store');

    // Target
    Route::get('/targets/filter', [TargetController::class, 'filterByDate'])->name('targets.filterByDate');
    Route::resource('/targets', TargetController::class);

    // SPGM & Store
    Route::get('/spgms/autocomplete', [SpgmController::class, 'autocomplete'])->name('spgms.autocomplete');
    Route::resource('promoters', SpgmController::class);
    Route::get('/stores/autocomplete', [StoreController::class, 'autocomplete'])->name('stores.autocomplete');

    // Product & Incentives
    Route::get('/products/autocomplete', [ModelIncentiveController::class, 'autocomplete'])->name('products.autocomplete');
    Route::resource('products', ProductController::class);
    Route::resource('model-incentives', ModelIncentiveController::class);
    Route::resource('discontinued-products', DiscontinuedProductController::class);

    // Transaksi
    Route::get('/transaksi/rincian', [SalesTransactionController::class, 'rincian'])->name('transaksi.rincian');
    Route::get('/transaksi/summary', [SalesTransactionController::class, 'summary'])->name('transaksi.summary');
});

// Auth routes (login/register)
require __DIR__ . '/auth.php';
