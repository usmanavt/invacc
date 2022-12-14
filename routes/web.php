<?php

use App\Models\Subhead;
use App\Models\bankpayments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkuController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\HeadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\HscodeController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\SubheadController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\RecivingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ClearanceController;
use App\Http\Controllers\DimensionController;
use App\Http\Controllers\BankPaymentsController;
use App\Http\Controllers\BankRecivingsController;
use App\Http\Controllers\CommercialInvoiceController;


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
    return view('reports')
    ->with('heads',App\Models\Head::where('status',1)->get())
    ->with('subheads',Subhead::where('status',1)->get());
})->middleware(['auth'])->name('reports');
Route::get('/fetchreport',function(Request $request){
    return $request->all();

    $report_type = $request->report_type;
    $fromdate = $request->fromdate;
    $todate = $request->todate;
    $head_id = $request->head_id;
    $subhead_id = $request->subhead_id;
    $additional; // array
    if($request->has('additional'))
        $additional = $request->additional;
    foreach($subhead_id as $si)
    {
        // check value and make report
    }
    // Process Report Here

})->name('getreport');

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
Route::get('/materials/getMaterialMaster', [MaterialController::class, 'getMaster'])->name('materials.master');
Route::get('/materials/copymaterial/copy/{material}', [MaterialController::class, 'copyMaterial'])->name('materials.copy');
Route::resource('materials', MaterialController::class);
//  Users Controller
Route::resource('users',UserController::class);


// Contract Controller
Route::get('/contracts/{contract}/printcontract', [ContractController::class, 'printContract'])->name('contracts.print');
Route::get('/contracts/getContractMaster', [ContractController::class, 'getMaster'])->name('contracts.master');
Route::get('/contracts/getContractDetails', [ContractController::class, 'getDetails'])->name('contracts.details');
Route::resource('contracts', ContractController::class);
//  CommercialInvoice
Route::get('/cis/getCisMaster', [CommercialInvoiceController::class, 'getMaster'])->name('cis.master');



Route::get('/cis/getCisDetails', [CommercialInvoiceController::class, 'getDetails'])->name('cis.details');
Route::get('/cis/getContractDetails', [CommercialInvoiceController::class, 'getContractDetails'])->name('cis.condet');
Route::resource('cis', CommercialInvoiceController::class);
//  Recivings
Route::get('/recivings/master', [RecivingController::class, 'getRecivingMaster'])->name('recivings.master');
Route::get('/recivings/details', [RecivingController::class, 'getRecivingDetails'])->name('recivings.details');
Route::get('/recivings/rcd', [RecivingController::class, 'updateCompletedReciving'])->name('reciving.updatercd');
Route::resource('recivings', RecivingController::class)->except(['create','store','show']);
//  Clearance
Route::get('/clearances/master', [ClearanceController::class, 'getMaster'])->name('clearances.master');
Route::get('/clearances/details', [ClearanceController::class, 'getDetails'])->name('clearances.details');
Route::get('/clearances/ccd', [ClearanceController::class, 'updateCompletedClearance'])->name('clearances.updatercd');
Route::resource('clearances', ClearanceController::class)->except(['create','store','show']);
//  Bank
Route::get('/banks/master', [BankController::class, 'getMaster'])->name('banks.master');
Route::resource('banks',BankController::class);
//  Bank Transactions
Route::get('/bankpayments/master', [BankPaymentsController::class, 'getMaster'])->name('bankpayments.master');
Route::resource('bankpayments',BankPaymentsController::class)->except(['create','show','destroy']);
//  Bank Recivings
Route::get('/bankrecivings/master', [BankRecivingsController::class, 'getMaster'])->name('bankrecivings.master');
Route::resource('bankrecivings',BankRecivingsController::class)->except(['create','show','destroy']);


// Route::get('myproc',function(){
//     // select procedure should be called with "call"
//     // parameter procedure should be calle with "exec"
//     $cis =  \DB::select('call MyProcedure');
//     return $cis;
// });

Route::get('myproc',function(){
    // select procedure should be called with "call"
    // parameter procedure should be calle with "exec"
    $cis = DB::table('commercial_invoices')
    ->select('invoice_date', 'invoiceno', 'machine_date', 'machineno')
    ->get();
    return $cis;
});





