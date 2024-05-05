<?php

namespace App\Http\Controllers;

use DB;
// use App\Models\Contract;
use App\Models\Quotation;
use App\Models\QuotationDetails;

use App\Models\CustomerOrder;
use App\Models\CustomerOrderDetails;

use App\Models\SaleInvoices;
use App\Models\SaleInvoicesDetails;
use App\Models\CreateSaleRate;
use App\Models\ItemBal;
use App\Models\BankTransaction;

use App\Models\Gatepasse;
use App\Models\ReceiveDetails;




use App\Models\Material;
use App\Models\Customer;
use App\Models\Sku;
use Illuminate\Http\Request;
// use App\Models\ContractDetails;
use App\Models\Location;
use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Session;

// LocalPurchaseController
class SalesInvoiceWopoController  extends Controller
{


    public function mdcno(Request $request)
    {
        //  dd($request->all());
        // $head_id = $request->head_id;
        $newdcno = DB::table('sale_invoices')->select('dcno')->max('dcno')+1;
        return  $newdcno;

    }

    public function mbillno(Request $request)
    {
        //  dd($request->all());
        // $head_id = $request->head_id;
        $newbillno = DB::table('sale_invoices')->select('billno')->max('billno')+1;
        return  $newbillno;

    }






    public function index(Request $request)
    {
         return view('salewopo.index');


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
        // // dd($request->all());
        // $status =$request->status ;
        // $search = $request->search;
        // $size = $request->size;
        // $field = $request->sort[0]["field"];     //  Nested Array
        // $dir = $request->sort[0]["dir"];         //  Nested Array
        // $cis = SaleInvoices::where('custplan_id','=','0')
        // ->where(function ($query) use ($search){
        //         $query->where('dcno','LIKE','%' . $search . '%')
        //         // ->orWhere('gpno','LIKE','%' . $search . '%')
        //         ->orWhere('billno','LIKE','%' . $search . '%');
        //     })
        //     // ->whereHas('customer', function ($query) {
        //     //      $query->where('source_id','=','1');
        //     // })
        // ->with('customer:id,title')
        //  ->orderBy($field,$dir)
        // ->paginate((int) $size);
        // return $cis;

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $cis = DB::table('vwswopoindex')
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
        $contractDetails = SaleInvoicesDetails::where('sale_invoice_id',$request->id)
        ->paginate((int) $size);
        return $contractDetails;
    }

    public function getMastercustplan(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $contracts = DB::table('vwmatcatfrsale')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        ->where('srchb', 'like', "%$search%")
        // ->orWhere('pono', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;
    }

    public function getDetailscustplan(Request $request)
    {
        $id = $request->id;
        // dd($id);
        //  $contractDetails = DB::table('vwdetailcustplan')->where('sale_invoice_id',$id)->get();
        $contractDetails = DB::select('call procdetailsalewopo(?)',array( $id ));
        return response()->json($contractDetails, 200);
    }





    public function create()
    {

        $result = DB::table('customers')->whereNotIn('id',[0,1])->get();
        $resultArray = $result->toArray();
        $data=compact('resultArray');

        $result1 = DB::table('vwswofrmmatlist')->get();
        $resultArray1 = $result1->toArray();
        $data1=compact('resultArray1');


        $locations = Location::select('id','title')->where('status',1)->get();

        // return view('sales.create')
        // $mycname='MUHAMMAD HABIB & Co.';
        $maxdcno = DB::table('sale_invoices')->select('dcno')->max('dcno')+1;
        // $maxgpno = DB::table('sale_invoices')->select('gpno')->max('gpno')+1;
        $maxbillno = DB::table('sale_invoices')->select('billno')->max('billno')+1;

        return \view ('salewopo.create',compact('maxdcno','maxbillno'))->with($data)->with($data1)
        ->with('customers',Customer::select('id','title')->get())
        //  ->with('locations',Location::select('id','title')->get());
         ->with('skus',Sku::select('id','title')->get());

        // ->with('maxdcno',lastsalinvno::select('id','poseqno')->get());

        // ->with('lastsno',DB::table('lastsalinvno')->select('*')->get());
    }

