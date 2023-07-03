<?php

namespace App\Http\Controllers;

use App\Models\Hscode;
use App\Models\Pcontract;
use App\Models\Subhead;
use App\Models\Location;
use App\Models\Reciving;
use App\Models\Clearance;
use Illuminate\Http\Request;
use App\Models\ContractDetails;
use App\Models\PcontractDetails;
use App\Models\CommercialInvoice;
use Illuminate\Support\Facades\DB;
use App\Models\RecivingPendingDetails;
use App\Models\ClearancePendingDetails;
use Illuminate\Support\Facades\Session;
use App\Models\CommercialInvoiceDetails;
use App\Models\PcommercialInvoiceDetails;
use App\Models\RecivingCompletedDetails;
use App\Models\PcommercialInvoice;
use App\Models\Sku;


class CommercialInvoiceController extends Controller
{

    public function __construct(){ $this->middleware('auth'); }

    public function index()
    {
        return view('commercialinvoices.index');
    }

    public function getMaster(Request $request)
    {
        $status =$request->status ;
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $cis = CommercialInvoice::where('status',$status)
        ->where(function ($query) use ($search){
                $query->where('invoiceno','LIKE','%' . $search . '%')
                ->orWhere('invoiceno','LIKE','%' . $search . '%');
            })
            ->whereHas('supplier', function ($query) {
                $query->where('source_id','=','2');
            })
        ->with('supplier:id,title')
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $cis;
    }

    public function getMaster123(Request $request)
    {
        $status =$request->status ;
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //$cis = CommercialInvoice::where('status',$status)
        $cis = DB::table('commercial_invoices')->get();
        return $cis;

    }

    public function getDetails(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $contractDetails = CommercialInvoiceDetails::where('commercial_invoice_id',$request->id)
        ->paginate((int) $size);
        return $contractDetails;
    }

    public function getContractDetails(Request $request)
    {
        $id = $request->id;
        // $contractDetails = ContractDetails::with('material.hscodes')->where('contract_id',$id)->get();

        $contractDetails = DB::table('vwfrmpendcontractsdtl')->where('contract_id',$id)->get();
        return response()->json($contractDetails, 200);
    }

