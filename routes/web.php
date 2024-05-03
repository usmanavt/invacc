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
// use App\Http\Controllers\CustomerOrderwoqController;
use App\Http\Controllers\SalesRetunrsController;
use App\Http\Controllers\PurchasingController;
use App\Http\Controllers\GatepasseController;
use App\Http\Controllers\OpeningGodownStockController;
use App\Http\Controllers\PurchasinglocController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\GodownprController;
use App\Http\Controllers\GodownsrController;
use App\Http\Controllers\SalesInvoiceWopoController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReceiveController;
use App\Http\Controllers\GodownMovementController;
use App\Http\Controllers\GodownMovementControllerR;
use App\Http\Controllers\StockanalysisController;








Route::get('/', function () {
    return view('auth.login');
});

Route::get('/mastersetup', function () {
    return view('mastersetup');
})->middleware(['auth'])->name('mastersetup');
Route::get('/transactons', function () {
    return view('transaction');
})->middleware(['auth'])->name('transaction');

Route::get('/gtransactons', function () {
    return view('gtransaction');
})->middleware(['auth'])->name('gtransaction');


// Financial Report
Route::get('reports',[ReportController::class, 'index'])->name('reports.index');
 Route::get('vouchers',[ReportController::class, 'vouchers'])->name('reports.vouchers');
Route::post('report/fetch',[ReportController::class, 'fetch'])->name('reports.fetch');

// Analysis Report
Route::get('analysis',[StockanalysisController::class, 'index'])->name('analysis.index');
//  Route::get('vouchers',[StockanalysisController::class, 'vouchers'])->name('analysis.vouchers');
Route::post('analysis/fetch',[StockanalysisController::class, 'fetch'])->name('analysis.fetch');





// Purchase Reports
Route::get('purrpt',[PurchaseRptController::class, 'index'])->name('purrpt.index');
Route::get('contlistfill',[PurchaseRptController::class, 'contlistfill'])->name('purrpt.contlistfill');
Route::get('funcpurcat',[PurchaseRptController::class, 'funcpurcat'])->name('purrpt.funcpurcat');
Route::get('funcpurcatlocal',[PurchaseRptController::class, 'funcpurcatlocal'])->name('purrpt.funcpurcatlocal');

Route::get('dutycategory',[PurchaseRptController::class, 'dutycategory'])->name('purrpt.dutycategory');
Route::get('pnddutycategory',[PurchaseRptController::class, 'pnddutycategory'])->name('purrpt.pnddutycategory');
Route::get('pndcontractcategory',[PurchaseRptController::class, 'pndcontractcategory'])->name('purrpt.pndcontractcategory');

Route::get('compcontractcategory',[PurchaseRptController::class, 'compcontractcategory'])->name('purrpt.compcontractcategory');

Route::get('funcgetsuplr',[PurchaseRptController::class, 'funcgetsuplr'])->name('purrpt.funcgetsuplr');


Route::get('cominvsloc',[PurchaseRptController::class, 'cominvsloc'])->name('purrpt.cominvsloc');
Route::get('cominvsimp',[PurchaseRptController::class, 'cominvsimp'])->name('purrpt.cominvsimp');

Route::get('funcpurretcategory',[PurchaseRptController::class, 'funcpurretcategory'])->name('purrpt.funcpurretcategory');



Route::get('xyz',[PurchaseRptController::class, 'xyz'])->name('purrpt.xyz');
Route::post('purrpt/fetch',[PurchaseRptController::class, 'fetch'])->name('purrpt.fetch');


// dutyclearance Reports
// Route::get('dutyclearance',[DutyRptController::class, 'index'])->name('dutyclearance.index');
// Route::get('xyz',[PurchaseRptController::class, 'xyz'])->name('purrpt.xyz');
// Route::post('purrpt/fetch',[PurchaseRptController::class, 'fetch'])->name('purrpt.fetch');