    /** Function Complete*/
    public function store(Request $request)
    {
            //    dd($request->all());
        $this->validate($request,[

            // 'dcno' => 'required|unique:sale_invoices',
            // 'gpno' => 'required|unique:sale_invoices',
            // 'poseqno' => 'required|min:1|unique:customer_orders',
            // 'pono' => 'required|min:1|unique:customer_orders'
            // 'gpno' => 'required|min:1|unique:sale_invoices',
            // 'customer_id' => 'required'
        ]);
        DB::beginTransaction();
        try {


            $ci = new SaleInvoices();
            $ci->custplan_id = 0;
            $ci->pono = 'Without P.O';
            $ci->podate = $request->deliverydt;
            $ci->saldate = $request->deliverydt;
            $ci->dcno = $request->dcno;
            // $ci->gpno = $request->gpno;
            $ci->billno = $request->billno;
            $ci->customer_id = $request->customer_id;
            $ci->discntper = $request->discntper;
            $ci->discntamt = $request->discntamt;
            $ci->cartage = $request->cartage;
            $ci->rcvblamount = $request->rcvblamount;
            $ci->saletaxper = $request->saletaxper;
            $ci->saletaxamt = $request->saletaxamt;
            $ci->totrcvbamount = $request->totrcvbamount;
            $ci->paymentbal = $request->totrcvbamount;
            $ci->saldescription = $request->saldescription;


            $ci->save();

            if($request->customer_id==0)
            {
                $pv = new BankTransaction();
                $pv->cashinvid = $ci->id;
                $pv->bank_id = 1;
                $pv->head_id = 33;
                $pv->subhead_id = 0;
                $pv->transaction_type = 'CRV';
                $pv->documentdate = $request->deliverydt;
                $pv->conversion_rate = 1;
                $pv->amount_fc = $request->totrcvbamount;
                $pv->amount_pkr = $request->totrcvbamount;
                $pv->cheque_date = $request->deliverydt;;
                $pv->cheque_no = '';
                $pv->description = 'Received Against Sale';
                $pv->transno = 0;
                $pv->advance = 0;
                $pv->supname = 'CUST CASH CUSTOMER';
                $pv->save();
            }






            foreach ($request->sales as $cont) {
                // $material = Material::findOrFail($cont['id']);

                $unitid = Sku::where("title", $cont['sku'])->first();
                // $lpd->sku_id = $unitid->id;

                // dd($unitid->id);
                $lpd = new SaleInvoicesDetails();
                $lpd->sale_invoice_id = $ci->id;
                $lpd->material_id = $cont['material_id'];
                $lpd->sku_id = $unitid->id;
                $lpd->repname = $cont['repname'];
                $lpd->brand = $cont['mybrand'];
                $lpd->qtykg = $cont['qtykg'];
                $lpd->qtypcs = $cont['qtypcs'];
                $lpd->qtyfeet = $cont['qtyfeet'];
                $lpd->unitconver = $cont['unitconver'];


                $lpd->price = $cont['price'];
                $lpd->saleamnt = $cont['saleamnt'];
                $lpd->feedqty = $cont['feedqty'];

                $lpd->qtykgcrt =0;
                // $cont['salcostkg'];
                $lpd->qtypcscrt =0;
                // $cont['salcostpcs'];
                $lpd->qtyfeetcrt =0;
                // $cont['salcostfeet'];

                $lpd->sqtykg = $cont['sqtykg'];
                $lpd->sqtypcs = $cont['sqtypcs'];
                $lpd->sqtyfeet = $cont['sqtyfeet'];

                $lpd->wtper = $cont['wtper'];
                $lpd->pcper = $cont['pcper'];
                $lpd->feetper = $cont['feetper'];

                $lpd->salewt = $cont['qtykg'];
                $lpd->salepcs = $cont['qtypcs'];
                $lpd->salefeet = $cont['qtyfeet'];

                $lstrt = CreateSaleRate::where('customer_id',$request->customer_id)->where('material_id',$cont['material_id'])->first();
                if(!$lstrt) {
                    $abc = new CreateSaleRate();
                    $abc->customer_id=$request->customer_id;
                    $abc->material_id=$cont['material_id'];
                    $abc->salrate=$cont['price'];
                    $abc->sunitid=$unitid->id;
                    $abc->sunitname=$cont['sku'];
                    $abc->tranid=$ci->id;
                    $abc->save();
                }
                else
                    {
                        $lstrt->material_id=$cont['material_id'];
                        $lstrt->salrate=$cont['price'];
                        $lstrt->sunitid=$unitid->id;
                        $lstrt->sunitname=$cont['sku'];
                        $lstrt->tranid=$ci->id;
                        $lstrt->save();
                    }



                $lpd->save();






                // $location = Location::where("title", $cont['location'])->first();
                // $lpd->locid = $location->id;

                // Last Sale Rate Update in Material Table
                // $matsrate = Material::findOrFail($lpd->material_id);
                // if($lpd->sku_id == 1)
                // { $matsrate->salertkg = $lpd->price;}
                // elseif($lpd->sku_id == 2)
                // { $matsrate->salertpcs = $lpd->price;}
                // elseif($lpd->sku_id == 3)
                // { $matsrate->salertfeet = $lpd->price;}
                // $matsrate->save();

                // $custplnbal = customer_order_details::findOrFail($lpd->material_id);
            //     $custplnbal = CustomerOrderDetails::where('sale_invoice_id',$ci->custplan_id)->where('material_id',$lpd->material_id)
            //     ->first();
            //     if($lpd->sku_id == 1)
            //     { $custplnbal->balqty = $cont['balqty'] - $cont['qtykg'];}
            //     elseif($lpd->sku_id == 2)
            //     { $custplnbal->balqty = $cont['balqty'] - $cont['qtypcs'];}
            //     elseif($lpd->sku_id == 3)
            //     { $custplnbal->balqty = $cont['balqty'] - $cont['qtyfeet'];}
            //     $custplnbal->save();

            // }


                // $lwsstk = ItemBal::where('locid',$location->id)->where('material_id',$cont['material_id'])->first();
                // ;
                //  if($cont['qtykg']>$lwsstk->cbqtykg || $cont['qtypcs']>$lwsstk->cbqtypcs || $cont['qtyfeet']>$lwsstk->cbqtyfeet )

                //  {

                //     $notification = array(
                //         'message' => 'Message wording goes here',
                //         // 'alert-type' => 'success / danger / warning / info etc.'
                //     );
                //     return ;

                // }

                //  { return response()->json(['message' =>'success'], 200);}
                //  { dd($lwsstk->cbqtykg,($cont['qtykg'])); }

            //  $dlvrdval = SaleInvoices->->select('totrcvbamount')::where('custplan_id',$ci->custplan_id)->sum('totrcvbamount');
            //  $dlvrdval=DB::table('sale_invoices')->where('custplan_id',$ci->custplan_id)->select('totrcvbamount')->sum('totrcvbamount');





            // $dlvrdval = SaleInvoices::where('custplan_id',$ci->custplan_id)->sum('totrcvbamount');
            // $custordr = CustomerOrder::where('id',$ci->custplan_id)->first();
            // $custordr->delivered = $dlvrdval;
            // $custordr->save();
            // $sordrbal = SaleInvoices::where('id',$ci->id)->first();
            // $sordrbal->ordrbal= $custordr->totrcvbamount - $dlvrdval;
            // $sordrbal->save();


            //  $dlvrd = DB::table('sale_invoices_details')
            // ->join('sale_invoices', 'sale_invoices_details.sale_invoice_id', '=', 'sale_invoices.id')
            // ->where('sale_invoices.custplan_id', '=', $ci->custplan_id)->where('sale_invoices_details.material_id', '=', $lpd->material_id)
            // ->sum(DB::raw('( CASE sale_invoices_details.sku_id  WHEN  1 THEN sale_invoices_details.qtykg WHEN 2 THEN sale_invoices_details.qtypcs WHEN 3 THEN sale_invoices_details.qtyfeet  END)'));
            // // dd($ci->custplan_id);
            // $custplnbal = CustomerOrderDetails::where('sale_invoice_id',$ci->custplan_id)->where('material_id',$cont['material_id'])
            // ->first();
            // $custplnbal->balqty = $custplnbal->qtykg - $dlvrd;
            // $custplnbal->save();
            }

            //// Details update

            /// **** update summary data to master table
            DB::update(DB::raw("
            UPDATE sale_invoices c
            INNER JOIN (
            SELECT sale_invoice_id,SUM(qtykg) AS twt,SUM(qtypcs) AS tpcs,SUM(qtyfeet) AS tfeet FROM sale_invoices_details WHERE sale_invoice_id=$ci->id GROUP BY sale_invoice_id
            ) x ON c.id = x.sale_invoice_id
            SET c.sltwt = x.twt,c.sltpcs=x.tpcs,c.slfeet=x.tfeet ,
            c.balsltwt=x.twt,c.balsltpcs=x.tpcs,c.balslfeet=x.tfeet  WHERE  c.id = $ci->id "));








            DB::update(DB::raw("
            UPDATE customer_order_details c
            INNER JOIN (
            SELECT b.custplan_id,a.material_id,SUM(feedqty) AS feedqty  FROM sale_invoices_details a
				INNER JOIN sale_invoices AS b ON b.id=a.sale_invoice_id WHERE b.custplan_id=$ci->custplan_id GROUP BY b.custplan_id,a.material_id
            ) x ON c.sale_invoice_id = x.custplan_id AND c.material_id=x.material_id
            SET c.balqty = c.qtykg - x.feedqty WHERE  c.sale_invoice_id = $ci->custplan_id"));


            ///**** Master Update
            DB::update(DB::raw("
            UPDATE customer_orders c
            INNER JOIN (
            SELECT custplan_id,SUM(totrcvbamount)-SUM(cartage) AS Dlvred FROM sale_invoices WHERE custplan_id=$ci->custplan_id
				GROUP BY custplan_id
            ) x ON c.id = x.custplan_id
            SET c.delivered = x.Dlvred,c.salordbal=( coalesce(totrcvbamount,0)-coalesce(cartage,0) )-x.Dlvred WHERE  c.id = $ci->custplan_id"));



            DB::insert(DB::raw("
            INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet,transvalue)
            SELECT a.id AS transid,a.saldate,'sales',4,b.material_id,b.sku_id,qtykg*-1,qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt
            ,( case c.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END )*-1 AS transvalue
            FROM sale_invoices a INNER JOIN  sale_invoices_details b INNER JOIN materials c ON b.material_id=c.id
            ON a.id=b.sale_invoice_id WHERE a.id=$ci->id"));






            DB::commit();
            // Session::flash('success','Contract Information Saved');
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

    }

    // public function edit(Contract $contract)
    public function edit($id)
    {


        $result1 = DB::table('vwswofrmmatlist')->get();
        $resultArray1 = $result1->toArray();
        $data1=compact('resultArray1');


         $passwrd = DB::table('tblpwrd')->select('pwrdtxt')->max('pwrdtxt');
         $cd = DB::select('call procsalewosoedit (?)',array( $id ));
         $data=compact('cd');
         $locations = Location::select('id','title')->where('status',1)->get();
        return view('salewopo.edit',compact('passwrd'))
        ->with('customer',Customer::select('id','title')->get())
        ->with('saleinvoices',SaleInvoices::findOrFail($id))
        ->with($data)->with($data1)
        ->with('skus',Sku::select('id','title')->get());
        // ->with('locations',Location::select('id','title')->get());

        // return view('contracts.edit')->with('suppliers',Supplier::select('id','title')->get())->with('contract',$contract)->with('cd',ContractDetails::where('contract_id',$contract->id)->get());
    }


    public function deleterec($id)
    {

        $fugp = Gatepasse::where('sale_invoice_id',$id)->max('sale_invoice_id');;
        $rcvvchr = ReceiveDetails::where('invoice_id',$id)->max('invoice_id');
        $pmtvchr = BankTransaction::where('cusinvid',$id)->max('cusinvid');

        $passwrd = DB::table('tblpwrd')->select('pwrdtxtdel')->max('pwrdtxtdel');
         $cd = DB::select('call procsalewosoedit (?)',array( $id ));
         $data=compact('cd');
         $locations = Location::select('id','title')->where('status',1)->get();
        return view('salewopo.deleterec',compact('passwrd','fugp','rcvvchr','pmtvchr'))
        ->with('customer',Customer::select('id','title')->get())
        ->with('saleinvoices',SaleInvoices::findOrFail($id))
        ->with($data)
        ->with('skus',Sku::select('id','title')->get());
    }








    public function update(Request $request, SaleInvoices $saleinvoices)
    {
        //  dd($commercialinvoice->commercial_invoice_id());
            //   dd($request->all());
        DB::beginTransaction();
        try {

            //  dd($request->sale_invoice_id);


            if($request->pcustno==0)
            {
                // $pv = new BankTransaction();
                // $pv = BankTransaction::findOrFail($request->sale_invoice_id);
                // dd($request->per());

                if($request->pcustno==0 and $request->customer_id==0 )

                {
                    $pv = BankTransaction::where('cashinvid',$request->sale_invoice_id)->first();
                    $pv->bank_id = 1;
                    $pv->head_id = 33;
                    $pv->subhead_id = 0;
                    $pv->transaction_type = 'CRV';
                    $pv->documentdate = $request->deliverydt;
                    $pv->conversion_rate = 1;
                    $pv->amount_fc = $request->totrcvbamount;
                    $pv->amount_pkr = $request->totrcvbamount;
                    $pv->cheque_date = $request->deliverydt;;
                    $pv->cheque_no = '';
                    $pv->description = 'Received Against Sale';
                    $pv->transno = 0;
                    $pv->advance = 0;
                    $pv->supname = 'CUST CASH CUSTOMER';
                    $pv->save();

                }
            else
            {
                DB::delete(DB::raw(" delete from bank_transactions where  cashinvid=$request->sale_invoice_id   "));

            }

            }




            $sale_invoices = SaleInvoices::findOrFail($request->sale_invoice_id);
            $sale_invoices->custplan_id = 0;
            $sale_invoices->pono = 'Without P.O';
            $sale_invoices->podate = $request->deliverydt;
            $sale_invoices->saldate = $request->deliverydt;
            $sale_invoices->dcno = $request->dcno;
            // $sale_invoices->gpno = $request->gpno;
            $sale_invoices->billno = $request->billno;
            $sale_invoices->customer_id = $request->customer_id;
            $sale_invoices->discntper = $request->discntper;
            $sale_invoices->discntamt = $request->discntamt;
            $sale_invoices->cartage = $request->cartage;
            $sale_invoices->rcvblamount = $request->rcvblamount;
            $sale_invoices->saletaxper = $request->saletaxper;
            $sale_invoices->saletaxamt = $request->saletaxamt;
            $sale_invoices->totrcvbamount = $request->totrcvbamount;
            $sale_invoices->paymentbal = $request->totrcvbamount;
            $sale_invoices->saldescription = $request->saldescription;

            $sale_invoices->save();

            // Get Data
            $cds = $request->salewopo; // This is array
            $cds = SaleInvoicesDetails::hydrate($cds); // Convert it into Model Collection
            // Now get old ContractDetails and then get the difference and delete difference
            $oldcd = SaleInvoicesDetails::where('sale_invoice_id',$sale_invoices->id)->get();
            $deleted = $oldcd->diff($cds);
            //  Delete contract details if marked for deletion
            foreach ($deleted as $d) {
                $d->delete();
            }
            // Now update existing and add new
            foreach ($cds as $cd) {
                if($cd->id)
                {
                    $cds = SaleInvoicesDetails::where('id',$cd->id)->first();
                    $cds->sale_invoice_id = $sale_invoices->id;
                    $cds->material_id = $cd->material_id;
                    $cds->sku_id = $cd->sku_id;
                    $cds->repname = $cd['repname'];
                    $cds->brand = $cd['brand'];
                    $cds->qtykg = $cd['qtykg'];
                    $cds->qtypcs = $cd['qtypcs'];
                    $cds->qtyfeet = $cd['qtyfeet'];
                    $cds->unitconver = $cd['unitconver'];
                    $cds->price = $cd['price'];
                    $cds->saleamnt = $cd['saleamnt'];
                    $cds->feedqty = $cd['feedqty'];
                    $unit = Sku::where("title", $cd['sku'])->first();
                    $cds->sku_id = $unit->id;
                    $cds->salewt = $cd['qtykg'];
                    $cds->salepcs = $cd['qtypcs'];
                    $cds->salefeet = $cd['qtyfeet'];

                    $cds->qtykgcrt = 0;
                    // $cd['qtykgcrt'];
                    $cds->qtypcscrt = 0;
                    // $cd['qtypcscrt'];
                    $cds->qtyfeetcrt = 0;
                    // $cd['qtyfeetcrt'];





                    // $lstrt = CreateSaleRate::where('customer_id',$request->customer_id)->where('material_id',$cd['material_id'])->first();
                    $lstrt = CreateSaleRate::where('tranid',$sale_invoices->id)->where('material_id',$cd['material_id'])->first();
                    if(!$lstrt) {
                        $abc = new CreateSaleRate();
                        $abc->customer_id=$request->customer_id;
                        $abc->material_id=$cd['material_id'];
                        $abc->salrate=$cd['price'];
                        $abc->sunitid=$unit->id;
                        $abc->sunitname=$cd['sku'];
                        $abc->tranid=$sale_invoices->id;
                        $abc->save();
                    }
                    else
                        {
                            $lstrt->material_id=$cd['material_id'];
                            $lstrt->customer_id=$request->customer_id;
                            $lstrt->salrate=$cd['price'];
                            $lstrt->sunitid=$unit->id;
                            $lstrt->sunitname=$cd['sku'];;

                            $lstrt->save();
                        }

                    $cds->save();

            }

            else
            {

               $cds = new SaleInvoicesDetails();
               $cds->sale_invoice_id = $sale_invoices->id;
               $cds->material_id = $cd->material_id;
               $cds->sku_id = $cd->sku_id;
               $cds->repname = $cd['repname'];
               $cds->brand = $cd['brand'];
               $cds->qtykg = $cd['qtykg'];
               $cds->qtypcs = $cd['qtypcs'];
               $cds->qtyfeet = $cd['qtyfeet'];
               $cds->unitconver = $cd['unitconver'];
               $cds->price = $cd['price'];
               $cds->saleamnt = $cd['saleamnt'];
               $cds->feedqty = $cd['feedqty'];
               $unit = Sku::where("title", $cd['sku'])->first();
               $cds->sku_id = $unit->id;
               $cds->salewt = $cd['qtykg'];
               $cds->salepcs = $cd['qtypcs'];
               $cds->salefeet = $cd['qtyfeet'];

               $cds->qtykgcrt = 0;
               $cds->qtypcscrt = 0;
               $cds->qtyfeetcrt = 0;
               $cds->save();

            }}

            /// **** update summary data to master table
            DB::update(DB::raw("
            UPDATE sale_invoices c
            INNER JOIN (
            SELECT sale_invoice_id,SUM(qtykg) AS twt,SUM(qtypcs) AS tpcs,SUM(qtyfeet) AS tfeet FROM sale_invoices_details WHERE sale_invoice_id=$sale_invoices->id GROUP BY sale_invoice_id
            ) x ON c.id = x.sale_invoice_id
            SET c.sltwt = x.twt,c.sltpcs=x.tpcs,c.slfeet=x.tfeet ,
            c.balsltwt=x.twt,c.balsltpcs=x.tpcs,c.balslfeet=x.tfeet  WHERE  c.id = $sale_invoices->id "));






        //// Details update
        DB::update(DB::raw("
        UPDATE customer_order_details c
        INNER JOIN (
        SELECT b.custplan_id,a.material_id,SUM(feedqty) AS feedqty  FROM sale_invoices_details a
            INNER JOIN sale_invoices AS b ON b.id=a.sale_invoice_id WHERE b.custplan_id=$sale_invoices->custplan_id GROUP BY b.custplan_id,a.material_id
        ) x ON c.sale_invoice_id = x.custplan_id AND c.material_id=x.material_id
        SET c.balqty = c.qtykg - x.feedqty WHERE  c.sale_invoice_id = $sale_invoices->custplan_id"));





        DB::update(DB::raw("
        UPDATE customer_orders c
        INNER JOIN (
        SELECT custplan_id,SUM(totrcvbamount)-SUM(cartage) AS Dlvred FROM sale_invoices WHERE custplan_id=$sale_invoices->custplan_id
            GROUP BY custplan_id
        ) x ON c.id = x.custplan_id
        SET c.delivered = x.Dlvred,c.salordbal=( coalesce(totrcvbamount,0)-coalesce(cartage,0) )-x.Dlvred WHERE  c.id = $sale_invoices->custplan_id"));

        DB::delete(DB::raw(" delete from office_item_bal where ttypeid=4 and  transaction_id=$sale_invoices->id   "));

        // DB::insert(DB::raw("
        // INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet)
        // SELECT a.id AS transid,a.saldate,'sales',4,b.material_id,sku_id,qtykg*-1,qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt FROM sale_invoices a INNER JOIN  sale_invoices_details b
        // ON a.id=b.sale_invoice_id WHERE a.id=$sale_invoices->id"));


        DB::insert(DB::raw("
        INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet,transvalue)
        SELECT a.id AS transid,a.saldate,'sales',4,b.material_id,b.sku_id,qtykg*-1,qtypcs*-1,qtyfeet*-1,qtykgcrt,qtypcscrt,qtyfeetcrt
        ,( case c.sku_id when 1 then qtykg * qtykgcrt  when 2 then qtypcs * qtypcscrt when 3 then qtyfeet * qtyfeetcrt END )*-1 AS transvalue
        FROM sale_invoices a INNER JOIN  sale_invoices_details b INNER JOIN materials c ON b.material_id=c.id
        ON a.id=b.sale_invoice_id WHERE a.id=$sale_invoices->id"));






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

    //     $hdng1 = $request->cname;
    //     $hdng2 = $request->csdrs;
    //     $head_id = $request->head_id;
    // // $head = Head::findOrFail($head_id);
    // $head = Customer::findOrFail($head_id);
    // if($request->has('subhead_id')){
    //     $subhead_id = $request->subhead_id;
        //  Clear Data from Table
        DB::table('tmpqutparrpt')->truncate();
        // foreach($request->subhead_id as $id)
        // {
            DB::table('tmpqutparrpt')->insert([ 'qutid' => $id ]);
        // }
    // }
    //  Call Procedure
    $mpdf = $this->getMPDFSettings();
    // if($report_type === 'saltxinvs')
    // {
        $data = DB::select('call procsaletaxinvoicefrm()');
    // }
    // else
    // {
    //     $data = DB::select('call procsaleinvoice()');
    // }



    if(!$data)
    {
        Session::flash('info','No data available');
        return redirect()->back();
    }
    $collection = collect($data);                   //  Make array a collection
    // $grouped = $collection->groupBy('SupName');       //  Sort collection by SupName
    $grouped = $collection->groupBy('id');       //  Sort collection by SupName
    $grouped->values()->all();                       //  values() removes indices of array
        foreach($grouped as $g){


            // if($report_type === 'dlvrychln')
            // {
            // $html =  view('salerpt.dlvrychalan')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
            // ->with('headtype',$head->title)
            // ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->render();
            // }
            // if($report_type === 'salinvs')
            // {
            // $html =  view('salerpt.saleinvoice')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)
            // ->with('headtype',$head->title)
            // ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->render();
            // }
            // if($report_type === 'saltxinvs')
            // {
            $html =  view('sales.print')->with('data',$g)->render();
            // ->with('fromdate',$fromdate)->with('todate',$todate)
            // ->with('headtype',$head->title)
            // ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->render();
            // }

         // $html =  view('salerpt.glhw')->with('data',$g)->with('fromdate',$fromdate)->with('todate',$todate)->render();
        $filename = $g[0]->id  .'.pdf';
        // $mpdf->SetHTMLFooter('
        // <table width="100%" style="border-top:1px solid gray">
        //     <tr>
        //         <td width="33%">{DATE d-m-Y}</td>
        //         <td width="33%" align="center">{PAGENO}/{nbpg}</td>

        //     </tr>
        // </table>');
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

                DB::delete(DB::raw(" delete from sale_invoices where id=$request->sale_invoice_id   "));
                DB::delete(DB::raw(" delete from sale_invoices_details where sale_invoice_id=$request->sale_invoice_id   "));


                // DB::update(DB::raw("
                // UPDATE sale_invoices c
                // INNER JOIN (

                //     SELECT customer_id,invoiceid,SUM(invsbal) AS invoicebal FROM
                //     (

                //         SELECT customer_id ,id AS invoiceid,totrcvbamount AS invsbal FROM sale_invoices
                //         WHERE customer_id=$request->customer_id  AND id=$request->sale_invoice_id
                //         UNION ALL
                //          SELECT subhead_id, invoice_id,b.totrcvd*-1 AS invsbal
                //          FROM bank_transactions AS a INNER join receive_details AS b ON a.id=b.receivedid and a.subhead_id =$request->customer_id
                //          AND invoice_id =$request->sale_invoice_id
                //          UNION all
                //          SELECT a.customer_id,invoice_id,a.totrcvbamount*-1 AS invsbal
                //          FROM sale_returns AS a INNER JOIN sale_invoices AS b  ON a.invoice_id=b.id  WHERE a.customer_id =$request->customer_id
                //          AND invoice_id =$request->sale_invoice_id
                //          UNION all
                //          SELECT a.subhead_id, b.id AS  invoice_id,a.amount_fc AS invsbal
                //          FROM bank_transactions AS a INNER join sale_invoices AS b ON a.cusinvid=b.dcno AND a.subhead_id =$request->customer_id
                //          AND b.id  =$request->sale_invoice_id

                //    ) AS w GROUP BY customer_id,invoiceid
                // ) x ON c.id = x.invoiceid
                // SET c.paymentbal = x.invoicebal
                // where  c.id = $request->sale_invoice_id "));



                DB::delete(DB::raw(" delete from office_item_bal where ttypeid=4 and  transaction_id=$request->sale_invoice_id   "));

                DB::commit();


                Session::flash('success','Record Deleted Successfully');
                return response()->json(['success'],200);

            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }



    }




















}
