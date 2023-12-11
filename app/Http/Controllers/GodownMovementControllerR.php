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
class GodownMovementControllerR  extends Controller
{
    public function index(Request $request)
    {
         return view('godownmovementr.index');


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
        $contracts = DB::table('vwgmindex')->where('clrldstatus',0)
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        ->where('stono', 'like', "%$search%")
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
        $contractDetails = DB::select('call procgmcreatekdtl(?)',array( $id));
        return response()->json($contractDetails, 200);
    }

    public function getIndexDetails(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $contracts = DB::table('vwgmindex')->where('clrldstatus',1)
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
        $maxstono = DB::table('godown_movements')->select('clrdid')->max('clrdid')+1;
        // $maxgpno = DB::table('sale_invoices')->select('gpno')->max('gpno')+1;
        // $maxbillno = DB::table('sale_invoices')->select('billno')->max('billno')+1;

        return \view ('godownmovementr.create',compact('maxstono'))
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

            // 'stono' => 'required|unique:godown_movements',
            // 'gpno' => 'required|unique:sale_invoices',
            // 'poseqno' => 'required|min:1|unique:customer_orders',
            // 'pono' => 'required|min:1|unique:customer_orders'
            // 'gpno' => 'required|min:1|unique:sale_invoices',
            // 'customer_id' => 'required'
        ]);
        DB::beginTransaction();
        try {

            $ci = GodownMovement::findOrFail($request->godown_movement_id);
            $ci->clrdid = $request->clrdid;
            $ci->clrddate = $request->clrddate;
            $ci->clrldstatus = 1;

            $ci->save();

            // $ci = new GodownMovement();

            // $ci->stodate = $request->stodate;
            // $ci->stono = $request->stono;
            // $ci->fromg = $request->fromg;
            // $ci->tog = $request->tog;
            // $ci->mremarks = $request->mremarks;

            // foreach ($request->godownmovementr as $cont) {
            //     $unitid = Sku::where("title", $cont['sku'])->first();
            //     $lpd = new GodownMovementDetails();
            //     $lpd->godown_movement_id = $ci->id;
            //     $lpd->material_id = $cont['material_id'];
            //     $lpd->sku_id = $unitid->id;
            //     $lpd->qtykg = $cont['qtykg'];
            //     $lpd->qtypcs = $cont['qtypcs'];
            //     $lpd->qtyfeet = $cont['qtyfeet'];
            //     $lpd->unitconver = 1;
            //     $lpd->price = $cont['price'];
            //     $lpd->saleamnt = $cont['saleamnt'];
            //     $lpd->feedqty = $cont['feedqty'];
            //     $lpd->qtykgcrt = $cont['salcostkg'];
            //     $lpd->qtypcscrt = $cont['salcostpcs'];
            //     $lpd->qtyfeetcrt = $cont['salcostfeet'];
            //     $lpd->sqtykg = $cont['sqtykg'];
            //     $lpd->sqtypcs = $cont['sqtypcs'];
            //     $lpd->sqtyfeet = $cont['sqtyfeet'];
            //     $lpd->wtper = $cont['wtper'];
            //     $lpd->pcper = $cont['pcper'];
            //     $lpd->feetper = $cont['feetper'];
            //     $lpd->salewt = $cont['qtykg'];
            //     $lpd->salepcs = $cont['qtypcs'];
            //     $lpd->salefeet = $cont['qtyfeet'];
            //     $lpd->save();

            // }

            //// Details update

            /// **** update summary data to master table
            // DB::update(DB::raw("
            // UPDATE godown_movements c
            // INNER JOIN (
            // SELECT godown_movement_id,SUM(qtykg) AS twt,SUM(qtypcs) AS tpcs,SUM(qtyfeet) AS tfeet,sum(saleamnt) as tval FROM  godown_movement_details
            // WHERE godown_movement_id=$ci->id GROUP BY godown_movement_id
            // ) x ON c.id = x.godown_movement_id
            // SET c.tqtywt = x.twt,c.tqtypcs=x.tpcs,c.tqtyfeet=x.tfeet ,c.bqtywt = x.twt,c.bqtypcs=x.tpcs,c.bqtyfeet=x.tfeet,c.goodsval=x.tval
            // WHERE  c.id = $ci->id "));


            // DB::insert(DB::raw("
            // INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet)
            // SELECT a.id AS transid,a.saldate,'sales',4,b.material_id,sku_id,qtykg*-1,qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt FROM sale_invoices a INNER JOIN  sale_invoices_details b
            // ON a.id=b.sale_invoice_id WHERE a.id=$ci->id"));

            if($ci->fromg == 1)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,7,'GM From',material_id,qtykg*-1,qtypcs*-1,qtyfeet*-1,0,0,0 ,0,0,0 ,0,0,0 ,0,0,0 ,0,0,0 ,qtykg*-1,
                qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END )*-1 AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }

            if($ci->fromg == 2)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,7,'GM From',material_id,0,0,0,qtykg*-1,qtypcs*-1,qtyfeet*-1 ,0,0,0 ,0,0,0 ,0,0,0 ,0,0,0 ,qtykg*-1,
                qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END )*-1 AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }

            if($ci->fromg == 3)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,7,'GM From',material_id,0,0,0,0,0,0,qtykg*-1,qtypcs*-1,qtyfeet*-1 ,0,0,0 ,0,0,0 ,0,0,0 ,qtykg*-1,
                qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END )*-1 AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }
            if($ci->fromg == 4)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,7,'GM From',material_id,0,0,0,0,0,0,0,0,0,qtykg*-1,qtypcs*-1,qtyfeet*-1  ,0,0,0 ,0,0,0 ,qtykg*-1,
                qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END )*-1 AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }

            if($ci->fromg == 5)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,7,'GM From',material_id,0,0,0,0,0,0,0,0,0,0,0,0,qtykg*-1,qtypcs*-1,qtyfeet*-1 ,0,0,0 ,qtykg*-1,
                qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END )*-1 AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }
            if($ci->fromg == 6)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,7,'GM From',material_id,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,qtykg*-1,qtypcs*-1,qtyfeet*-1  ,qtykg*-1,
                qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END )*-1 AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }






            if($ci->tog == 1)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,8,'GM To',material_id,qtykg,qtypcs,qtyfeet,0,0,0 ,0,0,0 ,0,0,0 ,0,0,0 ,0,0,0 ,qtykg,
                qtypcs,qtyfeet,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END ) AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }

            if($ci->tog == 2)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,8,'GM To',material_id,0,0,0,qtykg,qtypcs,qtyfeet ,0,0,0 ,0,0,0 ,0,0,0 ,0,0,0 ,qtykg,
                qtypcs,qtyfeet,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END ) AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }

            if($ci->tog == 3)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,8,'GM To',material_id,0,0,0,0,0,0,qtykg,qtypcs,qtyfeet ,0,0,0 ,0,0,0 ,0,0,0 ,qtykg,
                qtypcs,qtyfeet,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END ) AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }
            if($ci->tog == 4)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,8,'GM To',material_id,0,0,0,0,0,0,0,0,0,qtykg,qtypcs,qtyfeet  ,0,0,0 ,0,0,0 ,qtykg,
                qtypcs,qtyfeet,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END ) AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }

            if($ci->tog == 5)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,8,'GM To',material_id,0,0,0,0,0,0,0,0,0,0,0,0,qtykg,qtypcs,qtyfeet ,0,0,0 ,qtykg,
                qtypcs,qtyfeet,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END ) AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }
            if($ci->tog == 6)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,8,'GM To',material_id,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,qtykg,qtypcs,qtyfeet  ,qtykg,
                qtypcs,qtyfeet,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END ) AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }











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

         $cd = DB::select('call procgmedit (?)',array( $id ));
         $data=compact('cd');
        //  $locations = Location::select('id','title')->where('status',1)->get();
        return view('godownmovementr.edit')
        // ->with('customer',Customer::select('id','title')->get())
        ->with('godownmovementr',GodownMovement::findOrFail($id))
        ->with($data)
        ->with('skus',Sku::select('id','title')->get())
        ->with('locations',Location::select('id','title')->get());

        // return view('contracts.edit')->with('suppliers',Supplier::select('id','title')->get())->with('contract',$contract)->with('cd',ContractDetails::where('contract_id',$contract->id)->get());
    }


    public function update(Request $request, GodownMovement $godownmovementr)
    {
        //  dd($commercialinvoice->commercial_invoice_id());
            //   dd($request->all());
        DB::beginTransaction();
        try {

            //  dd($request->sale_invoice_id);
            $ci = GodownMovement::findOrFail($request->godown_movement_id);

            $ci->clrdid = $request->clrdid;
            $ci->clrddate = $request->clrddate;
            $ci->clrldstatus = 1;
            $ci->save();


            DB::delete(DB::raw(" delete from godown_stock where ttypeid in(7,8) and  transaction_id=$ci->id   "));

            if($ci->fromg == 1)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,7,'GM From',material_id,qtykg*-1,qtypcs*-1,qtyfeet*-1,0,0,0 ,0,0,0 ,0,0,0 ,0,0,0 ,0,0,0 ,qtykg*-1,
                qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END )*-1 AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }

            if($ci->fromg == 2)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,7,'GM From',material_id,0,0,0,qtykg*-1,qtypcs*-1,qtyfeet*-1 ,0,0,0 ,0,0,0 ,0,0,0 ,0,0,0 ,qtykg*-1,
                qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END )*-1 AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }

            if($ci->fromg == 3)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,7,'GM From',material_id,0,0,0,0,0,0,qtykg*-1,qtypcs*-1,qtyfeet*-1 ,0,0,0 ,0,0,0 ,0,0,0 ,qtykg*-1,
                qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END )*-1 AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }
            if($ci->fromg == 4)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,7,'GM From',material_id,0,0,0,0,0,0,0,0,0,qtykg*-1,qtypcs*-1,qtyfeet*-1  ,0,0,0 ,0,0,0 ,qtykg*-1,
                qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END )*-1 AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }

            if($ci->fromg == 5)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,7,'GM From',material_id,0,0,0,0,0,0,0,0,0,0,0,0,qtykg*-1,qtypcs*-1,qtyfeet*-1 ,0,0,0 ,qtykg*-1,
                qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END )*-1 AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }
            if($ci->fromg == 6)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,7,'GM From',material_id,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,qtykg*-1,qtypcs*-1,qtyfeet*-1  ,qtykg*-1,
                qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END )*-1 AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }






            if($ci->tog == 1)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,8,'GM To',material_id,qtykg,qtypcs,qtyfeet,0,0,0 ,0,0,0 ,0,0,0 ,0,0,0 ,0,0,0 ,qtykg,
                qtypcs,qtyfeet,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END ) AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }

            if($ci->tog == 2)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,8,'GM To',material_id,0,0,0,qtykg,qtypcs,qtyfeet ,0,0,0 ,0,0,0 ,0,0,0 ,0,0,0 ,qtykg,
                qtypcs,qtyfeet,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END ) AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }

            if($ci->tog == 3)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,8,'GM To',material_id,0,0,0,0,0,0,qtykg,qtypcs,qtyfeet ,0,0,0 ,0,0,0 ,0,0,0 ,qtykg,
                qtypcs,qtyfeet,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END ) AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }
            if($ci->tog == 4)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,8,'GM To',material_id,0,0,0,0,0,0,0,0,0,qtykg,qtypcs,qtyfeet  ,0,0,0 ,0,0,0 ,qtykg,
                qtypcs,qtyfeet,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END ) AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }

            if($ci->tog == 5)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,8,'GM To',material_id,0,0,0,0,0,0,0,0,0,0,0,0,qtykg,qtypcs,qtyfeet ,0,0,0 ,qtykg,
                qtypcs,qtyfeet,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END ) AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }
            if($ci->tog == 6)
            {
                DB::insert(DB::raw("
                INSERT INTO godown_stock(transaction_id,tdate,ttypeid,tdesc,material_id,stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,
                stkfeete24,stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue)
                SELECT a.id,clrddate,8,'GM To',material_id,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,qtykg,qtypcs,qtyfeet  ,qtykg,
                qtypcs,qtyfeet,qtykgcrt,qtypcscrt,qtyfeetcrt
                ,( case b.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END ) AS transvalue
                FROM godown_movements AS a INNER JOIN godown_movement_details AS b ON a.id=b.godown_movement_id AND a.id=$ci->id"));
            }
























            // Get Data
            // $cds = $request->godownmovementr; // This is array
            // $cds = GodownMovementDetails::hydrate($cds); // Convert it into Model Collection
            // $oldcd = GodownMovementDetails::where('godown_movement_id',$ci->id)->get();
            // $deleted = $oldcd->diff($cds);
            // foreach ($deleted as $d) {
            //     $d->delete();
            // }
            // foreach ($cds as $cd) {
            //     if($cd->id)
            //     {
            //         $cds = GodownMovementDetails::where('id',$cd->id)->first();
            //         $cds->godown_movement_id = $ci->id;
            //         $cds->material_id = $cd->material_id;
            //         $cds->sku_id = $cd->sku_id;
            //         $cds->qtykg = $cd['qtykg'];
            //         $cds->qtypcs = $cd['qtypcs'];
            //         $cds->qtyfeet = $cd['qtyfeet'];
            //         $cds->price = $cd['price'];
            //         $cds->saleamnt = $cd['saleamnt'];
            //         $cds->feedqty = $cd['feedqty'];
            //         $unit = Sku::where("title", $cd['sku'])->first();
            //         // $cds->sku_id = $unit->id;
            //         $cds->salewt = $cd['qtykg'];
            //         $cds->salepcs = $cd['qtypcs'];
            //         $cds->salefeet = $cd['qtyfeet'];


            //         $cds->save();


                    // $lstrt = CreateSaleRate::where('customer_id',$request->customer_id)->where('material_id',$cd->material_id)->first();
                    // if(!$lstrt) {
                    //     $abc = new CreateSaleRate();
                    //     $abc->customer_id=$request->customer_id;
                    //     $abc->material_id=$cd->material_id;
                    //     $abc->salrate=$cd['price'];;
                    //     $abc->save();
                    // }
                    // else
                    //     {
                    //     $lstrt->salrate=$cd['price'];;
                    //     $lstrt->save();
                    //     }





                    //  $cds->save();
                // }
                //     //  The item is new, Add it
                //      $cds = new SaleInvoicesDetails();
                //      $cds->sale_invoice_id = $sale_invoices->id;
                //      $cds->material_id = $cd->material_id;
                //      $cds->sku_id = $cd->sku_id;
                //      $cds->repname = $cd['repname'];
                //      $cds->brand = $cd['brand'];
                //      $cds->qtykg = $cd['qtykg'];
                //      $cds->qtypcs = $cd['qtypcs'];
                //      $cds->qtyfeet = $cd['qtyfeet'];
                //      $cds->price = $cd['price'];
                //      $cds->saleamnt = $cd['saleamnt'];
                //      $unit = Sku::where("title", $cd['sku'])->first();
                //       $cds->sku_id = $unit->id;


                //     $cds->save();
                // }
            // }
            // $dlvrd = SaleInvoices::where('custplan_id',$sale_invoices->custplan_id)->sum('totrcvbamount');
            // $custordr = CustomerOrder::where('id',$sale_invoices->custplan_id)->first();

            // $custordr->delivered = $dlvrd;
            // $custordr->save();

            // $sordrbal = SaleInvoices::where('id',$sale_invoices->id)->first();
            // $sordrbal->ordrbal= $custordr->totrcvbamount - $dlvrd;
            // $sordrbal->save();


        // }

        // DB::update(DB::raw("
        // UPDATE godown_movements c
        // INNER JOIN (
        // SELECT godown_movement_id,SUM(qtykg) AS twt,SUM(qtypcs) AS tpcs,SUM(qtyfeet) AS tfeet,sum(saleamnt) as tval FROM  godown_movement_details
        // WHERE godown_movement_id=$ci->id GROUP BY godown_movement_id
        // ) x ON c.id = x.godown_movement_id
        // SET c.tqtywt = x.twt,c.tqtypcs=x.tpcs,c.tqtyfeet=x.tfeet ,c.bqtywt = x.twt,c.bqtypcs=x.tpcs,c.bqtyfeet=x.tfeet,c.goodsval=x.tval
        // WHERE  c.id = $ci->id "));



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