// Sales Reports
Route::get('salerpt',[SaleRptController::class, 'index'])->name('salerpt.index');
Route::post('salerpt/fetch',[SaleRptController::class, 'fetch'])->name('salerpt.fetch');
Route::get('funcquotation',[SaleRptController::class, 'funcquotation'])->name('salerpt.funcquotation');
Route::get('funccustorder',[SaleRptController::class, 'funccustorder'])->name('salerpt.funccustorder');
Route::get('funcpendcustorder',[SaleRptController::class, 'funcpendcustorder'])->name('salerpt.funcpendcustorder');
Route::get('funcsalretcat',[SaleRptController::class, 'funcsalretcat'])->name('salerpt.funcsalretcat');
Route::get('funcpendquotation',[SaleRptController::class, 'funcpendquotation'])->name('salerpt.funcpendquotation');
Route::get('funccompquotation',[SaleRptController::class, 'funccompquotation'])->name('salerpt.funccompquotation');



Route::get('funcdlvrychln',[SaleRptController::class, 'funcdlvrychln'])->name('salerpt.funcdlvrychln');
Route::get('funcsalinvs',[SaleRptController::class, 'funcsalinvs'])->name('salerpt.funcsalinvs');
Route::get('funcsaltxinvs',[SaleRptController::class, 'funcsaltxinvs'])->name('salerpt.funcsaltxinvs');


Route::get('funcsalhist',[SaleRptController::class, 'funcsalhist'])->name('salerpt.funcsalhist');



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




Route::get('/materials/{id}/printcontract', [MaterialController::class, 'printContract'])->name('materials.print');
Route::post('/materials/printcontractSelected', [MaterialController::class, 'printContractSelected'])->name('materials.printselected');
Route::get('/materials/getMaterialMaster', [MaterialController::class, 'getMaster'])->name('materials.master');
Route::get('/materials/{id}/copyMaterial', [MaterialController::class, 'copyMaterial'])->name('materials.copy');
Route::resource('materials', MaterialController::class);
//  Users Controller
Route::resource('users',UserController::class);
// Contract Controller


// Route::get('/contracts/{id}/printcontract', [ContractController::class, 'printContract'])->name('jv.print');
 Route::get('/contracts/{contract}/printcontract', [ContractController::class, 'printContract'])->name('contracts.print');
 Route::post('/contracts/printcontractSelected', [ContractController::class, 'printContractSelected'])->name('contracts.printselected');
Route::post('/contracts/deleteBankRequest', [ContractController::class, 'deleteBankRequest'])->name('contracts.del');
Route::get('dupno',[ContractController::class, 'dupno'])->name('contracts.dupno');

// Route::post('/contracts/printrpt', [ContractController::class, 'printrpt'])->name('contracts.printrpt');


Route::get('/contracts/{id}/deleterec', [ContractController::class, 'deleterec']);


Route::get('/contracts/getContractMaster', [ContractController::class, 'getMaster'])->name('contracts.master');
Route::get('/contracts/getContractMasterI', [ContractController::class, 'getMasterImp'])->name('contracts.masterI');
Route::get('/contracts/getContractMasterL', [ContractController::class, 'getMasterLoc'])->name('contracts.masterL');
Route::get('/contracts/getContractDetails', [ContractController::class, 'getDetails'])->name('contracts.details');
Route::get('/contracts/getmatMaster', [ContractController::class, 'matMaster'])->name('mat.master');
Route::resource('contracts', ContractController::class);



//  CommercialInvoice

Route::get('/cis/{id}/printcontract', [CommercialInvoiceController::class, 'printContract'])->name('cis.print');
Route::post('/cis/deleteBankRequest', [CommercialInvoiceController::class, 'deleteBankRequest'])->name('cis.del');
Route::get('/cis/{id}/deleterec', [CommercialInvoiceController::class, 'deleterec']);


Route::get('/cis/getCisMaster', [CommercialInvoiceController::class, 'getMaster'])->name('cis.master');
Route::get('/cis/getCisDetails', [CommercialInvoiceController::class, 'getDetails'])->name('cis.details');
Route::get('/cid/getContractMasterI', [CommercialInvoiceController::class, 'getMasterImp'])->name('contracts.masterII');
Route::get('/cis/getContractDetails', [CommercialInvoiceController::class, 'getContractDetails'])->name('cis.condet');

