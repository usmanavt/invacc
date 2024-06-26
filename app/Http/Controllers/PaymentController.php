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



    public function headlistp1(Request $request)
    {
        //  dd($request->all());
        $head_id = $request->head_id;
        // procpaymentmaster(32)
        return  DB::select('call procpaymentmaster(?)',array($head_id));

    }

    public function mseqnop(Request $request)
    {
        //  dd($request->all());
        $head_id = $request->head_id;
        $maxposeqno = DB::table('bank_transactions')->select('*')->max('transno')+1;
        return  $maxposeqno;

    }




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
        ->orWhere('ref', 'like', "%$search%")
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
        // ->where('supname', 'like', "%$search%")
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


    // public function delrec()
    // {
    //     return view('deleterec');
    // }


    public function create()
    {


        $result1 = DB::table('vwpaymentmaster')->get();
        $resultArray1 = $result1->toArray();
        $data1=compact('resultArray1');

        $result = DB::table('banks')->whereNotIn('id',[2])->get();
        $resultArray = $result->toArray();
        $data=compact('resultArray');


        $maxposeqno = DB::table('bank_transactions')->select('*')->max('transno')+1;
        return \view ('payments.create',compact('maxposeqno'))->with($data)->with($data1)
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


// FOR DUPLICATE CHEQUE NO

    if($request->bank_id > 1 && $request->cheque_no != ' ' )
       {
        // $dupchqno = BankTransaction::where('cheque_no',$request->cheque_no)->first();
        $dupchqno = DB::table('vwdupchqno')->where('cheque_no',$request->cheque_no)->first();
        if($dupchqno) {
            Session::flash('info','Record not Save Successfully Due to "Duplicate Cheque_no" ');
            return response()->json(['success'],200);
                      }
        }


        DB::beginTransaction();
        try {
            $ci = new BankTransaction();
            // hdid,subhdid
            // dd($request->per());
            $ci->bank_id = $request->bank_id;
            $ci->head_id = $request->hdid;
            $ci->subhead_id = $request->subhdid;
            $ci->impgdno = $request->impgdno;
            $ci->cusinvid = $request->cusinvid;
            $ci->pmntto = $request->pmntto;


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
            $ci->supname = $request->shname;


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
                $lpd->purret = $cont['purretamount'];


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

            if($ci->head_id==32)
            {
                // DB::update(DB::raw("
                // UPDATE commercial_invoices c
                // INNER JOIN (
                // SELECT invoice_id,SUM(payedusd) as payment  FROM payment_details WHERE invoice_id in(select invoice_id from payment_details where paymentid =$ci->id  )  GROUP BY invoice_id
                // ) x ON c.id = x.invoice_id
                // SET c.invoicebal = ( case when contract_id=0 then c.total else tval end ) -  x.payment
                // where  c.id in(select invoice_id from payment_details where paymentid =$ci->id  ) "));

                DB::update(DB::raw("
                UPDATE commercial_invoices c
                INNER JOIN (

                    SELECT suppid,invsid,SUM(invoiceamount) AS invoicebal FROM
                    (
                    SELECT b.id AS suppid,a.id AS invsid,case WHEN b.source_id=2 then a.tval else  total end AS invoiceamount FROM commercial_invoices AS a
                    INNER JOIN suppliers AS b ON a.supplier_id=b.id  AND b.id=$request->subhdid AND a.id in(  SELECT invoice_id FROM payment_details WHERE paymentid=$ci->id )
                    UNION all
                     SELECT a.subhead_id,b.invoice_id,b.payedusd*-1 AS payment
                    FROM bank_transactions AS a INNER join payment_details AS b ON a.id=b.paymentid and a.subhead_id =$request->subhdid
                    AND b.invoice_id in(  SELECT invoice_id FROM payment_details WHERE paymentid=$ci->id )
                   UNION ALL
                    SELECT supplier_id,commercial_invoice_id,prtamount*-1 AS retqty FROM purchase_returns WHERE supplier_id =$request->subhdid
                    AND commercial_invoice_id in(  SELECT commercial_invoice_id FROM purchase_returns WHERE id=$ci->id )
                   UNION ALL
                    SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS Receivedqty
                    FROM bank_transactions AS a INNER join commercial_invoices AS b ON a.supinvid=b.invoiceno AND a.subhead_id =$request->subhdid
                    AND b.id  in(  SELECT invoice_id FROM payment_details WHERE paymentid=$ci->id )
                   ) AS w GROUP BY suppid,invsid
                ) x ON c.id = x.invsid
                SET c.invoicebal = x.invoicebal
                where  c.id in(select invoice_id from payment_details where paymentid =$ci->id  ) "));

            }

            if($ci->head_id==33 &&  $request->cusinvid <> ' ' )
            {
                DB::update(DB::raw("


                UPDATE sale_invoices c
                INNER JOIN (

                    SELECT customer_id,invoiceid,SUM(invsbal) AS invoicebal FROM
                    (

                        SELECT customer_id ,id AS invoiceid,totrcvbamount AS invsbal FROM sale_invoices
                        WHERE customer_id=$ci->subhead_id  AND dcno='$ci->cusinvid'
                        UNION ALL
                         SELECT subhead_id, invoice_id,b.totrcvd*-1 AS invsbal
                         FROM bank_transactions AS a INNER join receive_details AS b ON a.id=b.receivedid and a.subhead_id =$ci->subhead_id
                         AND invoice_id in(  SELECT invoice_id FROM receive_details WHERE dcno='$ci->cusinvid' )
                         UNION all
                         SELECT a.customer_id,invoice_id,a.totrcvbamount*-1 AS invsbal
                         FROM sale_returns AS a INNER JOIN sale_invoices AS b  ON a.invoice_id=b.id  WHERE a.customer_id =$ci->subhead_id
                         AND invoice_id in(SELECT invoice_id FROM sale_returns WHERE dcno='$ci->cusinvid')
                         UNION all
                         SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS invsbal
                         FROM bank_transactions AS a INNER join sale_invoices AS b ON a.cusinvid=b.dcno AND a.subhead_id =$ci->subhead_id
                         AND b.id  in(SELECT invoice_id FROM receive_details WHERE dcno='$ci->cusinvid')

                   ) AS w GROUP BY customer_id,invoiceid
                ) x ON c.id = x.invoiceid
                SET c.paymentbal = x.invoicebal
                where  c.id in(select invoice_id from receive_details where dcno='$ci->cusinvid') "));

            }



            DB::update(DB::raw("
            UPDATE cheque_transactions c
            INNER JOIN (SELECT id,documentdate,cheque_no,transaction_type,bank_id FROM bank_transactions WHERE bank_id>3 AND id=$ci->id) x
            ON c.cheque_no=x.cheque_no and c.bank_id=x.bank_id
            SET c.clrstatus=1,c.clrdate=x.documentdate,clrid=x.id,c.ref=CONCAT(x.transaction_type,'-',LPAD(x.id,4,'0')) "));


            DB::commit();
            return response()->json(['success'],200);
            return redirect()->back();
            // Session::flash('success','Payment Information Saved');
            // return response()->json(['success'],200);
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

        $result1 = DB::table('vwpaymentmaster')->get();
        $resultArray1 = $result1->toArray();
        $data1=compact('resultArray1');


        $passwrd = DB::table('tblpwrd')->select('pwrdtxt')->max('pwrdtxt');
        $stockdtl = DB::select('call procpurretbal()');

        // $stockdtl = DB::select('call procdetailquotations(?,?)',array( $id,2 ));
        $cd = DB::table('vwvoucherpaymentedit')
        // ->join('materials', 'materials.id', '=', 'customer_order_details.material_id')
        // ->join('skus', 'skus.id', '=', 'customer_order_details.sku_id')
        // ->leftJoin('tmptblinvswsstock','tmptblinvswsstock.material_id', '=', 'customer_order_details.material_id')
        // ->select('customer_order_details.*','materials.title as material_title','materials.dimension','skus.title as sku',
        // DB::raw('( CASE customer_order_details.sku_id  WHEN  1 THEN tmptblinvswsstock.qtykg WHEN 2 THEN tmptblinvswsstock.qtypcs WHEN 3 THEN tmptblinvswsstock.qtyfeet  END) AS balqty')
        // ,DB::raw('( CASE customer_order_details.sku_id  WHEN  1 THEN tmptblinvswsstock.qtykg - customer_order_details.qtykg  WHEN 2 THEN tmptblinvswsstock.qtypcs - customer_order_details.qtykg WHEN 3 THEN tmptblinvswsstock.qtyfeet - customer_order_details.qtykg  END) AS varqty') )
        ->where('paymentid',$id)->get();
         $data=compact('cd');


        return view('payments.edit',compact('passwrd'))
        ->with('suppliers',Supplier::select('id','title')->get())
        ->with('banktransaction',BankTransaction::findOrFail($id))
        ->with('heads',Head::where('status',1)->where('forcr',1)->get())
        ->with($data)->with($data1)
        ->with('banks',Bank::select('id','title')->get());

        // return view('contracts.edit')->with('suppliers',Supplier::select('id','title')->get())->with('contract',$contract)->with('cd',ContractDetails::where('contract_id',$contract->id)->get());
    }


    // showing view for purchase delete
    public function deleterec($id)
    {

        $passwrd = DB::table('tblpwrd')->select('pwrdtxtdel')->max('pwrdtxtdel');

        $stockdtl = DB::select('call procpurretbal()');

        // $stockdtl = DB::select('call procdetailquotations(?,?)',array( $id,2 ));
        $cd = DB::table('vwvoucherpaymentedit')
        ->where('paymentid',$id)->get();
         $data=compact('cd');


        return view('payments.deleterec',compact('passwrd'))
        ->with('id',$id)
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


            //  FOR SUBHEAD CHANGE CODING

            if($request->lastsupplier_id!= $request->subhdid || $request->head_id!= $request->hdid)
            {

                                        if($request->hdid==32)
                                        {

                                            DB::update(DB::raw("  update payment_details SET payedusd=0,payedrup=0 WHERE paymentid=$request->paymentid "));

                                            // dd($request->paymentid);

                                            DB::update(DB::raw("
                                            UPDATE commercial_invoices c
                                            INNER JOIN (

                                                SELECT suppid,invsid,SUM(invoiceamount) AS invoicebal FROM
                                                (
                                                SELECT b.id AS suppid,a.id AS invsid,case WHEN b.source_id=2 then a.tval else  total end AS invoiceamount FROM commercial_invoices AS a
                                                INNER JOIN suppliers AS b ON a.supplier_id=b.id  AND b.id=$request->lastsupplier_id AND a.id in(  SELECT invoice_id FROM payment_details WHERE paymentid=$request->paymentid )
                                                UNION all
                                                SELECT a.subhead_id,b.invoice_id,b.payedusd*-1 AS payment
                                                FROM bank_transactions AS a INNER join payment_details AS b ON a.id=b.paymentid and a.subhead_id =$request->lastsupplier_id
                                                AND b.invoice_id in(  SELECT invoice_id FROM payment_details WHERE paymentid=$request->paymentid )
                                                UNION ALL
                                                SELECT supplier_id,commercial_invoice_id,prtamount*-1 AS retqty FROM purchase_returns WHERE supplier_id =$request->lastsupplier_id
                                                AND commercial_invoice_id in(  SELECT invoice_id FROM payment_details WHERE paymentid=$request->paymentid )
                                                UNION ALL
                                                SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS Receivedqty
                                                FROM bank_transactions AS a INNER join commercial_invoices AS b ON a.supinvid=b.invoiceno AND a.subhead_id =$request->lastsupplier_id
                                                AND b.id  in(  SELECT invoice_id FROM payment_details WHERE paymentid=$request->paymentid )
                                            ) AS w GROUP BY suppid,invsid
                                            ) x ON c.id = x.invsid
                                            SET c.invoicebal = x.invoicebal
                                            where  c.id in(select invoice_id from payment_details where paymentid =$request->paymentid  ) "));
                                        }

                                        // if($request->head_id==33 &&  $request->cusinvid <> ' ' )
                                        if($request->head_id==33 &&  $request->cusinvid <> ' ' )
                                        {
                                            DB::update(DB::raw("  update bank_transactions SET amount_fc=0 WHERE id=$request->paymentid "));
                                            DB::update(DB::raw("

                                            UPDATE sale_invoices c
                                            INNER JOIN (

                                                SELECT customer_id,invoiceid,SUM(invsbal) AS invoicebal FROM
                                                (

                                                    SELECT customer_id ,id AS invoiceid,totrcvbamount AS invsbal FROM sale_invoices
                                                    WHERE customer_id=$request->lastsupplier_id  AND dcno='$request->cusinvid'
                                                    UNION ALL
                                                    SELECT subhead_id, invoice_id,b.totrcvd*-1 AS invsbal
                                                    FROM bank_transactions AS a INNER join receive_details AS b ON a.id=b.receivedid and a.subhead_id =$request->lastsupplier_id
                                                    AND invoice_id in(  SELECT invoice_id FROM receive_details WHERE dcno='$request->cusinvid' )
                                                    UNION all
                                                    SELECT a.customer_id,invoice_id,a.totrcvbamount*-1 AS invsbal
                                                    FROM sale_returns AS a INNER JOIN sale_invoices AS b  ON a.invoice_id=b.id  WHERE a.customer_id =$request->lastsupplier_id
                                                    AND invoice_id in(SELECT invoice_id FROM sale_returns WHERE dcno='$request->cusinvid')
                                                    UNION all
                                                    SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS invsbal
                                                    FROM bank_transactions AS a INNER join sale_invoices AS b ON a.cusinvid=b.dcno AND a.subhead_id =$request->lastsupplier_id
                                                    AND b.id  in(SELECT invoice_id FROM receive_details WHERE dcno='$request->cusinvid')

                                            ) AS w GROUP BY customer_id,invoiceid
                                            ) x ON c.id = x.invoiceid
                                            SET c.paymentbal = x.invoicebal
                                            where  c.id in(select invoice_id from receive_details where dcno='$request->cusinvid') "));

                                        }

                                        DB::commit();
                                            // dd($request->paymentid);
                                            // DB::delete(DB::raw(" delete from bank_transactions where id=$request->paymentid   "));
                                            DB::delete(DB::raw(" delete FROM payment_details WHERE paymentid =$request->paymentid   "));

            }
            // #######################





            $ci = BankTransaction::findOrFail($request->paymentid);
            $ci->bank_id = $request->bank_id;
            $ci->head_id = $request->head_id;
            $ci->subhead_id = $request->subhdid;
            $ci->impgdno = $request->impgdno;
            $ci->cusinvid = $request->cusinvid;
            $ci->pmntto = $request->pmntto;


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
            $ci->supname = $request->shname;
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
                     $cds = new PaymentDetail();
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

            if($ci->head_id==32)
            {
                // DB::update(DB::raw("
                // UPDATE commercial_invoices c
                // INNER JOIN (
                // SELECT invoice_id,SUM(payedusd) as payment  FROM payment_details WHERE invoice_id in(select invoice_id from payment_details where paymentid =$ci->id  )  GROUP BY invoice_id
                // ) x ON c.id = x.invoice_id
                // SET c.invoicebal = ( case when contract_id=0 then c.total else tval end ) -  x.payment
                // where  c.id in(select invoice_id from payment_details where paymentid =$ci->id  ) "));

                DB::update(DB::raw("
                UPDATE commercial_invoices c
                INNER JOIN (

                    SELECT suppid,invsid,SUM(invoiceamount) AS invoicebal FROM
                    (
                    SELECT b.id AS suppid,a.id AS invsid,case WHEN b.source_id=2 then a.tval else  total end AS invoiceamount FROM commercial_invoices AS a
                    INNER JOIN suppliers AS b ON a.supplier_id=b.id  AND b.id=$request->subhdid AND a.id in(  SELECT invoice_id FROM payment_details WHERE paymentid=$ci->id )
                    UNION all
                     SELECT a.subhead_id,b.invoice_id,b.payedusd*-1 AS payment
                    FROM bank_transactions AS a INNER join payment_details AS b ON a.id=b.paymentid and a.subhead_id =$request->subhdid
                    AND b.invoice_id in(  SELECT invoice_id FROM payment_details WHERE paymentid=$ci->id )
                   UNION ALL
                    SELECT supplier_id,commercial_invoice_id,prtamount*-1 AS retqty FROM purchase_returns WHERE supplier_id =$request->subhdid
                    AND commercial_invoice_id in(  SELECT invoice_id FROM payment_details WHERE paymentid=$ci->id )
                   UNION ALL
                    SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS Receivedqty
                    FROM bank_transactions AS a INNER join commercial_invoices AS b ON a.supinvid=b.invoiceno AND a.subhead_id =$request->subhdid
                    AND b.id  in(  SELECT invoice_id FROM payment_details WHERE paymentid=$ci->id )
                   ) AS w GROUP BY suppid,invsid
                ) x ON c.id = x.invsid
                SET c.invoicebal = x.invoicebal
                where  c.id in(select invoice_id from payment_details where paymentid =$ci->id  ) "));


            }

            if($ci->head_id==33 &&  $request->cusinvid <> ' ' )
            {
                DB::update(DB::raw("


                UPDATE sale_invoices c
                INNER JOIN (

                    SELECT customer_id,invoiceid,SUM(invsbal) AS invoicebal FROM
                    (

                        SELECT customer_id ,id AS invoiceid,totrcvbamount AS invsbal FROM sale_invoices
                        WHERE customer_id=$ci->subhead_id  AND dcno='$ci->cusinvid'
                        UNION ALL
                         SELECT subhead_id, invoice_id,b.totrcvd*-1 AS invsbal
                         FROM bank_transactions AS a INNER join receive_details AS b ON a.id=b.receivedid and a.subhead_id =$ci->subhead_id
                         AND invoice_id in(  SELECT invoice_id FROM receive_details WHERE dcno='$ci->cusinvid' )
                         UNION all
                         SELECT a.customer_id,invoice_id,a.totrcvbamount*-1 AS invsbal
                         FROM sale_returns AS a INNER JOIN sale_invoices AS b  ON a.invoice_id=b.id  WHERE a.customer_id =$ci->subhead_id
                         AND invoice_id in(SELECT invoice_id FROM sale_returns WHERE dcno='$ci->cusinvid')
                         UNION all
                         SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS invsbal
                         FROM bank_transactions AS a INNER join sale_invoices AS b ON a.cusinvid=b.dcno AND a.subhead_id =$ci->subhead_id
                         AND b.id  in(SELECT invoice_id FROM receive_details WHERE dcno='$ci->cusinvid')

                   ) AS w GROUP BY customer_id,invoiceid
                ) x ON c.id = x.invoiceid
                SET c.paymentbal = x.invoicebal
                where  c.id in(select invoice_id from receive_details where dcno='$ci->cusinvid') "));

            }


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


    public function getMPDFSettings($orientation = 'A4')
    {

        $format;
        $orientation == 'L' ? $format = 'A4': 'A4';

        $mpdf = new PDF( [
            'mode' => 'utf-8',
            'format' => $orientation,
            'margin_header' => '2',
            'margin_top' => '5',
            'margin_bottom' => '5',
            'margin_footer' => '2',
            'default_font_size' => 9,
            'margin_left' => '10',
            'margin_right' => '10',
        ]);
        $mpdf->showImageErrors = true;
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->debug = true;
        return $mpdf;
    }





    public function printContract($id)
    {

        // $hdng1 = $request->cname;
        // $hdng2 = $request->csdrs;

        // $head_id = $request->head_id;
        // $head = Head::findOrFail($head_id);
        // if($request->has('subhead_id')){
        //     $subhead_id = $request->subhead_id;
            //  Clear Data from Table
            DB::table('tmpvoucherrpt')->truncate();
            // foreach($request->subhead_id as $id)
            // {
                DB::table('tmpvoucherrpt')->insert([ 'supid' => $id ]);
        //     }
        // }
        //  Call Procedure
        // $data = DB::select('call ProcGLHW(?,?,?)',array($fromdate,$todate,$head_id));
        // if($head_id == 5)
        //     {
        //         $data = DB::select('call procvoucherrptjv()');
        //     }
        // else
        //     {
                $data = DB::select('call procvoucherrpt()');
            // }


        if(!$data)
        {
            Session::flash('info','No data available');
            return redirect()->back();
        }
        $mpdf = $this->getMPDFSettings();
        $collection = collect($data);                   //  Make array a collection


        // $grouped1 = $collection->groupBy('transno');       //  Sort collection by SupName
        // $grouped1->values()->all();

        // foreach($grouped1 as $g)
        // {
            $grouped = $collection->groupBy('jvno');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g)
            {

            // if($head_id == 5)
            // {
            //     $html =  view('reports.vouchergv')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
            // }
            // else
            // {
                $html =  view('payments.print')->with('data',$g)->render();
                // ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
            // }
                $filename = $g[0]->transno  .'.pdf';
                $chunks = explode("chunk", $html);
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }
                // $mpdf->AddPage();
            // }
        // $mpdf->AddPage();
        }
        //  $mpdf->Output($filename,'I');
        return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');






    }




    public function deleteBankRequest(Request $request)
    {
        // dd($request->all());
        // $delid = $request->delid;
        // dd($delid);
        //  dd($commercialinvoice->commercial_invoice_id());
           //   dd('0jd fakdsjf kdjf');
        if($request->paymentid == 0)
        {
            Session::flash('info','Record not Deleted');
            return response()->json(['success'],200);
        }


            DB::beginTransaction();
            try {



                // dd($request->paymentid);





            if($request->head_id==32)
            {

                DB::update(DB::raw("  update payment_details SET payedusd=0,payedrup=0 WHERE paymentid=$request->paymentid "));



                DB::update(DB::raw("
                UPDATE commercial_invoices c
                INNER JOIN (

                    SELECT suppid,invsid,SUM(invoiceamount) AS invoicebal FROM
                    (
                    SELECT b.id AS suppid,a.id AS invsid,case WHEN b.source_id=2 then a.tval else  total end AS invoiceamount FROM commercial_invoices AS a
                    INNER JOIN suppliers AS b ON a.supplier_id=b.id  AND b.id=$request->supplier_id AND a.id in(  SELECT invoice_id FROM payment_details WHERE paymentid=$request->paymentid )
                    UNION all
                     SELECT a.subhead_id,b.invoice_id,b.payedusd*-1 AS payment
                    FROM bank_transactions AS a INNER join payment_details AS b ON a.id=b.paymentid and a.subhead_id =$request->supplier_id
                    AND b.invoice_id in(  SELECT invoice_id FROM payment_details WHERE paymentid=$request->paymentid )
                   UNION ALL
                    SELECT supplier_id,commercial_invoice_id,prtamount*-1 AS retqty FROM purchase_returns WHERE supplier_id =$request->supplier_id
                    AND commercial_invoice_id in(  SELECT invoice_id FROM payment_details WHERE paymentid=$request->paymentid )
                   UNION ALL
                    SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS Receivedqty
                    FROM bank_transactions AS a INNER join commercial_invoices AS b ON a.supinvid=b.invoiceno AND a.subhead_id =$request->supplier_id
                    AND b.id  in(  SELECT invoice_id FROM payment_details WHERE paymentid=$request->paymentid )
                   ) AS w GROUP BY suppid,invsid
                ) x ON c.id = x.invsid
                SET c.invoicebal = x.invoicebal
                where  c.id in(select invoice_id from payment_details where paymentid =$request->paymentid  ) "));
            }

            // if($request->head_id==33 &&  $request->cusinvid <> ' ' )
            if($request->head_id==33 &&  $request->cusinvid <> ' ' )
            {
                DB::update(DB::raw("  update bank_transactions SET amount_fc=0 WHERE id=$request->paymentid "));
                DB::update(DB::raw("

                UPDATE sale_invoices c
                INNER JOIN (

                    SELECT customer_id,invoiceid,SUM(invsbal) AS invoicebal FROM
                    (

                        SELECT customer_id ,id AS invoiceid,totrcvbamount AS invsbal FROM sale_invoices
                        WHERE customer_id=$request->supplier_id  AND dcno='$request->cusinvid'
                        UNION ALL
                         SELECT subhead_id, invoice_id,b.totrcvd*-1 AS invsbal
                         FROM bank_transactions AS a INNER join receive_details AS b ON a.id=b.receivedid and a.subhead_id =$request->supplier_id
                         AND invoice_id in(  SELECT invoice_id FROM receive_details WHERE dcno='$request->cusinvid' )
                         UNION all
                         SELECT a.customer_id,invoice_id,a.totrcvbamount*-1 AS invsbal
                         FROM sale_returns AS a INNER JOIN sale_invoices AS b  ON a.invoice_id=b.id  WHERE a.customer_id =$request->supplier_id
                         AND invoice_id in(SELECT invoice_id FROM sale_returns WHERE dcno='$request->cusinvid')
                         UNION all
                         SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS invsbal
                         FROM bank_transactions AS a INNER join sale_invoices AS b ON a.cusinvid=b.dcno AND a.subhead_id =$request->supplier_id
                         AND b.id  in(SELECT invoice_id FROM receive_details WHERE dcno='$request->cusinvid')

                   ) AS w GROUP BY customer_id,invoiceid
                ) x ON c.id = x.invoiceid
                SET c.paymentbal = x.invoicebal
                where  c.id in(select invoice_id from receive_details where dcno='$request->cusinvid') "));

            }


                DB::delete(DB::raw(" delete from bank_transactions where id=$request->paymentid   "));
                DB::delete(DB::raw(" delete FROM payment_details WHERE paymentid =$request->paymentid   "));


                DB::commit();


                Session::flash('success','Record Deleted Successfully');
                return response()->json(['success'],200);

            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }



    }



// FOR UPDATE --------############################3


public function forChngsunhead(Request $request)
{
    // dd($request->all());
    // $delid = $request->delid;
    // dd($delid);
    //  dd($commercialinvoice->commercial_invoice_id());
       //   dd('0jd fakdsjf kdjf');
    if($request->paymentid == 0)
    {
        Session::flash('info','Record not Deleted');
        return response()->json(['success'],200);
    }

        DB::beginTransaction();
        try {
        if($request->head_id==32)
        {

            DB::update(DB::raw("  update payment_details SET payedusd=0,payedrup=0 WHERE paymentid=$request->paymentid "));
            DB::update(DB::raw("
            UPDATE commercial_invoices c
            INNER JOIN (

                SELECT suppid,invsid,SUM(invoiceamount) AS invoicebal FROM
                (
                SELECT b.id AS suppid,a.id AS invsid,case WHEN b.source_id=2 then a.tval else  total end AS invoiceamount FROM commercial_invoices AS a
                INNER JOIN suppliers AS b ON a.supplier_id=b.id  AND b.id=$request->supplier_id AND a.id in(  SELECT invoice_id FROM payment_details WHERE paymentid=$request->paymentid )
                UNION all
                 SELECT a.subhead_id,b.invoice_id,b.payedusd*-1 AS payment
                FROM bank_transactions AS a INNER join payment_details AS b ON a.id=b.paymentid and a.subhead_id =$request->supplier_id
                AND b.invoice_id in(  SELECT invoice_id FROM payment_details WHERE paymentid=$request->paymentid )
               UNION ALL
                SELECT supplier_id,commercial_invoice_id,prtamount*-1 AS retqty FROM purchase_returns WHERE supplier_id =$request->supplier_id
                AND commercial_invoice_id in(  SELECT invoice_id FROM payment_details WHERE paymentid=$request->paymentid )
               UNION ALL
                SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS Receivedqty
                FROM bank_transactions AS a INNER join commercial_invoices AS b ON a.supinvid=b.invoiceno AND a.subhead_id =$request->supplier_id
                AND b.id  in(  SELECT invoice_id FROM payment_details WHERE paymentid=$request->paymentid )
               ) AS w GROUP BY suppid,invsid
            ) x ON c.id = x.invsid
            SET c.invoicebal = x.invoicebal
            where  c.id in(select invoice_id from payment_details where paymentid =$request->paymentid  ) "));
        }

        // if($request->head_id==33 &&  $request->cusinvid <> ' ' )
        if($request->head_id==33 &&  $request->cusinvid <> ' ' )
        {
            DB::update(DB::raw("  update bank_transactions SET amount_fc=0 WHERE id=$request->paymentid "));
            DB::update(DB::raw("

            UPDATE sale_invoices c
            INNER JOIN (

                SELECT customer_id,invoiceid,SUM(invsbal) AS invoicebal FROM
                (

                    SELECT customer_id ,id AS invoiceid,totrcvbamount AS invsbal FROM sale_invoices
                    WHERE customer_id=$request->supplier_id  AND dcno='$request->cusinvid'
                    UNION ALL
                     SELECT subhead_id, invoice_id,b.totrcvd*-1 AS invsbal
                     FROM bank_transactions AS a INNER join receive_details AS b ON a.id=b.receivedid and a.subhead_id =$request->supplier_id
                     AND invoice_id in(  SELECT invoice_id FROM receive_details WHERE dcno='$request->cusinvid' )
                     UNION all
                     SELECT a.customer_id,invoice_id,a.totrcvbamount*-1 AS invsbal
                     FROM sale_returns AS a INNER JOIN sale_invoices AS b  ON a.invoice_id=b.id  WHERE a.customer_id =$request->supplier_id
                     AND invoice_id in(SELECT invoice_id FROM sale_returns WHERE dcno='$request->cusinvid')
                     UNION all
                     SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS invsbal
                     FROM bank_transactions AS a INNER join sale_invoices AS b ON a.cusinvid=b.dcno AND a.subhead_id =$request->supplier_id
                     AND b.id  in(SELECT invoice_id FROM receive_details WHERE dcno='$request->cusinvid')

               ) AS w GROUP BY customer_id,invoiceid
            ) x ON c.id = x.invoiceid
            SET c.paymentbal = x.invoicebal
            where  c.id in(select invoice_id from receive_details where dcno='$request->cusinvid') "));

        }


            DB::delete(DB::raw(" delete from bank_transactions where id=$request->paymentid   "));
            DB::delete(DB::raw(" delete FROM payment_details WHERE paymentid =$request->paymentid   "));


            DB::commit();


            Session::flash('success','Record Deleted Successfully');
            return response()->json(['success'],200);

        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }



}













}
