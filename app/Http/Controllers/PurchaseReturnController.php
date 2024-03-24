<?php

namespace App\Http\Controllers;

use DB;
// use App\Models\Contract;
use App\Models\Quotation;
use App\Models\QuotationDetails;

use App\Models\CustomerOrder;
use App\Models\CustomerOrderDetails;

use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetail;
use App\Models\Godownpr;


use App\Models\Supplier;


use App\Models\Material;
use App\Models\Customer;
use App\Models\Sku;
use Illuminate\Http\Request;
// use App\Models\ContractDetails;
use App\Models\Location;
use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Session;


// LocalPurchaseController
class PurchaseReturnController  extends Controller
{
    public function index(Request $request)
    {
         return view('purchasereturn.index');


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
        $cis = DB::table('vwprmast')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        // ->with('customer:id,title')
        ->where('supname', 'like', "%$search%")
         ->orWhere('prno', 'like', "%$search%")
         ->orWhere('commercial_invoice_id', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $cis;

    }


    public function getDetails(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $contractDetails = purchase_return_details::where('prid',$request->id)
        ->paginate((int) $size);
        return $contractDetails;
    }

    public function getMasterqut(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $contracts = DB::table('vwsalefrprmast')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        ->where('supname', 'like', "%$search%")
        ->orWhere('invoiceno', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;


    }

    public function getDetailsqut(Request $request)
    {
        $id = $request->id;
        // $abc = DB::select('call proctest0(1)');
        //  $contractDetails = DB::table('vwdetailquotations')->where('sale_invoice_id',$id)->get();
        $contractDetails = DB::select('call procprdetail(?)',array( $id ));
        return response()->json($contractDetails, 200);
    }


    public function create()
    {
        // $locations = Location::select('id','title')->where('status',1)->get();

        // return view('sales.create')
        // $mycname='MUHAMMAD HABIB & Co.';
        $maxposeqno = DB::table('purchase_returns')->select('*')->max('prno')+1;
        return \view ('purchasereturn.create',compact('maxposeqno'))
        ->with('supplier',Supplier::select('id','title')->get());
        // ->with('locations',Location::select('id','title')->get())
        // ->with('skus',Sku::select('id','title')->get());

        // ->with('maxdcno',lastsalinvno::select('id','poseqno')->get());

        // ->with('lastsno',DB::table('lastsalinvno')->select('*')->get());
    }

    /** Function Complete*/
    public function store(Request $request)
    {
            //    dd($request->all());
        $this->validate($request,[
            // 'saldate' => 'required|min:3|date',
        //    'title'=>'required|min:3|unique:materials'
            //  'poseqno' => 'required|min:1|unique:customer_orders',
            // 'pono' => 'required|min:1|unique:customer_orders'
            // 'gpno' => 'required|min:1|unique:sale_invoices',
            // 'customer_id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $ci = new PurchaseReturn();

            $ci->prdate = $request->prdate;
            $ci->prno = $request->prno;
            $ci->commercial_invoice_id = $request->purchase_id;
            $ci->supplier_id = $request->supplier_id;
            $ci->prinvdate = $request->invoice_date;
            $ci->prinvno = $request->invoiceno;
            $ci->retdescription = $request->retdescription;

            $ci->save();

            // Quotation Close
            // $qutclose = Quotation::findOrFail($request->quotation_id);
            // $qutclose->closed = 0;
            // $qutclose->save();


            foreach ($request->contracts as $cont) {
                // $material = Material::findOrFail($cont['id']);
                $lpd = new PurchaseReturnDetail();
                $lpd->prid = $ci->id;
                $lpd->material_id = $cont['material_id'];
                $lpd->prunitid = $cont['prunitid'];
                $lpd->prwt = $cont['prwt'];
                $lpd->prpcs = $cont['prpcs'];
                $lpd->prfeet = $cont['prfeet'];
                $lpd->prprice = $cont['prprice'];
                $lpd->pramount = $cont['pramount'];

                $lpd->prtbalwt = $cont['prwt'];
                $lpd->prtbalpcs = $cont['prpcs'];
                $lpd->prtbalfeet = $cont['prfeet'];



                $lpd->save();
            }

            DB::update(DB::raw("
            update purchase_returns c
            INNER JOIN (
				SELECT prid, SUM(prpcs) as pcs,SUM(prwt) AS wt,sum(prfeet) as ft,SUM(pramount) AS amount
                FROM purchase_return_details where  prid = $ci->id
                GROUP BY prid
            ) x ON c.id = x.prid
            SET c.prtpcs = x.pcs,c.prtwt=x.wt,c.prtfeet=x.ft,c.prtamount=x.amount,
            c.prbalpcs = x.pcs,c.prbalwt=x.wt,c.prbalfeet=x.ft
            where  id = $ci->id
            "));



            DB::update(DB::raw("
            UPDATE commercial_invoices c
            INNER JOIN (

                SELECT suppid,invsid,SUM(invoiceamount) AS invoicebal FROM
                (
                SELECT b.id AS suppid,a.id AS invsid,case WHEN b.source_id=2 then a.tval else  total end AS invoiceamount FROM commercial_invoices AS a
                INNER JOIN suppliers AS b ON a.supplier_id=b.id  AND b.id=$ci->supplier_id AND a.id =$ci->commercial_invoice_id
                UNION all
                 SELECT a.subhead_id,b.invoice_id,b.payedusd*-1 AS payment
                FROM bank_transactions AS a INNER join payment_details AS b ON a.id=b.paymentid and a.subhead_id =$ci->supplier_id
                AND b.invoice_id =$ci->commercial_invoice_id
               UNION ALL
                SELECT supplier_id,commercial_invoice_id,prtamount*-1 AS retqty FROM purchase_returns WHERE supplier_id =$ci->supplier_id
                AND commercial_invoice_id =$ci->commercial_invoice_id
               UNION ALL
                SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS Receivedqty
                FROM bank_transactions AS a INNER join commercial_invoices AS b ON a.supinvid=b.invoiceno AND a.subhead_id =$ci->supplier_id
                AND b.id  =$ci->commercial_invoice_id
               ) AS w GROUP BY suppid,invsid
            ) x ON c.id = x.invsid
            SET c.invoicebal = x.invoicebal
            where  c.id =$ci->commercial_invoice_id "));













            DB::insert(DB::raw("
            INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet,transvalue)
            SELECT a.id AS transid,a.prdate,'Purchase Return',5,b.material_id,b.prunitid,prwt*-1,prpcs*-1,prfeet*-1,prprice,prprice,prprice,pramount*-1
            FROM purchase_returns a INNER JOIN  purchase_return_details b    ON a.id=b.prid
            WHERE a.id=$ci->id"));

            // }
            DB::commit();
            Session::flash('success','Contract Information Saved');
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

    }
// jkjk kjkjkjksfda
    // public function edit(Contract $contract)
    public function edit($id)
    {

        $passwrd = DB::table('tblpwrd')->select('pwrdtxt')->max('pwrdtxt');

        // $cd = DB::table('vwpreditdtl')->select('vwpreditdtl.*')->where('id',$id)->get();
        $cd = DB::select('call procpurretedit(?)',array( $id ));
         $data=compact('cd');
         return view('purchasereturn.edit',compact('passwrd'))
        ->with('supplier',Supplier::select('id','title')->get())
        ->with('purchasereturn',PurchaseReturn::findOrFail($id))
        ->with($data)
        ->with('skus',Sku::select('id','title')->get());
    }


    public function deleterec($id)
    {

        $passwrd = DB::table('tblpwrd')->select('pwrdtxtdel')->max('pwrdtxtdel');
        $prgp = Godownpr::where('contract_id',$id)->max('contract_id');;

        // $cd = DB::table('vwpreditdtl')->select('vwpreditdtl.*')->where('id',$id)->get();
        $cd = DB::select('call procpurretedit(?)',array( $id ));
         $data=compact('cd');
         return view('purchasereturn.deleterec',compact('passwrd','prgp'))
        ->with('supplier',Supplier::select('id','title')->get())
        ->with('purchasereturn',PurchaseReturn::findOrFail($id))
        ->with($data)
        ->with('skus',Sku::select('id','title')->get());
    }









    public function update(Request $request, PurchaseReturn $purchasereturn)
    {
        //  dd($commercialinvoice->commercial_invoice_id());
            //   dd($request->all());

        $purchasereturn = $request->purchasereturn;
        DB::beginTransaction();
        try {

            $ci = PurchaseReturn::findOrFail($request->prid);
            // dd($request->prid);
            $ci->prdate = $request->prdate;
            $ci->prno = $request->prno;
            $ci->supplier_id = $request->supplier_id;
            $ci->prinvdate = $request->invoice_date;
            $ci->prinvno = $request->invoiceno;
            $ci->retdescription = $request->retdescription;

            $ci->save();


            foreach ($purchasereturn as $cd) {
                $c = PurchaseReturnDetail::findOrFail($cd['id']);
                    // $cds = PurchaseReturnDetail::where('id',$cd->id)->first();
                    $c->prid = $ci->id;
                    $c->material_id = $cd['material_id'];
                    $c->prunitid = $cd['prunitid'];
                    $c->prwt = $cd['prwt'];
                    $c->prpcs = $cd['prpcs'];
                    $c->prfeet = $cd['prfeet'];
                    $c->prprice = $cd['prprice'];
                    $c->pramount = $cd['pramount'];
                 $c->save();
                }

                DB::update(DB::raw("
                update purchase_returns c
                INNER JOIN (
                    SELECT prid, SUM(prpcs) as pcs,SUM(prwt) AS wt,sum(prfeet) as ft,SUM(pramount) AS amount
                    FROM purchase_return_details where  prid = $ci->id
                    GROUP BY prid
                ) x ON c.id = x.prid
                SET c.prtpcs = x.pcs,c.prtwt=x.wt,c.prtfeet=x.ft,c.prtamount=x.amount,
                c.prbalpcs = x.pcs,c.prbalwt=x.wt,c.prbalfeet=x.ft
                where  id = $ci->id
                "));


                DB::update(DB::raw("
                UPDATE commercial_invoices c
                INNER JOIN (

                    SELECT suppid,invsid,SUM(invoiceamount) AS invoicebal FROM
                    (
                    SELECT b.id AS suppid,a.id AS invsid,case WHEN b.source_id=2 then a.tval else  total end AS invoiceamount FROM commercial_invoices AS a
                    INNER JOIN suppliers AS b ON a.supplier_id=b.id  AND b.id=$ci->supplier_id
                    AND a.id in( select distinct commercial_invoice_id from purchase_returns where id=$ci->id  )
                    UNION all
                     SELECT a.subhead_id,b.invoice_id,b.payedusd*-1 AS payment
                    FROM bank_transactions AS a INNER join payment_details AS b ON a.id=b.paymentid and a.subhead_id =$ci->supplier_id
                    AND b.invoice_id in( select distinct commercial_invoice_id from purchase_returns where id=$ci->id  )
                   UNION ALL
                    SELECT supplier_id,commercial_invoice_id,prtamount*-1 AS retqty FROM purchase_returns WHERE supplier_id =$ci->supplier_id
                    AND commercial_invoice_id in( select distinct commercial_invoice_id from purchase_returns where id=$ci->id  )
                   UNION ALL
                    SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS Receivedqty
                    FROM bank_transactions AS a INNER join commercial_invoices AS b ON a.supinvid=b.invoiceno AND a.subhead_id =$ci->supplier_id
                    AND b.id  in( select distinct commercial_invoice_id from purchase_returns where id=$ci->id  )
                   ) AS w GROUP BY suppid,invsid
                ) x ON c.id = x.invsid
                SET c.invoicebal = x.invoicebal
                where  c.id in( select distinct commercial_invoice_id from purchase_returns where id=$ci->id  )  "));


                DB::delete(DB::raw(" delete from office_item_bal where ttypeid=5 and  transaction_id=$ci->id   "));

                DB::insert(DB::raw("
                INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet,transvalue)
                SELECT a.id AS transid,a.prdate,'Purchase Return',5,b.material_id,b.prunitid,prwt*-1,prpcs*-1,prfeet*-1,prprice,prprice,prprice,pramount*-1
                FROM purchase_returns a INNER JOIN  purchase_return_details b    ON a.id=b.prid
                WHERE a.id=$ci->id"));








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

    public function deleteBankRequest(Request $request)
    {


//  dd($request->invsid);
        DB::beginTransaction();
            try {



                DB::update(DB::raw("  update purchase_returns SET prtamount=0 WHERE id=$request->prid "));

                DB::update(DB::raw("
                UPDATE commercial_invoices c
                INNER JOIN (

                    SELECT suppid,invsid,SUM(invoiceamount) AS invoicebal FROM
                    (
                    SELECT b.id AS suppid,a.id AS invsid,case WHEN b.source_id=2 then a.tval else  total end AS invoiceamount FROM commercial_invoices AS a
                    INNER JOIN suppliers AS b ON a.supplier_id=b.id  AND b.id=$request->supplier_id AND a.id in(  SELECT commercial_invoice_id FROM purchase_returns WHERE id=$request->prid )
                    UNION all
                     SELECT a.subhead_id,b.invoice_id,b.payedusd*-1 AS payment
                    FROM bank_transactions AS a INNER join payment_details AS b ON a.id=b.paymentid and a.subhead_id =$request->supplier_id
                    AND b.invoice_id in(  SELECT commercial_invoice_id FROM purchase_returns WHERE id=$request->prid )
                   UNION ALL
                    SELECT supplier_id,commercial_invoice_id,prtamount*-1 AS retqty FROM purchase_returns WHERE supplier_id =$request->supplier_id
                    AND commercial_invoice_id in(  SELECT commercial_invoice_id FROM purchase_returns WHERE id=$request->prid )
                   UNION ALL
                    SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS Receivedqty
                    FROM bank_transactions AS a INNER join commercial_invoices AS b ON a.supinvid=b.invoiceno AND a.subhead_id =$request->supplier_id
                    AND b.id  in(  SELECT commercial_invoice_id FROM purchase_returns WHERE id=$request->prid )
                   ) AS w GROUP BY suppid,invsid
                ) x ON c.id = x.invsid
                SET c.invoicebal = x.invoicebal
                where  c.id in(SELECT commercial_invoice_id FROM purchase_returns WHERE id=$request->prid  ) "));


                DB::delete(DB::raw(" delete from purchase_returns where id=$request->prid   "));
                DB::delete(DB::raw(" delete from purchase_return_details where prid=$request->prid   "));

                DB::delete(DB::raw(" delete from office_item_bal where ttypeid=5 and  transaction_id=$request->prid   "));

                DB::commit();


                Session::flash('success','Record Deleted Successfully');
                return response()->json(['success'],200);

            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }
    }








}
