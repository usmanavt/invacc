<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkuController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\HeadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\HscodeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\SubheadController;
use App\Http\Controllers\VoucherController;
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
use App\Http\Controllers\CommercialInvoiceControllerlocal;
use App\Http\Controllers\CashPaymentController;
use App\Http\Controllers\CashRecivingsController;
use App\Http\Controllers\LocalPurchaseController;
use App\Http\Controllers\SalesInvoicesController;
use App\Http\Controllers\PurchaseRptController;
use App\Http\Controllers\SaleRptController;
use App\Http\Controllers\StockLedgerController;
use App\Http\Controllers\CareController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\CustomerOrderwoqController;
use App\Http\Controllers\SalesRetunrsController;
use App\Http\Controllers\PurchasingController;
use App\Http\Controllers\GatepasseController;
use App\Http\Controllers\OpeningGodownStockController;
use App\Http\Controllers\PurchasinglocController;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/mastersetup', function () {
    return view('mastersetup');
})->middleware(['auth'])->name('mastersetup');
Route::get('/transactons', function () {
    return view('transaction');
})->middleware(['auth'])->name('transaction');



// Financial Report
Route::get('reports',[ReportController::class, 'index'])->name('reports.index');
 Route::get('vouchers',[ReportController::class, 'vouchers'])->name('reports.vouchers');
Route::post('report/fetch',[ReportController::class, 'fetch'])->name('reports.fetch');

// Purchase Reports
Route::get('purrpt',[PurchaseRptController::class, 'index'])->name('purrpt.index');
Route::get('contlistfill',[PurchaseRptController::class, 'contlistfill'])->name('purrpt.contlistfill');
Route::get('funcpurcat',[PurchaseRptController::class, 'funcpurcat'])->name('purrpt.funcpurcat');
Route::get('dutycategory',[PurchaseRptController::class, 'dutycategory'])->name('purrpt.dutycategory');
Route::get('pnddutycategory',[PurchaseRptController::class, 'pnddutycategory'])->name('purrpt.pnddutycategory');
Route::get('pndcontractcategory',[PurchaseRptController::class, 'pndcontractcategory'])->name('purrpt.pndcontractcategory');

Route::get('compcontractcategory',[PurchaseRptController::class, 'compcontractcategory'])->name('purrpt.compcontractcategory');



Route::get('cominvsloc',[PurchaseRptController::class, 'cominvsloc'])->name('purrpt.cominvsloc');
Route::get('cominvsimp',[PurchaseRptController::class, 'cominvsimp'])->name('purrpt.cominvsimp');

Route::get('xyz',[PurchaseRptController::class, 'xyz'])->name('purrpt.xyz');
Route::post('purrpt/fetch',[PurchaseRptController::class, 'fetch'])->name('purrpt.fetch');


// dutyclearance Reports
Route::get('dutyclearance',[DutyRptController::class, 'index'])->name('dutyclearance.index');
// Route::get('xyz',[PurchaseRptController::class, 'xyz'])->name('purrpt.xyz');
// Route::post('purrpt/fetch',[PurchaseRptController::class, 'fetch'])->name('purrpt.fetch');

// Sales Reports
Route::get('salerpt',[SaleRptController::class, 'index'])->name('salerpt.index');
Route::post('salerpt/fetch',[SaleRptController::class, 'fetch'])->name('salerpt.fetch');
Route::get('funcquotation',[SaleRptController::class, 'funcquotation'])->name('salerpt.funcquotation');
Route::get('funccustorder',[SaleRptController::class, 'funccustorder'])->name('salerpt.funccustorder');
Route::get('funcdlvrychln',[SaleRptController::class, 'funcdlvrychln'])->name('salerpt.funcdlvrychln');
Route::get('funcsalinvs',[SaleRptController::class, 'funcsalinvs'])->name('salerpt.funcsalinvs');
Route::get('funcsaltxinvs',[SaleRptController::class, 'funcsaltxinvs'])->name('salerpt.funcsaltxinvs');


// Material Stock Reports
 Route::get('stockledgers',[StockLedgerController::class, 'index'])->name('stockledgers.index');
 Route::get('funcstkos',[StockLedgerController::class, 'funcstkos'])->name('stockledgers.funcstkos');

 Route::post('stockledgers/fetch',[StockLedgerController::class, 'fetch'])->name('stockledgers.fetch');