/// For Pending DutyClear Master
Route::get('/cis/getcidMaster', [CommercialInvoiceController::class, 'getMasterdc'])->name('dutyclear.master');


Route::resource('cis', CommercialInvoiceController::class);

//  CommercialInvoice - LOCAL NEW


Route::get('/localpurchase/{id}/printcontract', [LocalPurchaseController::class, 'printContract'])->name('localpurchase.print');
Route::post('/localpurchase/deleteBankRequest', [LocalPurchaseController::class, 'deleteBankRequest'])->name('localpurchase.del');

Route::get('maxgtpass',[LocalPurchaseController::class, 'maxgtpass'])->name('localpurchase.maxgtpass');

Route::get('/localpurchase/{id}/deleterec', [LocalPurchaseController::class, 'deleterec']);



Route::get('/localpurchase/getPurchaseMaster', [LocalPurchaseController::class, 'getMaster'])->name('localpurchase.master');
Route::get('/localpurchase/getPurchaseDetails', [LocalPurchaseController::class, 'getDetail'])->name('localpurchase.details');
Route::get('/localpurchase/getLocmatMaster', [LocalPurchaseController::class, 'matMaster'])->name('locmat.master');
Route::get('/localpurchase/getLocPurIndex', [LocalPurchaseController::class, 'getLocPurIndex'])->name('locmatindex.master');

Route::resource('localpurchase', LocalPurchaseController::class);


// openinggodownstock
Route::get('/opstock/getOpstkMaster', [OpeningGodownStockController::class, 'getMaster'])->name('opstk.master');
Route::get('/opstock/getMaterialMastermat', [OpeningGodownStockController::class, 'getMastermat'])->name('materials.mastermat');
Route::resource('openinggodownstock', OpeningGodownStockController::class);



//  Sales Invoices with purchase orders

Route::get('/saleinvoices/{id}/printcontract', [SalesInvoicesController::class, 'printContract'])->name('saleinvoices.print');
Route::post('/sales/deleteBankRequest', [SalesInvoicesController::class, 'deleteBankRequest'])->name('sales.del');
Route::get('/saleinvoices/{id}/deleterec', [SalesInvoicesController::class, 'deleterec']);


Route::get('/sales/getSalesMaster', [SalesInvoicesController::class, 'getMaster'])->name('sales.master');
Route::get('/sales/getSalesDetails', [SalesInvoicesController::class, 'getDetail'])->name('sales.details');
Route::get('/sales/getSalesCustplan', [SalesInvoicesController::class, 'getMastercustplan'])->name('sales.custplan');
Route::get('/sales/getSalesCustplandtl', [SalesInvoicesController::class, 'getDetailscustplan'])->name('sales.custplandtl');
Route::resource('saleinvoices', SalesInvoicesController::class);


//  Sales Invoices with out purchase orders

Route::get('/salewopo/{id}/printcontract', [SalesInvoiceWopoController::class, 'printContract'])->name('salewopo.print');
Route::post('/salewopo/deleteBankRequest', [SalesInvoiceWopoController::class, 'deleteBankRequest'])->name('salewopo.del');
Route::get('/salewopo/{id}/deleterec', [SalesInvoiceWopoController::class, 'deleterec']);


Route::get('/salewopo/getSalesMaster', [SalesInvoiceWopoController::class, 'getMaster'])->name('saleswopo.master');
Route::get('/salewopo/getSalesDetails', [SalesInvoiceWopoController::class, 'getDetail'])->name('saleswopo.details');
Route::get('/salewopo/getSalesCustplan', [SalesInvoiceWopoController::class, 'getMastercustplan'])->name('saleswopo.custplan');
Route::get('/salewopo/getSalesCustplandtl', [SalesInvoiceWopoController::class, 'getDetailscustplan'])->name('saleswopo.custplandtl');
Route::resource('salewopo', SalesInvoiceWopoController::class);


