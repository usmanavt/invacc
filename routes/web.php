<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SubheadController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemSizeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\GrouprelationController;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/mastersetup', function () {
    return view('mastersetup');
})->middleware(['auth'])->name('mastersetup');
Route::get('/transactons', function () {
    return view('transaction');
})->middleware(['auth'])->name('transaction');

require __DIR__.'/auth.php';

// Contract Controller
Route::get('/getItems', [ContractController::class, 'getItems']);
Route::get('/getSizes', [ContractController::class, 'getSizes']);
Route::resource('contracts', ContractController::class);

//  Category Controller
Route::resource('categories', CategoryController::class);

//  Supplier Controller
Route::resource('suppliers', SupplierController::class);

//  Item Controller
Route::resource('items', ItemController::class);

//  Location Controller
Route::resource('locations', LocationController::class);
//  ItemSize Controller
Route::resource('itemsize', ItemSizeController::class);
//  Customer Controller
Route::resource('customers', CustomerController::class);


Route::resource('subheads', SubheadController::class);
Route::resource('grouprelations', GrouprelationController::class);


Route::get('/layouts/navigation/{id}',[MenuController::class,'Showmenu']);


Route::post('/customer/update/{id}',[CustomerController::class,'update']);
Route::get('/customer/delete/{id}',[CustomerController::class,'destroy'])->name('customers.destroy');


Route::get('/subhead/delete/{id}',[SubheadController::class,'destroy'])->name('subheads.destroy');
Route::post('/subhead/update/{id}',[SubheadController::class,'update']);

Route::get('/grouprelation/delete/{id}',[GrouprelationController::class,'destroy'])->name('grouprelation.destroy');
Route::post('/grouprelation/update/{id}',[GrouprelationController::class,'update'])->name('grouprelation.update');

