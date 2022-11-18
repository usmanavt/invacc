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
        $search = $request->search;
        $status=$request->status;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $recivings = Reciving::where('status',$status)
        ->with('supplier:id,title')
        ->with('pendingDetails')
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $recivings;
    }
    public function getRecivingDetails(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $status = $request->status;
        $id = $request->id;
        $details = '';
        if($status === "1")
        {
            return  RecivingPendingDetails::where('reciving_id',$id)->where('status',1)->with('material:id,title')
            ->paginate((int) $size);
        }else {
            return RecivingCompletedDetails::where('reciving_id',$id)
            ->where('status',2)->with('material:id,title')
            ->paginate((int) $size);
        }
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
        // dd($request->all(),$reciving);
        DB::beginTransaction();
            try {
                foreach($request->pendings as $p)
                {
                    //  if we have GR Qty
                    if($p['qtythisgr'] >= 0)
                    {
                        $pending = RecivingPendingDetails::where('id',$p['id'])->first();
                        $pending->qtyinpcspending = $p['qtyinpcspending'] -$p['qtyinpcsrejected'] - $p['qtythisgr'];
                        $pending->save();
                        //  Close Pending if qtyinpcspending = 0
                        if($pending->qtyinpcspending == 0)
                        {
                            $pending->status = 2;
                            $pending->save();
                        }
                        // Create Good Received
                        $completed = new RecivingCompletedDetails();
                        $completed->reciving_id = $p['reciving_id'];
                        $completed->invoiceno = $p['invoiceno'];
                        $completed->location = $p['location'];
                        $completed->machine_date = $p['machine_date'];
                        $completed->machineno = $p['machineno'];
                        $completed->supplier_id = $p['supplier_id'];
                        $completed->commercial_invoice_id = $p['commercial_invoice_id'];
                        $completed->material_id = $p['material_id'];
                        $completed->material_title = $p['material']['title'];
                        $completed->received = $p['qtyinpcsrcv'];
                        $completed->rejected = $p['qtyinpcsrejected'];
                        $completed->thisgr = $p['qtythisgr'];
                        $completed->rateperft = $p['rateperft'];
                        $completed->rateperkg = $p['rateperkg'];
                        $completed->rateperpc = $p['rateperpc'];
                        $completed->save();
                    }
                }
                // Close Reciving
                $closeReciving = true;
                foreach ($reciving->pendingDetails as $pending)
                {
                    // dd($pending);
                    if($pending->status === 1)
                        $closeReciving = false;
                }
                if($closeReciving) {
                    $reciving->status = 2;
                    $reciving->save();
                    // Close Commercial Invoice
                    CommercialInvoice::closeCommercialInvoice($reciving->commercial_invoice_id);
                }
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
