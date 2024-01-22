<?php

namespace App\Http\Controllers;

use DB;
// use App\Models\Contract;
use App\Models\Quotation;
use App\Models\QuotationDetails;

use App\Models\CustomerOrder;
use App\Models\CustomerOrderDetails;
use App\Models\CommercialInvoice;


use App\Models\Material;
use App\Models\Customer;
use App\Models\Sku;
use App\Models\Head;
use App\Models\Bank;
use App\Models\BankTransaction;
use App\Models\PaymentDetail;
use App\Models\Supplier;


use Illuminate\Http\Request;
// use App\Models\ContractDetails;
use App\Models\Location;
use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Session;

// LocalPurchaseController
class PaymentController  extends Controller
{
    public function index(Request $request)
    {
         return view('payments.index');


    }

    // public function getMaster(Request $request)
    // {
    //     $status =$request->status ;
    //     $search = $request->search;
    //     $size = $request->size;
    //     $field = $request->sort[0]["field"];     //  Nested Array
    //     $dir = $request->sort[0]["dir"];         //  Nested Array
    //     $localpurchase = CommercialInvoice::where('status',$status)
    //     ->where(function ($query) use ($search){
    //             $query->where('invoiceno','LIKE','%' . $search . '%');

    //         })
    //         ->whereHas('supplier', function ($query) {
    //             $query->where('source_id','=','1');
    //             // ->orWhere('source_id',1);
    //         })

    //     ->with('supplier:id,title')
    //     ->orderBy($field,$dir)
    //     ->paginate((int) $size);
    //     return $localpurchase;
    // }

