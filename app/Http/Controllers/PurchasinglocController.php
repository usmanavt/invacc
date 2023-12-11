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
use App\Models\Sku;
use App\Models\Purchasing;
use App\Models\PurchasingDetails;
use App\Models\Supplier;



class PurchasinglocController extends Controller
{

    public function __construct(){ $this->middleware('auth'); }

    public function index()
    {
        return view('purchasingloc.index');
    }

    public function getMaster(Request $request)
    {
        $status =$request->status ;
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $cis = Purchasing::where('status',$status)
        ->where(function ($query) use ($search){
                $query->where('purinvsno','LIKE','%' . $search . '%');
                // ->orWhere('invoiceno','LIKE','%' . $search . '%');
            })
            ->whereHas('supplier', function ($query) {
                $query->where('source_id','<>','2');
            })
        ->with('supplier:id,title')
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $cis;
    }


    public function getDetails(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $contractDetails = PurchasingDetails::where('purid',$request->id)
        ->paginate((int) $size);
        return $contractDetails;
    }

    public function getContractDetails(Request $request)
    {
        $id = $request->id;
        // $contractDetails = ContractDetails::with('material.hscodes')->where('contract_id',$id)->get();

        // $contractDetails = DB::table('vwfrmpendcontractsdtl')->where('contract_id',$id)->get();
        $contractDetails = DB::select('call procfrmpendlocpurinvsdtl(?)',array( $id ));
        return response()->json($contractDetails, 200);
    }

