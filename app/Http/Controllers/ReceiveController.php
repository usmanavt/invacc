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
        ->where('custname', 'like', "%$search%")
        ->orWhere('cheque_no', 'like', "%$search%")
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
        // $locations = Location::select('id','title')->where('status',1)->get();

        // return view('sales.create')
        // $mycname='MUHAMMAD HABIB & Co.';
        $maxposeqno = DB::table('bank_transactions')->select('*')->max('transno')+1;
        return \view ('received.create',compact('maxposeqno'))
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
            $ci->supname = $request->custname;
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
                SELECT invoice_id,SUM(totrcvd) as received  FROM receive_details WHERE invoice_id in(select invoice_id from receive_details where receivedid =$ci->id  )  GROUP BY invoice_id
                ) x ON c.id = x.invoice_id
                SET c.paymentbal = totrcvbamount -  x.received
                where  c.id in(select invoice_id from receive_details where receivedid =$ci->id  ) "));
            }

            if($ci->head_id==32)
            {
                DB::update(DB::raw("

                UPDATE commercial_invoices c
                INNER JOIN (
				SELECT invoice_id,SUM(payment) AS payment FROM
				(
				SELECT invoice_id,SUM(payedusd) as payment  FROM payment_details WHERE invoice_id =$ci->supinvid   GROUP BY invoice_id
                UNION all
                SELECT supinvid,amount_fc*-1 FROM bank_transactions WHERE supinvid=$ci->supinvid AND  head_id=32
                ) y GROUP BY invoice_id
                ) x ON c.id = x.invoice_id
                SET c.invoicebal = ( case when contract_id=0 then c.total else tval end ) -  x.payment
                where  c.id =$ci->supinvid
                "));
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


        return view('received.edit')
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

            $ci = BankTransaction::findOrFail($request->receivedid);

            $ci->bank_id = $request->bank_id;
            $ci->head_id = $request->head_id;
            $ci->subhead_id = $request->subhead_id;
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
            $ci->supname = $request->supname;
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
                    SELECT invoice_id,SUM(totrcvd) as received  FROM receive_details WHERE invoice_id in(select invoice_id from receive_details where receivedid =$ci->id  )  GROUP BY invoice_id
                    ) x ON c.id = x.invoice_id
                    SET c.paymentbal = totrcvbamount -  x.received
                    where  c.id in(select invoice_id from receive_details where receivedid =$ci->id  ) "));
            }

            if($ci->head_id==32)
            {
                DB::update(DB::raw("

                UPDATE commercial_invoices c
                INNER JOIN (
				SELECT invoice_id,SUM(payment) AS payment FROM
				(
				SELECT invoice_id,SUM(payedusd) as payment  FROM payment_details WHERE invoice_id =$ci->supinvid   GROUP BY invoice_id
                UNION all
                SELECT supinvid,amount_fc*-1 FROM bank_transactions WHERE supinvid=$ci->supinvid AND  head_id=32
                ) y GROUP BY invoice_id
                ) x ON c.id = x.invoice_id
                SET c.invoicebal = ( case when contract_id=0 then c.total else tval end ) -  x.payment
                where  c.id =$ci->supinvid
                "));
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