    public function getMaster(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $cis1 = DB::select('call procpaymentindex');
        $cis = DB::table('vwpaymentindex')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        // ->with('customer:id,title')
        ->where('subhead', 'like', "%$search%")
        ->orWhere('trantype', 'like', "%$search%")
        ->orWhere('impgdno', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $cis;

    }


    public function getDetails(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $contractDetails = CustomerOrderDetails::where('sale_invoice_id',$request->id)
        ->paginate((int) $size);
        return $contractDetails;
    }

    public function getMasterqut(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $contracts = DB::table('vwpaymentmaster')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        ->where('supname', 'like', "%$search%")
        // ->orWhere('prno', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;


    }

    public function getDetailsqut(Request $request)
    {
        $id = $request->id;
        // $abc = DB::select('call proctest0(1)');
        //  $contractDetails = DB::table('vwdetailquotations')->where('sale_invoice_id',$id)->get();
        $contractDetails = DB::select('call procpaymentdtl(?)',array( $id ));
        return response()->json($contractDetails, 200);
    }


    public function create()
    {
        // $locations = Location::select('id','title')->where('status',1)->get();

        // return view('sales.create')
        // $mycname='MUHAMMAD HABIB & Co.';
        $maxposeqno = DB::table('bank_transactions')->select('*')->max('transno')+1;
        return \view ('payments.create',compact('maxposeqno'))
        ->with('heads',Head::where('status',1)->where('forcp',1)->get())
        ->with('banks',Bank::where('status',1)->get());
    }

    /** Function Complete*/
    public function store(Request $request)
    {
            //    dd($request->all());
        $this->validate($request,[
            // 'saldate' => 'required|min:3|date',
        //    'title'=>'required|min:3|unique:materials'
             'transno' => 'required|min:1|unique:bank_transactions',
            // 'pono' => 'required|min:1|unique:customer_orders'
            // 'gpno' => 'required|min:1|unique:sale_invoices',
            // 'customer_id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $ci = new BankTransaction();

            // dd($request->per());
            $ci->bank_id = $request->bank_id;
            $ci->head_id = $request->head_id;
            $ci->subhead_id = $request->supplier_id;
            $ci->impgdno = $request->impgdno;

            // $ci->transaction_type = 'BPV';
            if($request->bank_id == 1)
            {
                $ci->transaction_type = 'CPV';
            }
            if($request->bank_id > 2)
            {
                $ci->transaction_type = 'BPV';
            }
            $ci->documentdate = $request->documentdate;
            $ci->conversion_rate = $request->conversion_rate;
            $ci->amount_fc = $request->amount_fc;
            $ci->amount_pkr = $request->amount_pkr;
            $ci->cheque_date = $request->cheque_date;
            $ci->cheque_no = $request->cheque_no;
            $ci->description = $request->description;
            $ci->transno = $request->transno;
            $ci->advance = $request->advtxt;
            $ci->supname = $request->supname;


            $ci->save();

            // Quotation Close
            // $qutclose = Quotation::findOrFail($request->quotation_id);
            // $qutclose->closed = 0;
            // $qutclose->save();

            foreach ($request->banktransaction as $cont) {
                // $material = Material::findOrFail($cont['id']);
                $lpd = new PaymentDetail();
                if($cont['payedusd'] <> 0)
                {

                $lpd->paymentid = $ci->id;
                $lpd->invoice_id = $cont['invoice_id'];
                $lpd->invoice_no = $cont['invoice_no'];
                $lpd->invoice_date = $cont['invoice_date'];
                $lpd->invoice_amount = $cont['invoice_amount'];
                $lpd->curncy = $cont['curncy'];
                $lpd->payedusd = $cont['payedusd'];
                $lpd->convrate = $cont['convrate'];
                $lpd->payedrup = $cont['payedrup'];
                $lpd->invoice_bal = $cont['invoice_bal'];
                $lpd->save();
                }
            }

            $lstrt = CommercialInvoice::where('machineno',$ci->impgdno)->first();
            if($lstrt) {

                //  dd($ci->subhead_id);
             $tamount = BankTransaction::where('impgdno',$ci->impgdno)->where('subhead_id',$ci->subhead_id)->sum('amount_fc');
             if($ci->subhead_id==371)
                { $lstrt->bankcharges=$tamount;
                $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;

                $lstrt->save()
            ;}

            elseif($ci->subhead_id==372)
                { $lstrt->collofcustom=$tamount;
                    $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                    +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;

                    $lstrt->save()
            ;}

            elseif($ci->subhead_id==373)
                { $lstrt->exataxoffie=$tamount;
                    $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                    +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;
                $lstrt->save()
            ;}

            elseif($ci->subhead_id==374)
                { $lstrt->localcartage=$tamount;
                    $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                    +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;

                    $lstrt->save()
            ;}

            elseif($ci->subhead_id==375)
                { $lstrt->customsepoy=$tamount;
                    $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                    +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;

                    $lstrt->save()
            ;}

            elseif($ci->subhead_id==376)
                { $lstrt->weighbridge=$tamount;
                    $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                    +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;

                    $lstrt->save()
            ;}

            elseif($ci->subhead_id==377)
                { $lstrt->lngnshipdochrgs=$tamount;
                    $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                    +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;

                    $lstrt->save()
            ;}

            elseif($ci->subhead_id==378)
                { $lstrt->agencychrgs=$tamount;
                    $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                    +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;

                    $lstrt->save()
            ;}

            elseif($ci->subhead_id==379)
                { $lstrt->miscexpenses=$tamount;
                    $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                    +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;

                    $lstrt->save()
            ;}

            elseif($ci->subhead_id==380)
                { $lstrt->otherchrgs=$tamount;
                    $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                    +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;

                    $lstrt->save()
            ;}

            }



            DB::update(DB::raw("
            UPDATE bank_transactions c
            INNER JOIN (
            SELECT paymentid,SUM(payedusd) AS payedusd,SUM(payedrup) AS payedrup,max(convrate) AS convrate
            FROM payment_details WHERE paymentid=$ci->id GROUP BY paymentid
            ) x ON c.id = x.paymentid
            SET c.amount_fc = x.payedusd,c.amount_pkr=x.payedrup,c.conversion_rate=x.convrate
            where  c.id = $ci->id "));

            DB::update(DB::raw("
            UPDATE commercial_invoices c
            INNER JOIN (
            SELECT invoice_id,SUM(payedusd) as payment  FROM payment_details WHERE invoice_id in(select invoice_id from payment_details where paymentid =$ci->id  )  GROUP BY invoice_id
            ) x ON c.id = x.invoice_id
            SET c.invoicebal = ( case when contract_id=0 then c.total else tval end ) -  x.payment
            where  c.id in(select invoice_id from payment_details where paymentid =$ci->id  ) "));

            DB::update(DB::raw("
            UPDATE cheque_transactions c
            INNER JOIN (SELECT id,documentdate,cheque_no,transaction_type,bank_id FROM bank_transactions WHERE bank_id>3 AND id=$ci->id) x
            ON c.cheque_no=x.cheque_no and c.bank_id=x.bank_id
            SET c.clrstatus=1,c.clrdate=x.documentdate,clrid=x.id,c.ref=CONCAT(x.transaction_type,'-',LPAD(x.id,4,'0')) "));


            DB::commit();
            Session::flash('success','Payment Information Saved');
            return response()->json(['success'],200);
            // return redirect()->back();
            // Session::flash('success','Bank Transaction created');
            // return redirect()->route('banktransaction.create')->with('message','Operation Successful !');;
            // return Redirect::back()->with('message','Operation Successful !');

        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

    }

    // public function edit(Contract $contract)
    public function edit($id)
    {

        // $stockdtl = DB::select('call procdetailquotations(?,?)',array( $id,2 ));
        $cd = DB::table('payment_details')
        // ->join('materials', 'materials.id', '=', 'customer_order_details.material_id')
        // ->join('skus', 'skus.id', '=', 'customer_order_details.sku_id')
        // ->leftJoin('tmptblinvswsstock','tmptblinvswsstock.material_id', '=', 'customer_order_details.material_id')
        // ->select('customer_order_details.*','materials.title as material_title','materials.dimension','skus.title as sku',
        // DB::raw('( CASE customer_order_details.sku_id  WHEN  1 THEN tmptblinvswsstock.qtykg WHEN 2 THEN tmptblinvswsstock.qtypcs WHEN 3 THEN tmptblinvswsstock.qtyfeet  END) AS balqty')
        // ,DB::raw('( CASE customer_order_details.sku_id  WHEN  1 THEN tmptblinvswsstock.qtykg - customer_order_details.qtykg  WHEN 2 THEN tmptblinvswsstock.qtypcs - customer_order_details.qtykg WHEN 3 THEN tmptblinvswsstock.qtyfeet - customer_order_details.qtykg  END) AS varqty') )
        ->where('paymentid',$id)->get();
         $data=compact('cd');


        return view('payments.edit')
        ->with('suppliers',Supplier::select('id','title')->get())
        ->with('banktransaction',BankTransaction::findOrFail($id))
        ->with($data)
        ->with('banks',Bank::select('id','title')->get());

        // return view('contracts.edit')->with('suppliers',Supplier::select('id','title')->get())->with('contract',$contract)->with('cd',ContractDetails::where('contract_id',$contract->id)->get());
    }


    public function update(Request $request, BankTransaction $banktransaction)
    {
        //  dd($commercialinvoice->commercial_invoice_id());
            //   dd($request->all());
        DB::beginTransaction();
        try {

            //  dd($request->sale_invoice_id);
            $ci = BankTransaction::findOrFail($request->paymentid);
            $ci->bank_id = $request->bank_id;
            $ci->head_id = $request->head_id;
            $ci->subhead_id = $request->supplier_id;
            $ci->impgdno = $request->impgdno;
            if($request->bank_id == 1)
            {
                $ci->transaction_type = 'CPV';
            }
            if($request->bank_id > 2)
            {
                $ci->transaction_type = 'BPV';
            }



            $ci->documentdate = $request->documentdate;
            $ci->conversion_rate = $request->conversion_rate;
            $ci->amount_fc = $request->amount_fc;
            $ci->amount_pkr = $request->amount_pkr;
            $ci->cheque_date = $request->cheque_date;
            $ci->cheque_no = $request->cheque_no;
            $ci->description = $request->description;
            $ci->transno = $request->transno;
            $ci->advance = $request->advtxt;
            $ci->supname = $request->supname;
            $ci->save();

            $lstrt = CommercialInvoice::where('machineno',$ci->impgdno)->first();
            if($lstrt) {

                //  dd($ci->subhead_id);
             $tamount = BankTransaction::where('impgdno',$ci->impgdno)->where('subhead_id',$ci->subhead_id)->sum('amount_fc');
             if($ci->subhead_id==371)
                { $lstrt->bankcharges=$tamount;
                $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;

                $lstrt->save()
            ;}

            elseif($ci->subhead_id==372)
                { $lstrt->collofcustom=$tamount;
                    $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                    +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;

                    $lstrt->save()
            ;}

            elseif($ci->subhead_id==373)
                { $lstrt->exataxoffie=$tamount;
                    $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                    +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;
                $lstrt->save()
            ;}

            elseif($ci->subhead_id==374)
                { $lstrt->localcartage=$tamount;
                    $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                    +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;

                    $lstrt->save()
            ;}

            elseif($ci->subhead_id==375)
                { $lstrt->customsepoy=$tamount;
                    $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                    +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;

                    $lstrt->save()
            ;}

            elseif($ci->subhead_id==376)
                { $lstrt->weighbridge=$tamount;
                    $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                    +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;

                    $lstrt->save()
            ;}

            elseif($ci->subhead_id==377)
                { $lstrt->lngnshipdochrgs=$tamount;
                    $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                    +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;

                    $lstrt->save()
            ;}

            elseif($ci->subhead_id==378)
                { $lstrt->agencychrgs=$tamount;
                    $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                    +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;

                    $lstrt->save()
            ;}

            elseif($ci->subhead_id==379)
                { $lstrt->miscexpenses=$tamount;
                    $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                    +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;

                    $lstrt->save()
            ;}

            elseif($ci->subhead_id==380)
                { $lstrt->otherchrgs=$tamount;
                    $lstrt->total= $lstrt->bankcharges+$lstrt->collofcustom+$lstrt->exataxoffie+$lstrt->localcartage+$lstrt->customsepoy+$lstrt->weighbridge+$lstrt->lngnshipdochrgs
                    +$lstrt->agencychrgs+$lstrt->miscexpenses+$lstrt->otherchrgs;

                    $lstrt->save()
            ;}

            }









            // Get Data
            $cds = $request->banktransaction; // This is array
            $cds = PaymentDetail::hydrate($cds); // Convert it into Model Collection
            // Now get old ContractDetails and then get the difference and delete difference
            $oldcd = PaymentDetail::where('paymentid',$banktransaction->id)->get();
            $deleted = $oldcd->diff($cds);
            //  Delete contract details if marked for deletion
            foreach ($deleted as $d) {
                $d->delete();
            }
            // Now update existing and add new
            foreach ($cds as $cd) {
                if($cd->id)
                {
                    $cds = PaymentDetail::where('id',$cd->id)->first();
                if($cd['payedusd'] <> 0)
                {
                    $cds->paymentid = $ci->id;
                    $cds->invoice_id = $cd['invoice_id'];
                    $cds->invoice_no = $cd['invoice_no'];
                    $cds->invoice_date = $cd['invoice_date'];
                    $cds->invoice_amount = $cd['invoice_amount'];
                    $cds->curncy = $cd['curncy'];
                    $cds->payedusd = $cd['payedusd'];
                    $cds->convrate = $cd['convrate'];
                    $cds->payedrup = $cd['payedrup'];
                    $cds->invoice_bal = $cd['invoice_bal'];
                    $cds->save();
                }
                }else
                {
                    //  The item is new, Add it
                     $cds = new PaymentDetails();
                if($cd['payedusd'] <> 0)
                {
                     $cds->paymentid = $ci->id;
                     $cds->invoice_id = $cd['invoice_id'];
                     $cds->invoice_no = $cd['invoice_no'];
                     $cds->invoice_date = $cd['invoice_date'];
                     $cds->invoice_amount = $cd['invoice_amount'];
                     $cds->curncy = $cd['curncy'];
                     $cds->payedusd = $cd['payedusd'];
                     $cds->convrate = $cd['convrate'];
                     $cds->payedrup = $cd['payedrup'];
                     $cds->invoice_bal = $cd['invoice_bal'];
                    $cds->save();
                }
                }
            }

            DB::update(DB::raw("
            UPDATE bank_transactions c
            INNER JOIN (
            SELECT paymentid,SUM(payedusd) AS payedusd,SUM(payedrup) AS payedrup,max(convrate) AS convrate
            FROM payment_details WHERE paymentid=$ci->id GROUP BY paymentid
            ) x ON c.id = x.paymentid
            SET c.amount_fc = x.payedusd,c.amount_pkr=x.payedrup,c.conversion_rate=x.convrate
            where  c.id = $ci->id "));

            DB::update(DB::raw("
            UPDATE commercial_invoices c
            INNER JOIN (
            SELECT invoice_id,SUM(payedusd) as payment  FROM payment_details WHERE invoice_id in(select invoice_id from payment_details where paymentid =$ci->id  )  GROUP BY invoice_id
            ) x ON c.id = x.invoice_id
            SET c.invoicebal = ( case when contract_id=0 then c.total else tval end ) -  x.payment
            where  c.id in(select invoice_id from payment_details where paymentid =$ci->id  ) "));

            DB::update(DB::raw("
            UPDATE cheque_transactions c
            INNER JOIN (SELECT id,documentdate,cheque_no,transaction_type,bank_id FROM bank_transactions WHERE bank_id>3 AND id=$ci->id) x
            ON c.cheque_no=x.cheque_no and c.bank_id=x.bank_id
            SET c.clrstatus=1,c.clrdate=x.documentdate,clrid=x.id,c.ref=CONCAT(x.transaction_type,'-',LPAD(x.id,4,'0')) "));

            DB::commit();
            Session::flash('success','Contract Information Saved');
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }


    public function destroy(Contract $contract)
    {
        //
    }

    public function printContract($id)
    {
        // dd($id);
        $contract = Contract::findOrFail($id);
        $cd = ContractDetails::where('contract_id',$contract->id)->get();
        $html = view('contracts.print')->with('cd',$cd)->with('contract',$contract)->render();
        $filename = $contract->id . '.pdf';
        ini_set('max_execution_time', '2000');
        ini_set("pcre.backtrack_limit", "100000000");
        ini_set("memory_limit","8000M");
        ini_set('allow_url_fopen',1);
        $temp = storage_path('temp');
        // Create the mPDF document
        $mpdf = new PDF( [
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_header' => '3',
            'margin_top' => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
            'default_font_size' => 9,
            'orientation' => 'L'
        ]);
        $mpdf->SetHTMLFooter('
            <table width="100%" style="border-top:1px solid gray">
                <tr>
                    <td width="33%">{DATE j-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    <td width="33%" style="text-align: right;">' . $filename . '</td>
                </tr>
            </table>');
        $chunks = explode("chunk", $html);
        foreach($chunks as $key => $val) {
            $mpdf->WriteHTML($val);
        }
        $mpdf->Output($filename,'I');
        // 'D': download the PDF file
        // 'I': serves in-line to the browser
        // 'S': returns the PDF document as a string
        // 'F': save as file $file_out
    }
}