    public function getMasterpendipurnvs(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $contracts = DB::table('vwfrmpendlocpurinvs')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        ->where('supname', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;


    }


    public function create()
    {

        // $locations = Location::select('id','title')->where('status',1)->get();

        $maxpurseqid = DB::table('purchasings')->select('*')->max('purseqid')+1;
        return \view ('purchasingloc.create',compact('maxpurseqid'));
        // ->with('suppliers',Supplier::select('id','title')->get());





    }

    public function store(Request $request)
    {
        //    dd($request->all());
        // $comminvoice = $request->comminvoice;
         $purchasingloc = $request->purchasingloc;

        DB::beginTransaction();
        try {
            //  Commercial Invoice Master
            $ci = new Purchasing();
            $ci->contract_id = $request->contract_id;
            $ci->contract_date = $request->contract_date;
            $ci->supplier_id = $request->supplier_id;
            $ci->purseqid = $request->purseqid;
            $ci->purdate = $request->purdate;
            $ci->purinvsno = $request->purinvsno;
            $ci->save();


            //  Commercial Invoice Details
            foreach ($purchasingloc as $cid) {
                $c = new PurchasingDetails();
                $c->purid = $ci->id;
                $c->contract_id = $request->contract_id;
                $c->material_id = $cid['material_id'];
                $c->sku_id = $cid['sku_id'];
                $c->purwte13 = $cid['purwte13'];
                $c->purpcse13 = $cid['purpcse13'];
                $c->purfeete13 = $cid['purfeete13'];

                $c->purwtgn2 = $cid['purwtgn2'];
                $c->purpcsgn2 = $cid['purpcsgn2'];
                $c->purfeetgn2 = $cid['purfeetgn2'];

                $c->purwtams = $cid['purwtams'];
                $c->purpcsams = $cid['purpcsams'];
                $c->purfeetams = $cid['purfeetams'];

                $c->purwte24 = $cid['purwte24'];
                $c->purpcse24 = $cid['purpcse24'];
                $c->purfeete24 = $cid['purfeete24'];

                $c->purwtbs = $cid['purwtbs'];
                $c->purpcsbs = $cid['purpcsbs'];
                $c->purfeetbs = $cid['purfeetbs'];

                $c->purwtoth = $cid['purwtoth'];
                $c->purpcsoth = $cid['purpcsoth'];
                $c->purfeetoth = $cid['purfeetoth'];

                $c->purwttot = $cid['purwttot'];
                $c->purpcstot = $cid['purpcstot'];
                $c->purfeettot = $cid['purfeettot'];

                $c->length = $cid['length'];
                $c->brand = $cid['brand'];
                $c->repname = $cid['repname'];

                $c->gdsprice = $cid['gdsprice'];
                // $c->invsrate = $cid['invsrate'];
                // $c->bundle1 = $cid['bundle1'];
                // $c->bundle2 = $cid['bundle2'];


                $c->save();

            }


            DB::update(DB::raw("
            update purchasings c
            INNER JOIN (
				SELECT purid, SUM(purpcstot) as pcs,SUM(purwttot) AS wt,sum(purfeettot) as ft
            FROM purchasing_details where  purid = $ci->id
            GROUP BY purid
            ) x ON c.id = x.purid
            SET c.purtotpcs = x.pcs,c.purtotwt=x.wt,c.purtotfeet=x.ft where  purid = $ci->id
            "));

            //****################# Transfert Contract Balance to Contracts
            DB::update(DB::raw("
                    UPDATE commercial_invoices c
                    INNER JOIN (
                    SELECT contract_id, SUM(purtotpcs) as pcs,SUM(purtotwt) AS wt,SUM(purtotfeet) AS tfeet
                    FROM purchasings where  contract_id=$ci->contract_id  GROUP BY contract_id
                    ) x ON c.id = x.contract_id
                    SET c.dutybal = c.dutybal - x.pcs,c.wtbal= c.twt-x.wt,c.agencychrgs=c.miscexpenses-x.tfeet
                    where  id = $ci->contract_id  "));


            //****################# Transfert item wise Contract Balance from detail to detail
            DB::update(DB::raw("
                UPDATE commercial_invoice_details c
                INNER JOIN (
                SELECT contract_id,material_id,SUM(purpcstot) as pcs,SUM(purwttot) AS wt,SUM(purfeettot) AS tfeet
                FROM purchasing_details where  contract_id = $ci->contract_id    GROUP BY contract_id,material_id
                ) x ON c.contract_id = x.contract_id and c.material_id=x.material_id
                SET c.bundle1 = c.bundle1 - x.pcs,c.dbalwt= c.dbalwt-x.wt,c.bundle2=c.bundle2-x.tfeet WHERE  c.commercial_invoice_id = $ci->contract_id
            "));

             DB::insert(DB::raw("
             INSERT INTO godown_stock ( transaction_id,tdate,ttypeid,tdesc,material_id,
             stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,stkfeete24,
             stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue )
             SELECT a.id,a.purdate,3,'Lpurchasing',material_id,purwte13,purpcse13,purfeete13,purwtgn2,purpcsgn2,purfeetgn2,purwtams,purpcsams,purfeetams,purwte24,purpcse24,purfeete24,
             purwtbs,purpcsbs,purfeetbs,purwtoth,purpcsoth,purfeetoth,purwttot,purpcstot,purfeettot,gdsprice,gdsprice,gdsprice
             ,( case b.sku_id when 1 then purwttot * gdsprice  when 2 then purpcstot * gdsprice when 3 then purfeettot * gdsprice END ) AS transvalue
             FROM purchasings a inner join purchasing_details b ON a.id=b.purid  AND a.id=$ci->id
                         "));






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
    //     $cd = DB::table('skus')->select('id AS dunitid','title AS dunit')
    //     ->whereIn('id',[1,2])->get();
    //    $data=compact('cd');

    // $supplier = DB::table('suppliers')
    // ->join('purchasings', 'purchasings.supplier_id', '=', 'suppliers.id')
    // ->select('suppliers.id','suppliers.title as supname')
    // ->where('purchasings.id',$id)->get();
    // $data1=compact('supplier');



    $cd = DB::select('call proclocpuredit(?)',array( $id ));
    $data=compact('cd');
        return view('purchasingloc.edit')
        ->with('purchasing',Purchasing::findOrFail($id))
        ->with('supplier',Supplier::select('id','title')->get())
        ->with($data);

    }

    public function update(Request $request, Purchasing $purchasing)
    {

        $ci = Purchasing::findOrFail($request->purid);

        $purchasingloc = $request->purchasingloc;
        DB::beginTransaction();
        try {

            //  dd($request->all($request->purid));
            // $ci = Purchasing::findOrFail($request->purid);
            $ci->contract_id = $request->contract_id;
            $ci->contract_date = $request->contract_date;
            $ci->supplier_id = $request->supplier_id;
            $ci->purseqid = $request->purseqid;
            $ci->purdate = $request->purdate;
            $ci->purinvsno = $request->purinvsno;
            $ci->save();


            // foreach ($comminvoice as $cid) {
            //     $c = CommercialInvoiceDetails::findOrFail($cid['id']);

            foreach ($purchasingloc as $cid) {
                $c = PurchasingDetails::findOrFail($cid['id']);

                $c->purid = $ci->id;
                $c->contract_id = $request->contract_id;
                $c->material_id = $cid['material_id'];
                $c->sku_id = $cid['sku_id'];
                $c->purwte13 = $cid['purwte13'];
                $c->purpcse13 = $cid['purpcse13'];
                $c->purfeete13 = $cid['purfeete13'];

                $c->purwtgn2 = $cid['purwtgn2'];
                $c->purpcsgn2 = $cid['purpcsgn2'];
                $c->purfeetgn2 = $cid['purfeetgn2'];

                $c->purwtams = $cid['purwtams'];
                $c->purpcsams = $cid['purpcsams'];
                $c->purfeetams = $cid['purfeetams'];

                $c->purwte24 = $cid['purwte24'];
                $c->purpcse24 = $cid['purpcse24'];
                $c->purfeete24 = $cid['purfeete24'];

                $c->purwtbs = $cid['purwtbs'];
                $c->purpcsbs = $cid['purpcsbs'];
                $c->purfeetbs = $cid['purfeetbs'];

                $c->purwtoth = $cid['purwtoth'];
                $c->purpcsoth = $cid['purpcsoth'];
                $c->purfeetoth = $cid['purfeetoth'];

                $c->purwttot = $cid['purwttot'];
                $c->purpcstot = $cid['purpcstot'];
                $c->purfeettot = $cid['purfeettot'];

                $c->length = $cid['length'];
                $c->brand = $cid['brand'];
                $c->repname = $cid['repname'];

                $c->save();

            }


            DB::update(DB::raw("
            update purchasings c
            INNER JOIN (
				SELECT purid, SUM(purpcstot) as pcs,SUM(purwttot) AS wt,sum(purfeettot) as ft
            FROM purchasing_details where  purid = $ci->id
            GROUP BY purid
            ) x ON c.id = x.purid
            SET c.purtotpcs = x.pcs,c.purtotwt=x.wt,c.purtotfeet=x.ft where  purid = $ci->id
            "));

            //****################# Transfert Contract Balance to Contracts
            DB::update(DB::raw("
                    UPDATE commercial_invoices c
                    INNER JOIN (
                    SELECT contract_id, SUM(purtotpcs) as pcs,SUM(purtotwt) AS wt,SUM(purtotfeet) AS tfeet
                    FROM purchasings where  contract_id=$ci->contract_id  GROUP BY contract_id
                    ) x ON c.id = x.contract_id
                    SET c.dutybal = c.tpcs - x.pcs,c.wtbal= c.twt-x.wt,c.agencychrgs=c.miscexpenses-x.tfeet
                    where  id = $ci->contract_id  "));


            //****################# Transfert item wise Contract Balance from detail to detail
            DB::update(DB::raw("
                UPDATE commercial_invoice_details c
                INNER JOIN (
                SELECT contract_id,material_id,SUM(purpcstot) as pcs,SUM(purwttot) AS wt,SUM(purfeettot) AS tfeet
                FROM purchasing_details where  contract_id = $ci->contract_id    GROUP BY contract_id,material_id
                ) x ON c.contract_id = x.contract_id and c.material_id=x.material_id
                SET c.bundle1 = c.pcs - x.pcs,c.dbalwt= c.gdswt-x.wt,c.bundle2=c.qtyinfeet-x.tfeet WHERE  c.commercial_invoice_id = $ci->contract_id
            "));




            DB::delete(DB::raw(" delete from godown_stock where ttypeid=3 and  transaction_id=$ci->id  "));



        //     DB::insert(DB::raw("
        //     INSERT INTO godown_stock ( transaction_id,tdate,ttypeid,tdesc,material_id,
        //     stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,stkfeete24,
        //     stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet )
        //     SELECT a.id,a.purdate,3,'Lpurchasing',material_id,purwte13,purpcse13,purfeete13,purwtgn2,purpcsgn2,purfeetgn2,purwtams,purpcsams,purfeetams,purwte24,purpcse24,purfeete24,
        //     purwtbs,purpcsbs,purfeetbs,purwtoth,purpcsoth,purfeetoth,purwttot,purpcstot,purfeettot,gdsprice,gdsprice,gdsprice FROM purchasings a inner join purchasing_details b ON a.id=b.purid AND a.id=$ci->id
        //    "));
        DB::insert(DB::raw("
        INSERT INTO godown_stock ( transaction_id,tdate,ttypeid,tdesc,material_id,
        stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,stkfeete24,
        stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue )
        SELECT a.id,a.purdate,3,'Lpurchasing',material_id,purwte13,purpcse13,purfeete13,purwtgn2,purpcsgn2,purfeetgn2,purwtams,purpcsams,purfeetams,purwte24,purpcse24,purfeete24,
        purwtbs,purpcsbs,purfeetbs,purwtoth,purpcsoth,purfeetoth,purwttot,purpcstot,purfeettot,gdsprice,gdsprice,gdsprice
        ,( case b.sku_id when 1 then purwttot * gdsprice  when 2 then purpcstot * gdsprice when 3 then purfeettot * gdsprice END ) AS transvalue
        FROM purchasings a inner join purchasing_details b ON a.id=b.purid  AND a.id=$ci->id
                    "));





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