    public function create()
    {
         $cd = DB::table('skus')->select('id AS dunitid','title AS dunit')
         ->whereIn('id',[1,2])->get();
        $data=compact('cd');
        return view('commercialinvoices.create')
        ->with('hscodes',Hscode::all())
        ->with('locations',Location::select('id','title')->get())
        ->with($data);

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
            // $ci->challanno = $request->challanno;
            $ci->supplier_id = $comminvoice[0]['supplier_id'];
            $ci->machine_date = $request->machine_date;
            $ci->machineno = $request->machineno;
            $ci->conversionrate = $request->conversionrate;
            $ci->sconversionrate = $request->sconversionrate;
            $ci->insurance = $request->insurance;
            $ci->bankcharges = $request->bankcharges;
            $ci->collofcustom = $request->collofcustom;
            $ci->exataxoffie = $request->exataxoffie;
            $ci->lngnshipdochrgs = $request->lngnshipdochrgs;
            $ci->localcartage = $request->localcartage;
            $ci->miscexplunchetc = $request->miscexplunchetc;
            $ci->customsepoy = $request->customsepoy;
            $ci->weighbridge = $request->weighbridge;
            $ci->miscexpenses = $request->miscexpenses;
            $ci->agencychrgs = $request->agencychrgs;
            $ci->otherchrgs = $request->otherchrgs;
            $ci->dunitid = $request->dunitid;
            $ci->total = $request->total;
            $ci->save();

            $pcontract = Pcontract::where('contract_id',$ci->contract_id)->where('status', '=', 1)->first();
            $vartpcs1=$pcontract->totalpcs;
            $vartwt1=$pcontract->conversion_rate;
            $varval1=$pcontract->insurance;
            $pcontract->status=0;
            $pcontract->commercial_invoice_id=$ci->id;
            $pcontract->save();


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
            // $reciving = new Reciving();
            // $reciving->machine_date = $ci->machine_date;
            // $reciving->machineno = $ci->machineno;
            // $reciving->supplier_id = $comminvoice[0]['supplier_id'];
            // $reciving->commercial_invoice_id = $ci->id;
            // $reciving->invoiceno = $ci->invoiceno;
            // $reciving->save();


            $vartxt = 'Tonage';
            $varmac = $ci->machineno;
            $vardta = $vartxt . ' ' . $varmac;

            $subhead = new Subhead();
            $subhead->head_id = 111;
            $subhead->title =  $vardta;
            $subhead->commercial_invoice_id = $ci->id;
            $subhead->status = 1;
            $subhead->ob = 0;
            $subhead->save();

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
                $c->pcs = $cid['pcs'];
                $c->gdswt = $cid['gdswt'];
                $c->dutygdswt = $cid['dutygdswt'];
                $c->inkg = $cid['inkg'];
                $c->gdsprice = $cid['gdsprice'];
                $c->dtyrate = $cid['dtyrate'];
                $c->invsrate = $cid['invsrate'];
                $c->amtindollar = $cid['amtindollar'];
                $c->amtinpkr = $cid['amtinpkr'];
                $c->comamtindollar = $cid['comamtindollar'];
                $c->comamtinpkr = $cid['comamtinpkr'];
                $c->dtyamtindollar = $cid['dtyamtindollar'];
                $c->dtyamtinpkr = $cid['dtyamtinpkr'];
                $c->hscode = $cid['hscode'];
                $c->cd = $cid['cd'];
                $c->st = $cid['st'];
                $c->rd = $cid['rd'];
                $c->acd = $cid['acd'];
                $c->ast = $cid['ast'];
                $c->it = $cid['it'];
                $c->wse = $cid['wse'];
                $c->length = $cid['length'];
                //// From usman 13-12-2022
                $c->qtyinfeet = $cid['qtyinfeet'];
                ////////
                $c->itmratio = $cid['itmratio'];
                $c->insuranceperitem = $cid['insuranceperitem'];
                $c->amountwithoutinsurance = $cid['amountwithoutinsurance'];
                $c->onepercentdutypkr = $cid['onepercentdutypkr'];
                $c->pricevaluecostsheet = $cid['pricevaluecostsheet'];
                $c->totallccostwexp = $cid['totallccostwexp'];
                $c->cda = $cid['cda'];
                $c->sta = $cid['sta'];
                $c->rda = $cid['rda'];
                $c->acda = $cid['acda'];
                $c->asta = $cid['asta'];
                $c->ita = $cid['ita'];
                $c->wsca = $cid['wsca'];
                $c->total = $cid['total'];
                $c->perpc = $cid['perpc'];
                $c->perkg = $cid['perkg'];
                $c->perft = $cid['perft'];
                $c->otherexpenses = $cid['otherexpenses'];
                $c->invlvlchrgs = $cid['invlvlchrgs'];
                $c->location = $cid['location'];
                $location = Location::where("title", $cid['location'])->first();
                $c->locid = $location->id;
                $c->save();

                $pcontractdtl = PcontractDetails::where('contract_id',$cid['contract_id'])
                ->where('material_id',$cid['material_id'])->where('status', '=', 1)->first();
                $vartpcs=$pcontractdtl->totpcs - $cid['pcs'] ;
                $vartwt=$pcontractdtl->gdswt - $cid['gdswt'] ;
                $varval=$pcontractdtl->purval - $cid['amtindollar'];
                $pcontractdtl->status=0;
                $pcontractdtl->commercial_invoice_id=$ci->id;
                $pcontractdtl->save();


                $cpdtl = new PcontractDetails();
                $cpdtl->contract_id = $cid['contract_id'];
                $cpdtl->commercial_invoice_id = $ci->id;
                $cpdtl->material_id = $cid['material_id'];
                $cpdtl->user_id = $cid['user_id'];
                $cpdtl->totpcs = $vartpcs;
                $cpdtl->gdswt = $vartwt;
                $cpdtl->purval = $varval;
                $cpdtl->status = 1;
                $cpdtl->closed = 0;
                $cpdtl->save();


                $cpdtl1 = new PcommercialInvoiceDetails();
                $cpdtl1->commercial_invoice_id = $ci->id;
                $cpdtl1->material_id = $cid['material_id'];
                $cpdtl1->pcs = $cid['pcs'];
                $cpdtl1->gdswt = $cid['dutygdswt'];
                $cpdtl1->gdsprice = $cid['dtyrate'];
                $cpdtl1->dutyval = $cid['dtyamtindollar'];
                $cpdtl1->status = 1;
                $cpdtl1->closed = 1;
                $cpdtl1->save();









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
                // // $cpd->source_id = $cid['source_id'];
                // // $cpd->brand_id = $cid['brand_id'];

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
                // $cpd->gdsprice = $cid['dtyrate'];
                // // $cpd->dtyrate = $cid['dtyrate'];
                // $cpd->amtindollar = $cid['amtindollar'];
                // $cpd->amtinpkr = $cid['amtinpkr'];

                // $cpd->hscode = $cid['hscode'];
                // $cpd->cd = $cid['cd'];
                // $cpd->st = $cid['st'];
                // $cpd->rd = $cid['rd'];
                // $cpd->acd = $cid['acd'];
                // $cpd->ast = $cid['ast'];
                // $cpd->it = $cid['it'];
                // $cpd->wse = $cid['wse'];

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
                // $preciving = new RecivingPendingDetails();
                // $preciving->reciving_id = $reciving->id;
                // $preciving->machine_date = $request->machine_date;
                // $preciving->machineno = $request->machineno;
                // $preciving->supplier_id = $cid['supplier_id'];
                // $preciving->commercial_invoice_id = $ci->id;
                // $preciving->invoiceno = $request->invoiceno;
                // $preciving->material_id = $cid['material_id'];
                // $preciving->qtyinpcs = $cid['pcs'];
                // $preciving->qtyinkg = $cid['gdswt'];
                // $preciving->qtyinfeet = $cid['qtyinfeet']; //inkg
                // $preciving->rateperpc = $cid['perpc'];
                // $preciving->rateperkg = $cid['perkg'];
                // $preciving->rateperft = $cid['perft'];

                // /// Changed from usman on 16-12-2022
                // $preciving->length = $cid['length'];
                // $preciving->inkg = $cid['inkg'];
                // //******************************** */

                // $preciving->qtyinpcspending = $preciving->qtyinpcs = $cid['pcs'];
                // $preciving->save();
            }


