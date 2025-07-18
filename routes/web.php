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
    IncentiveRecapController,
    SalesTransactionController,
    ProfileController
};

Route::get('/', fn() => redirect()->route('login'));
Route::get('/dashboard', fn() => redirect()->route('dashboards.index'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('/incentive-recap', IncentiveRecapController::class);
    Route::resource('dashboards', DashboardController::class);


    Route::middleware('role:marketing')->group(function () {
        Route::resource('uploads', UploadController::class);
        Route::get('/data-import', [DataImportController::class, 'index'])->name('data.import.index');
        Route::post('/data-import', [DataImportController::class, 'store'])->name('data.import.store');
        Route::get('/targets/filter', [TargetController::class, 'filterByDate'])->name('targets.filterByDate');
        Route::resource('/targets', TargetController::class);
        Route::get('/spgms/autocomplete', [SpgmController::class, 'autocomplete'])->name('spgms.autocomplete');
        Route::resource('promoters', SpgmController::class);
        Route::get('/stores/autocomplete', [StoreController::class, 'autocomplete'])->name('stores.autocomplete');
        Route::get('/products/autocomplete', [ModelIncentiveController::class, 'autocomplete'])->name('products.autocomplete');
        Route::resource('products', ProductController::class);
        Route::resource('model-incentives', ModelIncentiveController::class);
        Route::resource('discontinued-products', DiscontinuedProductController::class);
    });

    Route::middleware(['role:manager|marketing'])->group(function () {
        Route::get('/transaksi/rincian', [SalesTransactionController::class, 'rincian'])->name('transaksi.rincian');
        Route::get('/transaksi/summary', [SalesTransactionController::class, 'summary'])->name('transaksi.summary');
    });
});

require __DIR__ . '/auth.php';
