<?php

use App\Http\Controllers\AdminBranchController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MetalRateController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductInventoryController;
use App\Http\Middleware\EnsureUserIsActive;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', EnsureUserIsActive::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Module: Live Metal Rates
    Route::get('/rates', [MetalRateController::class, 'index'])->name('rates.index');
    Route::post('/rates', [MetalRateController::class, 'store'])->name('rates.store');
    Route::post('/rates/sync', [MetalRateController::class, 'syncLiveRates'])->name('rates.sync');

    // Module: Product Inventory
    Route::get('/products', [ProductInventoryController::class, 'products'])->name('products.index');
    Route::post('/products', [ProductInventoryController::class, 'storeProduct'])->name('products.store');
    Route::delete('/products/{product}', [ProductInventoryController::class, 'destroyProduct'])->name('products.destroy');
    Route::get('/inventory', [ProductInventoryController::class, 'inventory'])->name('inventory.index');
    Route::post('/inventory', [ProductInventoryController::class, 'storeItem'])->name('inventory.store');
    Route::delete('/inventory/{inventoryItem}', [ProductInventoryController::class, 'destroyItem'])->name('inventory.destroy');

    // Module: POS & Billing
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/calculate', [PosController::class, 'calculatePreview'])->name('pos.calculate');
    Route::post('/pos/checkout', [PosController::class, 'store'])->name('pos.store');
    Route::get('/invoices', [PosController::class, 'invoices'])->name('pos.invoices');
    Route::get('/invoices/{invoice}', [PosController::class, 'showInvoice'])->name('pos.invoice');
    Route::delete('/invoices/{invoice}', [PosController::class, 'destroyInvoice'])->name('pos.invoices.destroy');
    Route::post('/invoices/{invoice}/cancel', [PosController::class, 'cancelInvoice'])->name('pos.cancel');

    // Module: CRM
    Route::get('/customers', [ProductInventoryController::class, 'customers'])->name('crm.index');
    Route::post('/customers', [ProductInventoryController::class, 'storeCustomer'])->name('crm.store');
    Route::get('/customers/{customer}', [ProductInventoryController::class, 'show'])->name('crm.show');
});