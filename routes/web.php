<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SubheadController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemsizeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ItemcategoryController;
use App\Http\Controllers\GrouprelationController;
use App\Http\Controllers\ContractMasterController;


Route::get('/', function () {
    // return view('welcome');
    return view('auth.login');
});

Route::get('/mastersetup', function () {
    return view('mastersetup');
})->middleware(['auth'])->name('mastersetup');
Route::get('/transactons', function () {
    return view('transaction');
})->middleware(['auth'])->name('transaction');


Route::get('/test1', function () {
    return view('testing.test1');
});


require __DIR__.'/auth.php';


Route::get('/layouts/navigation/{id}',[MenuController::class,'Showmenu']);


Route::get('/supplier/delete/{id}',[SupplierController::class,'destroy'])->name('suppliers.destroy');
// Route::post('/supplier/create',[SupplierController::class,'store'])->name('suppliers.create');
Route::post('/supplier/update/{id}',[SupplierController::class,'update']);

Route::post('/customer/update/{id}',[CustomerController::class,'update']);
Route::get('/customer/delete/{id}',[CustomerController::class,'destroy'])->name('customers.destroy');


Route::get('/location/delete/{id}',[LocationController::class,'destroy'])->name('locations.destroy');
Route::post('/location/update/{id}',[LocationController::class,'update']);

Route::get('/subhead/delete/{id}',[SubheadController::class,'destroy'])->name('subheads.destroy');
Route::post('/subhead/update/{id}',[SubheadController::class,'update']);

Route::get('/itemcategory/delete/{id}',[ItemcategoryController::class,'destroy'])->name('itemcategory.destroy');
Route::post('/itemcategory/update/{id}',[ItemcategoryController::class,'update'])->name('itemcategory.update');


Route::get('/item/delete/{id}',[ItemController::class,'destroy'])->name('item.destroy');
Route::post('/item/update/{id}',[ItemController::class,'update'])->name('item.update');

Route::get('/itemsize/delete/{id}',[ItemsizeController::class,'destroy'])->name('itemsize.destroy');
Route::post('/itemsize/update/{id}',[ItemsizeController::class,'update'])->name('itemsize.update');
Route::post('/itemsize/save/',[ItemsizeController::class,'storetemp']);


Route::get('/grouprelation/delete/{id}',[GrouprelationController::class,'destroy'])->name('grouprelation.destroy');
Route::post('/grouprelation/update/{id}',[GrouprelationController::class,'update'])->name('grouprelation.update');


// Contract Master Controller
Route::get('/getItem', [ContractMasterController::class, 'getItem']);
Route::get('/getSize', [ContractMasterController::class, 'getSize']);
Route::resource('contracts', ContractMasterController::class);


Route::resource('suppliers', SupplierController::class);
Route::resource('customers', CustomerController::class);
Route::resource('locations', LocationController::class);
Route::resource('subheads', SubheadController::class);
Route::resource('itemcategories', ItemcategoryController::class);
Route::resource('items', ItemController::class);
Route::resource('itemsize', ItemsizeController::class);
Route::resource('grouprelations', GrouprelationController::class);