<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkuController;
use App\Http\Controllers\HeadController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\HscodeController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\SubheadController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DimensionController;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/mastersetup', function () {
    return view('mastersetup');
})->middleware(['auth'])->name('mastersetup');
Route::get('/transactons', function () {
    return view('transaction');
})->middleware(['auth'])->name('transaction');
Route::get('/reports', function () {
    return view('reports');
})->middleware(['auth'])->name('reports');

require __DIR__.'/auth.php';

//  Category Controller
Route::resource('categories', CategoryController::class);
//  Sku Controller
Route::resource('skus', SkuController::class);
//  Dimension Controller
Route::resource('dimensions', DimensionController::class);
//  Brand Controller
Route::resource('brands',BrandController::class);
//  Source Controller
Route::resource('sources',SourceController::class);
//  Supplier Controller
Route::resource('suppliers', SupplierController::class);
//  Customer Controller
Route::resource('customers', CustomerController::class);
//  Location Controller
Route::resource('locations', LocationController::class);
//  Head Controller
Route::resource('heads', HeadController::class);
//  Subhead Controller
Route::resource('subheads', SubheadController::class);
//  HSE Controller
Route::resource('hscodes', HscodeController::class);
//  Material Controller
Route::get('/getMaterialMaster', [MaterialController::class, 'getMaster'])->name('materials.master');
Route::get('/copymaterial/copy/{material}', [MaterialController::class, 'copyMaterial'])->name('materials.copy');
Route::resource('materials', MaterialController::class);




// Contract Controller
Route::get('/getContractMaster', [ContractController::class, 'getMaster'])->name('contracts.master');
Route::get('/getContractDetails', [ContractController::class, 'getDetails'])->name('contracts.details');
Route::resource('contracts', ContractController::class);
