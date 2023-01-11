<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Reciving;
use Illuminate\Http\Request;
use App\Models\CommercialInvoice;
use Illuminate\Support\Facades\DB;
use App\Models\RecivingPendingDetails;
use Illuminate\Support\Facades\Session;
use App\Models\CommercialInvoiceDetails;
use App\Models\RecivingCompletedDetails;

class RecivingController extends Controller
{
    public function __construct(){ $this->middleware('auth'); }

    public function index()
    {
        return view('recivings.index');
    }

    public function getRecivingMaster(Request $request)
    {
        // dd($request->all());
        $status=$request->status;
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        if($status === "1")
        {
            $recivings = Reciving::where('status',$status)
            ->with('supplier:id,title')
            ->with('pendingDetails')
            ->orderBy($field,$dir)
            ->paginate((int) $size);
        }else {
            $recivings = Reciving::where('grmade',2)
            ->with('supplier:id,title')
            ->with('pendingDetails')
            ->orderBy($field,$dir)
            ->paginate((int) $size);
        }

        return $recivings;
    }
    public function getRecivingDetails(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $status = $request->status;
        $id = $request->id;
        $details = '';
        // dd($request->all());
        if($status === "1")
        {
            return  RecivingPendingDetails::where('reciving_id',$id)->where('status',1)->with('material:id,title')
            ->orderBy('material_id','asc')->paginate((int) $size);
        }else {
            return RecivingCompletedDetails::where('reciving_id',$id)
            ->where('status',2)->with('material:id,title')
            ->orderBy('material_id','asc')->paginate((int) $size);
        }
    }

    public function updateCompletedReciving(Request $request)
    {
        // dd($request->all());
        $rcd = RecivingCompletedDetails::findOrFail($request->rcdid);
        $rcd->thisgr = $request->thisgr;
        $rcd->save();

        $rcv = Reciving::findOrFail($rcd->reciving_id);
        $rpd = RecivingPendingDetails::where('reciving_id',$rcv->id)->where('material_id',$rcd->material_id)->first();

        $rcds = RecivingCompletedDetails::where('reciving_id',$rcv->id)->where('material_id',$rcd->material_id)->sum('thisgr');
        // return($rcds);

        if($rcv->status === 2) $rcv->status = 1;
        if($rpd->status === 2) $rpd->status = 1;


        $rpd->qtyinpcspending = $rpd->qtyinpcs - $rcds;


        $rpd->save();
        $rcv->save();

        return response()->json(['message' =>'success'], 200);
        // $diff_in_mins = now()->diffInMinutes($rcd->updated_at);
        // if($diff_in_mins < 300)
        // {
        //     Session::flash('warning','You cannot edit record within 5 miutes of Edit');
        //     return response()->json($data, 200, $headers);
        // }
        // return $rcd;
    }

    public function show(Request $request)
    {
        $pending = RecivingPendingDetails::where('reciving_id',$request->id)->get();
        return response()->json($pending, 200);
    }

    public function edit($id)
    {
        $reciving = Reciving::with('supplier:id,title')->findOrFail($id);
        if($reciving->status == 2)
        {
            Session::flash('info','This reciving is completed. Cannot be reworked on');
            return redirect()->back();
        }
        $locations = Location::select('id','title')->where('status',1)->get();
        return view('recivings.edit')->with('reciving',$reciving)->with('locations',$locations);
    }

    public function update(Request $request,Reciving $reciving)

    {


        DB::beginTransaction();
            try {
                foreach($request->pendings as $p)
                {
                    //  if we have GR Qty
             //       if($p['qtythisgr'] >= 0)
              //      {
                        $pending = RecivingPendingDetails::where('id',$p['id'])->first();
                       // $pending->qtyinpcspending = $p['qtyinpcspending'] -$p['qtyinpcsrejected'] - $p['qtythisgr'];
                        $pending->qtyinpcspending = 0 ;
                        $pending->save();
                        //  Close Pending if qtyinpcspending = 0
                        if($pending->qtyinpcspending == 0)
                        {
                            $pending->status = 2;
                            $pending->save();
                        }
                        // Create Good Received

                        $completed = new RecivingCompletedDetails();
                        $completed->reciving_id = $reciving->id;
                        $completed->reciving_date = now();
                        $completed->invoiceno = $p['invoiceno'];
                        $completed->location = $p['location'];
                        $completed->machine_date = $p['machine_date'];
                        $completed->machineno = $p['machineno'];
                        $completed->supplier_id = $p['supplier_id'];
                        $completed->commercial_invoice_id = $p['commercial_invoice_id'];
                        $completed->material_id = $p['material_id'];
                        $completed->material_title = $p['material']['title'];

                        // OLD CODING
                        // $completed->received = $p['qtyinpcsrcv'];
                        // $completed->rejected = $p['qtyinpcsrejected'];
                        //*********************** *
                        // CHANGED FROM USMAN ON 16-12-2022
                        $completed->received = $p['length'];
                        $completed->rejected = $p['inkg'];
                        //********************************* */

                        //$completed->thisgr = $p['qtythisgr'];
                        $completed->thisgr = $p['qtyinpcs'];
                        $completed->rateperft = $p['rateperft'];
                        $completed->rateperkg = $p['rateperkg'];
                        $completed->rateperpc = $p['rateperpc'];

                        // Changed From Usman on 15-12-2022
                        $completed->qtyinpcs = $p['qtyinpcs'];
                        $completed->qtyinkg = $p['qtyinkg'];
                        $completed->qtyinfeet = $p['qtyinfeet'];
                        //***** */

                        $completed->save();
                   // }
                }
                // Close Reciving
                $closeReciving = true;
                foreach ($reciving->pendingDetails as $pending)
                {
                    // dd($pending);
                    if($pending->status === 1){
                        $closeReciving = false;
                    }else {
                        $closeReciving = true;
                    }

                }
                if($closeReciving) {
                    $reciving->status = 2;
                    $reciving->save();
                    // Close Commercial Invoice
                    CommercialInvoice::closeCommercialInvoice($reciving->commercial_invoice_id);
                }
                $reciving->grmade = 2;
                $reciving->save();
            DB::commit();
            Session::flash('success','Goods Received');
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    // public function destroy(Reciving $reciving)
    // {
    //     //
    // }
}