require __DIR__.'/auth.php';

//  Category Controller
Route::get('/categories/master', [CategoryController::class, 'getMaster'])->name('categories.master');
Route::resource('categories', CategoryController::class)->except(['create','show','destroy']);
//  Sku Controller
Route::get('/skus/master', [SkuController::class, 'getMaster'])->name('skus.master');
Route::resource('skus', SkuController::class)->except(['create','show','destroy']);
//  Dimension Controller
Route::get('/dimensions/master', [DimensionController::class, 'getMaster'])->name('dimensions.master');
Route::resource('dimensions', DimensionController::class)->except(['create','show','destroy']);
//  careof Controller
Route::get('/cares/master', [CareController::class, 'getMaster'])->name('cares.master');
Route::resource('cares', CareController::class)->except(['create','show','destroy']);
//  Brand Controller
Route::get('/brands/master', [BrandController::class, 'getMaster'])->name('brands.master');
Route::resource('brands',BrandController::class)->except(['create','show','destroy']);
//  Source Controller
Route::get('/sources/master', [SourceController::class, 'getMaster'])->name('sources.master');
Route::resource('sources',SourceController::class);
//  Supplier Controller
Route::get('/suppliers/master', [SupplierController::class, 'getMaster'])->name('suppliers.master');
Route::resource('suppliers', SupplierController::class);
//  Customer Controller
Route::get('/customers/master', [CustomerController::class, 'getMaster'])->name('customers.master');
Route::resource('customers', CustomerController::class);
//  Location Controller
Route::get('/locations/master', [LocationController::class, 'getMaster'])->name('locations.master');
Route::resource('locations', LocationController::class)->except(['create','show','destroy']);
//  Head Controller
Route::get('/heads/master', [HeadController::class, 'getMaster'])->name('heads.master');
Route::resource('heads', HeadController::class)->except(['create','show','destroy']);
//  Subhead Controller
Route::get('/subheads/master', [SubheadController::class, 'getMaster'])->name('subheads.master');
Route::resource('subheads', SubheadController::class)->except(['create','show','destroy']);
//  HSE Controller
Route::get('/hscodes/master', [HscodeController::class, 'getMaster'])->name('hscodes.master');
Route::resource('hscodes', HscodeController::class);
//  Material Controller
Route::get('/materials/getMaterialMaster', [MaterialController::class, 'getMaster'])->name('materials.master');
Route::get('/materials/{id}/copyMaterial', [MaterialController::class, 'copyMaterial'])->name('materials.copy');
Route::resource('materials', MaterialController::class);
//  Users Controller
Route::resource('users',UserController::class);
// Contract Controller
Route::get('/contracts/{contract}/printcontract', [ContractController::class, 'printContract'])->name('contracts.print');
Route::get('/contracts/getContractMaster', [ContractController::class, 'getMaster'])->name('contracts.master');
Route::get('/contracts/getContractMasterI', [ContractController::class, 'getMasterImp'])->name('contracts.masterI');
Route::get('/contracts/getContractMasterL', [ContractController::class, 'getMasterLoc'])->name('contracts.masterL');
Route::get('/contracts/getContractDetails', [ContractController::class, 'getDetails'])->name('contracts.details');
Route::get('/contracts/getmatMaster', [ContractController::class, 'matMaster'])->name('mat.master');
Route::resource('contracts', ContractController::class);



//  CommercialInvoice
Route::get('/cis/getCisMaster', [CommercialInvoiceController::class, 'getMaster'])->name('cis.master');
Route::get('/cis/getCisDetails', [CommercialInvoiceController::class, 'getDetails'])->name('cis.details');
Route::get('/cid/getContractMasterI', [CommercialInvoiceController::class, 'getMasterImp'])->name('contracts.masterII');
Route::get('/cis/getContractDetails', [CommercialInvoiceController::class, 'getContractDetails'])->name('cis.condet');

/// For Pending DutyClear Master
Route::get('/cis/getcidMaster', [CommercialInvoiceController::class, 'getMasterdc'])->name('dutyclear.master');


Route::resource('cis', CommercialInvoiceController::class);

