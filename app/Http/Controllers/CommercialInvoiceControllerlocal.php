<?php

namespace App\Http\Controllers;

use App\Models\Reciving;
use App\Models\Clearance;
use Illuminate\Http\Request;
use App\Models\ContractDetails;
use App\Models\CommercialInvoice;
use Illuminate\Support\Facades\DB;
use App\Models\RecivingPendingDetails;
use App\Models\ClearancePendingDetails;
use Illuminate\Support\Facades\Session;
use App\Models\CommercialInvoiceDetails;
use App\Models\RecivingCompletedDetails;

class CommercialInvoiceControllerlocal extends Controller
{

    public function __construct(){ $this->middleware('auth'); }

    public function index()
    {
         return view('commercialinvoiceslocal.index');
    }

    public function getMaster(Request $request)
    {
        $status =$request->status ;
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $cisl = CommercialInvoice::where('status',$status)
        ->where(function ($query) use ($search){
                $query->where('invoiceno','LIKE','%' . $search . '%');

            })
            ->whereHas('supplier', function ($query) {
                $query->where('source_id','=','1');
                // ->orWhere('source_id',1);
            })

        ->with('supplier:id,title')
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $cisl;
    }

    public function getMaster123(Request $request)
    {
        $status =$request->status ;
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //$cis = CommercialInvoice::where('status',$status)
        $cisl = DB::table('commercial_invoices')->get();
        return $cisl;

    }

    public function getDetails(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $contractDetails = CommercialInvoiceDetails::where('commercial_invoice_id',$request->id)
        // ->andWhere('source_id','=','1')
        ->paginate((int) $size);
        return $contractDetails;
    }

    // ->orWhere('challanno','LIKE','%' . $search . '%');

    public function getContractDetails(Request $request)
    {
        $id = $request->id;
        $contractDetails = ContractDetails::with('material.hscodes')
        ->where('contract_id',$id)->get();


         return response()->json($contractDetails, 200);
    }

    public function create()
    {
        return view('commercialinvoiceslocal.create');
    }

