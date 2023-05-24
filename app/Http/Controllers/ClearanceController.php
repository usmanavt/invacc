<?php

namespace App\Http\Controllers;

use App\Models\Clearance;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ClearancePendingDetails;
use Illuminate\Support\Facades\Session;
use App\Models\RecivingCompletedDetails;
use App\Models\ClearanceCompletedDetails;

class ClearanceController extends Controller
{

    public function __construct(){ $this->middleware('auth'); }
    public function index(){   return view('clearance.index')

        ; }

    public function getMaster(Request $request)
    {
        $status =$request->status ;
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array

        return $status === "1" ?
            $cls = Clearance::where('status',$status)
            ->with('supplier:id,title')
            ->orderBy($field,$dir)
            ->paginate((int) $size)
            :
            $cls = Clearance::where('cleared',2)
            ->with('supplier:id,title')
            ->orderBy($field,$dir)
            ->paginate((int) $size);
    }

    public function getDetails(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $status = $request->status;
        $id = $request->id;
        return $status === "1" ?
            ClearancePendingDetails::where('clearance_id',$id)->where('status',1)->with('material:id,title')
            ->orderBy('material_id','asc')->paginate((int) $size)
            :
            ClearanceCompletedDetails::where('clearance_id',$id)->with('material:id,title')
            ->orderBy('material_id','asc')->paginate((int) $size);
    }

    public function updateCompletedClearance(Request $request)
    {
        // return $request->all();
        $ccd = ClearanceCompletedDetails::findOrFail($request->ccdid);
        $ccd->pcs = $request->pcs;
        $ccd->save();

        $ccl = Clearance::findOrFail($ccd->clearance_id);
        $cpd = ClearancePendingDetails::where('clearance_id',$ccl->id)->where('material_id',$ccd->material_id)->first();

        $ccds = ClearanceCompletedDetails::where('clearance_id',$ccl->id)->where('material_id',$ccd->material_id)->sum('pcs');
        // return($ccds);

        if($ccl->status === 2) $ccl->status = 1;
        if($cpd->status === 2) $cpd->status = 1;

        if($cpd->pcs_pending > 0){
            $cpd->pcs_pending = $cpd->pcs_pending - $ccds;
        }else {
            $cpd->pcs_pending =  $ccds;
        }

        $cpd->save();
        $ccl->save();

        return response()->json(['message' =>'success'], 200);
        // $diff_in_mins = now()->diffInMinutes($rcd->updated_at);
        // if($diff_in_mins < 300)
        // {
        //     Session::flash('warning','You cannot edit record within 5 miutes of Edit');
        //     return response()->json($data, 200, $headers);
        // }
        // return $rcd;
    }

