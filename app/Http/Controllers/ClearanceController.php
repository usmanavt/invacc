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
use App\Models\ClearanceCompletedDetails;
use Illuminate\Support\Facades\Session;
use App\Models\CommercialInvoiceDetails;
use App\Models\RecivingCompletedDetails;
use App\Models\Bank;
use App\Models\Sku;


class ClearanceController extends Controller
{

    public function __construct(){ $this->middleware('auth'); }

    public function index()
    {
        return view('clearance.index');
    }

    public function getMaster(Request $request)
    {
        $status =$request->status ;
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $cisclr = Clearance::where('status',$status)
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
        return $cisclr;
    }

    public function getMaster123(Request $request)
    {
        $status =$request->status ;
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //$cis = CommercialInvoice::where('status',$status)
        $cisclr = DB::table('commercial_invoices')->get();
        return $cisclr;

    }

    public function getDetails(Request $request)
    {
        // dd($request->all());



        $search = $request->search;
        $size = $request->size;
         $contractDetails = ClearanceCompletedDetails::where('clearance_id',$request->id)
        //  $contractDetails = DB::table('clearance_completed_details')->where('clearance_id',$request->id)
        ->paginate((int) $size);
        return $contractDetails;

        // $search = $request->search;
        // $size = $request->size;
        // $contractDetails = DB::table('clearance_completed_details')->where('clearance_id',$request->id)
        // ->paginate((int) $size);
        // return $contractDetails;

    }

    public function getContractDetails(Request $request)
    {
        $id = $request->id;
        // $contractDetails = ContractDetails::with('material.hscodes')->where('contract_id',$id)->get();

        // $contractDetails = DB::table('vwfrmpenddutycleardtl')->where('commercial_invoice_id',$id)->get();
        $contractDetails = DB::select('call procfrmpenddutycleardtl(?)',array( $id ));
        return response()->json($contractDetails, 200);
    }

    public function create()
    {

        $cd = DB::table('skus')->select('id AS dunitid','title AS dunit')
         ->whereIn('id',[1,2])->get();
        $data=compact('cd');

        $bnk = DB::table('banks')->select('id','title')->get();
        $bdata=compact('bnk');

        return view('clearance.create')
        ->with('hscodes',Hscode::all())
        // ->with('locations',Location::select('id','title')->get())
        ->with($data)
        ->with($bdata);

    }

