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
use App\Models\Gatepasse;
use App\Models\GatepasseDetails;
use App\Models\Customer;






class GatepasseController extends Controller
{

    public function __construct(){ $this->middleware('auth'); }

    public function index()
    {
        return view('gatepasse.index');
    }

    public function getMaster(Request $request)
    {
        // $status =$request->status ;
        // $search = $request->search;
        // $size = $request->size;
        // $field = $request->sort[0]["field"];     //  Nested Array
        // $dir = $request->sort[0]["dir"];         //  Nested Array
        // $cis = Gatepasse::where('status',$status)
        // ->where(function ($query) use ($search){
        //         $query->where('dcno','LIKE','%' . $search . '%');
        //         // ->orWhere('invoiceno','LIKE','%' . $search . '%');
        //     })
        //     ->whereHas('customer', function ($query) {
        //         $query->where('id','<>','1');
        //     })
        // ->with('customer:id,title')
        // ->orderBy($field,$dir)
        // ->paginate((int) $size);
        // return $cis;

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $cis = DB::table('vwgpassindex')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        ->where('custname', 'like', "%$search%")
        ->orWhere('dcno', 'like', "%$search%")
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
        $contractDetails = DB::select('call procfrmpendinvsdtl(?)',array( $id ));
        return response()->json($contractDetails, 200);
    }