//  Stock Transfer Order

Route::get('/godownmovement/{id}/printcontract', [GodownMovementController::class, 'printContract'])->name('godownmovement.print');
Route::post('/godownmovement/deleteBankRequest', [GodownMovementController::class, 'deleteBankRequest'])->name('godownmovement.del');
Route::get('/godownmovement/{id}/deleterec', [GodownMovementController::class, 'deleterec'])->name('godownmovement.deleterec');

Route::get('/godownmovement/getSalesMaster', [GodownMovementController::class, 'getMaster'])->name('godownmovement.master');
Route::get('/godownmovement/getSalesDetails', [GodownMovementController::class, 'getDetail'])->name('godownmovement.details');
Route::get('/godownmovement/getSalesCustplan', [GodownMovementController::class, 'getMastercustplan'])->name('godownmovement.custplan');
Route::get('/godownmovement/getSalesCustplandtl', [GodownMovementController::class, 'getDetailscustplan'])->name('godownmovement.custplandtl');
Route::get('/godownmovement/getIndexDetails', [GodownMovementController::class, 'getIndexDetails'])->name('godownmovement.getindex');
Route::resource('godownmovement', GodownMovementController::class);

Route::get('/godownmovementr/getSalesMaster', [GodownMovementControllerR::class, 'getMaster'])->name('godownmovementr.master');
Route::get('/godownmovementr/getSalesDetails', [GodownMovementControllerR::class, 'getDetail'])->name('godownmovementr.details');
Route::get('/godownmovementr/getSalesCustplan', [GodownMovementControllerR::class, 'getMastercustplan'])->name('godownmovementr.custplan');
Route::get('/godownmovementr/getSalesCustplandtl', [GodownMovementControllerR::class, 'getDetailscustplan'])->name('godownmovementr.custplandtl');
Route::get('/godownmovementr/getIndexDetails', [GodownMovementControllerR::class, 'getIndexDetails'])->name('godownmovementr.getindex');
Route::resource('godownmovementr', GodownMovementControllerR::class);









//  Gate Pass

Route::post('/gatepasse/deleteBankRequest', [GatepasseController::class, 'deleteBankRequest'])->name('gatepasse.del');
Route::get('/gatepasse/{id}/deleterec', [GatepasseController::class, 'deleterec']);



Route::get('/gatepasse/getSalesMaster', [GatepasseController::class, 'getMaster'])->name('gatepasse.master');
Route::get('/gatepasse/getSalesDetails', [GatepasseController::class, 'getDetail'])->name('gatepasse.details');
Route::get('/gatepasse/getInvsMaster', [GatepasseController::class, 'getMasterinvs'])->name('gatepasse.dcmaster');

Route::get('/gatepasse/getInvsDtl', [GatepasseController::class, 'getContractDetails'])->name('gatepasse.dcdtl');

Route::resource('gatepasse', GatepasseController::class);






//  Sales Return Invoices

Route::get('/salereturn/{id}/printcontract', [SalesRetunrsController::class, 'printContract'])->name('salereturn.print');
Route::post('/salereturn/deleteBankRequest', [SalesRetunrsController::class, 'deleteBankRequest'])->name('salereturn.del');
Route::get('/salereturn/{id}/deleterec', [SalesRetunrsController::class, 'deleterec']);


Route::get('/sales/getSalesrMaster', [SalesRetunrsController::class, 'getMaster'])->name('saler.master');
Route::get('/sales/getSalesrDetails', [SalesRetunrsController::class, 'getDetail'])->name('saler.details');
Route::get('/sales/getSalesrCustplan', [SalesRetunrsController::class, 'getMastersaler'])->name('salei.master');
Route::get('/sales/getSalesrdtl', [SalesRetunrsController::class, 'getDetailssaler'])->name('salei.details');
Route::resource('salereturn', SalesRetunrsController::class);



//  Quotation