                // $vartpcs=$pcontract->totalpcs;
                // $vartwt=$pcontract->conversion_rate;
                // $varval=$pcontract->insurance;

                $sumwt = $vartwt1 -  CommercialInvoiceDetails::where('commercial_invoice_id',$cpdtl->commercial_invoice_id)->sum('gdswt');
                $sumpcs = $vartpcs1 -  CommercialInvoiceDetails::where('commercial_invoice_id',$cpdtl->commercial_invoice_id)->sum('pcs');
                $sumval = $varval1 -  CommercialInvoiceDetails::where('commercial_invoice_id',$cpdtl->commercial_invoice_id)->sum('amtindollar');
                // $sumdtyval = CommercialInvoiceDetails::where('contcommercial_invoice_idract_id',$ci->id)->sum('dutval');

                // $sumwt=$vartwt - $sumwt;
                // $sumpcs=$vartpcs - $sumpcs;
                // $sumval=$varval - $sumval;
        //    dd($sumwt());
                $pcontract = new Pcontract();
                $pcontract->status=1;
                $pcontract->commercial_invoice_id=$ci->id;
                $pcontract->supplier_id=1;
                $pcontract->invoice_date = $request->invoicedate;
                $pcontract->number = $request->invoiceno;
                $pcontract->contract_id = $request->contract_id;
                $pcontract->supplier_id = $comminvoice[0]['supplier_id'];
                $pcontract->conversion_rate = $sumwt;
                $pcontract->insurance = $sumval;
                $pcontract->totalpcs = $sumpcs;
                // $pcontract->dutyval = $sumdtyval;
                $pcontract->save();

