<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Contract;
use App\Models\Sku;
use App\Models\CommercialInvoice;
use App\Models\CommercialInvoiceDetails;
use App\Models\Material;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\ContractDetails;
use App\Models\Location;
use App\Models\Purchasing;
use App\Models\PaymentDetail;
use App\Models\BankTransaction;





use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Session;

// LocalPurchaseController
class LocalPurchaseController  extends Controller
{
    public function index(Request $request)
    {
         return view('localpurchase.index');


    }

    // public function getMaster(Request $request)
    // {
    //     $status =$request->status ;
    //     $search = $request->search;
    //     $size = $request->size;
    //     $field = $request->sort[0]["field"];     //  Nested Array
    //     $dir = $request->sort[0]["dir"];         //  Nested Array
    //     $localpurchase = CommercialInvoice::where('status',$status)
    //     ->where(function ($query) use ($search){
    //             $query->where('invoiceno','LIKE','%' . $search . '%');

    //         })
    //         ->whereHas('supplier', function ($query) {
    //             $query->where('source_id','=','1');
    //             // ->orWhere('source_id',1);
    //         })

    //     ->with('supplier:id,title')
    //     ->orderBy($field,$dir)
    //     ->paginate((int) $size);
    //     return $localpurchase;
    // }








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
                ->orWhere('challanno','LIKE','%' . $search . '%');
            })
            ->whereHas('supplier', function ($query) use ($search) {
                $query->where('source_id','<>','2')
                ->orWhere('title','LIKE','%' . $search . '%');



            })
        ->with('supplier:id,title')
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $cis;
    }

    public function matMaster(Request $request)
    {
        $search = $request->search;
        // $supplierId = $request->supplierId;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array


        //  dd($request->all());
        // return $supplierId;
        // $contracts = DB::table('vwmastercustplan')
        //  With Tables
        $materials = Material::
        // $materials=DB::table('materials')
        // ->join('last_sale_rate', 'materials.id', '=', 'last_sale_rate.material_id')
    //    ->select('materials.*', 'last_sale_rate.salrate')
        where(function ($query) use ($search){
            $query->where('source_id','<>',2)
        //    ->where('brand_id','=',$supplierId)
            ->where('srchi','LIKE','%' . $search. '%');
        })
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $materials;
    }


    public function getDetails(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $contractDetails = CommercialInvoiceDetails::where('commercial_invoice_id',$request->id)
        ->paginate((int) $size);
        return $contractDetails;
    }

    public function getLocPurIndex(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        // $cis1 = DB::select('call procpaymentindex');
        $cis = DB::table('vwlocpurindex')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        // ->with('customer:id,title')
        ->where('invoiceno', 'like', "%$search%")
        ->orWhere('supname', 'like', "%$search%")
        // ->orWhere('tstatus', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $cis;

    }




    // public function getDetails(Request $request)
    // {
    //     $search = $request->search;
    //     $size = $request->size;
    //     $contractDetails = ContractDetails::where('contract_id',$request->id)
    //     ->paginate((int) $size);
    //     return $contractDetails;
    // }

    public function create()
    {
        $result = DB::table('suppliers')->where('source_id',13)->get();
        $resultArray = $result->toArray();
        $data=compact('resultArray');


        // $locations = Location::select('id','title')->where('status',1)->get();
        $maxgpno = DB::table('commercial_invoices')->select('gpassno')->max('gpassno')+1;
        return view('localpurchase.create',compact('maxgpno'))->with($data)
        // return \view ('sales.create',compact('maxdcno','maxblno','maxgpno'))
        ->with('suppliers',Supplier::select('id','title')->where('source_id','<>','2')->get())
        // ->where('source_id',1)->get())
        ->with('locations',Location::select('id','title')->get())
        ->with('skus',Sku::select('id','title')->get());
        // ->with('purunit',Sku::select('id','title')->get());
    }

    /** Function Complete*/
    public function store(Request $request)
    {
            //    dd($request->all());
        $this->validate($request,[
            'invoice_date' => 'required|min:3|date',
            'number' => 'required|min:3',
            'supplier_id' => 'required',
            'gpassno' => 'required|min:1|unique:commercial_invoices',
        ]);
        DB::beginTransaction();
        try {
            // Create Master Record
            // dd($request->all());
            // $contract = new Contract();
            // $contract->supplier_id = $request->supplier_id;
            // $contract->user_id = auth()->id();
            // $contract->invoice_date = $request->invoice_date;
            // $contract->number =$request->number;
            // $contract->save();
            // insurance,collofcustom,exataxoffie,bankntotal
            $ci = new CommercialInvoice();
            $ci->invoice_date = $request->invoice_date;
            $ci->invoiceno = $request->number;
            $ci->gpassno = $request->gpassno;
            $ci->contract_id = 0;
            $ci->challanno = $request->challanno;
            $ci->supplier_id = $request->supplier_id;
            $ci->machine_date = $request->invoice_date;
            $ci->conversionrate = 0;
            $ci->comdescription = $request->comdescription;
            $ci->ttype = $request->p9;


            if (!empty($request->insurance)) {
                $ci->insurance = $request->insurance;
              }
              else{
                $ci->insurance =  0;
              }

            $ci->collofcustom = $request->collofcustom;
            $ci->exataxoffie = $request->exataxoffie;
            $ci->lngnshipdochrgs = 0;
            $ci->localcartage = 0;
            $ci->miscexplunchetc = 0;
            $ci->customsepoy = 0;
            $ci->weighbridge = 0;
            $ci->miscexpenses = 0;
            $ci->agencychrgs = 0;
            $ci->otherchrgs = $request->otherchrgs;
            $ci->total = $request->bankntotal;
            $ci->invoicebal = $request->bankntotal;
            $ci->save();



            foreach ($request->contracts as $cont) {
                $material = Material::findOrFail($cont['id']);
                $lpd = new CommercialInvoiceDetails();
                $lpd->machine_date = $ci->invoice_date;
                $lpd->invoiceno = $ci->invoiceno;
                $lpd->commercial_invoice_id = $ci->id;
                $lpd->contract_id = 0;
                $lpd->material_id = $material->id;
                $lpd->supplier_id = $ci->supplier_id;
                $lpd->user_id = auth()->id();
                $lpd->category_id = $material->category_id;
                $lpd->dimension_id = $material->dimension_id;
                $lpd->hscode = '12314';
                $lpd->itmratio = 0;

                $lpd->machineno =  $cont['machineno'];
                $lpd->repname = $cont['repname'];
                $lpd->forcust = $cont['forcust'];
                $lpd->purunit = $cont['purunit'];

                $lpd->perft = $cont['cstrt'];
                $lpd->pricevaluecostsheet = $cont['cstamt'];


                $lpd->length = 0;
                $lpd->gdsprice = $cont['gdsprice'];
                $lpd->amtinpkr = $cont['amtinpkr'];
                // $lpd->location = $cont['location'];
                // $location = Location::where("title", $cont['location'])->first();
                // $lpd->locid = $location->id;
                $unitid = Sku::where("title", $cont['sku'])->first();
                $lpd->sku_id = $unitid->id;

                // if($lpd->sku_id==1)
                 $lpd->gdswt = $cont['gdswt'];
                 $lpd->dbalwt = $cont['gdswt'];

                // if($lpd->sku_id==2)
                 $lpd->pcs = $cont['pcs'];
                 $lpd->bundle1 = $cont['pcs'];

                // if($lpd->sku_id==3)
                  $lpd->qtyinfeet = $cont['qtyinfeet'];
                  $lpd->bundle2 = $cont['qtyinfeet'];
                $lpd->save();
            }

            DB::update(DB::raw("
            UPDATE commercial_invoices c
            INNER JOIN (
            SELECT commercial_invoice_id, SUM(pcs) as pcs,SUM(gdswt) AS wt,sum(qtyinfeet) as feet,SUM(amtinpkr) AS amount,
            sum(pricevaluecostsheet) as totcost
            FROM commercial_invoice_details where  commercial_invoice_id = $ci->id
            GROUP BY commercial_invoice_id
            ) x ON c.id = x.commercial_invoice_id
            SET c.tpcs = x.pcs,c.twt=x.wt,c.miscexpenses=x.feet,c.tval=x.amount,wtbal=x.wt,dutybal=x.pcs,agencychrgs=x.feet,c.tduty=x.totcost
            where  commercial_invoice_id = $ci->id "));



            // DB::update(DB::raw("
            // UPDATE commercial_invoices c
            // INNER JOIN (

            //     SELECT suppid,invsid,SUM(invoiceamount) AS invoicebal FROM
            //     (
            //     SELECT b.id AS suppid,a.id AS invsid,case WHEN b.source_id=2 then a.tval else  total end AS invoiceamount FROM commercial_invoices AS a
            //     INNER JOIN suppliers AS b ON a.supplier_id=b.id  AND b.id=$ci->supplier_id AND a.id =$ci->id
            //     UNION all
            //      SELECT a.subhead_id,b.invoice_id,b.payedusd*-1 AS payment
            //     FROM bank_transactions AS a INNER join payment_details AS b ON a.id=b.paymentid and a.subhead_id =$ci->supplier_id
            //     AND b.invoice_id =$ci->id
            //    UNION ALL
            //     SELECT supplier_id,commercial_invoice_id,prtamount*-1 AS retqty FROM purchase_returns WHERE supplier_id =$ci->supplier_id
            //     AND commercial_invoice_id =$ci->id
            //    UNION ALL
            //     SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS Receivedqty
            //     FROM bank_transactions AS a INNER join commercial_invoices AS b ON a.supinvid=b.invoiceno AND a.subhead_id =$ci->supplier_id
            //     AND b.id  =$ci->id
            //    ) AS w GROUP BY suppid,invsid
            // ) x ON c.id = x.invsid
            // SET c.invoicebal = x.invoicebal
            // where  c.id =$ci->id "));



            DB::insert(DB::raw("
            INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet,transvalue)
            SELECT a.id AS transid,a.invoice_date,'Lpurchasing',3,b.material_id,sku_id,gdswt,pcs,qtyinfeet,perft,perft,perft,pricevaluecostsheet FROM commercial_invoices a INNER JOIN  commercial_invoice_details b
            ON a.id=b.commercial_invoice_id WHERE a.id=$ci->id"));




            DB::commit();
            Session::flash('success','Contract Information Saved');
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

    }

    // public function edit(Contract $contract)
    public function edit($id)
    {

        $passwrd = DB::table('tblpwrd')->select('pwrdtxt')->max('pwrdtxt');
        $cd = DB::table('commercial_invoices as a')
        ->join('commercial_invoice_details as b', 'a.id', '=', 'b.commercial_invoice_id')
        ->join('materials as c', 'c.id', '=', 'b.material_id')
        ->join('skus as d', 'd.id', '=', 'b.sku_id')
        ->select('c.id as material_id','c.title','c.category_id','c.category','c.dimension_id','c.dimension','c.sku_id','c.sku','c.brand_id','c.brand'
        ,'b.user_id','b.supplier_id','b.id','b.pcs','b.length','b.qtyinfeet','b.gdsprice','b.amtinpkr','b.perkg','b.purval','b.repname',
        'b.machineno','b.forcust','b.purunit','b.locid','b.location','b.contract_id','d.title as sku',
        'b.gdswt','pcs','qtyinfeet','b.perft','pricevaluecostsheet'
        // DB::raw('( CASE b.sku_id  WHEN  1 THEN b.gdswt WHEN 2 THEN b.pcs WHEN 3 THEN b.qtyinfeet  END) AS gdswt')
        )
        ->where('a.id',$id)->get();

        $data=compact('cd');

         return view('localpurchase.edit',compact('passwrd'))
        ->with('suppliers',Supplier::select('id','title')->where('source_id',13)->get())
        ->with('commercialInvoice',CommercialInvoice::findOrFail($id))
        // ->with('cd',CommercialInvoiceDetails::where('commercial_invoice_id',$id)->get())
        ->with('locations',Location::select('id','title')->get())
        ->with('skus',Sku::select('id','title')->get())
        ->with($data);

    }



    public function deleterec($id)
    {

        $passwrd = DB::table('tblpwrd')->select('pwrdtxtdel')->max('pwrdtxtdel');
        $fugp = Purchasing::where('contract_id',$id)->max('contract_id');;
        $rcvvchr = PaymentDetail::where('invoice_id',$id)->max('invoice_id');
        $pmtvchr = BankTransaction::where('supinvid',$id)->max('supinvid');

        $cd = DB::table('commercial_invoices as a')
        ->join('commercial_invoice_details as b', 'a.id', '=', 'b.commercial_invoice_id')
        ->join('materials as c', 'c.id', '=', 'b.material_id')
        ->join('skus as d', 'd.id', '=', 'b.sku_id')
        ->select('c.id as material_id','c.title','c.category_id','c.category','c.dimension_id','c.dimension','c.sku_id','c.sku','c.brand_id','c.brand'
        ,'b.user_id','b.supplier_id','b.id','b.pcs','b.length','b.qtyinfeet','b.gdsprice','b.amtinpkr','b.perkg','b.purval','b.repname',
        'b.machineno','b.forcust','b.purunit','b.locid','b.location','b.contract_id','d.title as sku',
        'b.gdswt','pcs','qtyinfeet','b.perft','pricevaluecostsheet'
        // DB::raw('( CASE b.sku_id  WHEN  1 THEN b.gdswt WHEN 2 THEN b.pcs WHEN 3 THEN b.qtyinfeet  END) AS gdswt')
        )
        ->where('a.id',$id)->get();

        $data=compact('cd');

         return view('localpurchase.deleterec',compact('passwrd','fugp','rcvvchr','pmtvchr'))
        ->with('suppliers',Supplier::select('id','title')->get())
        ->with('commercialInvoice',CommercialInvoice::findOrFail($id))
        // ->with('cd',CommercialInvoiceDetails::where('commercial_invoice_id',$id)->get())
        ->with('locations',Location::select('id','title')->get())
        ->with('skus',Sku::select('id','title')->get())
        ->with($data);

    }









    public function update(Request $request, CommercialInvoice $commercialinvoice)
    {
        //  dd($commercialinvoice->commercial_invoice_id());
        //    dd($request->all());
        DB::beginTransaction();
        try {
            // Save Contract Data First : If changed
            // $commercialinvoice = CommercialInvoice::findOrFail($id);
            //  $commercialinvoice = 43;
            // $commercialinvoice = CommercialInvoice::findOrFail($request->commercial_invoice_id);


if($request->dltid==0)
{
            $commercialinvoice = CommercialInvoice::findOrFail($request->contract_id);
            $commercialinvoice->invoiceno = $request->invoiceno;
            $commercialinvoice->invoice_date = $request->invoice_date;
            $commercialinvoice->supplier_id = $request->supplier_id;
            $commercialinvoice->contract_id = 0;
            $commercialinvoice->challanno = $request->challanno;
            $commercialinvoice->machine_date = $request->invoice_date;
            $commercialinvoice->machineno = $request->invoiceno;
            $commercialinvoice->comdescription = $request->comdescription;
            $commercialinvoice->ttype = $request->p9;


            if (!empty($commercialinvoice->insurance)) {
                $commercialinvoice->insurance = $request->insurance;
              }
              else{
                $commercialinvoice->insurance = 0;
              }
            $commercialinvoice->collofcustom = $request->collofcustom;;
            $commercialinvoice->exataxoffie = $request->exataxoffie;
            $commercialinvoice->otherchrgs = $request->otherchrgs;
            $commercialinvoice->total = $request->bankntotal;
            $commercialinvoice->invoicebal = $request->bankntotal;
            $commercialinvoice->gpassno = $request->gpassno;
            $commercialinvoice->save();
            // Get Data
            $cds = $request->localpurchase; // This is array
            $cds = CommercialInvoiceDetails::hydrate($cds); // Convert it into Model Collection
            // Now get old ContractDetails and then get the difference and delete difference
            $oldcd = CommercialInvoiceDetails::where('commercial_invoice_id',$commercialinvoice->id)->get();
            $deleted = $oldcd->diff($cds);
            //  Delete contract details if marked for deletion
            foreach ($deleted as $d) {
                $d->delete();
            }
            // Now update existing and add new
            foreach ($cds as $cd) {
                if($cd->id)
                {
                    $cds = CommercialInvoiceDetails::where('id',$cd->id)->first();
                    $cds->machine_date = $cd->invoice_date;
                    $cds->invoiceno = $cd->invoiceno;
                    // $cds->commercial_invoice_id = $cd->id;
                    $cds->contract_id = 0;
                    $cds->material_id = $cd->material_id;
                    $cds->supplier_id = $cd->supplier_id;
                    $cds->user_id = auth()->id();
                    $cds->category_id = $cd->category_id;
                    $cds->dimension_id = $cd->dimension_id;
                    $cds->hscode = '12314';
                    $cds->itmratio = 0;

                    $cds->machineno = $cd->machineno;
                    $cds->repname = $cd->repname;
                    $cds->forcust = $cd->forcust;

                    $cds->perft = $cd->perft;
                    $cds->pricevaluecostsheet = $cd->pricevaluecostsheet;

                    // $cds->purunit = $cd->purunit;

                    // $cds->gdswt = $cd->gdswt;
                    $cds->pcs = 0;
                    $cds->qtyinfeet = 0;
                    $cds->length = 0;
                    $cds->gdsprice = $cd->gdsprice;
                    $cds->amtinpkr = $cd->amtinpkr;
                    // $cds->location = $cd->location;
                    // $location = Location::where("title", $cd['location'])->first();
                    // $cds->locid = $location->id;

                    $unitid = Sku::where("title", $cd['sku'])->first();
                    $cds->sku_id = $unitid->id;

                 // if($lpd->sku_id==1)
                 $cds->gdswt = $cd['gdswt'];
                 $cds->dbalwt = $cd['gdswt'];

                // if($lpd->sku_id==2)
                 $cds->pcs = $cd['pcs'];
                 $cds->bundle1 = $cd['pcs'];

                // if($lpd->sku_id==3)
                  $cds->qtyinfeet = $cd['qtyinfeet'];
                  $cds->bundle2 = $cd['qtyinfeet'];

                    $cds->save();
                }else
                {
                    //  The item is new, Add it

                    $cds = new CommercialInvoiceDetails();

                    $cds->commercial_invoice_id = $commercialinvoice->id;
                    $cds->repname = $cd->repname;
                    $cds->supplier_id = $request->supplier_id;
                    $cds->user_id =  auth()->id();
                    $cds->material_id = $cd->material_id;
                    $cds->category_id = $cd->category_id;
                    $cds->dimension_id = $cd->dimension_id;
                    $cds->source_id = $cd->source_id;
                    $cds->brand_id = $cd->brand_id;

                    $cds->perft = $cd->perft;
                    $cds->pricevaluecostsheet = $cd->pricevaluecostsheet;

                    // $cds->gdswt = $cd->gdswt;
                    $cds->perkg = 0;
                    $cds->amtinpkr = $cd->amtinpkr;
                    // $cds->location = $cd->location;
                    // $location = Location::where("title", $cd['location'])->first();
                    // $cds->locid = $location->id;
                    $unitid = Sku::where("title", $cd['sku'])->first();
                    $cds->sku_id = $unitid->id;
           // if($lpd->sku_id==1)
                    $cds->gdswt = $cd['gdswt'];
                    $cds->dbalwt = $cd['gdswt'];

                    // if($lpd->sku_id==2)
                    $cds->pcs = $cd['pcs'];
                    $cds->bundle1 = $cd['pcs'];

                    // if($lpd->sku_id==3)
                        $cds->qtyinfeet = $cd['qtyinfeet'];
                        $cds->bundle2 = $cd['qtyinfeet'];
                    $cds->save();
                }
            }

            DB::update(DB::raw("
            UPDATE commercial_invoices c
            INNER JOIN (
            SELECT commercial_invoice_id, SUM(pcs) as pcs,SUM(gdswt) AS wt,sum(qtyinfeet) as feet,SUM(amtinpkr) AS amount,sum(pricevaluecostsheet) as totcost
            FROM commercial_invoice_details where  commercial_invoice_id = $commercialinvoice->id
            GROUP BY commercial_invoice_id
            ) x ON c.id = x.commercial_invoice_id
            SET c.tpcs = x.pcs,c.twt=x.wt,c.miscexpenses=x.feet,c.tval=x.amount,wtbal=x.wt,dutybal=x.pcs,agencychrgs=x.feet,c.tduty=x.totcost
            where  commercial_invoice_id = $commercialinvoice->id "));


            DB::update(DB::raw("
            UPDATE commercial_invoices c
            INNER JOIN (

                SELECT suppid,invsid,SUM(invoiceamount) AS invoicebal FROM
                (
                SELECT b.id AS suppid,a.id AS invsid,case WHEN b.source_id=2 then a.tval else  total end AS invoiceamount FROM commercial_invoices AS a
                INNER JOIN suppliers AS b ON a.supplier_id=b.id  AND b.id=$cds->supplier_id AND a.id =$commercialinvoice->id
                UNION all
                 SELECT a.subhead_id,b.invoice_id,b.payedusd*-1 AS payment
                FROM bank_transactions AS a INNER join payment_details AS b ON a.id=b.paymentid and a.subhead_id =$cds->supplier_id
                AND b.invoice_id =$commercialinvoice->id
               UNION ALL
                SELECT supplier_id,commercial_invoice_id,prtamount*-1 AS retqty FROM purchase_returns WHERE supplier_id =$cds->supplier_id
                AND commercial_invoice_id =$commercialinvoice->id
               UNION ALL
                SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS Receivedqty
                FROM bank_transactions AS a INNER join commercial_invoices AS b ON a.supinvid=b.invoiceno AND a.subhead_id =$cds->supplier_id
                AND b.id  =$commercialinvoice->id
               ) AS w GROUP BY suppid,invsid
            ) x ON c.id = x.invsid
            SET c.invoicebal = x.invoicebal
            where  c.id =$commercialinvoice->id "));


















            DB::delete(DB::raw(" delete from office_item_bal where ttypeid=3 and  transaction_id=$commercialinvoice->id   "));

            // DB::insert(DB::raw("
            // INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet)
            // SELECT a.id AS transid,a.invoice_date,'Lpurchasing',3,b.material_id,sku_id,gdswt,pcs,qtyinfeet,perft,perft,perft FROM commercial_invoices a INNER JOIN  commercial_invoice_details b
            // ON a.id=b.commercial_invoice_id WHERE a.id=$commercialinvoice->id"));

            DB::insert(DB::raw("
            INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet,transvalue)
            SELECT a.id AS transid,a.invoice_date,'Lpurchasing',3,b.material_id,sku_id,gdswt,pcs,qtyinfeet,perft,perft,perft,pricevaluecostsheet FROM commercial_invoices a INNER JOIN  commercial_invoice_details b
            ON a.id=b.commercial_invoice_id WHERE a.id=$commercialinvoice->id"));

//   dd($request->dltid);
 }
if($request->dltid==1)
{
    // DB::delete(DB::raw(" delete FROM commercial_invoices WHERE id=$commercialinvoice->id   "));
    // DB::delete(DB::raw(" delete FROM commercial_invoice_details WHERE commercial_invoice_id =$commercialinvoice->id   "));

}




            DB::commit();
            Session::flash('success','Contract Information Saved');
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

    public function printContract($id)
    {

        $hdng1 = 'daf';
        $hdng2 = 'dfsf';

        // $head_id = $request->head_id;
        // $head = Supplier::findOrFail($head_id);
        // if($request->has('subhead_id')){
            // $subhead_id = $request->subhead_id;
            //  Clear Data from Table
            DB::table('contparameterrpt')->truncate();
            // foreach($request->subhead_id as $id)
            // {
                DB::table('contparameterrpt')->insert([ 'GLCODE' => $id ]);
            // }
        // }

        //  Call Procedure
        $data = DB::select('call procpurinvcloc()');
        if(!$data)
        {
            Session::flash('info','No data available');
            return redirect()->back();
        }
        $collection = collect($data);                   //  Make array a collection

        $mpdf = $this->getMPDFSettings();
        $grouped = $collection->groupBy('purid');       //  Sort collection by SupName
        $grouped->values()->all();                       //  values() removes indices of array
        foreach($grouped as $g){
            $html =  view('localpurchase.print')->with('hdng1',$hdng1)->with('hdng2',$hdng2)
               ->with('data',$g)->render();
            //    ->with('fromdate',$fromdate)
            //    ->with('todate',$todate)
            //    ->with('headtype',$head->title)->render();

            $filename = $g[0]->purid  .'.pdf';
            $chunks = explode("chunk", $html);
            foreach($chunks as $key => $val) {
                $mpdf->WriteHTML($val);
            }
            $mpdf->AddPage();
        }
        return response($mpdf->Output($filename,'I'),200)->header('Content-Type','application/pdf');

    }




    public function deleteBankRequest(Request $request)
    {


//  dd($request->invsid);
        DB::beginTransaction();
            try {

                DB::delete(DB::raw(" delete from commercial_invoices where id=$request->contract_id   "));
                DB::delete(DB::raw(" delete from commercial_invoice_details where commercial_invoice_id=$request->contract_id   "));

                DB::delete(DB::raw(" delete from office_item_bal where ttypeid=3 and  transaction_id=$request->contract_id   "));

                DB::commit();


                Session::flash('success','Record Deleted Successfully');
                return response()->json(['success'],200);

            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }



    }





}
