<?php

namespace App\Http\Controllers;

use DB;
// use App\Models\Contract;
use App\Models\Quotation;
use App\Models\QuotationDetails;

use App\Models\CustomerOrder;
use App\Models\CustomerOrderDetails;

use App\Models\Material;
use App\Models\Customer;
use App\Models\Sku;
use App\Models\Head;
use App\Models\Bank;
use App\Models\BankTransaction;
use App\Models\PaymentDetail;
use App\Models\ReceiveDetails;

use App\Models\Supplier;


use Illuminate\Http\Request;
// use App\Models\ContractDetails;
use App\Models\Location;
use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Session;

// LocalPurchaseController
class ReceiveController  extends Controller
{
    public function index(Request $request)
    {
         return view('received.index');


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


    public function headlist(Request $request)
    {
        //  dd($request->all());
        $head_id = $request->head_id;
        // procpaymentmaster(32)
        return  DB::select('call procreceivedmaster(?)',array($head_id));

    }

    public function mseqno(Request $request)
    {
        //  dd($request->all());
        $head_id = $request->head_id;
        $maxposeqno = DB::table('bank_transactions')->select('*')->max('transno')+1;
        return  $maxposeqno;

    }

    public function chqvalid(Request $request)
    {
        //  dd($request->all());
        $chequeno = $request->cheque_no;
        $chqamnt = DB::table('cheque_transactions')->select('*')->where('cheque_no',$chequeno)->first();
        dd($chqamnt);
        return  $chqamnt;



    }





    public function getMaster(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $cis1 = DB::select('call procreceivedindex');
        $cis = DB::table('vwreceivedindex')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        // ->with('customer:id,title')
        ->where('subhead', 'like', "%$search%")
        ->orWhere('trantype', 'like', "%$search%")
        ->orWhere('ref', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $cis;

    }

    public function getDetails(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $contractDetails = ReceiveDetails::where('sale_invoice_id',$request->id)
        ->paginate((int) $size);
        return $contractDetails;
    }

    public function getMasterqut(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $contracts = DB::table('vwreceivedmaster')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        // ->where('custname', 'like', "%$search%")
        // ->orWhere('cheque_no', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;

    }


    public function getDetailsqut(Request $request)
    {
        $id = $request->id;
        // $abc = DB::select('call proctest0(1)');
        //  $contractDetails = DB::table('vwdetailquotations')->where('sale_invoice_id',$id)->get();
        $contractDetails = DB::select('call procreceiveddtl(?)',array( $id ));
        return response()->json($contractDetails, 200);
    }


    public function create()
    {


        // $result1 = DB::table('vwreceivedmaster')->get();
        // $resultArray1 = $result1->toArray();
        $resultArray1 = DB::select('call procreceivedmaster1st');
        $data1=compact('resultArray1');



        $result = DB::table('banks')->whereNotIn('id',[2])->get();
        $resultArray = $result->toArray();
        $data=compact('resultArray');

        $maxposeqno = DB::table('bank_transactions')->select('*')->max('transno')+1;
        return \view ('received.create',compact('maxposeqno'))->with($data)->with($data1)
        ->with('heads',Head::where('status',1)->where('forcp',1)->get())
        ->with('banks',Bank::where('status',1)->get());
    }

    /** Function Complete*/
    public function store(Request $request)
    {
            //    dd($request->supinvid);
        $this->validate($request,[
            // 'saldate' => 'required|min:3|date',
        //    'title'=>'required|min:3|unique:materials'
             'transno' => 'required|min:1|unique:bank_transactions',
            //  'cheque_no' => 'required|unique:bank_transactions',
            // 'pono' => 'required|min:1|unique:customer_orders'
            // 'gpno' => 'required|min:1|unique:sale_invoices',
            // 'customer_id' => 'required'
        ]);





        // if($request->bank_id > 1 && $request->cheque_no != ' ' )
        // {
        //  // $dupchqno = BankTransaction::where('cheque_no',$request->cheque_no)->first();
        //  $dupchqno = DB::table('vwdupchqno')->where('cheque_no',$request->cheque_no)->first();
        //  if($dupchqno) {
        //      Session::flash('info','Record not Save Successfully Due to "Duplicate Cheque_no" ');
        //      return response()->json(['success'],200);
        //                }
        //  }

        // if($request->bank_id > 1 && $request->cheque_no != ' ' )
        // {

        //     $chqno = DB::table('cheque_transactions')->where('cheque_no',$request->cheque_no)->first();
        //     // dd($chqno);
        //     if($chqno)
        //     {
        //         $chqamount = DB::table('cheque_transactions')->where('cheque_no',$request->cheque_no)->where('received',$request->amount_fc)->first();
        //         if(!$chqamount)
        //         {
        //                  Session::flash('info','Record not Save Successfully Due to "Invalid Cheque Amount" ');
        //                  return response()->json(['success'],200);
        //         }


        //     }



        // }




        DB::beginTransaction();
        try {
            $ci = new BankTransaction();

            // dd($request->per());
            $ci->bank_id = $request->bank_id;
            $ci->head_id = $request->hdid;
            $ci->subhead_id = $request->subhdid;
            $ci->pmntto = $request->pmntto;


            if($request->bank_id == 1)
            {
                $ci->transaction_type = 'CRV';
            }
            if($request->bank_id > 3)
            {
                $ci->transaction_type = 'BRV';
            }
            $ci->documentdate = $request->documentdate;
            $ci->conversion_rate = $request->conversion_rate;
            if($request->amount_fc<=0)
            {

                $ci->amount_fc = 0;
                $ci->amount_pkr = 0;

            }
            else
            {
                $ci->amount_fc = $request->amount_fc;
                $ci->amount_pkr = $request->amount_pkr;

            }
            $ci->cheque_date = $request->cheque_date;
            $ci->cheque_no = $request->cheque_no;
            $ci->description = $request->description;
            $ci->transno = $request->transno;
            $ci->advance = $request->advtxt;
            $ci->supname = $request->shname;
            $ci->supinvid = $request->supinvid;
            $ci->save();

            // Quotation Close
            // $qutclose = Quotation::findOrFail($request->quotation_id);
            // $qutclose->closed = 0;
            // $qutclose->save();


            foreach ($request->banktransactionr as $cont) {
                // $material = Material::findOrFail($cont['id']);
                $lpd = new ReceiveDetails();
                if($cont['totrcvd'] <> 0)
             {

                $lpd->receivedid = $ci->id;
                $lpd->invoice_id = $cont['invoice_id'];
                $lpd->dcno = $cont['dcno'];
                $lpd->billno = $cont['billno'];
                $lpd->saldate = $cont['saldate'];
                $lpd->staxper = $cont['staxper'];
                $lpd->staxamount = $cont['staxamount'];
                $lpd->totrcvble = $cont['totrcvble'];
                $lpd->totrcvd = $cont['totrcvd'];
                $lpd->salret = $cont['saleretamount'];
                $lpd->invoice_bal = $cont['invoice_bal'];
                $lpd->pono = $cont['pono'];
                $lpd->save();
             }
            }

            // DB::update(DB::raw("
            // UPDATE bank_transactions c
            // INNER JOIN (
            // SELECT receivedid,SUM(totrcvd) AS totrcvd
            // FROM receive_details WHERE receivedid=$ci->id GROUP BY receivedid
            // ) x ON c.id = x.receivedid
            // SET c.amount_fc = x.totrcvd,c.amount_pkr=x.totrcvd,c.conversion_rate=0
            // where  c.id = $ci->id "));

            // dd($ci->cheque_no);

            DB::update(DB::raw("
            UPDATE cheque_transactions c
            INNER JOIN (SELECT id,documentdate,cheque_no,transaction_type,bank_id FROM bank_transactions WHERE  id=$ci->id) x
            ON c.cheque_no=x.cheque_no
            SET c.bank_id=x.bank_id, c.clrstatus=1,c.clrdate=x.documentdate,clrid=x.id,c.ref=CONCAT(x.transaction_type,'-',LPAD(x.id,4,'0')) "));

            DB::update(DB::raw("
            UPDATE cheque_transactions c
            INNER JOIN (
            SELECT cheque_no,SUM(totrcvd) AS invsamount,max(b.amount_fc) as chqamount    FROM receive_details AS a INNER JOIN bank_transactions AS b
				ON a.receivedid=b.id WHERE b.cheque_no= (select cheque_no from bank_transactions where id=$ci->id)  GROUP BY cheque_no
            ) x ON c.cheque_no = x.cheque_no
            SET c.invsclrd = x.invsamount,c.crdtcust=x.chqamount
            WHERE  c.cheque_no =  (select cheque_no from bank_transactions where id=$ci->id)  "));

            if($ci->head_id==33)
            {

                DB::update(DB::raw("
                UPDATE sale_invoices c
                INNER JOIN (

                    SELECT customer_id,invoiceid,SUM(invsbal) AS invoicebal FROM
                    (

                        SELECT customer_id ,id AS invoiceid,totrcvbamount AS invsbal FROM sale_invoices
                        WHERE customer_id=$ci->subhead_id  AND id in(  SELECT invoice_id FROM receive_details WHERE receivedid=$ci->id )
                        UNION ALL
                         SELECT subhead_id, invoice_id,b.totrcvd*-1 AS invsbal
                         FROM bank_transactions AS a INNER join receive_details AS b ON a.id=b.receivedid and a.subhead_id =$ci->subhead_id
                         AND invoice_id in(  SELECT invoice_id FROM receive_details WHERE receivedid=$ci->id )
                         UNION all
                         SELECT a.customer_id,invoice_id,a.totrcvbamount*-1 AS invsbal
                         FROM sale_returns AS a INNER JOIN sale_invoices AS b  ON a.invoice_id=b.id  WHERE a.customer_id =$ci->subhead_id
                         AND invoice_id in(SELECT invoice_id FROM sale_returns WHERE id=$ci->id)
                         UNION all
                         SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS invsbal
                         FROM bank_transactions AS a INNER join sale_invoices AS b ON a.cusinvid=b.dcno AND a.subhead_id =$ci->subhead_id
                         AND b.id  in(SELECT invoice_id FROM receive_details WHERE receivedid=$ci->id)

                   ) AS w GROUP BY customer_id,invoiceid
                ) x ON c.id = x.invoiceid
                SET c.paymentbal = x.invoicebal
                where  c.id in(select invoice_id from receive_details where receivedid=$ci->id  ) "));

            }

            if($ci->head_id==32)
            {
                // DB::update(DB::raw("
                // UPDATE commercial_invoices c
                // INNER JOIN (
				// SELECT invoice_no,SUM(payment) AS payment FROM
				// (
				// SELECT invoice_no,SUM(payedusd) as payment  FROM payment_details WHERE invoice_no ='$ci->supinvid'   GROUP BY invoice_no
                // UNION all
                // SELECT supinvid,amount_fc*-1 FROM bank_transactions WHERE supinvid='$ci->supinvid' AND  head_id=32
                // ) y GROUP BY invoice_no
                // ) x ON c.invoiceno = x.invoice_no
                // SET c.invoicebal = ( case when contract_id=0 then c.total else tval end ) -  x.payment
                // where  c.invoiceno ='$ci->supinvid'
                // "));

                DB::update(DB::raw("
                UPDATE commercial_invoices c
                INNER JOIN (

                    SELECT suppid,invsid,SUM(invoiceamount) AS invoicebal FROM
                    (
                    SELECT b.id AS suppid,a.id AS invsid,case WHEN b.source_id=2 then a.tval else  total end AS invoiceamount FROM commercial_invoices AS a
                    INNER JOIN suppliers AS b ON a.supplier_id=b.id  AND b.id=$ci->subhead_id AND a.invoiceno='$ci->supinvid'
                    UNION all
                     SELECT a.subhead_id,b.invoice_id,b.payedusd*-1 AS payment
                    FROM bank_transactions AS a INNER join payment_details AS b ON a.id=b.paymentid and a.subhead_id =$ci->subhead_id
                    AND b.invoice_id in(  SELECT invoice_id FROM payment_details WHERE invoice_no='$ci->supinvid' )
                   UNION ALL
                    SELECT supplier_id,commercial_invoice_id,prtamount*-1 AS retqty FROM purchase_returns WHERE supplier_id =$ci->subhead_id
                    AND commercial_invoice_id in(  SELECT id FROM commercial_invoices WHERE invoiceno='$ci->supinvid' )
                   UNION ALL
                    SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS Receivedqty
                    FROM bank_transactions AS a INNER join commercial_invoices AS b ON a.supinvid=b.invoiceno AND a.subhead_id =$ci->subhead_id
                    AND b.invoiceno='$ci->supinvid'
                   ) AS w GROUP BY suppid,invsid
                ) x ON c.id = x.invsid
                SET c.invoicebal = x.invoicebal
                where  c.invoiceno='$ci->supinvid' "));


            }

            DB::commit();
            Session::flash('success','Payment Information Saved');
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

    }
    // SELECT a.*,COALESCE(b.totrcvbamount,0) AS saleretamount FROM receive_details AS a LEFT OUTER JOIN sale_returns AS b ON a.invoice_id=b.invoice_id
    // public function edit(Contract $contract)
    public function edit($id)
    {


        $resultArray1 = DB::select('call procreceivedmaster1st');
        $data1=compact('resultArray1');


        $passwrd = DB::table('tblpwrd')->select('pwrdtxt')->max('pwrdtxt');
        $stockdtl = DB::select('call prcsaleretbal()');
        $cd = DB::table('vsvoucherrcvedit')
        // receive_details
        // ->join('materials', 'materials.id', '=', 'customer_order_details.material_id')
        // ->join('skus', 'skus.id', '=', 'customer_order_details.sku_id')
        // ->leftJoin('sale_returns','sale_returns.invoice_id', '=', 'receive_details.invoice_id')
        ->select('vsvoucherrcvedit.*')
        // DB::raw('( CASE customer_order_details.sku_id  WHEN  1 THEN tmptblinvswsstock.qtykg WHEN 2 THEN tmptblinvswsstock.qtypcs WHEN 3 THEN tmptblinvswsstock.qtyfeet  END) AS balqty')
        // ,DB::raw('( CASE customer_order_details.sku_id  WHEN  1 THEN tmptblinvswsstock.qtykg - customer_order_details.qtykg  WHEN 2 THEN tmptblinvswsstock.qtypcs - customer_order_details.qtykg WHEN 3 THEN tmptblinvswsstock.qtyfeet - customer_order_details.qtykg  END) AS varqty') )
        ->where('receivedid',$id)->get();
         $data=compact('cd');


        return view('received.edit',compact('passwrd'))
        ->with('customers',Customer::select('id','title')->get())
        ->with('banktransaction',BankTransaction::findOrFail($id))
        ->with('heads',Head::where('status',1)->where('forcr',1)->get())
        ->with($data)->with($data1)
        ->with('banks',Bank::select('id','title')->get());

        // return view('contracts.edit')->with('suppliers',Supplier::select('id','title')->get())->with('contract',$contract)->with('cd',ContractDetails::where('contract_id',$contract->id)->get());
    }



    public function deleterec($id)
    {

        $passwrd = DB::table('tblpwrd')->select('pwrdtxtdel')->max('pwrdtxtdel');
        $stockdtl = DB::select('call prcsaleretbal()');
        $cd = DB::table('vsvoucherrcvedit')
        ->select('vsvoucherrcvedit.*')
        ->where('receivedid',$id)->get();
         $data=compact('cd');


        return view('received.deleterec',compact('passwrd'))
        ->with('customers',Customer::select('id','title')->get())
        ->with('banktransaction',BankTransaction::findOrFail($id))
        ->with($data)
        ->with('banks',Bank::select('id','title')->get());

        // return view('contracts.edit')->with('suppliers',Supplier::select('id','title')->get())->with('contract',$contract)->with('cd',ContractDetails::where('contract_id',$contract->id)->get());
    }




    public function update(Request $request, BankTransaction $banktransactionr)
    {
        //  dd($commercialinvoice->commercial_invoice_id());
            //   dd($request->all());
        DB::beginTransaction();
        try {

            //  FOR SUBHEAD CHANGE CODING

            if($request->lastsubhdid!= $request->subhead_id || $request->head_id!= $request->hdid)
            {

                // dd('dfadfafdf');
                if($request->hdid==33)
                {

                    DB::update(DB::raw("  update receive_details SET totrcvd=0 WHERE receivedid=$request->receivedid "));
                    DB::update(DB::raw("
                    UPDATE sale_invoices c
                    INNER JOIN (

                        SELECT customer_id,invoiceid,SUM(invsbal) AS invoicebal FROM
                        (

                            SELECT customer_id ,id AS invoiceid,totrcvbamount AS invsbal FROM sale_invoices
                            WHERE customer_id=$request->lastsubhdid  AND id in(  SELECT invoice_id FROM receive_details WHERE receivedid=$request->receivedid )
                            UNION ALL
                             SELECT subhead_id, invoice_id,b.totrcvd*-1 AS invsbal
                             FROM bank_transactions AS a INNER join receive_details AS b ON a.id=b.receivedid and a.subhead_id =$request->lastsubhdid
                             AND invoice_id in(  SELECT invoice_id FROM receive_details WHERE receivedid=$request->receivedid )
                             UNION all
                             SELECT a.customer_id,invoice_id,a.totrcvbamount*-1 AS invsbal
                             FROM sale_returns AS a INNER JOIN sale_invoices AS b  ON a.invoice_id=b.id  WHERE a.customer_id =$request->lastsubhdid
                             AND invoice_id in(SELECT invoice_id FROM receive_details WHERE receivedid=$request->receivedid)
                             UNION all
                             SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS invsbal
                             FROM bank_transactions AS a INNER join sale_invoices AS b ON a.cusinvid=b.dcno AND a.subhead_id =$request->lastsubhdid
                             AND b.id  in(SELECT invoice_id FROM receive_details WHERE receivedid=$request->receivedid)

                       ) AS w GROUP BY customer_id,invoiceid
                    ) x ON c.id = x.invoiceid
                    SET c.paymentbal = x.invoicebal
                    where  c.id in(select invoice_id from receive_details where receivedid=$request->receivedid  ) "));
                }

                if($request->hdid==32  )
                {

                    DB::update(DB::raw("  update bank_transactions SET amount_fc=0 WHERE id=$request->receivedid "));

                    DB::update(DB::raw("
                    UPDATE commercial_invoices c
                    INNER JOIN (

                        SELECT suppid,invsid,SUM(invoiceamount) AS invoicebal FROM
                        (
                        SELECT b.id AS suppid,a.id AS invsid,case WHEN b.source_id=2 then a.tval else  total end AS invoiceamount FROM commercial_invoices AS a
                        INNER JOIN suppliers AS b ON a.supplier_id=b.id  AND b.id=$request->lastsubhdid AND a.invoiceno='$request->supinvid'
                        UNION all
                         SELECT a.subhead_id,b.invoice_id,b.payedusd*-1 AS payment
                        FROM bank_transactions AS a INNER join payment_details AS b ON a.id=b.paymentid and a.subhead_id =$request->lastsubhdid
                        AND b.invoice_id in(  SELECT invoice_id FROM payment_details WHERE invoice_no='$request->supinvid' )
                       UNION ALL
                        SELECT supplier_id,commercial_invoice_id,prtamount*-1 AS retqty FROM purchase_returns WHERE supplier_id =$request->lastsubhdid
                        AND commercial_invoice_id in(  SELECT id FROM commercial_invoices WHERE invoiceno='$request->supinvid' )
                       UNION ALL
                        SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS Receivedqty
                        FROM bank_transactions AS a INNER join commercial_invoices AS b ON a.supinvid=b.invoiceno AND a.subhead_id =$request->lastsubhdid
                        AND b.invoiceno='$request->supinvid'
                       ) AS w GROUP BY suppid,invsid
                    ) x ON c.id = x.invsid
                    SET c.invoicebal = x.invoicebal
                    where  c.invoiceno='$request->supinvid' "));

                }


                    // DB::delete(DB::raw(" delete from bank_transactions where id=$request->receivedid   "));
                    DB::delete(DB::raw(" delete FROM receive_details WHERE receivedid =$request->receivedid   "));

            }
            // #######################









            // dd($request->supinvid);
            $ci = BankTransaction::findOrFail($request->receivedid);

            $ci->bank_id = $request->bank_id;
            $ci->head_id = $request->head_id;
            $ci->subhead_id = $request->subhead_id;
            $ci->pmntto = $request->pmntto;
            if($request->bank_id == 1)
            {
                $ci->transaction_type = 'CRV';
            }
            if($request->bank_id > 2)
            {
                $ci->transaction_type = 'BRV';
            }
            $ci->documentdate = $request->documentdate;
            $ci->conversion_rate = $request->conversion_rate;

            if($request->amount_fc<=0)
            {

                $ci->amount_fc = 0;
                $ci->amount_pkr = 0;

            }
            else
            {
                $ci->amount_fc = $request->amount_fc;
                $ci->amount_pkr = $request->amount_pkr;

            }


            $ci->cheque_date = $request->cheque_date;
            $ci->cheque_no = $request->cheque_no;
            $ci->description = $request->description;
            $ci->transno = $request->transno;
            $ci->advance = $request->advtxt;
            $ci->supname = $request->shname;
            $ci->supinvid = $request->supinvid;

            $ci->save();



            // Get Data
            $cds = $request->banktransactionr; // This is array
            $cds = ReceiveDetails::hydrate($cds); // Convert it into Model Collection
            // Now get old ContractDetails and then get the difference and delete difference
            $oldcd = ReceiveDetails::where('receivedid',$banktransactionr->id)->get();
            $deleted = $oldcd->diff($cds);
            //  Delete contract details if marked for deletion
            foreach ($deleted as $d) {
                $d->delete();
            }
            // Now update existing and add new
            foreach ($cds as $cd) {
                if($cd->id)
                {

            $cds = ReceiveDetails::where('id',$cd->id)->first();
            // if($cd['totrcvd'] <> 0)
            // {



                    $cds->receivedid = $ci->id;
                    $cds->invoice_id = $cd['invoice_id'];
                    $cds->dcno = $cd['dcno'];
                    $cds->billno = $cd['billno'];
                    $cds->saldate = $cd['saldate'];
                    $cds->staxper = $cd['staxper'];
                    $cds->staxamount = $cd['staxamount'];
                    $cds->totrcvble = $cd['totrcvble'];
                    $cds->totrcvd = $cd['totrcvd'];
                    $cds->salret = $cd['saleretamount'];
                    $cds->invoice_bal = $cd['invoice_bal'];
                    $cds->pono = $cd['pono'];
                    $cds->save();
            // }
                }else
                {
                    //  The item is new, Add it
                     $cds = new ReceiveDetails();
                // if($cd['totrcvd'] <> 0)
                // {

                     $cds->receivedid = $ci->id;
                     $cds->invoice_id = $cd['invoice_id'];
                     $cds->dcno = $cd['dcno'];
                     $cds->billno = $cd['billno'];
                     $cds->saldate = $cd['saldate'];
                     $cds->staxper = $cd['staxper'];
                     $cds->staxamount = $cd['staxamount'];
                     $cds->totrcvble = $cd['totrcvble'];
                     $cds->totrcvd = $cd['totrcvd'];
                     $cds->invoice_bal = $cd['invoice_bal'];
                     $cds->salret = $cd['saleretamount'];
                     $cds->pono = $cd['pono'];

                     $cds->save();
                // }
                    }
            }



            // DB::update(DB::raw("
            // UPDATE bank_transactions c
            // INNER JOIN (
            // SELECT receivedid,SUM(totrcvd) AS totrcvd
            // FROM receive_details WHERE receivedid=$ci->id GROUP BY receivedid
            // ) x ON c.id = x.receivedid
            // SET c.amount_fc = x.totrcvd,c.amount_pkr=x.totrcvd,c.conversion_rate=0
            // where  c.id = $ci->id "));

            DB::update(DB::raw("
            UPDATE cheque_transactions c
            INNER JOIN (SELECT id,documentdate,cheque_no,transaction_type,bank_id FROM bank_transactions WHERE  id=$ci->id) x
            ON c.cheque_no=x.cheque_no
            SET c.bank_id=x.bank_id, c.clrstatus=1,c.clrdate=x.documentdate,clrid=x.id,c.ref=CONCAT(x.transaction_type,'-',LPAD(x.id,4,'0')) "));


            if($ci->head_id==33)
            {

                    DB::update(DB::raw("
                    UPDATE sale_invoices c
                    INNER JOIN (

                        SELECT customer_id,invoiceid,SUM(invsbal) AS invoicebal FROM
                        (

                            SELECT customer_id ,id AS invoiceid,totrcvbamount AS invsbal FROM sale_invoices
                            WHERE customer_id=$request->subhead_id  AND id in(  SELECT invoice_id FROM receive_details WHERE receivedid=$ci->id )
                            UNION ALL
                             SELECT subhead_id, invoice_id,b.totrcvd*-1 AS invsbal
                             FROM bank_transactions AS a INNER join receive_details AS b ON a.id=b.receivedid and a.subhead_id =$request->subhead_id
                             AND invoice_id in(  SELECT invoice_id FROM receive_details WHERE receivedid=$ci->id )
                             UNION all
                             SELECT a.customer_id,invoice_id,a.totrcvbamount*-1 AS invsbal
                             FROM sale_returns AS a INNER JOIN sale_invoices AS b  ON a.invoice_id=b.id  WHERE a.customer_id =$request->subhead_id
                             AND invoice_id in(SELECT invoice_id FROM sale_returns WHERE id=$ci->id)
                             UNION all
                             SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS invsbal
                             FROM bank_transactions AS a INNER join sale_invoices AS b ON a.cusinvid=b.dcno AND a.subhead_id =$request->subhead_id
                             AND b.id  in(SELECT invoice_id FROM receive_details WHERE receivedid=$ci->id)

                       ) AS w GROUP BY customer_id,invoiceid
                    ) x ON c.id = x.invoiceid
                    SET c.paymentbal = x.invoicebal
                    where  c.id in(select invoice_id from receive_details where receivedid=$request->receivedid  ) "));

            }

            if($ci->head_id==32)
            {
                // dd($request->supinvid);
                // DB::update(DB::raw("

                // UPDATE commercial_invoices c
                // INNER JOIN (
				// SELECT invoice_no,SUM(payment) AS payment FROM
				// (
				// SELECT invoice_no,SUM(payedusd) as payment  FROM payment_details WHERE invoice_no ='$ci->supinvid'   GROUP BY invoice_no
                // UNION all
                // SELECT supinvid,amount_fc*-1 FROM bank_transactions WHERE supinvid='$ci->supinvid' AND  head_id=32
                // ) y GROUP BY invoice_no
                // ) x ON c.invoiceno = x.invoice_no
                // SET c.invoicebal = ( case when contract_id=0 then c.total else tval end ) -  x.payment
                // where  c.invoiceno ='$ci->supinvid'
                // "));


                DB::update(DB::raw("
                UPDATE commercial_invoices c
                INNER JOIN (

                    SELECT suppid,invsid,SUM(invoiceamount) AS invoicebal FROM
                    (
                    SELECT b.id AS suppid,a.id AS invsid,case WHEN b.source_id=2 then a.tval else  total end AS invoiceamount FROM commercial_invoices AS a
                    INNER JOIN suppliers AS b ON a.supplier_id=b.id  AND b.id=$request->subhead_id AND a.invoiceno='$ci->supinvid'
                    UNION all
                     SELECT a.subhead_id,b.invoice_id,b.payedusd*-1 AS payment
                    FROM bank_transactions AS a INNER join payment_details AS b ON a.id=b.paymentid and a.subhead_id =$request->subhead_id
                    AND b.invoice_id in(  SELECT invoice_id FROM payment_details WHERE invoice_no='$ci->supinvid' )
                   UNION ALL
                    SELECT supplier_id,commercial_invoice_id,prtamount*-1 AS retqty FROM purchase_returns WHERE supplier_id =$request->subhead_id
                    AND commercial_invoice_id in(  SELECT id FROM commercial_invoices WHERE invoiceno='$ci->supinvid' )
                   UNION ALL
                    SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS Receivedqty
                    FROM bank_transactions AS a INNER join commercial_invoices AS b ON a.supinvid=b.invoiceno AND a.subhead_id =$request->subhead_id
                    AND b.invoiceno='$ci->supinvid'
                   ) AS w GROUP BY suppid,invsid
                ) x ON c.id = x.invsid
                SET c.invoicebal = x.invoicebal
                where  c.invoiceno='$ci->supinvid' "));







            }

            DB::update(DB::raw("
            UPDATE cheque_transactions c
            INNER JOIN (SELECT id,documentdate,cheque_no,transaction_type,bank_id FROM bank_transactions WHERE  id=$ci->id) x
            ON c.cheque_no=x.cheque_no and c.bank_id=x.bank_id
            SET c.clrstatus=1,c.clrdate=x.documentdate,clrid=x.id,c.ref=CONCAT(x.transaction_type,'-',LPAD(x.id,4,'0')) "));


            DB::update(DB::raw("
            UPDATE cheque_transactions c
            INNER JOIN (
            SELECT cheque_no,SUM(totrcvd) AS invsamount,max(b.amount_fc) as chqamount    FROM receive_details AS a INNER JOIN bank_transactions AS b
				ON a.receivedid=b.id WHERE b.cheque_no= (select cheque_no from bank_transactions where id=$ci->id )  GROUP BY cheque_no
            ) x ON c.cheque_no = x.cheque_no
            SET c.invsclrd = x.invsamount,c.crdtcust=x.chqamount
            WHERE  c.cheque_no =  (select cheque_no from bank_transactions where id=$ci->id) "));




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
        if($request->receivedid == 0)
        {
            Session::flash('info','Record not Deleted');
            return response()->json(['success'],200);
        }

            DB::beginTransaction();
            try {

            if($request->head_id==33)
            {

                DB::update(DB::raw("  update receive_details SET totrcvd=0 WHERE receivedid=$request->receivedid "));
                DB::update(DB::raw("
                UPDATE sale_invoices c
                INNER JOIN (

                    SELECT customer_id,invoiceid,SUM(invsbal) AS invoicebal FROM
                    (

                        SELECT customer_id ,id AS invoiceid,totrcvbamount AS invsbal FROM sale_invoices
                        WHERE customer_id=$request->subhead_id  AND id in(  SELECT invoice_id FROM receive_details WHERE receivedid=$request->receivedid )
                        UNION ALL
                         SELECT subhead_id, invoice_id,b.totrcvd*-1 AS invsbal
                         FROM bank_transactions AS a INNER join receive_details AS b ON a.id=b.receivedid and a.subhead_id =$request->subhead_id
                         AND invoice_id in(  SELECT invoice_id FROM receive_details WHERE receivedid=$request->receivedid )
                         UNION all
                         SELECT a.customer_id,invoice_id,a.totrcvbamount*-1 AS invsbal
                         FROM sale_returns AS a INNER JOIN sale_invoices AS b  ON a.invoice_id=b.id  WHERE a.customer_id =$request->subhead_id
                         AND invoice_id in(SELECT invoice_id FROM receive_details WHERE receivedid=$request->receivedid)
                         UNION all
                         SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS invsbal
                         FROM bank_transactions AS a INNER join sale_invoices AS b ON a.cusinvid=b.dcno AND a.subhead_id =$request->subhead_id
                         AND b.id  in(SELECT invoice_id FROM receive_details WHERE receivedid=$request->receivedid)

                   ) AS w GROUP BY customer_id,invoiceid
                ) x ON c.id = x.invoiceid
                SET c.paymentbal = x.invoicebal
                where  c.id in(select invoice_id from receive_details where receivedid=$request->receivedid  ) "));
            }

            if($request->head_id==32  )
            {
                // DB::update(DB::raw("
                // UPDATE sale_invoices c
                // INNER JOIN (
                //     SELECT dcno,SUM(received) AS received FROM
                //     (
                //     SELECT dcno,SUM(totrcvd) as received  FROM receive_details WHERE dcno='$request->cusinvid'   GROUP BY dcno
                //     UNION all
                //     SELECT cusinvid,amount_fc FROM bank_transactions WHERE cusinvid='$request->cusinvid' AND  head_id=33
                // ) y GROUP BY dcno
                // ) x ON c.dcno = x.dcno
                // SET c.paymentbal = totrcvbamount +  x.received
                // where  c.dcno ='$request->cusinvid' "));

                DB::update(DB::raw("  update bank_transactions SET amount_fc=0 WHERE id=$request->receivedid "));

                DB::update(DB::raw("
                UPDATE commercial_invoices c
                INNER JOIN (

                    SELECT suppid,invsid,SUM(invoiceamount) AS invoicebal FROM
                    (
                    SELECT b.id AS suppid,a.id AS invsid,case WHEN b.source_id=2 then a.tval else  total end AS invoiceamount FROM commercial_invoices AS a
                    INNER JOIN suppliers AS b ON a.supplier_id=b.id  AND b.id=$request->subhead_id AND a.invoiceno='$request->supinvid'
                    UNION all
                     SELECT a.subhead_id,b.invoice_id,b.payedusd*-1 AS payment
                    FROM bank_transactions AS a INNER join payment_details AS b ON a.id=b.paymentid and a.subhead_id =$request->subhead_id
                    AND b.invoice_id in(  SELECT invoice_id FROM payment_details WHERE invoice_no='$request->supinvid' )
                   UNION ALL
                    SELECT supplier_id,commercial_invoice_id,prtamount*-1 AS retqty FROM purchase_returns WHERE supplier_id =$request->subhead_id
                    AND commercial_invoice_id in(  SELECT id FROM commercial_invoices WHERE invoiceno='$request->supinvid' )
                   UNION ALL
                    SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS Receivedqty
                    FROM bank_transactions AS a INNER join commercial_invoices AS b ON a.supinvid=b.invoiceno AND a.subhead_id =$request->subhead_id
                    AND b.invoiceno='$request->supinvid'
                   ) AS w GROUP BY suppid,invsid
                ) x ON c.id = x.invsid
                SET c.invoicebal = x.invoicebal
                where  c.invoiceno='$request->supinvid' "));

            }


                DB::delete(DB::raw(" delete from bank_transactions where id=$request->receivedid   "));
                DB::delete(DB::raw(" delete FROM receive_details WHERE receivedid =$request->receivedid   "));


                DB::commit();


                Session::flash('success','Record Deleted Successfully');
                return response()->json(['success'],200);

            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }



    }



}