                $sumwt3 =  CommercialInvoiceDetails::where('commercial_invoice_id',$cpdtl->commercial_invoice_id)->sum('dutygdswt');
                $sumpcs3 = CommercialInvoiceDetails::where('commercial_invoice_id',$cpdtl->commercial_invoice_id)->sum('pcs');
                $sumval3 = CommercialInvoiceDetails::where('commercial_invoice_id',$cpdtl->commercial_invoice_id)->sum('dtyamtindollar');




                $pci = new PcommercialInvoice();
                $pci->commercial_invoice_id = $cpdtl->commercial_invoice_id;
                $pci->invoice_date = $request->invoicedate;
                $pci->invoiceno = $request->invoiceno;
                $pci->machine_date = $request->machine_date;
                $pci->machineno = $request->machineno;

                $pci->totpcs = $sumpcs3;
                $pci->totwt = $sumwt3;
                $pci->dutyval = $sumval3;
                $pci->save();








            DB::commit();
            Session::flash('success',"Commerical Invoice#[$ci->id] Created with Reciving# & Duty Clearance#[$ci->id]");
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function show($id)
    {
        return view('commercialinvoices.show')->with('i',CommercialInvoice::whereId($id)->with('commericalInvoiceDetails.material.hscodes')->first());
    }

    public function edit($id)
    {
        $cd = DB::table('skus')->select('id AS dunitid','title AS dunit')
        ->whereIn('id',[1,2])->get();
       $data=compact('cd');

        return view('commercialinvoices.edit')
        ->with('i',CommercialInvoice::whereId($id)->with('commericalInvoiceDetails.material.hscodes')->first())
        ->with('locations',Location::select('id','title')->get())
        ->with('hscodes',Hscode::all())
        ->with($data);
    }