Route::get('/quotations/{id}/printcontract', [QuotationController::class, 'printContract'])->name('quotations.print');
Route::post('/quotations/deleteBankRequest', [QuotationController::class, 'deleteBankRequest'])->name('quotations.del');
Route::get('/quotations/{id}/deleterec', [QuotationController::class, 'deleterec']);

Route::get('/quotations/getQuotationsMaster', [QuotationController::class, 'getMaster'])->name('quotations.master');
Route::get('/quotations/getQuotationsDetails', [QuotationController::class, 'getDetail'])->name('quotations.details');
Route::get('/quotations/getMmfrqut', [QuotationController::class, 'getmmfrqut'])->name('quotations.mmfrqut');
Route::get('/quotations/getqutindex', [QuotationController::class, 'qutIndex'])->name('quotations.qIndex');

Route::get('itemlistwrate',[QuotationController::class, 'itemlistwrate'])->name('quotations.itemlistwrate');
Route::get('qutseqno',[QuotationController::class, 'qutseqno'])->name('quotations.qutseqno');


Route::resource('quotations', QuotationController::class);

//  Customer Orders

Route::get('/customerorder/{id}/printcontract', [CustomerOrderController::class, 'printContract'])->name('customerorder.print');
Route::post('/customerorder/deleteBankRequest', [CustomerOrderController::class, 'deleteBankRequest'])->name('customerorder.del');
Route::get('/customerorder/{id}/deleterec', [CustomerOrderController::class, 'deleterec']);


Route::get('/custorders/getQuotationsMaster', [CustomerOrderController::class, 'getMaster'])->name('custorders.master');
Route::get('/custorders/getQuotationsDetails', [CustomerOrderController::class, 'getDetail'])->name('custorders.details');
Route::get('/custorders/getcidMaster', [CustomerOrderController::class, 'getMasterqut'])->name('custorders.quotations');
Route::get('/custorders/getCustordersQuotationsdtl', [CustomerOrderController::class, 'getDetailsqut'])->name('custorders.quotationsdtl');
Route::resource('customerorder', CustomerOrderController::class);



//  Payment Voucher
// Route::get('/materials/{id}/copyMaterial', [MaterialController::class, 'copyMaterial'])->name('materials.copy');
Route::get('/banktransaction/{id}/printcontract', [PaymentController::class, 'printContract'])->name('banktransaction.print');
Route::post('/banktransaction/deleteBankRequest', [PaymentController::class, 'deleteBankRequest'])->name('banktransaction.del');
Route::get('headlistp',[PaymentController::class, 'headlistp'])->name('banktransaction.headlistp');
Route::get('mseqnop',[PaymentController::class, 'mseqnop'])->name('banktransaction.mseqnop');
Route::get('/banktransaction/{id}/deleterec', [PaymentController::class, 'deleterec']);

Route::get('/banktransaction/getQuotationsMaster', [PaymentController::class, 'getMaster'])->name('banktransaction.master');
Route::get('/banktransaction/getQuotationsDetails', [PaymentController::class, 'getDetail'])->name('banktransaction.details');
Route::get('/banktransaction/getcidMaster', [PaymentController::class, 'getMasterqut'])->name('banktransaction.quotations');
Route::get('/banktransaction/getCustordersQuotationsdtl', [PaymentController::class, 'getDetailsqut'])->name('banktransaction.quotationsdtl');
Route::resource('banktransaction', PaymentController::class);


//  Received Voucher
Route::get('/banktransactionr/{id}/printcontract', [ReceiveController::class, 'printContract'])->name('banktransactionr.print');
Route::post('/banktransactionr/deleteBankRequest', [ReceiveController::class, 'deleteBankRequest'])->name('banktransactionr.del');
Route::get('/banktransactionr/{id}/deleterec', [ReceiveController::class, 'deleterec']);

