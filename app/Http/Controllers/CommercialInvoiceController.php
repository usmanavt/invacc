<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContractDetails;
use App\Models\CommercialInvoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\CommercialInvoiceDetails;

class CommercialInvoiceController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('commercialinvoices.index');
    }
    public function getMaster(Request $request)
    {
        // dd($request->all());
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $cis = CommercialInvoice::where(function ($query) use ($search){
                $query->where('invoiceno','LIKE','%' . $search . '%')
                ->orWhere('challanno','LIKE','%' . $search . '%');
            })

        // ->with('user:id,name','supplier:id,title')
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $cis;
    }

    public function getDetails(Request $request)
    {
        $contractDetails = CommercialInvoiceDetails::where('commercial_invoice_id',$request->id)->get();
        return $contractDetails;
    }

    public function getContractDetails(Request $request)
    {
        $id = $request->id;
        $contractDetails = ContractDetails::with('material.hscodes')->where('contract_id',$id)->get();
        return response()->json($contractDetails, 200);
    }

    public function create()
    {
        return view('commercialinvoices.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $comminvoice = $request->comminvoice;
        // dd($comminvoice[0]['supplier_id']);
        DB::beginTransaction();
        try {
            $ci = new CommercialInvoice();
            $ci->invoice_date = $request->invoicedate;
            $ci->invoiceno = $request->invoiceno;
            $ci->challanno = $request->challanno;
            $ci->supplier_id = $comminvoice[0]['supplier_id'];
            $ci->machine_date = $request->machine_date;
            $ci->machineno = $request->machineno;
            $ci->conversionrate = $request->conversionrate;
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
            $ci->total = $request->total;
            $ci->save();

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
                $c->amtindollar = $cid['amtindollar'];
                $c->amtinpkr = $cid['amtinpkr'];

                $c->hscode = $cid['hscode'];
                $c->cd = $cid['cd'];
                $c->st = $cid['st'];
                $c->rd = $cid['rd'];
                $c->acd = $cid['acd'];
                $c->ast = $cid['ast'];
                $c->it = $cid['it'];
                $c->wse = $cid['wsc'];

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
                $c->save();
            }
            DB::commit();
            Session::flash('success','Commerical Invoice Created');
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
        return view('commercialinvoices.edit')->with('i',CommercialInvoice::whereId($id)->with('commericalInvoiceDetails.material.hscodes')->first());
    }

    public function update(Request $request, CommercialInvoice $commercialInvoice)
    {
        // dd($request->all());
        $ci = CommercialInvoice::findOrFail($request->commercial_invoice_id);
        //  Get Details
        $comminvoice = $request->comminvoice;

        DB::beginTransaction();
        try {
            $ci->invoice_date = $request->invoicedate;
            $ci->invoiceno = $request->invoiceno;
            $ci->challanno = $request->challanno;
            $ci->machine_date = $request->machine_date;
            $ci->machineno = $request->machineno;
            $ci->conversionrate = $request->conversionrate;
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
            $ci->total = $request->total;
            $ci->save();


            foreach ($comminvoice as $cid) {
                $c = CommercialInvoiceDetails::findOrFail($cid['id']);
                // dd($c->id);

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
                $c->gdswt = $cid['gdswt'];
                $c->inkg = $cid['inkg'];
                $c->gdsprice = $cid['gdsprice'];
                $c->amtindollar = $cid['amtindollar'];
                $c->amtinpkr = $cid['amtinpkr'];

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
                $c->save();

            }
            DB::commit();
            Session::flash('info','Commerical Invoice Updated');
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