    public function getMasterinvs(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $contracts = DB::table('vwfrmpendsale')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        ->where('custname', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;


    }


    public function create()
    {

        // $locations = Location::select('id','title')->where('status',1)->get();

        $maxgpseqid = DB::table('gatepasses')->select('*')->max('gpseqid')+1;
        return \view ('gatepasse.create',compact('maxgpseqid'));
        // ->with('suppliers',Supplier::select('id','title')->get());




        // $cd = DB::table('skus')->select('id AS dunitid','title AS dunit')
        //  ->whereIn('id',[1,2])->get();
        // $data=compact('cd');
        // return view('purchasing.create')
        // ->with('hscodes',Hscode::all())
        // ->with('locations',Location::select('id','title')->get())
        // ->with($data);

    }

    public function store(Request $request)
    {
        //    dd($request->all());
        // $comminvoice = $request->comminvoice;
         $gatepasse = $request->gatepasse;

        DB::beginTransaction();
        try {
            //  Commercial Invoice Master
            $ci = new Gatepasse();
            $ci->sale_invoice_id = $request->sale_invoice_id;
            $ci->saldate = $request->saldate;
            $ci->customer_id = $request->customer_id;
            $ci->gpseqid = $request->gpseqid;
            $ci->gpdate = $request->gpdate;
            $ci->dcno = $request->dcno;
            $ci->save();


            //  Commercial Invoice Details
            foreach ($gatepasse as $cid) {
                $c = new GatepasseDetails();
                $c->gpid = $ci->id;
                $c->sale_invoice_id = $request->sale_invoice_id;
                $c->material_id = $cid['material_id'];
                $c->sku_id = $cid['sku_id'];
                $c->gpwte13 = $cid['gpwte13'];
                $c->gppcse13 = $cid['gppcse13'];
                $c->gpfeete13 = $cid['gpfeete13'];

                $c->gpwtgn2 = $cid['gpwtgn2'];
                $c->gppcsgn2 = $cid['gppcsgn2'];
                $c->gpfeetgn2 = $cid['gpfeetgn2'];

                $c->gpwtams = $cid['gpwtams'];
                $c->gppcsams = $cid['gppcsams'];
                $c->gpfeetams = $cid['gpfeetams'];

                $c->gpwte24 = $cid['gpwte24'];
                $c->gppcse24 = $cid['gppcse24'];
                $c->gpfeete24 = $cid['gpfeete24'];

                $c->gpwtbs = $cid['gpwtbs'];
                $c->gppcsbs = $cid['gppcsbs'];
                $c->gpfeetbs = $cid['gpfeetbs'];

                $c->gpwtoth = $cid['gpwtoth'];
                $c->gppcsoth = $cid['gppcsoth'];
                $c->gpfeetoth = $cid['gpfeetoth'];

                $c->gpwttot = $cid['gpwttot'];
                $c->gppcstot = $cid['gppcstot'];
                $c->gpfeettot = $cid['gpfeettot'];

                // $c->length = $cid['length'];
                $c->brand = $cid['brand'];
                $c->repname = $cid['repname'];

                $c->gpkgrate = $cid['qtykgcrt'];
                $c->gppcsrate = $cid['qtypcscrt'];
                $c->gpfeetrate = $cid['qtyfeetcrt'];
                $c->save();

            }


            DB::update(DB::raw("
            update gatepasses c
            INNER JOIN (
				SELECT gpid, SUM(gppcstot) as pcs,SUM(gpwttot) AS wt,sum(gpfeettot) as ft
            FROM gatepasse_details where  gpid = $ci->id
            GROUP BY gpid

            ) x ON c.id = x.gpid
            SET c.gptotpcs = x.pcs,c.gptotwt=x.wt,c.gptotfeet=x.ft where  gpid = $ci->id
            "));

            // //****################# Transfert Contract Balance to Contracts
            DB::update(DB::raw("
            UPDATE sale_invoices c
            INNER JOIN (
                  SELECT sale_invoice_id, SUM(gptotpcs) as pcs,SUM(gptotwt) AS wt,SUM(gptotfeet) AS ft
            FROM gatepasses where  sale_invoice_id=$ci->sale_invoice_id  GROUP BY sale_invoice_id) x ON c.id = x.sale_invoice_id
            SET c.balsltpcs = c.sltpcs - x.pcs,c.balsltwt= c.sltwt-x.wt,c.balslfeet=slfeet-x.ft
            where  id = $ci->sale_invoice_id  "));

            // //****################# Transfert item wise Contract Balance from detail to detail
            DB::update(DB::raw("
            UPDATE sale_invoices_details c
            INNER JOIN (
            SELECT sale_invoice_id,material_id,SUM(gppcstot) as pcs,SUM(gpwttot) AS wt,SUM(gpfeettot) AS ft
            FROM gatepasse_details where  sale_invoice_id = $ci->sale_invoice_id   GROUP BY sale_invoice_id,material_id
            ) x ON c.sale_invoice_id = x.sale_invoice_id and c.material_id=x.material_id
            SET c.salepcs = c.qtypcs - x.pcs,c.salewt= c.qtykg-x.wt,c.salefeet=c.qtyfeet-ft WHERE  c.sale_invoice_id = $ci->sale_invoice_id
            "));

             DB::insert(DB::raw("
             INSERT INTO godown_stock ( transaction_id,tdate,ttypeid,tdesc,material_id,
             stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,stkfeete24,
             stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue )
             SELECT a.id,a.gpdate,4,'gatepass',material_id,gpwte13*-1,gppcse13*-1,gpfeete13*-1,gpwtgn2*-1,gppcsgn2*-1,gpfeetgn2*-1,gpwtams*-1,gppcsams*-1,gpfeetams*-1,gpwte24*-1,gppcse24*-1,gpfeete24*-1,
             gpwtbs*-1,gppcsbs*-1,gpfeetbs*-1,gpwtoth*-1,gppcsoth*-1,gpfeetoth*-1,gpwttot*-1,gppcstot*-1,gpfeettot*-1
             , gpkgrate,gppcsrate,gpfeetrate
             ,( case b.sku_id when 1 then gpwttot * gpkgrate  when 2 then gppcstot * gppcsrate when 3 then gpfeettot * gpfeetrate END )*-1 AS transvalue
             FROM gatepasses a inner JOIN gatepasse_details b ON a.id=b.gpid AND a.id=$ci->id

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

    $passwrd = DB::table('tblpwrd')->select('pwrdtxt')->max('pwrdtxt');
    $cd = DB::select('call procgpedit(?)',array( $id ));
     $data=compact('cd');
        return view('gatepasse.edit',compact('passwrd'))
        ->with('gatepasse',Gatepasse::findOrFail($id))
        ->with('customer',Customer::select('id','title')->get())
         ->with($data);

    }


    public function deleterec($id)
    {

    $passwrd = DB::table('tblpwrd')->select('pwrdtxtdel')->max('pwrdtxtdel');
    $cd = DB::select('call procgpedit(?)',array( $id ));
     $data=compact('cd');
        return view('gatepasse.deleterec',compact('passwrd'))
        ->with('gatepasse',Gatepasse::findOrFail($id))
        ->with('customer',Customer::select('id','title')->get())
         ->with($data);

    }







    public function update(Request $request, Gatepasse $gatepasse)
    {

        // dd($request->gpid);
        $ci = Gatepasse::findOrFail($request->gpid);

        $gatepasse = $request->gatepasse;
        DB::beginTransaction();
        try {

            //  dd($request->all($request->purid));

            $ci->sale_invoice_id = $request->sale_invoice_id;
            $ci->saldate = $request->saldate;
            $ci->customer_id = $request->customer_id;
            $ci->gpseqid = $request->gpseqid;
            $ci->gpdate = $request->gpdate;
            $ci->dcno = $request->dcno;
            $ci->save();


            // foreach ($comminvoice as $cid) {
            //     $c = CommercialInvoiceDetails::findOrFail($cid['id']);

            foreach ($gatepasse as $cid) {
                $c = GatepasseDetails::findOrFail($cid['id']);

                $c->gpid = $ci->id;
                $c->sale_invoice_id = $request->sale_invoice_id;
                $c->material_id = $cid['material_id'];
                $c->sku_id = $cid['sku_id'];
                $c->gpwte13 = $cid['gpwte13'];
                $c->gppcse13 = $cid['gppcse13'];
                $c->gpfeete13 = $cid['gpfeete13'];

                $c->gpwtgn2 = $cid['gpwtgn2'];
                $c->gppcsgn2 = $cid['gppcsgn2'];
                $c->gpfeetgn2 = $cid['gpfeetgn2'];

                $c->gpwtams = $cid['gpwtams'];
                $c->gppcsams = $cid['gppcsams'];
                $c->gpfeetams = $cid['gpfeetams'];

                $c->gpwte24 = $cid['gpwte24'];
                $c->gppcse24 = $cid['gppcse24'];
                $c->gpfeete24 = $cid['gpfeete24'];

                $c->gpwtbs = $cid['gpwtbs'];
                $c->gppcsbs = $cid['gppcsbs'];
                $c->gpfeetbs = $cid['gpfeetbs'];

                $c->gpwtoth = $cid['gpwtoth'];
                $c->gppcsoth = $cid['gppcsoth'];
                $c->gpfeetoth = $cid['gpfeetoth'];

                $c->gpwttot = $cid['gpwttot'];
                $c->gppcstot = $cid['gppcstot'];
                $c->gpfeettot = $cid['gpfeettot'];

                // $c->length = $cid['length'];
                $c->brand = $cid['brand'];
                $c->repname = $cid['repname'];

                $c->gpkgrate = $cid['gpkgrate'];
                $c->gppcsrate = $cid['gppcsrate'];
                $c->gpfeetrate = $cid['gpfeetrate'];


                $c->save();

            }



            DB::update(DB::raw("
            update gatepasses c
            INNER JOIN (
				SELECT gpid, SUM(gppcstot) as pcs,SUM(gpwttot) AS wt,sum(gpfeettot) as ft
            FROM gatepasse_details where  gpid = $ci->id
            GROUP BY gpid

            ) x ON c.id = x.gpid
            SET c.gptotpcs = x.pcs,c.gptotwt=x.wt,c.gptotfeet=x.ft where  gpid = $ci->id
            "));

            // //****################# Transfert Contract Balance to Contracts
            DB::update(DB::raw("
            UPDATE sale_invoices c
            INNER JOIN (
                  SELECT sale_invoice_id, SUM(gptotpcs) as pcs,SUM(gptotwt) AS wt,SUM(gptotfeet) AS ft
            FROM gatepasses where  sale_invoice_id=$ci->sale_invoice_id  GROUP BY sale_invoice_id) x ON c.id = x.sale_invoice_id
            SET c.balsltpcs = c.sltpcs - x.pcs,c.balsltwt= c.sltwt-x.wt,c.balslfeet=slfeet-x.ft
            where  id = $ci->sale_invoice_id  "));

            // //****################# Transfert item wise Contract Balance from detail to detail
            DB::update(DB::raw("
            UPDATE sale_invoices_details c
            INNER JOIN (
            SELECT sale_invoice_id,material_id,SUM(gppcstot) as pcs,SUM(gpwttot) AS wt,SUM(gpfeettot) AS ft
            FROM gatepasse_details where  sale_invoice_id = $ci->sale_invoice_id   GROUP BY sale_invoice_id,material_id
            ) x ON c.sale_invoice_id = x.sale_invoice_id and c.material_id=x.material_id
            SET c.salepcs = c.qtypcs - x.pcs,c.salewt= c.qtykg-x.wt,c.salefeet=c.qtyfeet-ft WHERE  c.sale_invoice_id = $ci->sale_invoice_id
            "));



            DB::delete(DB::raw(" delete from godown_stock where ttypeid=4 and  transaction_id=$ci->id   "));

        //     DB::insert(DB::raw("
        //     INSERT INTO godown_stock ( transaction_id,tdate,ttypeid,tdesc,material_id,
        //     stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,stkfeete24,
        //     stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet )
        //     SELECT a.id,a.gpdate,4,'gatepass',material_id,gpwte13*-1,gppcse13*-1,gpfeete13*-1,gpwtgn2*-1,gppcsgn2*-1,gpfeetgn2*-1,gpwtams*-1,gppcsams*-1,gpfeetams*-1,gpwte24*-1,gppcse24*-1,gpfeete24*-1,
        //     gpwtbs*-1,gppcsbs*-1,gpfeetbs*-1,gpwtoth*-1,gppcsoth*-1,gpfeetoth*-1,gpwttot*-1,gppcstot*-1,gpfeettot*-1
        //     , gpkgrate,gppcsrate,gpfeetrate
        //     FROM gatepasses a inner JOIN gatepasse_details b ON a.id=b.gpid AND a.id=$ci->id

        //    "));

        DB::insert(DB::raw("
        INSERT INTO godown_stock ( transaction_id,tdate,ttypeid,tdesc,material_id,
        stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,stkfeete24,
        stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet,transvalue )
        SELECT a.id,a.gpdate,4,'gatepass',material_id,gpwte13*-1,gppcse13*-1,gpfeete13*-1,gpwtgn2*-1,gppcsgn2*-1,gpfeetgn2*-1,gpwtams*-1,gppcsams*-1,gpfeetams*-1,gpwte24*-1,gppcse24*-1,gpfeete24*-1,
        gpwtbs*-1,gppcsbs*-1,gpfeetbs*-1,gpwtoth*-1,gppcsoth*-1,gpfeetoth*-1,gpwttot*-1,gppcstot*-1,gpfeettot*-1
        , gpkgrate,gppcsrate,gpfeetrate
        ,( case b.sku_id when 1 then gpwttot * gpkgrate  when 2 then gppcstot * gppcsrate when 3 then gpfeettot * gpfeetrate END )*-1 AS transvalue
        FROM gatepasses a inner JOIN gatepasse_details b ON a.id=b.gpid AND a.id=$ci->id

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



                DB::update(DB::raw(" update gatepasses SET gptotpcs=0,gptotwt=0,gptotfeet=0 where id=$request->gpid "));
                DB::update(DB::raw(" update gatepasse_details SET gppcstot=0,gpfeettot=0 where gpid=$request->gpid "));



            // //****################# Transfert Contract Balance to Contracts
            DB::update(DB::raw("
            UPDATE sale_invoices c
            INNER JOIN (
                  SELECT sale_invoice_id, SUM(gptotpcs) as pcs,SUM(gptotwt) AS wt,SUM(gptotfeet) AS ft
            FROM gatepasses where  sale_invoice_id=$request->sale_invoice_id  GROUP BY sale_invoice_id) x ON c.id = x.sale_invoice_id
            SET c.balsltpcs = c.sltpcs - x.pcs,c.balsltwt= c.sltwt-x.wt,c.balslfeet=slfeet-x.ft
            where  id = $request->sale_invoice_id  "));

            // //****################# Transfert item wise Contract Balance from detail to detail
            DB::update(DB::raw("
            UPDATE sale_invoices_details c
            INNER JOIN (
            SELECT sale_invoice_id,material_id,SUM(gppcstot) as pcs,SUM(gpwttot) AS wt,SUM(gpfeettot) AS ft
            FROM gatepasse_details where  sale_invoice_id = $request->sale_invoice_id   GROUP BY sale_invoice_id,material_id
            ) x ON c.sale_invoice_id = x.sale_invoice_id and c.material_id=x.material_id
            SET c.salepcs = c.qtypcs - x.pcs,c.salewt= c.qtykg-x.wt,c.salefeet=c.qtyfeet-ft WHERE  c.sale_invoice_id = $request->sale_invoice_id
            "));



                DB::delete(DB::raw(" delete from gatepasses where id=$request->gpid"  ));
                DB::delete(DB::raw(" delete from gatepasse_details where gpid=$request->gpid   "));

                DB::delete(DB::raw(" delete from godown_stock where ttypeid=4 and  transaction_id=$request->gpid   "));

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