//  CommercialInvoice - LOCAL NEW
Route::get('/localpurchase/getPurchaseMaster', [LocalPurchaseController::class, 'getMaster'])->name('localpurchase.master');
Route::get('/localpurchase/getPurchaseDetails', [LocalPurchaseController::class, 'getDetail'])->name('localpurchase.details');
Route::get('/localpurchase/getLocmatMaster', [LocalPurchaseController::class, 'matMaster'])->name('locmat.master');



Route::resource('localpurchase', LocalPurchaseController::class);


// openinggodownstock
Route::get('/opstock/getOpstkMaster', [OpeningGodownStockController::class, 'getMaster'])->name('opstk.master');
Route::get('/opstock/getMaterialMastermat', [OpeningGodownStockController::class, 'getMastermat'])->name('materials.mastermat');
Route::resource('openinggodownstock', OpeningGodownStockController::class);



//  Sales Invoices

Route::get('/sales/getSalesMaster', [SalesInvoicesController::class, 'getMaster'])->name('sales.master');
Route::get('/sales/getSalesDetails', [SalesInvoicesController::class, 'getDetail'])->name('sales.details');
Route::get('/sales/getSalesCustplan', [SalesInvoicesController::class, 'getMastercustplan'])->name('sales.custplan');
Route::get('/sales/getSalesCustplandtl', [SalesInvoicesController::class, 'getDetailscustplan'])->name('sales.custplandtl');
Route::resource('saleinvoices', SalesInvoicesController::class);



//  Gate Pass
Route::get('/gatepasse/getSalesMaster', [GatepasseController::class, 'getMaster'])->name('gatepasse.master');
Route::get('/gatepasse/getSalesDetails', [GatepasseController::class, 'getDetail'])->name('gatepasse.details');
Route::get('/gatepasse/getInvsMaster', [GatepasseController::class, 'getMasterinvs'])->name('gatepasse.dcmaster');

Route::get('/gatepasse/getInvsDtl', [GatepasseController::class, 'getContractDetails'])->name('gatepasse.dcdtl');

Route::resource('gatepasse', GatepasseController::class);






//  Sales Return Invoices
Route::get('/sales/getSalesrMaster', [SalesRetunrsController::class, 'getMaster'])->name('saler.master');
Route::get('/sales/getSalesrDetails', [SalesRetunrsController::class, 'getDetail'])->name('saler.details');
Route::get('/sales/getSalesrCustplan', [SalesRetunrsController::class, 'getMastersaler'])->name('salei.master');
Route::get('/sales/getSalesrdtl', [SalesRetunrsController::class, 'getDetailssaler'])->name('salei.details');
Route::resource('salereturn', SalesRetunrsController::class);



//  Quotation

Route::get('/quotations/getQuotationsMaster', [QuotationController::class, 'getMaster'])->name('quotations.master');
Route::get('/quotations/getQuotationsDetails', [QuotationController::class, 'getDetail'])->name('quotations.details');
Route::get('/quotations/getMmfrqut', [QuotationController::class, 'getmmfrqut'])->name('quotations.mmfrqut');



Route::resource('quotations', QuotationController::class);

//  Customer Orders
Route::get('/custorders/getQuotationsMaster', [CustomerOrderController::class, 'getMaster'])->name('custorders.master');
Route::get('/custorders/getQuotationsDetails', [CustomerOrderController::class, 'getDetail'])->name('custorders.details');
Route::get('/custorders/getcidMaster', [CustomerOrderController::class, 'getMasterqut'])->name('custorders.quotations');
Route::get('/custorders/getCustordersQuotationsdtl', [CustomerOrderController::class, 'getDetailsqut'])->name('custorders.quotationsdtl');
Route::resource('customerorder', CustomerOrderController::class);





//  Purchasing Imported
Route::get('/Purchasing/getPurchasingMaster', [PurchasingController::class, 'getMaster'])->name('purchasing.master');
Route::get('/Purchasing/getPurchasingDetails', [PurchasingController::class, 'getDetail'])->name('purchasing.details');
Route::get('/Purchasing/getContractDetails', [PurchasingController::class, 'getContractDetails'])->name('contfrpur.dtl');
Route::resource('purchasing', PurchasingController::class);


