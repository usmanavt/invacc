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
use App\Models\Contract;
use App\Models\CommercialInvoice;
use Illuminate\Support\Facades\DB;
use App\Models\RecivingPendingDetails;
use App\Models\ClearancePendingDetails;
use Illuminate\Support\Facades\Session;
use App\Models\CommercialInvoiceDetails;
use App\Models\PcommercialInvoiceDetails;
use App\Models\RecivingCompletedDetails;
use App\Models\PcommercialInvoice;
use App\Models\Material;
use App\Models\Packaging;
use App\Models\Sku;
use App\Models\Voucher;
use App\Models\PaymentDetail;
use App\Models\BankTransaction;
use \Mpdf\Mpdf as PDF;


class CommercialInvoiceController extends Controller
{

    public function __construct(){ $this->middleware('auth'); }

    public function index()
    {
        return view('commercialinvoices.index');
    }

    public function getMaster(Request $request)
    {
        // $status =$request->status ;
        // $search = $request->search;
        // $size = $request->size;
        // $field = $request->sort[0]["field"];     //  Nested Array
        // $dir = $request->sort[0]["dir"];         //  Nested Array
        // $cis = CommercialInvoice::where('status',$status)
        // ->where(function ($query) use ($search){
        //         $query->where('invoiceno','LIKE','%' . $search . '%')
        //         ->orWhere('invoiceno','LIKE','%' . $search . '%');
        //     })
        //     ->whereHas('supplier', function ($query) {
        //         $query->where('source_id','=','2');
        //     })
        // ->with('supplier:id,title')
        // ->orderBy($field,$dir)
        // ->paginate((int) $size);
        // return $cis;

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $cis = DB::table('vwimppurindex')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        ->where('supname', 'like', "%$search%")
        ->orWhere('machineno', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
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

        // $contractDetails = DB::table('vwfrmpendcontractsdtl')->where('contract_id',$id)->get();
        $contractDetails = DB::select('call procfrmpendpurdtl(?)',array( $id ));
        return response()->json($contractDetails, 200);
    }

    public function getMasterImp(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $contracts = DB::table('vwfrmpendpurchase')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        ->where('supname', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;


    }


    public function getMasterdc(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $contracts = DB::table('vwfrmpenddutyclear')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        ->where('supname', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;


    }








    public function create()
    {
        $pack = DB::table('packagings')->select('id AS packid','title AS packing')->get();


        $cd = DB::table('skus')->select('id AS dunitid','title AS dunit')
         ->whereIn('id',[1,2])->get();
        $data=compact('cd','pack');
        return view('commercialinvoices.create')
        ->with('hscodes',Hscode::all())
        ->with('locations',Location::select('id','title')->get())
        ->with($data);

    }

    public function store(Request $request)
    {
        //    dd($request->all());
        $comminvoice = $request->comminvoice;
        DB::beginTransaction();
        try {
            //  Commercial Invoice Master
            $ci = new CommercialInvoice();
            $ci->invoice_date = $request->invoicedate;
            $ci->invoiceno = $request->invoiceno;
            $ci->contract_id = $request->contract_id;
            $ci->comdescription = $request->comdescription;
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
            $ci->purid = $request->purid;

            // dd($request->$request->packingtype);
            $ci->packingid = $request->packingid;
            $ci->packingwt = $request->packingwt;
            $ci->packingwtbal = $request->packingwt;
            $ci->save();

            // $pcontract = Pcontract::where('contract_id',$ci->contract_id)->where('status', '=', 1)->first();
            // $vartpcs1=$pcontract->totalpcs;
            // $vartwt1=$pcontract->conversion_rate;
            // $varval1=$pcontract->insurance;
            // $pcontract->status=0;
            // $pcontract->commercial_invoice_id=$ci->id;
            // $pcontract->save();





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
                // $c->user_id = $cid['user_id'];
                // $c->category_id = $cid['category_id'];
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
                $c->total = $cid['goods_received'];
                $c->goods_received = $cid['total'];

                $c->perpc = $cid['perpc'];
                $c->perkg = $cid['perkg'];

                if ( $cid['perft']<>'infinity' )
                { $c->perft = $cid['perft']; }
                elseif ( $cid['perft']='infinity' )
                { $c->perft = 0; }


                $c->otherexpenses = $cid['otherexpenses'];
                $c->invlvlchrgs = $cid['invlvlchrgs'];
                $c->dbalwt = $cid['dutygdswt'];
                $c->dbalpcs = $cid['pcs'];
                $c->dtybal = $cid['total'];
                $c->dbundle1 = $cid['bundle1'];
                $c->dbundle2 = $cid['bundle2'];
                $c->bundle1 = $cid['bundle1'];
                $c->bundle2 = $cid['bundle2'];



                // $c->location = $cid['location'];
                // $location = Location::where("title", $cid['location'])->first();
                // $c->locid = $location->id;



                $c->save();


                // $tsumpcs3 = CommercialInvoiceDetails::where('contract_id',$c->contract_id)->where('material_id',$c->material_id)->sum('pcs');
                // $tsumval3 = CommercialInvoiceDetails::where('contract_id',$c->contract_id)->where('material_id',$c->material_id)->sum('amtindollar');


                // $tcontmbal = ContractDetails::where('contract_id',$c->contract_id)->where('material_id',$c->material_id)->first();
                // $tcontmbal->tbalwt = $tcontmbal->tbalwt - $cid['gdswt'];
                // $tcontmbal->tbalpcs=$tcontmbal->tbalpcs - $cid['pcs'];
                // $tcontmbal->tbalsupval=$tcontmbal->tbalsupval - $cid['amtindollar'];
                // $tcontmbal->save();



                // $pcontractdtl = PcontractDetails::where('contract_id',$cid['contract_id'])
                // ->where('material_id',$cid['material_id'])->where('status', '=', 1)->first();
                // $vartpcs=$pcontractdtl->totpcs - $cid['pcs'] ;
                // $vartwt=$pcontractdtl->gdswt - $cid['gdswt'] ;
                // $varval=$pcontractdtl->purval - $cid['amtindollar'];
                // $pcontractdtl->status=0;
                // $pcontractdtl->commercial_invoice_id=$ci->id;
                // $pcontractdtl->save();


                // $cpdtl = new PcontractDetails();
                // $cpdtl->contract_id = $cid['contract_id'];
                // $cpdtl->commercial_invoice_id = $ci->id;
                // $cpdtl->material_id = $cid['material_id'];
                // $cpdtl->user_id = $cid['user_id'];
                // $cpdtl->totpcs = $vartpcs;
                // $cpdtl->gdswt = $vartwt;
                // $cpdtl->purval = $varval;
                // $cpdtl->status = 1;
                // $cpdtl->closed = 0;
                // $cpdtl->save();


                // $cpdtl1 = new PcommercialInvoiceDetails();
                // $cpdtl1->commercial_invoice_id = $ci->id;
                // $cpdtl1->material_id = $cid['material_id'];
                // $cpdtl1->pcs = $cid['pcs'];
                // $cpdtl1->gdswt = $cid['dutygdswt'];
                // $cpdtl1->gdsprice = $cid['dtyrate'];
                // $cpdtl1->dutyval = $cid['dtyamtindollar'];
                // $cpdtl1->status = 1;
                // $cpdtl1->closed = 1;
                // $cpdtl1->save();

            }


            $vtotwt =  CommercialInvoiceDetails::where('commercial_invoice_id',$ci->id)->sum('gdswt');
            $vartxt = $vtotwt;
            // 'Tonage';
            $varmac = $ci->machineno;
            $vardta = $vartxt . ' ' . $varmac;

            $subhead = new Subhead();
            $subhead->head_id = 111;
            $subhead->title =  $vardta;
            $subhead->commercial_invoice_id = $ci->id;
            $subhead->status = 1;
            $subhead->ob = 0;
            $subhead->save();



                // $sumwt = $vartwt1 -  CommercialInvoiceDetails::where('commercial_invoice_id',$cpdtl->commercial_invoice_id)->sum('gdswt');
                // $sumpcs = $vartpcs1 -  CommercialInvoiceDetails::where('commercial_invoice_id',$cpdtl->commercial_invoice_id)->sum('pcs');
                // $sumval = $varval1 -  CommercialInvoiceDetails::where('commercial_invoice_id',$cpdtl->commercial_invoice_id)->sum('amtindollar');

                // $pcontract = new Pcontract();
                // $pcontract->status=1;
                // $pcontract->commercial_invoice_id=$ci->id;
                // $pcontract->supplier_id=1;
                // $pcontract->invoice_date = $request->invoicedate;
                // $pcontract->number = $request->invoiceno;
                // $pcontract->contract_id = $request->contract_id;
                // $pcontract->supplier_id = $comminvoice[0]['supplier_id'];
                // $pcontract->conversion_rate = $sumwt;
                // $pcontract->insurance = $sumval;
                // $pcontract->totalpcs = $sumpcs;

                // $pcontract->save();

                // $sumwt3 =  CommercialInvoiceDetails::where('contract_id',$c->contract_id)->sum('gdswt');
                // $sumpcs3 = CommercialInvoiceDetails::where('contract_id',$c->contract_id)->sum('pcs');
                // $sumval3 = CommercialInvoiceDetails::where('contract_id',$c->contract_id)->sum('amtindollar');
                // $contmbal = Contract::where('id',$c->contract_id)->first();
                // $contmbal->balwt = $contmbal->conversion_rate - $sumwt3;
                // $contmbal->balpcs=$contmbal->totalpcs - $sumpcs3;
                // $contmbal->balsupval=$contmbal->insurance -$sumval3;
                // $contmbal->save();

                // $pci = new PcommercialInvoice();
                // $pci->commercial_invoice_id = $cpdtl->commercial_invoice_id;
                // $pci->invoice_date = $request->invoicedate;
                // $pci->invoiceno = $request->invoiceno;
                // $pci->machine_date = $request->machine_date;
                // $pci->machineno = $request->machineno;
                // $pci->totpcs = $sumpcs3;
                // $pci->totwt = $sumwt3;
                // $pci->dutyval = $sumval3;
                // $pci->save();

            // DB::update(DB::raw("
            // UPDATE commercial_invoices c
            // INNER JOIN (
            // SELECT commercial_invoice_id, SUM(pcs) as pcs,SUM(gdswt) AS swt,sum(dutygdswt) as wt,SUM(amtindollar) AS amount
            // ,sum(total) as totduty
            // FROM commercial_invoice_details where  commercial_invoice_id = $ci->id
            // GROUP BY commercial_invoice_id
            // ) x ON c.id = x.commercial_invoice_id
            // SET c.tpcs = x.pcs,c.twt=x.wt,c.tval=x.amount,c.tduty=totduty,dutybal=totduty,c.tswt=x.swt where  commercial_invoice_id = $ci->id  "));
            DB::update(DB::raw("
            UPDATE commercial_invoices c
            INNER JOIN (
            SELECT commercial_invoice_id, SUM(pcs) as pcs,SUM(gdswt) AS swt,sum(dutygdswt) as wt,SUM(amtindollar) AS amount
            ,sum(amtinpkr) as amtinpkr,sum(total) as totduty,sum(dtyamtindollar) as dutval
            FROM commercial_invoice_details where  commercial_invoice_id = $ci->id
            GROUP BY commercial_invoice_id
            ) x ON c.id = x.commercial_invoice_id
            SET c.tpcs = x.pcs,c.twt=x.wt,c.tval=x.amount,c.invoicebal=x.amount,c.tduty=totduty,c.tvalpkr=x.amtinpkr,c.tswt=x.swt,
            c.wtbal=x.wt,
            c.tdutval=x.dutval,c.tdutvalbal=x.dutval,dutybal=totduty,c.pcsbal=x.pcs
            where  commercial_invoice_id = $ci->id "));

            //****################# Transfert Contract Balance to Contracts
            DB::update(DB::raw("
            UPDATE contracts c
            INNER JOIN (
            SELECT contract_id, SUM(tval) AS amount
            FROM commercial_invoices where  contract_id=$c->contract_id
            GROUP BY contract_id
            ) x ON c.id = x.contract_id
            SET c.balsupval=c.insurance-x.amount
            where  contract_id = $c->contract_id "));

            //****################# Transfert item wise Contract Balance from detail to detail
            DB::update(DB::raw("
            UPDATE contract_details c
            INNER JOIN (
            SELECT contract_id,material_id,SUM(amtindollar) AS amount
            FROM commercial_invoice_details where  contract_id = $c->contract_id
            GROUP BY contract_id,material_id
            ) x ON c.contract_id = x.contract_id and c.material_id=x.material_id
            SET c.tbalsupval=c.purval-x.amount WHERE  c.contract_id = $c->contract_id "));

            DB::update(DB::raw(" update purchasings set closed=0 where id=$ci->purid "));

            DB::insert(DB::raw("
            INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet,transvalue)
            SELECT a.id AS transid,a.invoice_date,'Ipurchasing',2,b.material_id,sku_id,gdswt,pcs,qtyinfeet,perkg,perpc,perft,totallccostwexp FROM commercial_invoices a INNER JOIN  commercial_invoice_details b
            ON a.id=b.commercial_invoice_id WHERE a.id=$ci->id"));



            //****################# Transfert item cost to godown stock table
            DB::update(DB::raw("
            UPDATE godown_stock c
            INNER JOIN (
            SELECT b.purid,material_id,perpc,perkg,perft,totallccostwexp
            FROM commercial_invoice_details as a inner join commercial_invoices as b
            on a.commercial_invoice_id=b.id  where  b.purid = $ci->purid
            ) x ON c.transaction_id = x.purid and c.material_id=x.material_id
            SET c.costwt=x.perkg,c.costpcs=x.perpc,c.costfeet=x.perft,c.transvalue=x.totallccostwexp WHERE  c.transaction_id = $ci->purid "));

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
        // $pack = DB::table('packagings')->select('id AS packid ','title AS packing')->get();
        // $data1=compact('pack');
        $passwrd = DB::table('tblpwrd')->select('pwrdtxt')->max('pwrdtxt');
        $cd = DB::table('skus')->select('id AS dunitid','title AS dunit')
        ->whereIn('id',[1,2])->get();
       $data=compact('cd');
        return view('commercialinvoices.edit',compact('passwrd'))
        ->with('i',CommercialInvoice::whereId($id)->with('commericalInvoiceDetails.material.hscodes')->first())
        ->with('locations',Location::select('id','title')->get())
        // ->with('pack',Packaging::select('id','title')->get())
        ->with('packaging',Packaging::all())
        ->with('hscodes',Hscode::all())
        ->with($data);
    }

    public function deleterec($id)
    {

        $passwrd = DB::table('tblpwrd')->select('pwrdtxtdel')->max('pwrdtxtdel');
        $fugp = Clearance::where('commercial_invoice_id',$id)->max('commercial_invoice_id');;
        $rcvvchr = PaymentDetail::where('invoice_id',$id)->max('invoice_id');
        $pmtvchr = BankTransaction::where('supinvid',$id)->max('supinvid');

        $cd = DB::table('skus')->select('id AS dunitid','title AS dunit')
        ->whereIn('id',[1,2])->get();
       $data=compact('cd');
        return view('commercialinvoices.deleterec',compact('passwrd','fugp','rcvvchr','pmtvchr'))
        ->with('i',CommercialInvoice::whereId($id)->with('commericalInvoiceDetails.material.hscodes')->first())
        ->with('locations',Location::select('id','title')->get())
        // ->with('pack',Packaging::select('id','title')->get())
        ->with('packaging',Packaging::all())
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
            $ci->comdescription = $request->comdescription;
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
            $ci->purid = $request->purid;
            $ci->packingid = $request->packingid;
            $ci->packingwt = $request->packingwt;
            $ci->packingwtbal = $request->packingwt;



            $ci->save();




            foreach ($comminvoice as $cid) {
                $c = CommercialInvoiceDetails::findOrFail($cid['id']);
                // $tsumwt3 =  CommercialInvoiceDetails::where('commercial_invoice_id',$ci->id)->where('material_id',$cid['material_id'])->first();


                //  $bwt=$tsumwt3->gdswt;
                //  $bpcs=$tsumwt3->pcs;
                //  $bval=$tsumwt3->amtindollar;


                $c->machine_date = $ci->machine_date;
                $c->machineno = $ci->machineno;
                $c->commercial_invoice_id = $cid['commercial_invoice_id'];
                $c->contract_id = $cid['contract_id'];
                $c->material_id = $cid['material_id'];
                $c->supplier_id = $cid['supplier_id'];
                // $c->user_id = $cid['user_id'];
                // $c->category_id = $cid['category_id'];
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
                $c->goods_received = $cid['goods_received'];

                $c->perpc = $cid['perpc'];
                $c->perkg = $cid['perkg'];
                // dd($cid['perft']);

                if ( $cid['perft']<>'infinity' )
                // dd($cid['perft']);
                { $c->perft = $cid['perft']; }
                elseif ( $cid['perft']='infinity' )
                // dd(575);
                { $c->perft = 0; }


                $c->otherexpenses =  $cid['otherexpenses'];
                $c->invlvlchrgs =  $cid['invlvlchrgs'];
                $c->dbalwt = $cid['dutygdswt'];
                $c->dbalpcs = $cid['pcs'];
                $c->dtybal = $cid['total'];
                $c->dbundle1 = $cid['bundle1'];
                $c->dbundle2 = $cid['bundle2'];
                $c->bundle1 = $cid['bundle1'];
                $c->bundle2 = $cid['bundle2'];

                $c->save();

                //  $tsumwt3 =  CommercialInvoiceDetails::where('contract_id',$c->contract_id)->where('material_id',$c->material_id) ->sum('gdswt');
                //  $tsumpcs3 = CommercialInvoiceDetails::where('contract_id',$c->contract_id)->where('material_id',$c->material_id)->sum('pcs');
                //  $tsumval3 = CommercialInvoiceDetails::where('contract_id',$c->contract_id)->where('material_id',$c->material_id)->sum('amtindollar');


                 // for Contract_details Balance

                //  $swt=0;
                //  $spcs=0;
                //  $sval=0;



                    //  *******#########################3
                // $test = DB::update(DB::raw('UPDATE users SET name='.$name.' WHERE id =3'));

            }


            $vtotwt =  CommercialInvoiceDetails::where('commercial_invoice_id',$ci->id)->sum('gdswt');
            $vartxt = $vtotwt;
            // 'Tonage';
            $varmac = $ci->machineno;
            $vardta = $vartxt . ' ' . $varmac;

            $subhead = Subhead::where('commercial_invoice_id',$ci->id)->first();
            $subhead->head_id = 111;
            $subhead->title =  $vardta;
            // $subhead->commercial_invoice_id = $ci->id;
            $subhead->status = 1;
            $subhead->ob = 0;
            $subhead->save();



            //****################# Transfert Data Summary from commercial_invoice_details to Commercial_invoices
            DB::update(DB::raw("
            UPDATE commercial_invoices c
            INNER JOIN (
            SELECT commercial_invoice_id, SUM(pcs) as pcs,SUM(gdswt) AS swt,sum(dutygdswt) as wt,SUM(amtindollar) AS amount
            ,sum(amtinpkr) as amtinpkr,sum(total) as totduty,sum(dtyamtindollar) as dutval
            FROM commercial_invoice_details where  commercial_invoice_id = $ci->id
            GROUP BY commercial_invoice_id
            ) x ON c.id = x.commercial_invoice_id
            SET c.tpcs = x.pcs,c.twt=x.wt,c.tval=x.amount,c.tduty=totduty,c.tvalpkr=x.amtinpkr,c.tswt=x.swt,c.wtbal=wt,c.tdutval=dutval,
            c.tdutvalbal=dutval,c.pcsbal=x.pcs
            where  commercial_invoice_id = $ci->id "));

            $lstrt = Clearance::where('commercial_invoice_id',$ci->id)->first();
            if(!$lstrt) {
                DB::update(DB::raw("
                UPDATE commercial_invoices c
                INNER JOIN (
                SELECT commercial_invoice_id, sum(total) as totduty
                FROM commercial_invoice_details where  commercial_invoice_id = $ci->id
                GROUP BY commercial_invoice_id
                ) x ON c.id = x.commercial_invoice_id
                SET c.dutybal=totduty where  commercial_invoice_id = $ci->id "));
                }


            //  update from clearance table
                DB::update(DB::raw("
                UPDATE commercial_invoices c
                INNER JOIN (
                 SELECT commercial_invoice_id,SUM(exataxoffie) AS clrwt,SUM(total) AS clrval FROM clearances WHERE commercial_invoice_id=$ci->id
                     GROUP BY commercial_invoice_id

                    ) x ON c.id = x.commercial_invoice_id
                SET c.wtbal=c.twt-x.clrwt,c.payed=x.clrval,c.dutybal=c.tduty-x.clrval
                WHERE  c.id = $ci->id "));


                //****################# Transfert Contract Balance to Contracts
            DB::update(DB::raw("
            UPDATE contracts c
            INNER JOIN (
            SELECT contract_id,SUM(tval) AS amount
            FROM commercial_invoices where  contract_id=$c->contract_id
            GROUP BY contract_id
            ) x ON c.id = x.contract_id
            SET c.balsupval=c.insurance-x.amount
            where  contract_id = $c->contract_id "));

            //****################# Transfert item wise Contract Balance from detail to detail
            DB::update(DB::raw("
            UPDATE contract_details c
            INNER JOIN (
            SELECT contract_id,material_id,SUM(amtindollar) AS amount
            FROM commercial_invoice_details where  contract_id = $c->contract_id
            GROUP BY contract_id,material_id
            ) x ON c.contract_id = x.contract_id and c.material_id=x.material_id
            SET c.tbalsupval=c.purval-x.amount WHERE  c.contract_id = $c->contract_id "));

            DB::delete(DB::raw(" delete from office_item_bal where ttypeid=2 and  transaction_id=$ci->id   "));

            DB::insert(DB::raw("
            INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet,transvalue)
            SELECT a.id AS transid,a.invoice_date,'Ipurchasing',2,b.material_id,sku_id,gdswt,pcs,qtyinfeet,perkg,perpc,perft,totallccostwexp FROM commercial_invoices a INNER JOIN  commercial_invoice_details b
            ON a.id=b.commercial_invoice_id WHERE a.id=$ci->id"));

//    dd($request->jv1);
if($request->jv1==1)
{
            $lstrt = Voucher::where('vgdno',$ci->machineno)->first();
            if(!$lstrt) {

                        // FOR GENERATE JV AGAINTST CLEARANCE INVOICE LEVEL EXPENSES
                        DB::insert(DB::raw("
                        INSERT INTO  vouchers(TRANSACTION,vgdno,vcominvno,document_date,transaction_type,head_id,head_title,subhead_id,subhead_title,jvno,amount,DESCRIPTION)
                        SELECT (SELECT MAX(TRANSACTION)+1  FROM vouchers) AS transaction,machineno,id,invoice_date AS document_date,'DEBIT' AS transaction_type,108 AS head_id,'MAIN HEAD COUNT' AS head_title,
                        36 AS subhead_id,'IMPORT PURCHASE' AS subhead_title,(SELECT MAX(jvno)+1  FROM vouchers) AS jvno,total AS amount,'' AS descripion
                        FROM commercial_invoices WHERE machineno='$ci->machineno'
                        UNION all
                        SELECT (SELECT MAX(TRANSACTION)+1  FROM vouchers) as transaction,machineno,b.id,b.invoice_date,'CREDIT',a.head_id,c.title AS mhead,a.subhead_id,supname AS subhead,(SELECT MAX(jvno)+1  FROM vouchers) as jvno,a.amount_fc,a.description
                        FROM bank_transactions AS a INNER join commercial_invoices AS b ON a.impgdno=b.machineno INNER JOIN heads AS c
                        ON a.head_id=c.id INNER JOIN subheads AS d ON a.subhead_id=d.id WHERE machineno='$ci->machineno' "));
                        }
            else
                        {

                            $trno=$lstrt->transaction;
                            $vjvno=$lstrt->jvno;
                            DB::delete(DB::raw(" delete FROM vouchers WHERE vcominvno=$ci->id   "));
                            DB::insert(DB::raw("
                            INSERT INTO  vouchers(TRANSACTION,vgdno,vcominvno,document_date,transaction_type,head_id,head_title,subhead_id,subhead_title,jvno,amount,DESCRIPTION)
                            SELECT $trno AS transaction,machineno,id,invoice_date AS document_date,'DEBIT' AS transaction_type,108 AS head_id,'MAIN HEAD COUNT' AS head_title,
                            36 AS subhead_id,'IMPORT PURCHASE' AS subhead_title,$vjvno AS jvno,total AS amount,'' AS descripion
                            FROM commercial_invoices WHERE machineno='$ci->machineno'
                            UNION all
                            SELECT $trno as transaction,machineno,b.id,b.invoice_date,'CREDIT',a.head_id,c.title AS mhead,a.subhead_id,supname AS subhead,
                            $vjvno as jvno,a.amount_fc,a.description
                            FROM bank_transactions AS a INNER join commercial_invoices AS b ON a.impgdno=b.machineno INNER JOIN heads AS c
                            ON a.head_id=c.id INNER JOIN subheads AS d ON a.subhead_id=d.id WHERE machineno='$ci->machineno' "));


                        }

}








            //****################# Transfert item cost to godown stock table
            DB::update(DB::raw("
            UPDATE godown_stock c
            INNER JOIN (
            SELECT b.purid,material_id,perpc,perkg,perft,totallccostwexp
            FROM commercial_invoice_details as a inner join commercial_invoices as b
            on a.commercial_invoice_id=b.id  where  b.purid = $ci->purid
            ) x ON c.transaction_id = x.purid and c.material_id=x.material_id
            SET c.costwt=x.perkg,c.costpcs=x.perpc,c.costfeet=x.perft,c.transvalue=x.totallccostwexp WHERE ttypeid=2 and   c.transaction_id = $ci->purid "));






            DB::commit();
            Session::flash('info',"Commerical Invoice#[$ci->id] Updated with Reciving# & Duty Clearance#[$ci->id]");
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function getMPDFSettings($orientation = 'A4')
    {

        $format;
        $orientation == 'P' ? $format = 'A4': 'A4';

        $mpdf = new PDF( [
            'mode' => 'utf-8',
            'format' => $orientation,
            'margin_header' => '2',
            'margin_top' => '5',
            'margin_bottom' => '5',
            'margin_footer' => '2',
            'default_font_size' => 9,
            'margin_left' => '6',
            'margin_right' => '6',
        ]);
        $mpdf->showImageErrors = true;
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->debug = true;
        return $mpdf;
    }





    public function printcontract($id)
    {

            $hdng1 = '211';
            $hdng2 = '21';
            // $head_id = '1212';
            $head = '21';
            // if($request->has('subhead_id')){
            //     $subhead_id = $request->subhead_id;
                //  Clear Data from Table
                DB::table('contparameterrpt')->truncate();
                // foreach($request->subhead_id as $id)
                // {
                    DB::table('contparameterrpt')->insert([ 'GLCODE' => $id ]);
                // }
            // }
            //  Call Procedure
            // imppurdtl.blade
            // if($request->p5==0)
             $data = DB::select('call procimpcominvs()');
            // else
            // { $data = DB::select('call procipdetail()'); }
             if(!$data)
            {
                Session::flash('info','No data available');
                return redirect()->back();
            }
            $mpdf = $this->getMPDFSettings();
            $collection = collect($data);                   //  Make array a collection
            $grouped = $collection->groupBy('purid');       //  Sort collection by SupName
            $grouped->values()->all();                       //  values() removes indices of array
            foreach($grouped as $g){

                // if($report_type === 'impcominvs')
                // {
                //     if($request->p5==0)
                         $html =  view('commercialinvoices.print')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->render();
                //     else
                //     { $html =  view('purrpt.imppurdtl')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render(); }

                // }
                // if($report_type === 'impcominvs1')
                // {
                // $html =  view('purrpt.impcominvs1')->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->with('headtype',$head->title)->render();
                // }

                // $html =  view('purrpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
                $fromdate='lkl';
                $todate='ioio';

                $filename = $g[0]->purid  .'-'.$fromdate.'-'.$todate.'.pdf';
                $chunks = explode("chunk", $html);
                $mpdf->AddPage();
                foreach($chunks as $key => $val) {
                    $mpdf->WriteHTML($val);
                }

            }
            return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');
        }












    public function deleteBankRequest(Request $request)
    {


//  dd($request->invsid);
        DB::beginTransaction();
            try {

                DB::delete(DB::raw(" delete from commercial_invoices where id=$request->commercial_invoice_id   "));
                DB::delete(DB::raw(" delete from commercial_invoice_details where commercial_invoice_id=$request->commercial_invoice_id   "));

                DB::delete(DB::raw(" delete from office_item_bal where ttypeid=2 and  transaction_id=$request->commercial_invoice_id   "));

                DB::commit();


                Session::flash('success','Record Deleted Successfully');
                return response()->json(['success'],200);

            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }



    }






}