Route::get('/banktransactionr/getQuotationsMaster', [ReceiveController::class, 'getMaster'])->name('banktransactionr.master');
Route::get('/banktransactionr/getQuotationsDetails', [ReceiveController::class, 'getDetail'])->name('banktransactionr.details');
Route::get('/banktransactionr/getcidMaster', [ReceiveController::class, 'getMasterqut'])->name('banktransactionr.quotations');
Route::get('/banktransactionr/getCustordersQuotationsdtl', [ReceiveController::class, 'getDetailsqut'])->name('banktransactionr.quotationsdtl');
Route::get('headlist',[ReceiveController::class, 'headlist'])->name('banktransactionr.headlist');
Route::get('mseqno',[ReceiveController::class, 'mseqno'])->name('banktransactionr.mseqno');
Route::get('chqvalid',[ReceiveController::class, 'chqvalid'])->name('banktransactionr.chqvalid');


Route::resource('banktransactionr', ReceiveController::class);




//  Purchase Return
Route::get('/purchasereturn/{id}/printcontract', [PurchaseReturnController::class, 'printContract'])->name('purchasereturn.print');
Route::post('/purchasereturn/deleteBankRequest', [PurchaseReturnController::class, 'deleteBankRequest'])->name('purchasereturn.del');
Route::get('/purchasereturn/{id}/deleterec', [PurchaseReturnController::class, 'deleterec']);


Route::get('/purchasereturn/getQuotationsMaster', [PurchaseReturnController::class, 'getMaster'])->name('purchasereturn.master');
Route::get('/purchasereturn/getQuotationsDetails', [PurchaseReturnController::class, 'getDetail'])->name('purchasereturn.details');
Route::get('/purchasereturn/getcidMaster', [PurchaseReturnController::class, 'getMasterqut'])->name('purchasereturn.quotations');
Route::get('/purchasereturn/getCustordersQuotationsdtl', [PurchaseReturnController::class, 'getDetailsqut'])->name('purchasereturn.quotationsdtl');
Route::resource('purchasereturn', PurchaseReturnController::class);



//  Purchasing Imported

Route::get('/purchasing/{id}/printcontract', [PurchasingController::class, 'printContract'])->name('purchasing.print');
Route::post('/purchasing/deleteBankRequest', [PurchasingController::class, 'deleteBankRequest'])->name('purchasing.del');
Route::get('/purchasing/{id}/deleterec', [PurchasingController::class, 'deleterec']);



Route::get('/Purchasing/getPurchasingMaster', [PurchasingController::class, 'getMaster'])->name('purchasing.master');
Route::get('/Purchasing/getPurchasingDetails', [PurchasingController::class, 'getDetail'])->name('purchasing.details');
Route::get('/Purchasing/getContractDetails', [PurchasingController::class, 'getContractDetails'])->name('contfrpur.dtl');
Route::resource('purchasing', PurchasingController::class);


//  Purchasing Local
Route::get('/purchasingloc/{id}/printcontract', [PurchasinglocController::class, 'printContract'])->name('purchasingloc.print');
Route::post('/purchasingloc/deleteBankRequest', [PurchasinglocController::class, 'deleteBankRequest'])->name('purchasingloc.del');
Route::get('/purchasingloc/{id}/deleterec', [PurchasinglocController::class, 'deleterec']);



Route::get('/Purchasingloc/getPurchasingMaster', [PurchasinglocController::class, 'getMaster'])->name('purchasingloc.master');
Route::get('/Purchasingloc/getPurchasingDetails', [PurchasinglocController::class, 'getDetail'])->name('purchasingloc.details');
Route::get('/Purchasingloc/PurinvsMaster', [PurchasinglocController::class, 'getMasterpendipurnvs'])->name('purinvs.master');
Route::get('/Purchasingloc/P.urinvsDetail', [PurchasinglocController::class, 'getContractDetails'])->name('purinvs.detail');
Route::resource('purchasingloc', PurchasinglocController::class);


//  Godown purhcase return

Route::post('/godownpr/deleteBankRequest', [GodownprController::class, 'deleteBankRequest'])->name('godownpr.del');
Route::get('/godownpr/{id}/deleterec', [GodownprController::class, 'deleterec']);