    public function update(Request $request, CommercialInvoice $commercialInvoice)
    {
        // dd($request->all());
        $ci = CommercialInvoice::findOrFail($request->commercial_invoice_id);
        //  FIXME:If This commerical invoice has Completed Reciving, then don't allow edit
        // $cr = RecivingCompletedDetails::where('commercial_invoice_id',$ci->id)->first();
        //  Get Details
        $comminvoice = $request->comminvoice;
        DB::beginTransaction();
        try {
            //  Update Commerical Invoice
            // dd($request->all());
            $ci->invoice_date = $request->invoicedate;
            $ci->invoiceno = $request->invoiceno;
            // $ci->challanno = $request->challanno;
            $ci->machine_date = $request->machine_date;
            $ci->machineno = $request->machineno;
            $ci->conversionrate = $request->conversionrate;
            $ci->sconversionrate = $request->sconversionrate;
            $ci->insurance = $request->insurance;
            $ci->bankcharges = $request->bankcharges;
            $ci->collofcustom = $request->collofcustom;
            $ci->exataxoffie = $request->exataxoffie;
            $ci->lngnshipdochrgs = $request->lngnshipdochrgs;
            $ci->localcartage = $request->localcartage;
            $ci->miscexplunchetc = $request->miscexplunchetc;
            $ci->customsepoy = $request->customsepoy;
            $ci->weighbridge = $request->weighbridge;
            $ci->miscexpenses = $request->miscexpenses;
            $ci->agencychrgs = $request->agencychrgs;
            $ci->otherchrgs = $request->otherchrgs;
            $ci->dunitid = $request->dunitid;
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
            // //  Update Reciving
            // $reciving = Reciving::where('commercial_invoice_id',$ci->id)->first();
            // $reciving->machine_date = $ci->machine_date;
            // $reciving->machineno = $ci->machineno;
            // $reciving->supplier_id = $comminvoice[0]['supplier_id'];
            // $reciving->commercial_invoice_id = $ci->id;
            // $reciving->invoiceno = $ci->invoiceno;
            // $reciving->save();

            //  Update Subhead
            $vartxt = 'Tonage';
            $varmac = $ci->machineno;
            $vardta = $vartxt . ' ' . $varmac;
            $subhead = Subhead::where('commercial_invoice_id',$ci->id)->first();
            // $subhead = new Subhead();
            // $subhead->head_id = 111;
            $subhead->title =  $vardta;
            // $subhead->commercial_invoice_id = $reciving->commercial_invoice_id;
            // $subhead->status = 1;
            // $subhead->ob = 0;
            $subhead->save();

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
                $c->pcs = $cid['pcs'];
                $c->gdswt = $cid['gdswt'];
                $c->dutygdswt = $cid['dutygdswt'];
                $c->inkg = $cid['inkg'];
                $c->qtyinfeet = $cid['qtyinfeet'];
                $c->gdsprice = $cid['gdsprice'];
                $c->dtyrate = $cid['dtyrate'];
                $c->invsrate = $cid['invsrate'];
                $c->amtindollar = $cid['amtindollar'];
                $c->amtinpkr = $cid['amtinpkr'];
                $c->dtyamtindollar = $cid['dtyamtindollar'];
                $c->dtyamtinpkr = $cid['dtyamtinpkr'];
                $c->comamtindollar = $cid['comamtindollar'];
                $c->comamtinpkr = $cid['comamtinpkr'];
                $c->hscode = $cid['hscode'];
                $c->cd = $cid['cd'];
                $c->st = $cid['st'];
                $c->rd = $cid['rd'];
                $c->acd = $cid['acd'];
                $c->ast = $cid['ast'];
                $c->it = $cid['it'];
                $c->wse = $cid['wse'];
                $c->length = $cid['length'];
                $c->itmratio = $cid['itmratio'];
                $c->insuranceperitem = $cid['insuranceperitem'];
                $c->amountwithoutinsurance = $cid['amountwithoutinsurance'];
                $c->onepercentdutypkr = $cid['onepercentdutypkr'];
                $c->pricevaluecostsheet = $cid['pricevaluecostsheet'];
                $c->totallccostwexp = $cid['totallccostwexp'];
                $c->cda = $cid['cda'];
                $c->sta = $cid['sta'];
                $c->rda = $cid['rda'];
                $c->acda = $cid['acda'];
                $c->asta = $cid['asta'];
                $c->ita = $cid['ita'];
                $c->wsca = $cid['wsca'];
                $c->total = $cid['total'];
                $c->perpc = $cid['perpc'];
                $c->perkg = $cid['perkg'];
                $c->perft = $cid['perft'];
                $c->otherexpenses =  $cid['otherexpenses'];
                $c->location = $cid['location'];
                $location = Location::where("title", $cid['location'])->first();
                $c->locid = $location->id;
                $c->save();

                // dd($c->all());

                $pcontractdtl = PcontractDetails::where('commercial_invoice_id',$ci->id)
                ->where('material_id',$cid['material_id'])
                ->where('status', '=', 0)->first();
                $vartpcs2=$pcontractdtl->totpcs - $cid['pcs'] ;
                $vartwt2=$pcontractdtl->gdswt - $cid['gdswt'] ;
                $varval2=$pcontractdtl->purval - $cid['amtindollar'];
                // dd($c->all());



                $pcontractdtl = PcontractDetails::where('commercial_invoice_id',$cid['commercial_invoice_id'])
                ->where('material_id',$cid['material_id'])
                ->where('status', '=', 1)->first();
                $pcontractdtl->totpcs=$vartpcs2;
                $pcontractdtl->gdswt=$vartwt2;
                $pcontractdtl->purval=$varval2;
                $pcontractdtl->save();




                $cpdtl1 =PcommercialInvoiceDetails::where('commercial_invoice_id',$cid['commercial_invoice_id'])
                ->where('material_id',$cid['material_id'])
                ->where('status', '=', 1)->first();
                $cpdtl1->pcs = $cid['pcs'];
                $cpdtl1->gdswt = $cid['dutygdswt'];
                $cpdtl1->gdsprice = $cid['dtyrate'];
                $cpdtl1->dutyval = $cid['dtyamtindollar'];
                $cpdtl1->save();






                // Update Auto Pending Clearance [COpy of CIDetails]
                // $cpd = ClearancePendingDetails::where('commercial_invoice_id',$cid['commercial_invoice_id'])->where('material_id',$cid['material_id'])->first();
                // $cpd->clearance_id = $ci->id;
                // $cpd->machine_date = $ci->machine_date;
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
                // // $cpd->source_id = $cid['source_id'];
                // // $cpd->brand_id = $cid['brand_id'];

                // $cpd->pcs = $cid['pcs'];
                // $cpd->gdswt = $cid['gdswt'];
                // $cpd->inkg = $cid['inkg'];
                // $cpd->pcs_pending = $cid['pcs'];
                // $cpd->gdsprice = $cid['dtyrate'];
                // // $cpd->dtyrate = $cid['dtyrate'];
                // $cpd->amtindollar = $cid['amtindollar'];
                // $cpd->amtinpkr = $cid['amtinpkr'];

                // $cpd->hscode = $cid['hscode'];
                // $cpd->cd = $cid['cd'];
                // $cpd->st = $cid['st'];
                // $cpd->rd = $cid['rd'];
                // $cpd->acd = $cid['acd'];
                // $cpd->ast = $cid['ast'];
                // $cpd->it = $cid['it'];
                // $cpd->wse = $cid['wse'];

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



//              for pcontacts edit

                $pcontract = Pcontract::where('commercial_invoice_id',$ci->id)
                ->where('status', '=', 0)->first();
                $vartpcs1=$pcontract->totalpcs;
                $vartwt1=$pcontract->conversion_rate;
                $varval1=$pcontract->insurance;


                $sumwt = $vartwt1 -  CommercialInvoiceDetails::where('commercial_invoice_id',$ci->id)->sum('gdswt');
                $sumpcs = $vartpcs1 -  CommercialInvoiceDetails::where('commercial_invoice_id',$ci->id)->sum('pcs');
                $sumval = $varval1 -  CommercialInvoiceDetails::where('commercial_invoice_id',$ci->id)->sum('amtindollar');
         //    dd($sumwt());
                $pcontract = Pcontract::where('commercial_invoice_id',$ci->id)
                ->where('status', '=', 1)->first();
                $pcontract->conversion_rate = $sumwt;
                $pcontract->insurance = $sumval;
                $pcontract->totalpcs = $sumpcs;
                // $pcontract->dutyval = $sumdtyval;
                $pcontract->save();


                $sumwt3 =  CommercialInvoiceDetails::where('commercial_invoice_id',$ci->id)->sum('dutygdswt');
                $sumpcs3 = CommercialInvoiceDetails::where('commercial_invoice_id',$ci->id)->sum('pcs');
                $sumval3 = CommercialInvoiceDetails::where('commercial_invoice_id',$ci->id)->sum('dtyamtindollar');

                $pci = PcommercialInvoice::where('commercial_invoice_id',$ci->id)
                ->where('status', '=', 1)->first();
                $pci->totpcs = $sumpcs3;
                $pci->totwt = $sumwt3;
                $pci->dutyval = $sumval3;
                $pci->save();
//  *******#########################3
            }
            DB::commit();
            Session::flash('info',"Commerical Invoice#[$ci->id] Updated with Reciving# & Duty Clearance#[$ci->id]");
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
