<?php

namespace App\Http\Controllers;

use DB;
// use App\Models\Contract;
use App\Models\Quotation;
use App\Models\QuotationDetails;

use App\Models\CustomerOrder;
use App\Models\CustomerOrderDetails;

use App\Models\SaleInvoices;
use App\Models\SaleInvoicesDetails;
use App\Models\CreateSaleRate;
use App\Models\ItemBal;

use App\Models\GodownMovement;
use App\Models\GodownMovementDetails;

use App\Models\Material;
use App\Models\Customer;
use App\Models\Sku;
use Illuminate\Http\Request;
// use App\Models\ContractDetails;
use App\Models\Location;
use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Session;

// LocalPurchaseController
class GodownMovementController  extends Controller
{
    public function index(Request $request)
    {
         return view('godownmovement.index');


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
        // dd($request->all());
        $status =$request->status ;
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $cis = GodownMovement::
        // where('custplan_id','=','0')
        where(function ($query) use ($search){
                $query->where('stono','LIKE','%' . $search . '%');
                // ->orWhere('gpno','LIKE','%' . $search . '%')
                // ->orWhere('billno','LIKE','%' . $search . '%');
            })
            // ->whereHas('customer', function ($query) {
            //      $query->where('source_id','=','1');
            // })
        ->with('locations:id,title')
         ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $cis;
    }


    public function getDetails(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $contractDetails = GodownMovementDetails::where('godown_movement_id',$request->id)
        ->paginate((int) $size);
        return $contractDetails;
    }

    public function getMastercustplan(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $contracts = DB::table('vwmatcatfrsale')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        ->where('srchb', 'like', "%$search%")
        // ->orWhere('pono', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;
    }

    public function getDetailscustplan(Request $request)
    {
        $id = $request->id;


        //  $cid=$request->fromg;
        //   dd($request->mremarks);
        //  $contractDetails = DB::table('vwdetailcustplan')->where('sale_invoice_id',$id)->get();
        $contractDetails = DB::select('call procdetailgodownmov(?)',array( $id));
        return response()->json($contractDetails, 200);
    }

    public function getIndexDetails(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $contracts = DB::table('vwgmindex')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        ->where('stono', 'like', "%$search%")
        // ->orWhere('pono', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;

    }








    public function create()
    {
         $locations = Location::select('id','title')->where('status',1)->get();

        // return view('sales.create')
        // $mycname='MUHAMMAD HABIB & Co.';
        $maxstono = DB::table('godown_movements')->select('stono')->max('stono')+1;
        // $maxgpno = DB::table('sale_invoices')->select('gpno')->max('gpno')+1;
        // $maxbillno = DB::table('sale_invoices')->select('billno')->max('billno')+1;

        return \view ('godownmovement.create',compact('maxstono'))
        ->with('customers',Customer::select('id','title')->get())
         ->with('locations',Location::select('id','title')->get())
         ->with('skus',Sku::select('id','title')->get());

        // ->with('maxdcno',lastsalinvno::select('id','poseqno')->get());

        // ->with('lastsno',DB::table('lastsalinvno')->select('*')->get());
    }