Route::get('/godownpr/getPurchasingMaster', [GodownprController::class, 'getMaster'])->name('godownpr.master');
Route::get('/godownpr/getPurchasingDetails', [GodownprController::class, 'getDetail'])->name('godownpr.details');
Route::get('/godownpr/PurinvsMaster', [GodownprController::class, 'getMasterpendipurnvs'])->name('purinvspr.master');
Route::get('/godownpr/P.urinvsDetail', [GodownprController::class, 'getContractDetails'])->name('purinvspr.detail');
Route::resource('godownpr', GodownprController::class);


//  Godown sale return
Route::post('/godownsr/deleteBankRequest', [GodownsrController::class, 'deleteBankRequest'])->name('godownsr.del');
Route::get('/godownsr/{id}/deleterec', [GodownsrController::class, 'deleterec']);


Route::get('/godownsr/getPurchasingMaster', [GodownsrController::class, 'getMaster'])->name('godownsr.master');
Route::get('/godownsr/getPurchasingDetails', [GodownsrController::class, 'getDetail'])->name('godownsr.details');
Route::get('/godownsr/PurinvsMaster', [GodownsrController::class, 'getMasterpendipurnvs'])->name('purinvssr.master');
Route::get('/godownsr/P.urinvsDetail', [GodownsrController::class, 'getContractDetails'])->name('purinvssr.detail');
Route::resource('godownsr', GodownsrController::class);





// Route::get('/custorderswoq/getQuotationsMaster', [CustomerOrderwoqController::class, 'getMaster'])->name('custorderswoq.master');
// Route::get('/custorderswoq/getQuotationsDetails', [CustomerOrderwoqController::class, 'getDetail'])->name('custorderswoq.details');
// Route::get('/custorderswoq/getcidMaster', [CustomerOrderwoqController::class, 'getMasterqut'])->name('custorderswoq.quotations');
// Route::get('/custorderswoq/getCustordersQuotationsdtl', [CustomerOrderwoqController::class, 'getDetailsqut'])->name('custorderswoq.quotationsdtl');
// Route::resource('customerorderwoq', CustomerOrderwoqController::class);


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


Route::get('/clearance/{id}/printcontract', [ClearanceController::class, 'printContract'])->name('clearance.print');
Route::post('/clearance/deleteBankRequest', [ClearanceController::class, 'deleteBankRequest'])->name('clearance.del');
Route::get('/clearance/{id}/deleterec', [ClearanceController::class, 'deleterec']);


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


// Route::get('/bankrecivings/printcontract', [BankRecivingsController::class, 'printContract'])->name('bankrecivings.print');
Route::get('/bankrecivings/{id}/printcontract', [BankRecivingsController::class, 'printContract'])->name('bankrecivings.print');
Route::post('/bankrecivings/deleteBankRequest', [BankRecivingsController::class, 'deleteBankRequest'])->name('bankrecivings.del');
Route::get('/bankrecivings/{id}/deleterec', [BankRecivingsController::class, 'deleterec'])->name('bankrecivings.deleterec');


Route::get('/bankrecivings/master', [BankRecivingsController::class, 'getMaster'])->name('bankrecivings.master');
Route::resource('bankrecivings',BankRecivingsController::class)->except(['create','show','destroy']);
//  Cash Payment
Route::get('/cashpayments/master', [CashPaymentController::class, 'getMaster'])->name('cashpayments.master');
Route::resource('cashpayments',CashPaymentController::class)->except(['create','show','destroy']);

//  Cash Recivings
Route::get('/cashrecivings/master', [CashRecivingsController::class, 'getMaster'])->name('cashrecivings.master');
Route::resource('cashrecivings',CashRecivingsController::class)->except(['create','show','destroy']);



//  Journal Vouchers


Route::get('/jv/{id}/printcontract', [VoucherController::class, 'printContract'])->name('jv.print');
Route::post('/jv/deleteBankRequest', [VoucherController::class, 'deleteBankRequest'])->name('jv.del');
Route::get('/jv/{id}/deleterec', [VoucherController::class, 'deleterec'])->name('jv.deleterec');


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