//  Purchasing Local
Route::get('/Purchasingloc/getPurchasingMaster', [PurchasinglocController::class, 'getMaster'])->name('purchasingloc.master');
Route::get('/Purchasingloc/getPurchasingDetails', [PurchasinglocController::class, 'getDetail'])->name('purchasingloc.details');
Route::get('/Purchasingloc/PurinvsMaster', [PurchasinglocController::class, 'getMasterpendipurnvs'])->name('purinvs.master');
Route::get('/Purchasingloc/P.urinvsDetail', [PurchasinglocController::class, 'getContractDetails'])->name('purinvs.detail');
Route::resource('purchasingloc', PurchasinglocController::class);








Route::get('/custorderswoq/getQuotationsMaster', [CustomerOrderwoqController::class, 'getMaster'])->name('custorderswoq.master');
Route::get('/custorderswoq/getQuotationsDetails', [CustomerOrderwoqController::class, 'getDetail'])->name('custorderswoq.details');
Route::get('/custorderswoq/getcidMaster', [CustomerOrderwoqController::class, 'getMasterqut'])->name('custorderswoq.quotations');
Route::get('/custorderswoq/getCustordersQuotationsdtl', [CustomerOrderwoqController::class, 'getDetailsqut'])->name('custorderswoq.quotationsdtl');
Route::resource('customerorderwoq', CustomerOrderwoqController::class);


//  CommercialInvoice - LOCAL
Route::get('/cisl/getCisMaster', [CommercialInvoiceControllerlocal::class, 'getMaster'])->name('cisl.master');
Route::get('/cisl/getCisDetails', [CommercialInvoiceControllerlocal::class, 'getDetails'])->name('cisl.details');
Route::get('/cisl/getContractDetails', [CommercialInvoiceControllerlocal::class, 'getContractDetails'])->name('cisl.condet');
Route::resource('cisl', CommercialInvoiceControllerlocal::class);






//  Recivings
Route::get('/recivings/master', [RecivingController::class, 'getRecivingMaster'])->name('recivings.master');
Route::get('/recivings/details', [RecivingController::class, 'getRecivingDetails'])->name('recivings.details');
Route::get('/recivings/rcd', [RecivingController::class, 'updateCompletedReciving'])->name('reciving.updatercd');
Route::resource('recivings', RecivingController::class)->except(['create','store','show']);
//  Clearance
// Route::get('/clearances/master', [ClearanceController::class, 'getMaster'])->name('clearances.master');
// Route::get('/clearances/details', [ClearanceController::class, 'getDetails'])->name('clearances.details');
//  Route::get('/clearances/ccd', [ClearanceController::class, 'updateCompletedClearance'])->name('clearances.updatercd');

Route::get('/clearance/getCisclrMaster', [ClearanceController::class, 'getMaster'])->name('cisclr.master');
Route::get('/clearance/getCisclrDetails', [ClearanceController::class, 'getDetails'])->name('clearances.details');

Route::get('/clearance/getContractDetails', [ClearanceController::class, 'getContractDetails'])->name('cis3.condet');

Route::resource('clearance', ClearanceController::class);
// ->except(['create','store','show']);




//  Bank
Route::get('/banks/master', [BankController::class, 'getMaster'])->name('banks.master');
Route::resource('banks',BankController::class);
//  Bank Transactions
Route::get('/bankpayments/master', [BankPaymentsController::class, 'getMaster'])->name('bankpayments.master');
Route::resource('bankpayments',BankPaymentsController::class)->except(['create','show','destroy']);
//  Bank Recivings
Route::get('/bankrecivings/master', [BankRecivingsController::class, 'getMaster'])->name('bankrecivings.master');
Route::resource('bankrecivings',BankRecivingsController::class)->except(['create','show','destroy']);
//  Cash Payment
Route::get('/cashpayments/master', [CashPaymentController::class, 'getMaster'])->name('cashpayments.master');
Route::resource('cashpayments',CashPaymentController::class)->except(['create','show','destroy']);

//  Cash Recivings
Route::get('/cashrecivings/master', [CashRecivingsController::class, 'getMaster'])->name('cashrecivings.master');
Route::resource('cashrecivings',CashRecivingsController::class)->except(['create','show','destroy']);



//  Journal Vouchers
Route::get('/jv/master', [VoucherController::class, 'getMaster'])->name('jv.master');
Route::resource('jv',VoucherController::class);

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





