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

use App\Models\Godownpr;
use App\Models\GodownprDetails;



class GodownprController extends Controller
{

    public function __construct(){ $this->middleware('auth'); }

    public function index()
    {
        return view('godownpr.index');
    }

    public function getMaster(Request $request)
    {
        $status =$request->status ;
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $cis = Godownpr::where('status',$status)
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
        $contractDetails = GodownprDetails::where('gprid',$request->id)
        ->paginate((int) $size);
        return $contractDetails;
    }

    public function getContractDetails(Request $request)
    {
        $id = $request->id;
        // $contractDetails = ContractDetails::with('material.hscodes')->where('contract_id',$id)->get();

        // $contractDetails = DB::table('vwfrmpendcontractsdtl')->where('contract_id',$id)->get();
        $contractDetails = DB::select('call procfrmpendprinvsdtl(?)',array( $id ));
        return response()->json($contractDetails, 200);
    }

    public function getMasterpendipurnvs(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $contracts = DB::table('vwfrmpendlocprinvs')
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

        $maxpurseqid = DB::table('godownprs')->select('*')->max('gpno')+1;
        return \view ('godownpr.create',compact('maxpurseqid'));
        // ->with('suppliers',Supplier::select('id','title')->get());





    }

    public function store(Request $request)
    {
        //    dd($request->all());
        // $comminvoice = $request->comminvoice;
         $godownpr = $request->godownpr;

        DB::beginTransaction();
        try {
            //  Commercial Invoice Master
            $ci = new Godownpr();
            // dd($request->contract_id);
            $ci->contract_id = $request->contract_id;
            $ci->cominvid = $request->cominvid;
            $ci->contract_date = $request->contract_date;
            $ci->purinvsno = $request->purinvsno;
            $ci->supplier_id = $request->supplier_id;
            $ci->gpno = $request->purseqid;
            $ci->gpdate = $request->purdate;
            $ci->save();


            //  Commercial Invoice Details
            foreach ($godownpr as $cid) {
                $c = new GodownprDetails();
                $c->gprid = $ci->id;
                $c->tcontract_id = $ci->contract_id;

                // $c->contract_id = $request->contract_id;
                $c->material_id = $cid['material_id'];
                $c->sku_id = $cid['sku_id'];
                $c->prgpwte13 = $cid['purwte13'];
                $c->prgppcse13 = $cid['purpcse13'];
                $c->prgpfeete13 = $cid['purfeete13'];

                $c->prgpwtgn2 = $cid['purwtgn2'];
                $c->prgppcsgn2 = $cid['purpcsgn2'];
                $c->prgpfeetgn2 = $cid['purfeetgn2'];

                $c->prgpwtams = $cid['purwtams'];
                $c->prgppcsams = $cid['purpcsams'];
                $c->prgpfeetams = $cid['purfeetams'];

                $c->prgpwte24 = $cid['purwte24'];
                $c->prgppcse24 = $cid['purpcse24'];
                $c->prgpfeete24 = $cid['purfeete24'];

                $c->prgpwtbs = $cid['purwtbs'];
                $c->prgppcsbs = $cid['purpcsbs'];
                $c->prgpfeetbs = $cid['purfeetbs'];

                $c->prgpwtoth = $cid['purwtoth'];
                $c->prgppcsoth = $cid['purpcsoth'];
                $c->prgpfeetoth = $cid['purfeetoth'];

                $c->prgpwttot = $cid['purwttot'];
                $c->prgppcstot = $cid['purpcstot'];
                $c->prgpfeettot = $cid['purfeettot'];

                $c->prgpkgrate = $cid['gdsprice'];
                $c->prgppcsrate = $cid['gdsprice'];
                $c->prgpfeetrate = $cid['gdsprice'];


                // $c->length = $cid['length'];
                // $c->brand = $cid['brand'];
                // $c->repname = $cid['repname'];

                // $c->gdsprice = $cid['gdsprice'];
                // $c->invsrate = $cid['invsrate'];
                // $c->bundle1 = $cid['bundle1'];
                // $c->bundle2 = $cid['bundle2'];


                $c->save();

            }


            DB::update(DB::raw("
            update godownprs c
            INNER JOIN (
				SELECT gprid, SUM(prgppcstot) as pcs,SUM(prgpwttot) AS wt,sum(prgpfeettot) as ft
                FROM godownpr_details where  gprid = $ci->id
                GROUP BY gprid
            ) x ON c.id = x.gprid
            SET c.purtotpcs = x.pcs,c.purtotwt=x.wt,c.purtotfeet=x.ft where  id = $ci->id
            "));

            //****################# Transfert Contract Balance to Contracts
            DB::update(DB::raw("
                    UPDATE purchase_returns c
                    INNER JOIN (
                    SELECT tcontract_id, SUM(prgppcstot) as pcs,SUM(prgpwttot) AS wt,sum(prgpfeettot) as ft
                    FROM godownpr_details where  tcontract_id = $ci->contract_id
                    GROUP BY tcontract_id
                    ) x ON c.id = x.tcontract_id
                    SET c.prbalpcs = c.prtpcs - x.pcs,c.prbalwt= c.prtwt-x.wt,c.prbalfeet=c.prtfeet-x.ft
                    where  id = $ci->contract_id  "));

                    DB::update(DB::raw("
                    UPDATE purchase_return_details c
                    INNER JOIN (
                    SELECT tcontract_id,material_id, SUM(prgppcstot) as pcs,SUM(prgpwttot) AS wt,sum(prgpfeettot) as ft
                    FROM godownpr_details where  tcontract_id = $ci->contract_id
                    GROUP BY tcontract_id,material_id
                    ) x ON c.prid = x.tcontract_id and c.material_id=x.material_id
                    SET c.prtbalpcs = c.prpcs - x.pcs,c.prtbalwt= c.prwt-x.wt,c.prtbalfeet=c.prfeet-x.ft
                    where  prid = $ci->contract_id  "));



                    DB::insert(DB::raw("
                    INSERT INTO godown_stock ( transaction_id,tdate,ttypeid,tdesc,material_id,
                    stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,stkfeete24,
                    stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue )
                     SELECT a.id,a.contract_date,5,'Purchase Return',material_id,prgpwte13*-1,prgppcse13*-1,prgpfeete13*-1,prgpwtgn2*-1,prgppcsgn2*-1,prgpfeetgn2*-1,
                     prgpwtams*-1,prgppcsams*-1,prgpfeetams*-1,prgpwte24*-1,prgppcse24*-1, prgpfeete24*-1,prgpwtbs*-1,prgppcsbs*-1,prgpfeetbs*-1,
                     prgpwtoth*-1,prgppcsoth*-1,prgpfeetoth*-1,prgpwttot*-1,prgppcstot*-1,prgpfeettot*-1,prgpkgrate,prgppcsrate,prgpfeetrate
                     ,( case b.sku_id when 1 then prgpwttot * prgpkgrate  when 2 then prgppcstot * prgppcsrate when 3 then prgpfeettot * prgpfeetrate END )*-1 AS transvalue
                     FROM godownprs a inner join godownpr_details b ON a.id=b.gprid
                    AND a.id=$ci->id
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



    $cd = DB::select('call proclocpredit(?)',array( $id ));
    $passwrd = DB::table('tblpwrd')->select('pwrdtxt')->max('pwrdtxt');
    $data=compact('cd');
        return view('godownpr.edit',compact('passwrd'))
        ->with('godownpr',Godownpr::findOrFail($id))
        ->with('supplier',Supplier::select('id','title')->get())
        ->with($data);

    }


    public function deleterec($id)
    {
    $passwrd = DB::table('tblpwrd')->select('pwrdtxtdel')->max('pwrdtxtdel');
    $cd = DB::select('call proclocpredit(?)',array( $id ));
    $data=compact('cd');
        return view('godownpr.deleterec',compact('passwrd'))
        ->with('godownpr',Godownpr::findOrFail($id))
        ->with('supplier',Supplier::select('id','title')->get())
        ->with($data);

    }









    public function update(Request $request, Godownpr $godownpr)
    {

        $ci = Godownpr::findOrFail($request->tranid);

        //    dd($ci);
        $godownpr = $request->godownpr;
        DB::beginTransaction();
        try {

            $ci->contract_id = $request->contract_id;
            $ci->cominvid = $request->cominvid;
            $ci->contract_date = $request->contract_date;
            $ci->purinvsno = $request->purinvsno;
            $ci->gpno = $request->purseqid;
            $ci->gpdate = $request->purdate;
            $ci->save();

            // foreach ($comminvoice as $cid) {
            //     $c = CommercialInvoiceDetails::findOrFail($cid['id']);

            foreach ($godownpr as $cid) {
                $c = GodownprDetails::findOrFail($cid['id']);
                $c->gprid = $ci->id;
                $c->tcontract_id = $ci->contract_id;
                // $c->contract_id = $request->contract_id;
                $c->material_id = $cid['material_id'];
                $c->sku_id = $cid['sku_id'];
                $c->prgpwte13 = $cid['prgpwte13'];
                $c->prgppcse13 = $cid['prgppcse13'];
                $c->prgpfeete13 = $cid['prgpfeete13'];

                $c->prgpwtgn2 = $cid['prgpwtgn2'];
                $c->prgppcsgn2 = $cid['prgppcsgn2'];
                $c->prgpfeetgn2 = $cid['prgpfeetgn2'];

                $c->prgpwtams = $cid['prgpwtams'];
                $c->prgppcsams = $cid['prgppcsams'];
                $c->prgpfeetams = $cid['prgpfeetams'];

                $c->prgpwte24 = $cid['prgpwte24'];
                $c->prgppcse24 = $cid['prgppcse24'];
                $c->prgpfeete24 = $cid['prgpfeete24'];

                $c->prgpwtbs = $cid['prgpwtbs'];
                $c->prgppcsbs = $cid['prgppcsbs'];
                $c->prgpfeetbs = $cid['prgpfeetbs'];

                $c->prgpwtoth = $cid['prgpwtoth'];
                $c->prgppcsoth = $cid['prgppcsoth'];
                $c->prgpfeetoth = $cid['prgpfeetoth'];

                $c->prgpwttot = $cid['prgpwttot'];
                $c->prgppcstot = $cid['prgppcstot'];
                $c->prgpfeettot = $cid['prgpfeettot'];

                $c->save();

            }

            DB::update(DB::raw("
            update godownprs c
            INNER JOIN (
				SELECT gprid, SUM(prgppcstot) as pcs,SUM(prgpwttot) AS wt,sum(prgpfeettot) as ft
                FROM godownpr_details where  gprid = $ci->id
                GROUP BY gprid
            ) x ON c.id = x.gprid
            SET c.purtotpcs = x.pcs,c.purtotwt=x.wt,c.purtotfeet=x.ft where  id = $ci->id
            "));


            DB::update(DB::raw("
                    UPDATE purchase_returns c
                    INNER JOIN (
                    SELECT tcontract_id, SUM(prgppcstot) as pcs,SUM(prgpwttot) AS wt,sum(prgpfeettot) as ft
                    FROM godownpr_details where  tcontract_id = $ci->contract_id
                    GROUP BY tcontract_id
                    ) x ON c.id = x.tcontract_id
                    SET c.prbalpcs = c.prtpcs - x.pcs,c.prbalwt= c.prtwt-x.wt,c.prbalfeet=c.prtfeet-x.ft
                    where  id = $ci->contract_id  "));

                    DB::update(DB::raw("
                    UPDATE purchase_return_details c
                    INNER JOIN (
                    SELECT tcontract_id,material_id, SUM(prgppcstot) as pcs,SUM(prgpwttot) AS wt,sum(prgpfeettot) as ft
                    FROM godownpr_details where  tcontract_id = $ci->contract_id
                    GROUP BY tcontract_id,material_id
                    ) x ON c.prid = x.tcontract_id and c.material_id=x.material_id
                    SET c.prtbalpcs = c.prpcs - x.pcs,c.prtbalwt= c.prwt-x.wt,c.prtbalfeet=c.prfeet-x.ft
                    where  prid = $ci->contract_id  "));


             DB::delete(DB::raw(" delete from godown_stock where ttypeid=5 and  transaction_id=$ci->id  "));

            //  DB::insert(DB::raw("
            //  INSERT INTO godown_stock ( transaction_id,tdate,ttypeid,tdesc,material_id,
            //  stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,stkfeete24,
            //  stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet )
            //   SELECT a.id,a.contract_date,5,'Purchase Return',material_id,prgpwte13*-1,prgppcse13*-1,prgpfeete13*-1,prgpwtgn2*-1,prgppcsgn2*-1,prgpfeetgn2*-1,
            //   prgpwtams*-1,prgppcsams*-1,prgpfeetams*-1,prgpwte24*-1,prgppcse24*-1,prgpfeete24*-1,prgpwtbs*-1,prgppcsbs*-1,prgpfeetbs*-1,prgpwtoth*-1,
            //   prgppcsoth*-1,prgpfeetoth*-1,prgpwttot*-1,prgppcstot*-1,prgpfeettot*-1,prgpkgrate,prgppcsrate,prgpfeetrate
            //   FROM godownprs a inner join godownpr_details b ON a.id=b.gprid
            //  AND a.id=$ci->id
            // "));

            DB::insert(DB::raw("
            INSERT INTO godown_stock ( transaction_id,tdate,ttypeid,tdesc,material_id,
            stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,stkfeete24,
            stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue )
             SELECT a.id,a.contract_date,5,'Purchase Return',material_id,prgpwte13*-1,prgppcse13*-1,prgpfeete13*-1,prgpwtgn2*-1,prgppcsgn2*-1,prgpfeetgn2*-1,
             prgpwtams*-1,prgppcsams*-1,prgpfeetams*-1,prgpwte24*-1,prgppcse24*-1, prgpfeete24*-1,prgpwtbs*-1,prgppcsbs*-1,prgpfeetbs*-1,
             prgpwtoth*-1,prgppcsoth*-1,prgpfeetoth*-1,prgpwttot*-1,prgppcstot*-1,prgpfeettot*-1,prgpkgrate,prgppcsrate,prgpfeetrate
             ,( case b.sku_id when 1 then prgpwttot * prgpkgrate  when 2 then prgppcstot * prgppcsrate when 3 then prgpfeettot * prgpfeetrate END )*-1 AS transvalue
             FROM godownprs a inner join godownpr_details b ON a.id=b.gprid
            AND a.id=$ci->id
           "));




            DB::commit();
            Session::flash('info',"Commerical Invoice#[$ci->id] Updated with Reciving# & Duty Clearance#[$ci->id]");
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function deleteBankRequest(Request $request)
    {

        DB::beginTransaction();
            try {

                DB::update(DB::raw(" update godownprs SET purtotpcs=0,purtotwt=0,purtotfeet=0 where id=$request->tranid "));
                DB::update(DB::raw(" update godownpr_details SET prgpwttot=0,prgppcstot=0,prgpfeettot=0 where gprid=$request->tranid "));
            // //****################# Transfert Contract Balance to Contracts

            DB::update(DB::raw("
                    UPDATE purchase_returns c
                    INNER JOIN (
                    SELECT tcontract_id, SUM(prgppcstot) as pcs,SUM(prgpwttot) AS wt,sum(prgpfeettot) as ft
                    FROM godownpr_details where  tcontract_id = $request->contract_id
                    GROUP BY tcontract_id
                    ) x ON c.id = x.tcontract_id
                    SET c.prbalpcs = c.prtpcs - x.pcs,c.prbalwt= c.prtwt-x.wt,c.prbalfeet=c.prtfeet-x.ft
                    where  id = $request->contract_id  "));

                    DB::update(DB::raw("
                    UPDATE purchase_return_details c
                    INNER JOIN (
                    SELECT tcontract_id,material_id, SUM(prgppcstot) as pcs,SUM(prgpwttot) AS wt,sum(prgpfeettot) as ft
                    FROM godownpr_details where  tcontract_id = $request->contract_id
                    GROUP BY tcontract_id,material_id
                    ) x ON c.prid = x.tcontract_id and c.material_id=x.material_id
                    SET c.prtbalpcs = c.prpcs - x.pcs,c.prtbalwt= c.prwt-x.wt,c.prtbalfeet=c.prfeet-x.ft
                    where  prid = $request->contract_id  "));



                DB::delete(DB::raw(" delete from godownprs where id=$request->tranid"  ));
                DB::delete(DB::raw(" delete from godownpr_details where gprid=$request->tranid   "));

                DB::delete(DB::raw(" delete from godown_stock where ttypeid=5 and  transaction_id=$request->tranid   "));

                // DB::update(DB::raw(" update contracts set closed=0 where id=$request->contract_id "));

                DB::commit();
                Session::flash('success','Record Deleted Successfully');
                return response()->json(['success'],200);

            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }
    }








}