    public function store(Request $request)
    {
        //   dd($request->all());
        $comminvoice = $request->comminvoice;
        DB::beginTransaction();
        try {


            //  Commercial Invoice Master
            $ci = new CommercialInvoice();
            $ci->invoice_date = $request->invoicedate;
            $ci->invoiceno = $request->invoiceno;
            $ci->contract_id = $request->contract_id;
            $ci->challanno = $request->challanno;
            $ci->supplier_id = $comminvoice[0]['supplier_id'];
            $ci->machine_date = $request->machine_date;
            $ci->machineno = $request->machineno;
            $ci->conversionrate = 0;
            $ci->insurance = 0;
            $ci->bankcharges = $request->bankcharges;
            $ci->collofcustom = $request->collofcustom;
            $ci->exataxoffie = 0;
            $ci->lngnshipdochrgs = 0;
            $ci->localcartage = 0;
            $ci->miscexplunchetc = 0;
            $ci->customsepoy = 0;
            $ci->weighbridge = 0;
            $ci->miscexpenses = 0;
            $ci->agencychrgs = 0;
            $ci->otherchrgs = 0;
            $ci->total = $request->total;
            $ci->save();








            //  Create Auto Clearance Document
                    // $cl = new Clearance();
                    // $cl->commercial_invoice_id = $ci->id;
                    // $cl->invoice_date = $request->invoicedate;
                    // $cl->invoiceno = $request->invoiceno;
                    // $cl->supplier_id = $comminvoice[0]['supplier_id'];
                    // $cl->machine_date = $request->machine_date;
                    // $cl->machineno = $request->machineno;
                    // $cl->conversionrate = $request->conversionrate;
                    // $cl->insurance = $request->insurance;
                    // $cl->bankcharges = $request->bankcharges;
                    // $cl->collofcustom = $request->collofcustom;
                    // $cl->exataxoffie = $request->exataxoffie;
                    // $cl->lngnshipdochrgs = $request->lngnshipdochrgs;
                    // $cl->localcartage = $request->localcartage;
                    // $cl->miscexplunchetc = $request->miscexplunchetc;
                    // $cl->customsepoy = $request->customsepoy;
                    // $cl->weighbridge = $request->weighbridge;
                    // $cl->miscexpenses = $request->miscexpenses;
                    // $cl->agencychrgs = $request->agencychrgs;
                    // $cl->otherchrgs = $request->otherchrgs;
                    // $cl->total = $request->total;
                    // $cl->save();
            //  Create Auto Reciving
                                                        $reciving = new Reciving();
                                                        $reciving->machine_date = $ci->machine_date;
                                                        $reciving->machineno = $ci->machineno;
                                                        $reciving->supplier_id = $comminvoice[0]['supplier_id'];
                                                        $reciving->commercial_invoice_id = $ci->id;
                                                        $reciving->invoiceno = $ci->invoiceno;
                                                        $reciving->save();

            //  Commercial Invoice Details
            foreach ($comminvoice as $cid) {
                $c = new CommercialInvoiceDetails();
                $c->machine_date = $request->machine_date;
                $c->machineno = $request->machineno;
                $c->invoiceno = $request->invoiceno;
                $c->commercial_invoice_id = $ci->id;
                $c->contract_id = $cid['contract_id'];
                $c->material_id = $cid['material_id'];
                $c->supplier_id = $cid['supplier_id'];
                $c->user_id = $cid['user_id'];
                $c->category_id = $cid['category_id'];
                $c->sku_id = $cid['sku_id'];
                $c->dimension_id = $cid['dimension_id'];
                $c->source_id = $cid['source_id'];
                $c->brand_id = $cid['brand_id'];

                $c->pcs = $cid['pcs'];
                $c->gdswt = $cid['gdswt'];
                $c->inkg = $cid['inkg'];
                $c->gdsprice = $cid['gdsprice'];
                $c->amtindollar = 0;
                $c->amtinpkr = $cid['amtinpkr'];

                 $c->hscode = $cid['hscode'];
                // $c->cd = $cid['cd'];
                // $c->st = $cid['st'];
                // $c->rd = $cid['rd'];
                // $c->acd = $cid['acd'];
                // $c->ast = $cid['ast'];
                // $c->it = $cid['it'];
                // $c->wse = $cid['wsc'];

                $c->length = $cid['length'];
                //// From usman 13-12-2022
                $c->qtyinfeet = $cid['qtyinfeet'];
                ////////

                $c->itmratio = $cid['itmratio'];
                // $c->insuranceperitem = $cid['insuranceperitem'];
                // $c->amountwithoutinsurance = $cid['amountwithoutinsurance'];
                // $c->onepercentdutypkr = $cid['onepercentdutypkr'];
                // $c->pricevaluecostsheet = $cid['pricevaluecostsheet'];
                $c->totallccostwexp = $cid['totallccostwexp'];

                    // $c->cda = $cid['cda'];
                    // $c->sta = $cid['sta'];
                    // $c->rda = $cid['rda'];
                    // $c->acda = $cid['acda'];
                    // $c->asta = $cid['asta'];
                    // $c->ita = $cid['ita'];
                    // $c->wsca = $cid['wsca'];
                $c->total = $cid['total'];
                $c->perpc = $cid['perpc'];
                $c->perkg = $cid['perkg'];
                $c->perft = $cid['perft'];
                $c->otherexpenses = $cid['otherexpenses'];
                 $c->save();

                // Create Auto Pending Clearance [COpy of CIDetails]
                // $cpd = new ClearancePendingDetails();
                // $cpd->clearance_id = $cl->id;
                // $cpd->machine_date = $cl->machine_date;
                // $cpd->machineno = $cl->machineno;
                // $cpd->invoiceno = $cl->invoiceno;
                // $cpd->commercial_invoice_id =  $c->commercial_invoice_id;
                // $cpd->contract_id = $cid['contract_id'];
                // $cpd->material_id = $cid['material_id'];
                // $cpd->supplier_id = $cid['supplier_id'];
                // $cpd->user_id = $cid['user_id'];
                // $cpd->category_id = $cid['category_id'];
                // $cpd->sku_id = $cid['sku_id'];
                // $cpd->dimension_id = $cid['dimension_id'];
                // $cpd->source_id = $cid['source_id'];
                // $cpd->brand_id = $cid['brand_id'];

                // $cpd->pcs = $cid['pcs'];
                // $cpd->gdswt = $cid['gdswt'];

                // /// *** From Muhammad usman on 27-12-2022
                // $cpd->pcs_pending = $cid['pcs'];
                // $cpd->gdswt_pending = $cid['gdswt'];
                // /// *********************************

                // $cpd->inkg = $cid['inkg'];
                // $cpd->pcs = $cid['pcs'];
                // $cpd->gdswt = $cid['gdswt'];
                // $cpd->inkg = $cid['inkg'];
                // $cpd->gdsprice = $cid['gdsprice'];
                // $cpd->amtindollar = $cid['amtindollar'];
                // $cpd->amtinpkr = $cid['amtinpkr'];

                // $cpd->hscode = $cid['hscode'];
                // $cpd->cd = $cid['cd'];
                // $cpd->st = $cid['st'];
                // $cpd->rd = $cid['rd'];
                // $cpd->acd = $cid['acd'];
                // $cpd->ast = $cid['ast'];
                // $cpd->it = $cid['it'];
                // $cpd->wse = $cid['wsc'];

                // $cpd->length = $cid['length'];
                // $cpd->itmratio = $cid['itmratio'];
                // $cpd->insuranceperitem = $cid['insuranceperitem'];
                // $cpd->amountwithoutinsurance = $cid['amountwithoutinsurance'];
                // $cpd->onepercentdutypkr = $cid['onepercentdutypkr'];
                // $cpd->pricevaluecostsheet = $cid['pricevaluecostsheet'];
                // $cpd->totallccostwexp = $cid['totallccostwexp'];

                // $cpd->cda = $cid['cda'];
                // $cpd->sta = $cid['sta'];
                // $cpd->rda = $cid['rda'];
                // $cpd->acda = $cid['acda'];
                // $cpd->asta = $cid['asta'];
                // $cpd->ita = $cid['ita'];
                // $cpd->wsca = $cid['wsca'];
                // $cpd->total = $cid['total'];
                // $cpd->perpc = $cid['perpc'];
                // $cpd->perkg = $cid['perkg'];
                // $cpd->perft = $cid['perft'];
                // $cpd->otherexpenses = $cid['otherexpenses'];
                // $cpd->save();
                //  Create Auto Pending Reciving [Copy of CIDetails]
                $preciving = new RecivingPendingDetails();
                $preciving->reciving_id = $reciving->id;
                $preciving->machine_date = $request->machine_date;
                $preciving->machineno = $request->machineno;
                $preciving->supplier_id = $cid['supplier_id'];
                $preciving->commercial_invoice_id = $ci->id;
                $preciving->invoiceno = $request->invoiceno;
                $preciving->material_id = $cid['material_id'];
                $preciving->qtyinpcs = $cid['pcs'];
                $preciving->qtyinkg = $cid['gdswt'];
                $preciving->qtyinfeet = $cid['qtyinfeet']; //inkg
                $preciving->rateperpc = $cid['perpc'];
                $preciving->rateperkg = $cid['perkg'];
                $preciving->rateperft = $cid['perft'];

                /// Changed from usman on 16-12-2022
                $preciving->length = $cid['length'];
                $preciving->inkg = $cid['inkg'];
                //******************************** */

                $preciving->qtyinpcspending = $preciving->qtyinpcs = $cid['pcs'];
                 $preciving->save();
            }
            DB::commit();
            // Session::flash('success',"Commerical Invoice#[$ci->id] Created with Reciving#[$reciving->id] & Duty Clearance#[$cl->id]");
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function show($id)
    {
        return view('commercialinvoiceslocal.show')->with('i',CommercialInvoice::whereId($id)->with('commericalInvoiceDetails.material.hscodes')->first());
    }

    public function edit($id)
    {
        //// Marking From Usman on 15-12-2022
        // if(CommercialInvoice::hasCompletedReciving($id))
        // {
        //     Session::flash('info','You cannot edit a commercial invoice, when you already have received Goods against it');
        //     return redirect()->back();
        // }
        //** */ Marking From Usman on 15-12-2022
        return view('commercialinvoiceslocal.edit')->with('i',CommercialInvoice::whereId($id)->with('commericalInvoiceDetails.material.hscodes')->first());
    }

    public function update(Request $request, CommercialInvoice $commercialInvoice)
    {
        // dd($request->all());
        $ci = CommercialInvoice::findOrFail($request->commercial_invoice_id);
        //  FIXME:If This commerical invoice has Completed Reciving, then don't allow edit
        $cr = RecivingCompletedDetails::where('commercial_invoice_id',$ci->id)->first();
        //  Get Details
        $comminvoice = $request->comminvoice;
        DB::beginTransaction();
        try {
            //  Update Commerical Invoice
            $ci->invoice_date = $request->invoicedate;
            $ci->invoiceno = $request->invoiceno;
            $ci->challanno = $request->challanno;
            $ci->machine_date = $request->machine_date;
            $ci->machineno = $request->machineno;
            $ci->conversionrate = 1;
            $ci->insurance = 0;
            $ci->bankcharges = $request->bankcharges;
            $ci->collofcustom = $request->collofcustom;
            $ci->exataxoffie = 0;
            $ci->lngnshipdochrgs = 0;
            $ci->localcartage = 0;
            $ci->miscexplunchetc = 0;
            $ci->customsepoy = 0;
            $ci->weighbridge = 0;
            $ci->miscexpenses = 0;
            $ci->agencychrgs = 0;
            $ci->otherchrgs = 0;
            $ci->total = $request->total;
            $ci->save();
            //  Create Auto Clearance Document
            // $cl = Clearance::where('commercial_invoice_id',$ci->id)->first();
            // $cl->commercial_invoice_id = $ci->id;
            // $cl->invoice_date = $request->invoicedate;
            // $cl->invoiceno = $request->invoiceno;
            // $cl->machine_date = $request->machine_date;
            // $cl->machineno = $request->machineno;
            // $cl->conversionrate = $request->conversionrate;
            // $cl->insurance = $request->insurance;
            // $cl->bankcharges = $request->bankcharges;
            // $cl->collofcustom = $request->collofcustom;
            // $cl->exataxoffie = $request->exataxoffie;
            // $cl->lngnshipdochrgs = $request->lngnshipdochrgs;
            // $cl->localcartage = $request->localcartage;
            // $cl->miscexplunchetc = $request->miscexplunchetc;
            // $cl->customsepoy = $request->customsepoy;
            // $cl->weighbridge = $request->weighbridge;
            // $cl->miscexpenses = $request->miscexpenses;
            // $cl->agencychrgs = $request->agencychrgs;
            // $cl->otherchrgs = $request->otherchrgs;
            // $cl->total = $request->total;
            // $cl->save();
            //  Update Reciving
            $reciving = Reciving::where('commercial_invoice_id',$ci->id)->first();
            $reciving->machine_date = $ci->machine_date;
            $reciving->machineno = $ci->machineno;
            $reciving->supplier_id = $comminvoice[0]['supplier_id'];
            $reciving->commercial_invoice_id = $ci->id;
            $reciving->invoiceno = $ci->invoiceno;
            $reciving->save();

            foreach ($comminvoice as $cid) {
                $c = CommercialInvoiceDetails::findOrFail($cid['id']);
                $c->machine_date = $ci->machine_date;
                $c->machineno = $ci->machineno;
                $c->commercial_invoice_id = $cid['commercial_invoice_id'];
                $c->contract_id = $cid['contract_id'];
                $c->material_id = $cid['material_id'];
                $c->supplier_id = $cid['supplier_id'];
                $c->user_id = $cid['user_id'];
                $c->category_id = $cid['category_id'];
                $c->sku_id = $cid['sku_id'];
                $c->dimension_id = $cid['dimension_id'];
                $c->source_id = $cid['source_id'];
                $c->brand_id = $cid['brand_id'];

                $c->pcs = $cid['pcs'];
                // $c->gdswt = $cid['gdswt'];
                $c->inkg = $cid['inkg'];
                $c->qtyinfeet = $cid['qtyinfeet'];
                $c->gdsprice = $cid['gdsprice'];
                $c->amtindollar = $cid['amtindollar'];
                $c->amtinpkr = $cid['amtinpkr'];

                $c->hscode = $cid['hscode'];
                // $c->cd = $cid['cd'];
                // $c->st = $cid['st'];
                // $c->rd = $cid['rd'];
                // $c->acd = $cid['acd'];
                // $c->ast = $cid['ast'];
                // $c->it = $cid['it'];
                // $c->wse = $cid['wse'];

                $c->length = $cid['length'];
                $c->itmratio = $cid['itmratio'];
                $c->insuranceperitem = $cid['insuranceperitem'];
                $c->amountwithoutinsurance = $cid['amountwithoutinsurance'];
                $c->onepercentdutypkr = $cid['onepercentdutypkr'];
                $c->pricevaluecostsheet = $cid['pricevaluecostsheet'];
                $c->totallccostwexp = $cid['totallccostwexp'];

                // $c->cda = $cid['cda'];
                // $c->sta = $cid['sta'];
                // $c->rda = $cid['rda'];
                // $c->acda = $cid['acda'];
                // $c->asta = $cid['asta'];
                // $c->ita = $cid['ita'];
                // $c->wsca = $cid['wsca'];
                $c->total = 10000;
                // $cid['totallccostwexp'];
                $c->perpc = $cid['perpc'];
                $c->perkg = $cid['perkg'];
                $c->perft = $cid['perft'];
                $c->otherexpenses = $cid['otherexpenses'];
                $c->save();
                $preciving = RecivingPendingDetails::where('commercial_invoice_id',$cid['commercial_invoice_id'])->where('material_id',$cid['material_id'])->first();
                $preciving->reciving_id = $reciving->id;
                $preciving->machine_date = $request->machine_date;
                $preciving->machineno = $request->machineno;
                $preciving->supplier_id = $cid['supplier_id'];
                $preciving->commercial_invoice_id = $ci->id;
                $preciving->invoiceno = $request->invoiceno;
                $preciving->material_id = $cid['material_id'];
                $preciving->qtyinpcs = $cid['pcs'];
                $preciving->qtyinkg = $cid['gdswt'];
                $preciving->qtyinfeet = $cid['qtyinfeet']; //inkg
                $preciving->rateperpc = $cid['perpc'];
                $preciving->rateperkg = $cid['perkg'];
                $preciving->rateperft = $cid['perft'];

                /// Changed from usman on 16-12-2022
                $preciving->length = $cid['length'];
                $preciving->inkg = $cid['inkg'];
                //******************************** */
                $preciving->qtyinpcspending = $preciving->qtyinpcs = $cid['pcs'];
                $preciving->save();







            }
            DB::commit();
            //  Session::flash('info',"Commerical Invoice#[$ci->id] Updated with Reciving#[$reciving->id] & Duty Clearance#[$cl->id]");
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function destroy(CommercialInvoice $commercialInvoice)
    {
        //
    }
}