    public function store(Request $request)
    {
            //  dd($request->all());

        $comminvoice = $request->comminvoice;
        DB::beginTransaction();
        try {
            //  Commercial Invoice Master

            $ci = new Clearance();
            $ci->commercial_invoice_id = $request->cominvsid;
            $ci->invoiceno = $request->invoiceno;
            $ci->supplier_id = $comminvoice[0]['supplier_id'];
            $ci->machineno = $request->machineno;
            $ci->gd_date = $request->gd_date;
            $ci->gdno = $request->gdno;
            $ci->dunitid = $request->dunitid;
            $ci->conversionrate = $request->conversionrate;
            $ci->insurance = $request->insurance;
            $ci->bank_id = $request->bank_id;
            $ci->cheque_date = $request->cheque_date;
            $ci->cheque_no = $request->cheque_no;
            $ci->invoice_date = $request->invoice_date;

            $ci->save();



            //  Commercial Invoice Details
            foreach ($comminvoice as $cid) {
                $c = new ClearanceCompletedDetails();
                $c->invoiceno = $request->invoiceno;
                $c->clearance_id = $ci->id;
                $c->commercial_invoice_id = $request->cominvsid;
                $c->material_id = 0;
                $c->supplier_id = $cid['supplier_id'];
                $c->user_id = 1;
                $c->packing = $cid['packing'];
                $c->category_id = 0;
                $c->sku_id = $cid['sku_id'];
                $c->dimension_id = 1;
                $c->pcs = $cid['pcs'];
                $c->gdswt = $cid['dutygdswt'];
                $c->gdsprice = $cid['dtyrate'];
                $c->amtindollar = $cid['dtyamtindollar'];
                $c->amtinpkr = $cid['dtyamtinpkr'];

                $c->bundle1 = $cid['packingwtbal'];
                $c->pcspbundle1 = 0;
                $c->bundle2 = 0;
                $c->pcspbundle2 = 0;

                $c->hscode = $cid['hscode'];
                $c->cd = $cid['cd'];
                $c->st = $cid['st'];
                $c->rd = $cid['rd'];
                $c->acd = $cid['acd'];
                $c->ast = $cid['ast'];
                $c->it = $cid['it'];
                // $c->wse = $cid['wse'];


                $c->itmratio = $cid['dtyitmratio'];
                $c->insuranceperitem = $cid['dtyinsuranceperitem'];
                $c->amountwithoutinsurance = $cid['dtyamountwithoutinsurance'];
                $c->onepercentdutypkr = $cid['dtyonepercentdutypkr'];
                $c->dtyinsuranceperitemrs = $cid['dtyinsuranceperitemrs'];
                // $c->totallccostwexp = $cid['totallccostwexp'];

                $c->cda = $cid['cda'];
                $c->sta = $cid['sta'];
                $c->rda = $cid['rda'];
                $c->acda = $cid['acda'];
                $c->asta = $cid['asta'];
                $c->ita = $cid['ita'];
                // $c->wsca = $cid['wsca'];
                $c->total = $cid['total'];
                $c->perpc = $cid['perpc'];
                $c->perkg = $cid['perkg'];
                $c->perft = $cid['perft'];
                $c->save();
            }


                DB::update(DB::raw("
                UPDATE clearances c
                INNER JOIN (
                SELECT clearance_id, SUM(pcs) as pcs,SUM(gdswt) AS wt,SUM(total) AS payduty
                FROM clearance_completed_details where  clearance_id = $ci->id
                GROUP BY clearance_id
                ) x ON c.id = x.clearance_id
                SET c.collofcustom = x.pcs,c.exataxoffie=x.wt,c.total=x.payduty where  clearance_id = $ci->id  "));

                DB::update(DB::raw("
                UPDATE commercial_invoices c
                INNER JOIN (
                SELECT commercial_invoice_id,sum(gdswt) AS wt,sum(pcs) AS pcs,sum(amtindollar) as amtindollar,
                sum(bundle1) AS nosofpack,sum(total) AS amount FROM clearance_completed_details
                where  commercial_invoice_id = $ci->commercial_invoice_id group by commercial_invoice_id
                ) x ON c.id = x.commercial_invoice_id
                SET c.payed = x.amount,c.dutybal=c.tduty-x.amount,c.wtbal=c.twt-x.wt,c.packingwtbal=c.packingwt-x.nosofpack,
                c.tdutvalbal=c.tdutval-x.amtindollar,c.pcsbal=c.tpcs-x.pcs
                where  id = $ci->commercial_invoice_id "));

                // DB::update(DB::raw("
                // UPDATE commercial_invoice_details c
                // INNER JOIN (
                //        SELECT commercial_invoice_id,material_id,SUM(pcs) as pcs,SUM(gdswt) AS wt,SUM(total) AS amount,SUM(bundle1) AS bundle1,SUM(bundle2) AS bundle2
                //     FROM clearance_completed_details where  commercial_invoice_id = $ci->commercial_invoice_id  GROUP BY commercial_invoice_id,material_id
                //  ) x ON c.commercial_invoice_id = x.commercial_invoice_id and c.material_id=x.material_id
                // SET c.dbalwt = c.dutygdswt - x.wt,c.dbalpcs= c.pcs-x.pcs,c.dtybal=c.total-x.amount,c.dbundle1=c.bundle1-x.bundle1,c.dbundle2=c.bundle2-x.bundle2
                //     WHERE   c.commercial_invoice_id = $ci->commercial_invoice_id  "));







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
        // return view('commercialinvoices.show')->with('i',CommercialInvoice::whereId($id)->with('commericalInvoiceDetails.material.hscodes')->first());
    }



        // public function edit($id)
        // {
        //     $cd = DB::table('skus')->select('id AS dunitid','title AS dunit')
        //     ->whereIn('id',[1,2])->get();
        //    $data=compact('cd');

        //     return view('clearance.edit')
        //     ->with('i',Clearance::whereId($id)->with('commericalInvoiceDetails.material.hscodes')->first())
        //     ->with('locations',Location::select('id','title')->get())
        //     ->with('hscodes',Hscode::all());
        //     // ->with($data);
        // }

        public function edit($id)
        {

            $passwrd = DB::table('tblpwrd')->select('pwrdtxt')->max('pwrdtxt');
            return view('clearance.edit',compact('passwrd'))->with('clearance',Clearance::where('id',$id)->first())
            ->with('banks',Bank::where('status',1)->get())
            ->with('cd',Sku::whereIn('id',[1,2])->get());
        }

        public function deleterec($id)
        {

            $passwrd = DB::table('tblpwrd')->select('pwrdtxtdel')->max('pwrdtxtdel');
            return view('clearance.deleterec',compact('passwrd'))->with('clearance',Clearance::where('id',$id)->first())
            ->with('banks',Bank::where('status',1)->get())
            ->with('cd',Sku::whereIn('id',[1,2])->get());
        }




//     public function update(Request $request, CommercialInvoice $commercialInvoice)
//     {
//         // dd($request->all());
//         $ci = Clearance::findOrFail($request->commercial_invoice_id);
//         //  FIXME:If This commerical invoice has Completed Reciving, then don't allow edit
//         $cr = RecivingCompletedDetails::where('commercial_invoice_id',$ci->id)->first();
//         //  Get Details
//         $comminvoice = $request->comminvoice;
//         DB::beginTransaction();
//         try {
//             //  Update Commerical Invoice
//             $ci->invoice_date = $request->invoicedate;
//             $ci->invoiceno = $request->invoiceno;
//             // $ci->challanno = $request->challanno;
//             $ci->machine_date = $request->machine_date;
//             $ci->machineno = $request->machineno;
//             $ci->conversionrate = $request->conversionrate;
//             $ci->sconversionrate = $request->sconversionrate;
//             $ci->insurance = $request->insurance;
//             $ci->bankcharges = $request->bankcharges;
//             $ci->collofcustom = $request->collofcustom;
//             $ci->exataxoffie = $request->exataxoffie;
//             $ci->lngnshipdochrgs = $request->lngnshipdochrgs;
//             $ci->localcartage = $request->localcartage;
//             $ci->miscexplunchetc = $request->miscexplunchetc;
//             $ci->customsepoy = $request->customsepoy;
//             $ci->weighbridge = $request->weighbridge;
//             $ci->miscexpenses = $request->miscexpenses;
//             $ci->agencychrgs = $request->agencychrgs;
//             $ci->otherchrgs = $request->otherchrgs;
//             $ci->total = $request->total;
//             $ci->save();






//             //  Create Auto Clearance Document
//             $cl = Clearance::where('commercial_invoice_id',$ci->id)->first();
//             $cl->commercial_invoice_id = $ci->id;
//             $cl->invoice_date = $request->invoicedate;
//             $cl->invoiceno = $request->invoiceno;
//             $cl->machine_date = $request->machine_date;
//             $cl->machineno = $request->machineno;
//             $cl->conversionrate = $request->conversionrate;
//             $cl->insurance = $request->insurance;
//             $cl->bankcharges = $request->bankcharges;
//             $cl->collofcustom = $request->collofcustom;
//             $cl->exataxoffie = $request->exataxoffie;
//             $cl->lngnshipdochrgs = $request->lngnshipdochrgs;
//             $cl->localcartage = $request->localcartage;
//             $cl->miscexplunchetc = $request->miscexplunchetc;
//             $cl->customsepoy = $request->customsepoy;
//             $cl->weighbridge = $request->weighbridge;
//             $cl->miscexpenses = $request->miscexpenses;
//             $cl->agencychrgs = $request->agencychrgs;
//             $cl->otherchrgs = $request->otherchrgs;
//             $cl->total = $request->total;
//             $cl->save();
//             // //  Update Reciving
//             // $reciving = Reciving::where('commercial_invoice_id',$ci->id)->first();
//             // $reciving->machine_date = $ci->machine_date;
//             // $reciving->machineno = $ci->machineno;
//             // $reciving->supplier_id = $comminvoice[0]['supplier_id'];
//             // $reciving->commercial_invoice_id = $ci->id;
//             // $reciving->invoiceno = $ci->invoiceno;
//             // $reciving->save();

//             //  Update Subhead
//             $vartxt = 'Tonage';
//             $varmac = $cl->machineno;
//             $vardta = $vartxt . ' ' . $varmac;
//             $subhead = Subhead::where('commercial_invoice_id',$ci->id)->first();
//             // $subhead = new Subhead();
//             // $subhead->head_id = 111;
//             $subhead->title =  $vardta;
//             // $subhead->commercial_invoice_id = $reciving->commercial_invoice_id;
//             // $subhead->status = 1;
//             // $subhead->ob = 0;
//             $subhead->save();

//             foreach ($comminvoice as $cid) {
//                 $c = CommercialInvoiceDetails::findOrFail($cid['id']);
//                 $c->machine_date = $ci->machine_date;
//                 $c->machineno = $ci->machineno;
//                 $c->commercial_invoice_id = $cid['commercial_invoice_id'];
//                 $c->contract_id = $cid['contract_id'];
//                 $c->material_id = $cid['material_id'];
//                 $c->supplier_id = $cid['supplier_id'];
//                 $c->user_id = $cid['user_id'];
//                 $c->category_id = $cid['category_id'];
//                 $c->sku_id = $cid['sku_id'];
//                 $c->dimension_id = $cid['dimension_id'];
//                 // $c->source_id = $cid['source_id'];
//                 // $c->brand_id = $cid['brand_id'];

//                 $c->pcs = $cid['pcs'];
//                 $c->gdswt = $cid['gdswt'];
//                 $c->dutygdswt = $cid['dutygdswt'];
//                 $c->inkg = $cid['inkg'];
//                 $c->qtyinfeet = $cid['qtyinfeet'];
//                 $c->gdsprice = $cid['gdsprice'];
//                 $c->dtyrate = $cid['dtyrate'];
//                 $c->invsrate = $cid['invsrate'];
//                 $c->amtindollar = $cid['amtindollar'];
//                 $c->amtinpkr = $cid['amtinpkr'];

//                 $c->dtyamtindollar = $cid['dtyamtindollar'];
//                 $c->dtyamtinpkr = $cid['dtyamtinpkr'];

//                 $c->comamtindollar = $cid['comamtindollar'];
//                 $c->comamtinpkr = $cid['comamtinpkr'];

//                 $c->hscode = $cid['hscode'];
//                 $c->cd = $cid['cd'];
//                 $c->st = $cid['st'];
//                 $c->rd = $cid['rd'];
//                 $c->acd = $cid['acd'];
//                 $c->ast = $cid['ast'];
//                 $c->it = $cid['it'];
//                 $c->wse = $cid['wse'];

//                 $c->length = $cid['length'];
//                 $c->itmratio = $cid['itmratio'];
//                 $c->insuranceperitem = $cid['insuranceperitem'];
//                 $c->amountwithoutinsurance = $cid['amountwithoutinsurance'];
//                 $c->onepercentdutypkr = $cid['onepercentdutypkr'];
//                 $c->pricevaluecostsheet = $cid['pricevaluecostsheet'];
//                 $c->totallccostwexp = $cid['totallccostwexp'];

//                 $c->cda = $cid['cda'];
//                 $c->sta = $cid['sta'];
//                 $c->rda = $cid['rda'];
//                 $c->acda = $cid['acda'];
//                 $c->asta = $cid['asta'];
//                 $c->ita = $cid['ita'];
//                 $c->wsca = $cid['wsca'];
//                 $c->total = $cid['total'];
//                 $c->perpc = $cid['perpc'];
//                 $c->perkg = $cid['perkg'];
//                 $c->perft = $cid['perft'];
//                 $c->otherexpenses =  $cid['otherexpenses'];
//                 $c->location = $cid['location'];
//                 $location = Location::where("title", $cid['location'])->first();
//                 $c->locid = $location->id;
//                 $c->save();


//                 $pcontractdtl = PcontractDetails::where('commercial_invoice_id',$cid['commercial_invoice_id'])
//                 ->where('material_id',$cid['material_id'])
//                 ->where('status', '=', 0)->first();
//                 $vartpcs2=$pcontractdtl->totpcs - $cid['pcs'] ;
//                 $vartwt2=$pcontractdtl->gdswt - $cid['gdswt'] ;
//                 $varval2=$pcontractdtl->purval - $cid['amtindollar'];
//                 // dd($pcontractdtl->all());



//                 $pcontractdtl = PcontractDetails::where('commercial_invoice_id',$cid['commercial_invoice_id'])
//                 ->where('material_id',$cid['material_id'])
//                 ->where('status', '=', 1)->first();
//                 $pcontractdtl->totpcs=$vartpcs2;
//                 $pcontractdtl->gdswt=$vartwt2;
//                 $pcontractdtl->purval=$varval2;
//                 $pcontractdtl->save();




//                 // Update Auto Pending Clearance [COpy of CIDetails]
//                 $cpd = ClearancePendingDetails::where('commercial_invoice_id',$cid['commercial_invoice_id'])->where('material_id',$cid['material_id'])->first();
//                 $cpd->clearance_id = $cl->id;
//                 $cpd->machine_date = $cl->machine_date;
//                 $cpd->machineno = $cl->machineno;
//                 $cpd->invoiceno = $cl->invoiceno;
//                 $cpd->commercial_invoice_id =  $c->commercial_invoice_id;
//                 $cpd->contract_id = $cid['contract_id'];
//                 $cpd->material_id = $cid['material_id'];
//                 $cpd->supplier_id = $cid['supplier_id'];
//                 $cpd->user_id = $cid['user_id'];
//                 $cpd->category_id = $cid['category_id'];
//                 $cpd->sku_id = $cid['sku_id'];
//                 $cpd->dimension_id = $cid['dimension_id'];
//                 // $cpd->source_id = $cid['source_id'];
//                 // $cpd->brand_id = $cid['brand_id'];

//                 $cpd->pcs = $cid['pcs'];
//                 $cpd->gdswt = $cid['gdswt'];
//                 $cpd->inkg = $cid['inkg'];
//                 $cpd->pcs_pending = $cid['pcs'];
//                 $cpd->gdsprice = $cid['dtyrate'];
//                 // $cpd->dtyrate = $cid['dtyrate'];
//                 $cpd->amtindollar = $cid['amtindollar'];
//                 $cpd->amtinpkr = $cid['amtinpkr'];

//                 $cpd->hscode = $cid['hscode'];
//                 $cpd->cd = $cid['cd'];
//                 $cpd->st = $cid['st'];
//                 $cpd->rd = $cid['rd'];
//                 $cpd->acd = $cid['acd'];
//                 $cpd->ast = $cid['ast'];
//                 $cpd->it = $cid['it'];
//                 $cpd->wse = $cid['wse'];

//                 $cpd->length = $cid['length'];
//                 $cpd->itmratio = $cid['itmratio'];
//                 $cpd->insuranceperitem = $cid['insuranceperitem'];
//                 $cpd->amountwithoutinsurance = $cid['amountwithoutinsurance'];
//                 $cpd->onepercentdutypkr = $cid['onepercentdutypkr'];
//                 $cpd->pricevaluecostsheet = $cid['pricevaluecostsheet'];
//                 $cpd->totallccostwexp = $cid['totallccostwexp'];

//                 $cpd->cda = $cid['cda'];
//                 $cpd->sta = $cid['sta'];
//                 $cpd->rda = $cid['rda'];
//                 $cpd->acda = $cid['acda'];
//                 $cpd->asta = $cid['asta'];
//                 $cpd->ita = $cid['ita'];
//                 $cpd->wsca = $cid['wsca'];
//                 $cpd->total = $cid['total'];
//                 $cpd->perpc = $cid['perpc'];
//                 $cpd->perkg = $cid['perkg'];
//                 $cpd->perft = $cid['perft'];
//                 $cpd->otherexpenses = $cid['otherexpenses'];
//                 $cpd->save();



// //              for pcontacts edit

//                 $pcontract = Pcontract::where('commercial_invoice_id',$cpd->commercial_invoice_id)
//                 ->where('status', '=', 0)->first();
//                 $vartpcs1=$pcontract->totalpcs;
//                 $vartwt1=$pcontract->conversion_rate;
//                 $varval1=$pcontract->insurance;


//                 $sumwt = $vartwt1 -  CommercialInvoiceDetails::where('commercial_invoice_id',$cpd->commercial_invoice_id)->sum('gdswt');
//                 $sumpcs = $vartpcs1 -  CommercialInvoiceDetails::where('commercial_invoice_id',$cpd->commercial_invoice_id)->sum('pcs');
//                 $sumval = $varval1 -  CommercialInvoiceDetails::where('commercial_invoice_id',$cpd->commercial_invoice_id)->sum('amtindollar');
//                 // $sumdtyval = CommercialInvoiceDetails::where('contcommercial_invoice_idract_id',$ci->id)->sum('dutval');

//                 // $sumwt=$vartwt - $sumwt;
//                 // $sumpcs=$vartpcs - $sumpcs;
//                 // $sumval=$varval - $sumval;
//          //    dd($sumwt());
//                 // $pcontract = new Pcontract();
//                 $pcontract = Pcontract::where('commercial_invoice_id',$cpd->commercial_invoice_id)
//                 ->where('status', '=', 1)->first();
//                 $pcontract->conversion_rate = $sumwt;
//                 $pcontract->insurance = $sumval;
//                 $pcontract->totalpcs = $sumpcs;
//                 // $pcontract->dutyval = $sumdtyval;
//                 $pcontract->save();

//                 // $pcontract = Pcontract::where('commercial_invoice_id',$cpd->commercial_invoice_id)
//                 // ->where('status', '=', 1)->first();
//                 // $pcontract->conversion_rate = $sumwt;
//                 // $pcontract->insurance = $sumval;
//                 // $pcontract->totalpcs = $sumpcs;
//                 // // $pcontract->dutyval = $sumdtyval;
//                 // $pcontract->save();




// //  *******#########################3



//             }
//             DB::commit();
//             Session::flash('info',"Commerical Invoice#[$ci->id] Updated with Reciving# & Duty Clearance#[$cl->id]");
//             return response()->json(['success'],200);
//         } catch (\Throwable $th) {
//             DB::rollback();
//             throw $th;
//         }
//     }


public function update(Request $request)
    {
        //   dd($request->all());
         $dc = $request->dutyclearance;

        DB::beginTransaction();
        try {
            //  Get Clearance

            $clearance = Clearance::findOrFail($request->clearance_id);
            $clearance->invoiceno = $request->invoiceno;
            // $clearance->supplier_id = $comminvoice[0]['supplier_id'];
            $clearance->machineno = $request->machineno;
            $clearance->gd_date = $request->gd_date;
            $clearance->gdno = $request->gdno;
            $clearance->dunitid = $request->dunitid;
            $clearance->conversionrate = $request->conversionrate;
            $clearance->insurance = $request->insurance;
            $clearance->bank_id = $request->bank_id;
            $clearance->cheque_date = $request->cheque_date;
            $clearance->cheque_no = $request->cheque_no;
            $clearance->save();



            // $clearance = Clearance::findOrFail($request->clearance_id);
            // Create Completed GD
            foreach($dc as $cid)
            {
                // $dcn = new ClearanceCompletedDetails();
                 $c = ClearanceCompletedDetails::findOrFail(($cid['id']));
                // $c = ClearanceCompletedDetails::where('clearance_id',$clearance->id)->first();
                $c->invoiceno = $request->invoiceno;
                // $c->clearance_id = 1;
                $c->material_id = 0;
                $c->supplier_id = $cid['supplier_id'];
                $c->user_id = 1;
                $c->packing = $cid['packing'];
                $c->category_id = 0;
                $c->sku_id = $cid['sku_id'];
                $c->dimension_id = 1;
                $c->pcs = $cid['pcs'];
                $c->gdswt = $cid['gdswt'];
                $c->gdsprice = $cid['gdsprice'];
                $c->amtindollar = $cid['amtindollar'];
                $c->amtinpkr = $cid['amtinpkr'];

                $c->bundle1 = $cid['bundle1'];
                $c->pcspbundle1 = 0;
                $c->bundle2 = 0;
                $c->pcspbundle2 = 0;

                $c->hscode = $cid['hscode'];
                $c->cd = $cid['cd'];
                $c->st = $cid['st'];
                $c->rd = $cid['rd'];
                $c->acd = $cid['acd'];
                $c->ast = $cid['ast'];
                $c->it = $cid['it'];
                // $c->wse = $cid['wse'];
                $c->itmratio = $cid['itmratio'];
                $c->insuranceperitem = $cid['insuranceperitem'];
                $c->amountwithoutinsurance = $cid['amountwithoutinsurance'];
                $c->onepercentdutypkr = $cid['onepercentdutypkr'];
                $c->dtyinsuranceperitemrs = $cid['dtyinsuranceperitemrs'];
                $c->cda = $cid['cda'];
                $c->sta = $cid['sta'];
                $c->rda = $cid['rda'];
                $c->acda = $cid['acda'];
                $c->asta = $cid['asta'];
                $c->ita = $cid['ita'];
                // $c->wsca = $cid['wsca'];
                $c->total = $cid['total'];
                $c->perpc = $cid['perpc'];
                $c->perkg = $cid['perkg'];
                $c->perft = $cid['perft'];
                $c->save();













                // $dcn->clearance_id = $clearance->id;
                // $dcn->gdno = $request->gdno;
                // $dcn->gd_date = $request->gd_date;
                // $dcn->machine_date = $request->machine_date;
                // $dcn->machineno = $request->machineno;
                // $dcn->commercial_invoice_id = $request->commercial_invoice_id;
                // $dcn->invoiceno = $request->invoiceno;
                // // From Usman on 19-01-2023
                // $dcn->conrate = $request->conversionrate;
                // $dcn->insrnce = $request->insurance;
                // //**********************

                // $dcn->contract_id = $d['contract_id'];
                // $dcn->material_id = $d['material_id'];
                // $dcn->supplier_id = $d['supplier_id'];
                // $dcn->user_id = $d['user_id'];
                // $dcn->category_id = $d['category_id'];
                // $dcn->sku_id = $d['sku_id'];
                // $dcn->dimension_id = $d['dimension_id'];
                // $dcn->source_id = $d['source_id'];
                // $dcn->brand_id = $d['brand_id'];
                // $dcn->pcs = $d['pcs_rcv'];
                // $dcn->gdswt = $d['kg_rcv'];
                // $dcn->inkg = $d['inkg'];
                // $dcn->gdsprice = $d['gdsprice'];
                // $dcn->amtindollar = $d['amtindollar'];
                // $dcn->hscode = $d['hscode'];
                // $dcn->cd = $d['cd'];
                // $dcn->st = $d['st'];
                // $dcn->rd = $d['rd'];
                // $dcn->acd = $d['acd'];
                // $dcn->ast = $d['ast'];
                // $dcn->it = $d['it'];
                // $dcn->wse = $d['wse'];
                // $dcn->length = $d['length'];
                // $dcn->itmratio = $d['itmratio'];
                // $dcn->insuranceperitem = $d['insuranceperitem'];
                // $dcn->amountwithoutinsurance = $d['amountwithoutinsurance'];
                // $dcn->onepercentdutypkr = $d['onepercentdutypkr'];
                // $dcn->pricevaluecostsheet = $d['pricevaluecostsheet'];
                // $dcn->totallccostwexp = $d['totallccostwexp'];
                // $dcn->otherexpenses = $d['otherexpenses'];
                // $dcn->cda = $d['cda'];
                // $dcn->sta = $d['sta'];
                // $dcn->rda = $d['rda'];
                // $dcn->acda = $d['acda'];
                // $dcn->asta = $d['asta'];
                // $dcn->ita = $d['ita'];
                // $dcn->wsca = $d['wsca'];
                // $dcn->total = $d['total'];
                // $dcn->perpc = $d['perpc'];
                // $dcn->perkg = $d['perkg'];
                // $dcn->perft = $d['perft'];
                // $dcn->save();









                //                 // //  Update Pending
//                 // $dcp = ClearancePendingDetails::findOrFail($d['id']);
//                 // $pending = (int) $d['pcs_pending'] -  (int) $d['pcs_rcv'];  //  Calculate Pending
//                 // $dcp->pcs_pending =  $pending;
//                 // // $dcp->save();
//                 // $pendingkg = (int) $d['gdswt_pending'] -  (int) $d['kg_rcv'];  //  Calculate Pending
//                 // $dcp->gdswt_pending =  $pendingkg;
//                 // if($pending <= 0 or $pendingkg <= 0 )
//                 // {
//                 //     $dcp->status = 2;
//                 // }
//                 // $dcp->save();
//   }


//             // Update & Close Clearance if Completed
//             // $closeClearance = true;
//             // foreach($clearance->clearancePendingDetails as $pending)

//             // {

//             //     if($pending->status === 1)
//             //         $closeClearance = false;
//             // }
//             // if($closeClearance){
//             //     $clearance->status = 2;
//             // }

//             // $clearance->gd_date = $request->gd_date;
//             // $clearance->gdno = $request->gdno;

//             // $clearance->bank_id = $request->bank_id;
//             // $clearance->cheque_date = $request->cheque_date;
//             // $clearance->cheque_no = $request->cheque_no;


//             // $clearance->conversionrate = $request->conversionrate;
//             // $clearance->insurance = $request->insurance;
//             // $clearance->bankcharges = $request->bankcharges;
//             // $clearance->collofcustom = $request->collofcustom;
//             // $clearance->exataxoffie = $request->exataxoffie;
//             // $clearance->lngnshipdochrgs = $request->lngnshipdochrgs;
//             // $clearance->localcartage = $request->localcartage;
//             // $clearance->miscexplunchetc = $request->miscexplunchetc;
//             // $clearance->customsepoy = $request->customsepoy;
//             // $clearance->weighbridge = $request->weighbridge;
//             // $clearance->miscexpenses = $request->miscexpenses;
//             // $clearance->agencychrgs = $request->agencychrgs;
//             // $clearance->otherchrgs = $request->otherchrgs;
//             // $clearance->total = $request->total;
//             // $clearance->cleared = 2;

//             // $clearance->save();
            }

            DB::update(DB::raw("
            UPDATE clearances c
            INNER JOIN (
            SELECT clearance_id, SUM(pcs) as pcs,SUM(gdswt) AS wt,SUM(total) AS payduty
            FROM clearance_completed_details where  clearance_id = $clearance->id
            GROUP BY clearance_id
            ) x ON c.id = x.clearance_id
            SET c.collofcustom = x.pcs,c.exataxoffie=x.wt,c.total=x.payduty where  clearance_id = $clearance->id  "));

            // DB::update(DB::raw("
            // UPDATE commercial_invoices c
            // INNER JOIN (
            // SELECT commercial_invoice_id, SUM(total) AS amount,sum(exataxoffie) as wt
            // FROM clearances where  commercial_invoice_id = $clearance->commercial_invoice_id
            // GROUP BY commercial_invoice_id
            // ) x ON c.id = x.commercial_invoice_id
            // SET c.payed = x.amount,c.dutybal=c.tduty-x.amount,c.wtbal=c.twt-x.wt where  id = $clearance->commercial_invoice_id "));

            DB::update(DB::raw("
                UPDATE commercial_invoices c
                INNER JOIN (
                SELECT commercial_invoice_id,sum(gdswt) AS wt,sum(pcs) AS pcs,sum(amtindollar) as amtindollar,
                sum(bundle1) AS nosofpack,sum(total) AS amount FROM clearance_completed_details
                where  commercial_invoice_id = $clearance->commercial_invoice_id group by commercial_invoice_id
                ) x ON c.id = x.commercial_invoice_id
                SET c.payed = x.amount,c.dutybal=c.tduty-x.amount,c.wtbal=c.twt-x.wt,c.packingwtbal=c.packingwt-x.nosofpack,
                c.tdutvalbal=c.tdutval-x.amtindollar,c.pcsbal=c.tpcs-x.pcs
                where  id = $clearance->commercial_invoice_id "));


            DB::update(DB::raw("
            UPDATE commercial_invoice_details c
            INNER JOIN (
                   SELECT commercial_invoice_id,material_id,SUM(pcs) as pcs,SUM(gdswt) AS wt,SUM(total) AS amount,SUM(bundle1) AS bundle1,SUM(bundle2) AS bundle2
                FROM clearance_completed_details where  commercial_invoice_id = $clearance->commercial_invoice_id  GROUP BY commercial_invoice_id,material_id
             ) x ON c.commercial_invoice_id = x.commercial_invoice_id and c.material_id=x.material_id
            SET c.dbalwt = c.dutygdswt - x.wt,c.dbalpcs= c.pcs-x.pcs,c.dtybal=c.total-x.amount,c.dbundle1=c.bundle1-x.bundle1,c.dbundle2=c.bundle2-x.bundle2
                WHERE   c.commercial_invoice_id = $clearance->commercial_invoice_id  "));






            DB::commit();
            Session::flash('success',"Clearance Updated");
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }


    public function deleteBankRequest(Request $request)
    {


//  dd($request->invsid);
        DB::beginTransaction();
            try {


                DB::update(DB::raw(" update clearance_completed_details set gdswt=0,pcs=0,amtindollar=0,bundle1=0,total=0
                where clearance_id=$request->clearance_id  "));




                DB::update(DB::raw("
                UPDATE commercial_invoices c
                INNER JOIN (
                SELECT commercial_invoice_id,sum(gdswt) AS wt,sum(pcs) AS pcs,sum(amtindollar) as amtindollar,
                sum(bundle1) AS nosofpack,sum(total) AS amount FROM clearance_completed_details
                where  commercial_invoice_id = $request->cominvsid group by commercial_invoice_id
                ) x ON c.id = x.commercial_invoice_id
                SET c.payed = x.amount,c.dutybal=c.tduty-x.amount,c.wtbal=c.twt-x.wt,c.packingwtbal=c.packingwt-x.nosofpack,
                c.tdutvalbal=c.tdutval-x.amtindollar,c.pcsbal=c.tpcs-x.pcs
                where  id = $request->cominvsid "));


            DB::update(DB::raw("
            UPDATE commercial_invoice_details c
            INNER JOIN (
                   SELECT commercial_invoice_id,material_id,SUM(pcs) as pcs,SUM(gdswt) AS wt,SUM(total) AS amount,SUM(bundle1) AS bundle1,SUM(bundle2) AS bundle2
                FROM clearance_completed_details where  commercial_invoice_id = $request->cominvsid  GROUP BY commercial_invoice_id,material_id
             ) x ON c.commercial_invoice_id = x.commercial_invoice_id and c.material_id=x.material_id
            SET c.dbalwt = c.dutygdswt - x.wt,c.dbalpcs= c.pcs-x.pcs,c.dtybal=c.total-x.amount,c.dbundle1=c.bundle1-x.bundle1,c.dbundle2=c.bundle2-x.bundle2
                WHERE   c.commercial_invoice_id = $request->cominvsid  "));



                DB::delete(DB::raw(" delete from clearances where id=$request->clearance_id   "));
                DB::delete(DB::raw(" delete from clearance_completed_details where clearance_id=$request->clearance_id   "));

                // DB::delete(DB::raw(" delete from office_item_bal where ttypeid=2 and  transaction_id=$request->clearance_id   "));

                DB::commit();


                Session::flash('success','Record Deleted Successfully');
                return response()->json(['success'],200);

            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }



    }














}