    public function edit($id)
    {
        return view('clearance.edit')->with('clearance',Clearance::where('id',$id)->first())
        ->with('banks',Bank::where('status',1)->get())
        ;
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $dc = $request->dutyclearance;

        DB::beginTransaction();
        try {
            //  Get Clearance
            $clearance = Clearance::findOrFail($request->clearance_id);
            // Create Completed GD
            foreach($dc as $d)
            {
                $dcn = new ClearanceCompletedDetails();
                $dcn->clearance_id = $clearance->id;
                $dcn->gdno = $request->gdno;
                $dcn->gd_date = $request->gd_date;
                $dcn->machine_date = $request->machine_date;
                $dcn->machineno = $request->machineno;

                // $dcn->cheque_date = $request->cheque_date;
                // $dcn->cheque_no = $request->cheque_no;


                $dcn->commercial_invoice_id = $request->commercial_invoice_id;
                $dcn->invoiceno = $request->invoiceno;


                // From Usman on 19-01-2023
                $dcn->conrate = $request->conversionrate;
                $dcn->insrnce = $request->insurance;
                //**********************

                $dcn->contract_id = $d['contract_id'];
                $dcn->material_id = $d['material_id'];
                $dcn->supplier_id = $d['supplier_id'];
                $dcn->user_id = $d['user_id'];
                $dcn->category_id = $d['category_id'];
                $dcn->sku_id = $d['sku_id'];
                $dcn->dimension_id = $d['dimension_id'];
                $dcn->source_id = $d['source_id'];
                $dcn->brand_id = $d['brand_id'];
                $dcn->pcs = $d['pcs_rcv'];
                $dcn->gdswt = $d['kg_rcv'];
                $dcn->inkg = $d['inkg'];
                $dcn->gdsprice = $d['gdsprice'];
                $dcn->amtindollar = $d['amtindollar'];
                $dcn->hscode = $d['hscode'];
                $dcn->cd = $d['cd'];
                $dcn->st = $d['st'];
                $dcn->rd = $d['rd'];
                $dcn->acd = $d['acd'];
                $dcn->ast = $d['ast'];
                $dcn->it = $d['it'];
                $dcn->wse = $d['wse'];
                $dcn->length = $d['length'];
                $dcn->itmratio = $d['itmratio'];
                $dcn->insuranceperitem = $d['insuranceperitem'];
                $dcn->amountwithoutinsurance = $d['amountwithoutinsurance'];
                $dcn->onepercentdutypkr = $d['onepercentdutypkr'];
                $dcn->pricevaluecostsheet = $d['pricevaluecostsheet'];
                $dcn->totallccostwexp = $d['totallccostwexp'];
                $dcn->otherexpenses = $d['otherexpenses'];
                $dcn->cda = $d['cda'];
                $dcn->sta = $d['sta'];
                $dcn->rda = $d['rda'];
                $dcn->acda = $d['acda'];
                $dcn->asta = $d['asta'];
                $dcn->ita = $d['ita'];
                $dcn->wsca = $d['wsca'];
                $dcn->total = $d['total'];
                $dcn->perpc = $d['perpc'];
                $dcn->perkg = $d['perkg'];
                $dcn->perft = $d['perft'];
                $dcn->save();
                //  Update Pending
                $dcp = ClearancePendingDetails::findOrFail($d['id']);
                $pending = (int) $d['pcs_pending'] -  (int) $d['pcs_rcv'];  //  Calculate Pending
                $dcp->pcs_pending =  $pending;
                // $dcp->save();
                $pendingkg = (int) $d['gdswt_pending'] -  (int) $d['kg_rcv'];  //  Calculate Pending
                $dcp->gdswt_pending =  $pendingkg;
                if($pending <= 0 or $pendingkg <= 0 )
                {
                    $dcp->status = 2;
                }
                $dcp->save();
  }


            // Update & Close Clearance if Completed
            $closeClearance = true;
            foreach($clearance->clearancePendingDetails as $pending)

            {

                if($pending->status === 1)
                    $closeClearance = false;
            }
            if($closeClearance){
                $clearance->status = 2;
            }

            $clearance->gd_date = $request->gd_date;
            $clearance->gdno = $request->gdno;

            $clearance->bank_id = $request->bank_id;
            $clearance->cheque_date = $request->cheque_date;
            $clearance->cheque_no = $request->cheque_no;


            $clearance->conversionrate = $request->conversionrate;
            $clearance->insurance = $request->insurance;
            $clearance->bankcharges = $request->bankcharges;
            $clearance->collofcustom = $request->collofcustom;
            $clearance->exataxoffie = $request->exataxoffie;
            $clearance->lngnshipdochrgs = $request->lngnshipdochrgs;
            $clearance->localcartage = $request->localcartage;
            $clearance->miscexplunchetc = $request->miscexplunchetc;
            $clearance->customsepoy = $request->customsepoy;
            $clearance->weighbridge = $request->weighbridge;
            $clearance->miscexpenses = $request->miscexpenses;
            $clearance->agencychrgs = $request->agencychrgs;
            $clearance->otherchrgs = $request->otherchrgs;
            $clearance->total = $request->total;
            $clearance->cleared = 2;

            $clearance->save();
            DB::commit();
            Session::flash('success',"Clearance Updated");
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function destroy(Clearance $clearance)
    {
        //
    }
}