    /** Function Complete*/
    public function store(Request $request)
    {
            //    dd($request->all());
        $this->validate($request,[

            'stono' => 'required|unique:godown_movements',
            // 'gpno' => 'required|unique:sale_invoices',
            // 'poseqno' => 'required|min:1|unique:customer_orders',
            // 'pono' => 'required|min:1|unique:customer_orders'
            // 'gpno' => 'required|min:1|unique:sale_invoices',
            // 'customer_id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $ci = new GodownMovement();

            $ci->stodate = $request->stodate;
            $ci->stono = $request->stono;
            $ci->fromg = $request->fromg;
            $ci->tog = $request->tog;
            $ci->mremarks = $request->mremarks;

            $ci->save();

            foreach ($request->godownmovement as $cont) {

                $unitid = Sku::where("title", $cont['sku'])->first();
                $lpd = new GodownMovementDetails();
                $lpd->godown_movement_id = $ci->id;
                $lpd->material_id = $cont['material_id'];
                $lpd->sku_id = $unitid->id;
                $lpd->qtykg = $cont['qtykg'];
                $lpd->qtypcs = $cont['qtypcs'];
                $lpd->qtyfeet = $cont['qtyfeet'];
                $lpd->unitconver = 1;
                $lpd->price = $cont['price'];
                $lpd->saleamnt = $cont['saleamnt'];
                $lpd->feedqty = $cont['feedqty'];
                $lpd->qtykgcrt = $cont['salcostkg'];
                $lpd->qtypcscrt = $cont['salcostpcs'];
                $lpd->qtyfeetcrt = $cont['salcostfeet'];
                $lpd->sqtykg = $cont['sqtykg'];
                $lpd->sqtypcs = $cont['sqtypcs'];
                $lpd->sqtyfeet = $cont['sqtyfeet'];
                $lpd->wtper = $cont['wtper'];
                $lpd->pcper = $cont['pcper'];
                $lpd->feetper = $cont['feetper'];
                $lpd->salewt = $cont['qtykg'];
                $lpd->salepcs = $cont['qtypcs'];
                $lpd->salefeet = $cont['qtyfeet'];


                $lpd->save();

            }

            //// Details update

            /// **** update summary data to master table
            DB::update(DB::raw("
            UPDATE godown_movements c
            INNER JOIN (
            SELECT godown_movement_id,SUM(qtykg) AS twt,SUM(qtypcs) AS tpcs,SUM(qtyfeet) AS tfeet,sum(saleamnt) as tval FROM  godown_movement_details
            WHERE godown_movement_id=$ci->id GROUP BY godown_movement_id
            ) x ON c.id = x.godown_movement_id
            SET c.tqtywt = x.twt,c.tqtypcs=x.tpcs,c.tqtyfeet=x.tfeet ,c.bqtywt = x.twt,c.bqtypcs=x.tpcs,c.bqtyfeet=x.tfeet,c.goodsval=x.tval
            WHERE  c.id = $ci->id "));


            // DB::insert(DB::raw("
            // INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet)
            // SELECT a.id AS transid,a.saldate,'sales',4,b.material_id,sku_id,qtykg*-1,qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt FROM sale_invoices a INNER JOIN  sale_invoices_details b
            // ON a.id=b.sale_invoice_id WHERE a.id=$ci->id"));






            DB::commit();
            Session::flash('success','Contract Information Saved');
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

    }

    // public function edit(Contract $contract)
    public function edit($id)
    {

        $passwrd = DB::table('tblpwrd')->select('pwrdtxt')->max('pwrdtxt');


         $cd = DB::select('call procgmedit (?)',array( $id ));
         $data=compact('cd');
        //  $locations = Location::select('id','title')->where('status',1)->get();
        return view('godownmovement.edit',compact('passwrd'))
        // ->with('customer',Customer::select('id','title')->get())
        ->with('godownmovement',GodownMovement::findOrFail($id))
        ->with($data)
        ->with('skus',Sku::select('id','title')->get())
        ->with('locations',Location::select('id','title')->get());

        // return view('contracts.edit')->with('suppliers',Supplier::select('id','title')->get())->with('contract',$contract)->with('cd',ContractDetails::where('contract_id',$contract->id)->get());
    }


    public function update(Request $request, GodownMovement $godownmovement)
    {
        //  dd($commercialinvoice->commercial_invoice_id());
            //   dd($request->all());
        DB::beginTransaction();
        try {

            //  dd($request->all);
            $ci = GodownMovement::findOrFail($request->godown_movement_id);

            $ci->stodate = $request->stodate;
            $ci->stono = $request->stono;
            $ci->fromg = $request->fromg;
            $ci->tog = $request->tog;
            $ci->mremarks = $request->mremarks;
            $ci->save();





            $cds = $request->godownmovement; // This is array
            $cds = GodownMovementDetails::hydrate($cds); // Convert it into Model Collection
            // Now get old ContractDetails and then get the difference and delete difference
            $oldcd = GodownMovementDetails::where('godown_movement_id',$ci->id)->get();
            $deleted = $oldcd->diff($cds);
            //  Delete contract details if marked for deletion
            foreach ($deleted as $d) {
                $d->delete();
            }
            // Now update existing and add new
            foreach ($cds as $cd) {
                if($cd->id)
                {
                    $cds = GodownMovementDetails::where('id',$cd->id)->first();
                    // $cds->machine_date = $cd->invoice_date;

                    $cds->godown_movement_id = $ci->id;
                    $cds->material_id = $cd['material_id'];
                    $unitid = Sku::where("title", $cd['sku'])->first();
                    $cds->sku_id = $unitid->id;
                    $cds->qtykg = $cd['qtykg'];
                    $cds->qtypcs = $cd['qtypcs'];
                    $cds->qtyfeet = $cd['qtyfeet'];
                    $cds->unitconver = 1;
                    $cds->price = $cd['price'];
                    $cds->saleamnt = $cd['saleamnt'];
                    $cds->feedqty = $cd['feedqty'];
                    $cds->qtykgcrt = $cd['qtykgcrt'];
                    $cds->qtypcscrt = $cd['qtypcscrt'];
                    $cds->qtyfeetcrt = $cd['qtyfeetcrt'];
                    $cds->sqtykg = $cd['sqtykg'];
                    $cds->sqtypcs = $cd['sqtypcs'];
                    $cds->sqtyfeet = $cd['sqtyfeet'];
                    $cds->wtper = $cd['wtper'];
                    $cds->pcper = $cd['pcper'];
                    $cds->feetper = $cd['feetper'];
                    $cds->salewt = $cd['qtykg'];
                    $cds->salepcs = $cd['qtypcs'];
                    $cds->salefeet = $cd['qtyfeet'];

                    $cds->save();
                }else
                {
                    //  The item is new, Add it

                    $cds = new GodownMovementDetails();
                    // $cds->godown_movement_id = $ci->id;
                    $cds->material_id = $cd['material_id'];
                    $unitid = Sku::where("title", $cd['sku'])->first();
                    $cds->sku_id = $unitid->id;
                    $cds->qtykg = $cd['qtykg'];
                    $cds->qtypcs = $cd['qtypcs'];
                    $cds->qtyfeet = $cd['qtyfeet'];
                    $cds->unitconver = 1;
                    $cds->price = $cd['price'];
                    $cds->saleamnt = $cd['saleamnt'];
                    $cds->feedqty = $cd['feedqty'];
                    $cds->qtykgcrt = $cd['salcostkg'];
                    $cds->qtypcscrt = $cd['salcostpcs'];
                    $cds->qtyfeetcrt = $cd['salcostfeet'];
                    $cds->sqtykg = $cd['sqtykg'];
                    $cds->sqtypcs = $cd['sqtypcs'];
                    $cds->sqtyfeet = $cd['sqtyfeet'];
                    $cds->wtper = $cd['wtper'];
                    $cds->pcper = $cd['pcper'];
                    $cds->feetper = $cd['feetper'];
                    $cds->salewt = $cd['qtykg'];
                    $cds->salepcs = $cd['qtypcs'];
                    $cds->salefeet = $cd['qtyfeet'];
                    $cds->save();
                }
            }


            // Get Data

        DB::update(DB::raw("
        UPDATE godown_movements c
        INNER JOIN (
        SELECT godown_movement_id,SUM(qtykg) AS twt,SUM(qtypcs) AS tpcs,SUM(qtyfeet) AS tfeet,sum(saleamnt) as tval FROM  godown_movement_details
        WHERE godown_movement_id=$ci->id GROUP BY godown_movement_id
        ) x ON c.id = x.godown_movement_id
        SET c.tqtywt = x.twt,c.tqtypcs=x.tpcs,c.tqtyfeet=x.tfeet ,c.bqtywt = x.twt,c.bqtypcs=x.tpcs,c.bqtyfeet=x.tfeet,c.goodsval=x.tval
        WHERE  c.id = $ci->id "));



        /// **** update summary data to master table
            // DB::update(DB::raw("
            // UPDATE sale_invoices c
            // INNER JOIN (
            // SELECT sale_invoice_id,SUM(qtykg) AS twt,SUM(qtypcs) AS tpcs,SUM(qtyfeet) AS tfeet FROM sale_invoices_details WHERE sale_invoice_id=$sale_invoices->id GROUP BY sale_invoice_id
            // ) x ON c.id = x.sale_invoice_id
            // SET c.sltwt = x.twt,c.sltpcs=x.tpcs,c.slfeet=x.tfeet ,
            // c.balsltwt=x.twt,c.balsltpcs=x.tpcs,c.balslfeet=x.tfeet  WHERE  c.id = $sale_invoices->id "));






        //// Details update
        // DB::update(DB::raw("
        // UPDATE customer_order_details c
        // INNER JOIN (
        // SELECT b.custplan_id,a.material_id,SUM(feedqty) AS feedqty  FROM sale_invoices_details a
        //     INNER JOIN sale_invoices AS b ON b.id=a.sale_invoice_id WHERE b.custplan_id=$sale_invoices->custplan_id GROUP BY b.custplan_id,a.material_id
        // ) x ON c.sale_invoice_id = x.custplan_id AND c.material_id=x.material_id
        // SET c.balqty = c.qtykg - x.feedqty WHERE  c.sale_invoice_id = $sale_invoices->custplan_id"));





        // DB::update(DB::raw("
        // UPDATE customer_orders c
        // INNER JOIN (
        // SELECT custplan_id,SUM(totrcvbamount)-SUM(cartage) AS Dlvred FROM sale_invoices WHERE custplan_id=$sale_invoices->custplan_id
        //     GROUP BY custplan_id
        // ) x ON c.id = x.custplan_id
        // SET c.delivered = x.Dlvred,c.salordbal=( coalesce(totrcvbamount,0)-coalesce(cartage,0) )-x.Dlvred WHERE  c.id = $sale_invoices->custplan_id"));

        // DB::delete(DB::raw(" delete from office_item_bal where ttypeid=4 and  transaction_id=$sale_invoices->id   "));

        // DB::insert(DB::raw("
        // INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet)
        // SELECT a.id AS transid,a.saldate,'sales',4,b.material_id,sku_id,qtykg*-1,qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt FROM sale_invoices a INNER JOIN  sale_invoices_details b
        // ON a.id=b.sale_invoice_id WHERE a.id=$sale_invoices->id"));


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
