<?php

namespace App\Http\Controllers;

use DB;
// use App\Models\Contract;
use App\Models\Quotation;
use App\Models\QuotationDetails;

use App\Models\CustomerOrder;
use App\Models\CustomerOrderDetails;
use App\Models\SaleInvoices;


use App\Models\Material;
use App\Models\Customer;
use App\Models\Sku;
use Illuminate\Http\Request;
// use App\Models\ContractDetails;
use App\Models\Location;
use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Session;

// LocalPurchaseController
class CustomerOrderController  extends Controller
{
    public function index(Request $request)
    {
         return view('custorders.index');


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
        // $search = $request->search;
        // $size = $request->size;
        // $field = $request->sort[0]["field"];     //  Nested Array
        // $dir = $request->sort[0]["dir"];         //  Nested Array
        // $cis = CustomerOrder::select ('*')
        // ->where(function ($query) use ($search){
        //         $query->where('poseqno','LIKE','%' . $search . '%')
        //         ->orWhere('pono','LIKE','%' . $search . '%');
        //     })
        // ->with('customer:id,title')
        //  ->orderBy($field,$dir)
        // ->paginate((int) $size);
        // return $cis;

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $cis = DB::table('vwcustomerorders')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        // ->with('customer:id,title')
        ->where('custname', 'like', "%$search%")
         ->orWhere('pono', 'like', "%$search%")
         ->orWhere('pqutno', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $cis;

    }


    public function getDetails(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $contractDetails = CustomerOrderDetails::where('sale_invoice_id',$request->id)
        ->paginate((int) $size);
        return $contractDetails;
    }

    public function getMasterqut(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $contracts = DB::table('vwmasterquotations')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        ->where('custname', 'like', "%$search%")
        ->orWhere('prno', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;


    }

    public function getDetailsqut(Request $request)
    {
        $id = $request->id;
        // $abc = DB::select('call proctest0(1)');
        //  $contractDetails = DB::table('vwdetailquotations')->where('sale_invoice_id',$id)->get();
        $contractDetails = DB::select('call procdetailquotations(?,?)',array( $id,1 ));
        return response()->json($contractDetails, 200);
    }





    public function create()
    {
        // $locations = Location::select('id','title')->where('status',1)->get();

        // return view('sales.create')
        // $mycname='MUHAMMAD HABIB & Co.';
        $maxposeqno = DB::table('customer_orders')->select('*')->max('poseqno')+1;
        return \view ('custorders.create',compact('maxposeqno'))
        ->with('customers',Customer::select('id','title')->get());
        // ->with('locations',Location::select('id','title')->get())
        // ->with('skus',Sku::select('id','title')->get());

        // ->with('maxdcno',lastsalinvno::select('id','poseqno')->get());

        // ->with('lastsno',DB::table('lastsalinvno')->select('*')->get());
    }

    /** Function Complete*/
    public function store(Request $request)
    {
            //    dd($request->all());
        $this->validate($request,[
            // 'saldate' => 'required|min:3|date',
        //    'title'=>'required|min:3|unique:materials'
             'poseqno' => 'required|min:1|unique:customer_orders',
            // 'pono' => 'required|min:1|unique:customer_orders'
            // 'gpno' => 'required|min:1|unique:sale_invoices',
            // 'customer_id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $ci = new CustomerOrder();

            $ci->quotation_id = $request->quotation_id;
            $ci->qutdate = $request->qutdate;

            $ci->podate = $request->podate;
            $ci->deliverydt = $request->deliverydt;
            $ci->poseqno = $request->poseqno;
            $ci->pono = $request->pono;

            $ci->pqutno = $request->qutno;
            $ci->pprno = $request->prno;

            $ci->customer_id = $request->customer_id;
            // $ci->remarks = $request->remarks;


            $ci->discntper = $request->discntper;
            $ci->discntamt = $request->discntamt;
            $ci->cartage = $request->cartage;
            $ci->rcvblamount = $request->rcvblamount;
            $ci->salordbal = $request->rcvblamount;

            $ci->saletaxper = $request->saletaxper;
            $ci->saletaxamt = $request->saletaxamt;
            $ci->totrcvbamount = $request->totrcvbamount;
            $ci->save();

            // Quotation Close
            // $qutclose = Quotation::findOrFail($request->quotation_id);
            // $qutclose->closed = 0;
            // $qutclose->fstatus = 1;
            // $qutclose->save();


            foreach ($request->contracts as $cont) {
                // $material = Material::findOrFail($cont['id']);
                $lpd = new CustomerOrderDetails();
                $lpd->sale_invoice_id = $ci->id;
                $lpd->material_id = $cont['material_id'];
                $lpd->sku_id = $cont['sku_id'];
                $lpd->repname = $cont['repname'];
                $lpd->brand = $cont['mybrand'];
                $lpd->qtykg = $cont['saleqty'];
                $lpd->balqty = $cont['saleqty'];
                $lpd->price = $cont['price'];
                $lpd->saleamnt = $cont['saleamnt'];
                $lpd->save();
            }

            DB::update(DB::raw("
            UPDATE customer_orders c
            INNER JOIN (
            SELECT sale_invoice_id,SUM(b.qtykg) AS qty from customer_orders as a inner join customer_order_details as b on a.id=b.sale_invoice_id
            WHERE sale_invoice_id=$ci->id GROUP BY sale_invoice_id
            ) x ON c.id = x.sale_invoice_id
            SET c.tplnqty = x.qty  WHERE  c.id = $ci->id"));



            DB::update(DB::raw("
            UPDATE quotations c
            INNER JOIN (
            SELECT quotation_id,SUM(b.qtykg) AS qty,SUM(b.saleamnt) AS amount from customer_orders as a inner join customer_order_details as b on a.id=b.sale_invoice_id
            WHERE quotation_id=$ci->quotation_id GROUP BY quotation_id
            ) x ON c.id = x.quotation_id
            SET c.tqpendqty = c.tqqty - coalesce(x.qty,0), c.tqpendval = c.rcvblamount - coalesce(x.amount,0) WHERE  c.id = $ci->quotation_id"));

            DB::update(DB::raw("
            UPDATE quotation_details c
            INNER JOIN (
            SELECT quotation_id,material_id,SUM(b.qtykg) AS qty,SUM(b.saleamnt) AS amount from customer_orders as a inner join customer_order_details as b on a.id=b.sale_invoice_id
            WHERE quotation_id=$ci->quotation_id GROUP BY quotation_id,material_id
            ) x ON c.sale_invoice_id = x.quotation_id and c.material_id=x.material_id
            SET c.tqtpendqty = c.qtykg - coalesce(x.qty,0) WHERE  c.sale_invoice_id = $ci->quotation_id"));

            DB::update(DB::raw("
            UPDATE customer_orders c
            INNER JOIN (
            SELECT sale_invoice_id,SUM(b.qtykg) AS qty from customer_orders as a inner join customer_order_details as b on a.id=b.sale_invoice_id
            WHERE sale_invoice_id=$ci->id GROUP BY sale_invoice_id
            ) x ON c.id = x.sale_invoice_id
            SET c.tplnqty = x.qty  WHERE  c.id = $ci->id"));






            // }


            // DB::update(DB::raw("
            // UPDATE customer_order_details c
            // INNER JOIN (
            // SELECT b.custplan_id,a.material_id,SUM(feedqty) AS feedqty  FROM sale_invoices_details a
			// 	INNER JOIN sale_invoices AS b ON b.id=a.sale_invoice_id WHERE b.custplan_id=$ci->custplan_id GROUP BY b.custplan_id,a.material_id
            // ) x ON c.sale_invoice_id = x.custplan_id AND c.material_id=x.material_id
            // SET c.balqty = c.qtykg - x.feedqty WHERE  c.sale_invoice_id = $ci->custplan_id"));


            ///**** Master Update










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

        $stockdtl = DB::select('call procdetailquotations(?,?)',array( $id,2 ));
        $cd = DB::table('customer_order_details')
        ->join('materials', 'materials.id', '=', 'customer_order_details.material_id')
        ->join('skus', 'skus.id', '=', 'customer_order_details.sku_id')
        ->leftJoin('tmptblinvswsstock','tmptblinvswsstock.material_id', '=', 'customer_order_details.material_id')
        ->select('customer_order_details.*','materials.title as material_title','materials.dimension','skus.title as sku',
        DB::raw('( CASE customer_order_details.sku_id  WHEN  1 THEN tmptblinvswsstock.qtykg WHEN 2 THEN tmptblinvswsstock.qtypcs WHEN 3 THEN tmptblinvswsstock.qtyfeet  END) AS balqty')
        ,DB::raw('( CASE customer_order_details.sku_id  WHEN  1 THEN tmptblinvswsstock.qtykg - customer_order_details.qtykg  WHEN 2 THEN tmptblinvswsstock.qtypcs - customer_order_details.qtykg WHEN 3 THEN tmptblinvswsstock.qtyfeet - customer_order_details.qtykg  END) AS varqty') )
        ->where('sale_invoice_id',$id)->get();
         $data=compact('cd');


        return view('custorders.edit',compact('passwrd'))
        ->with('customer',Customer::select('id','title')->get())
        ->with('customerorder',CustomerOrder::findOrFail($id))
        ->with($data)
        ->with('skus',Sku::select('id','title')->get());

        // return view('contracts.edit')->with('suppliers',Supplier::select('id','title')->get())->with('contract',$contract)->with('cd',ContractDetails::where('contract_id',$contract->id)->get());
    }


    public function deleterec($id)
    {


        $rsrvpo = SaleInvoices::where('custplan_id',$id)->max('custplan_id');;

        $passwrd = DB::table('tblpwrd')->select('pwrdtxtdel')->max('pwrdtxtdel');
        $stockdtl = DB::select('call procdetailquotations(?,?)',array( $id,2 ));
        $cd = DB::table('customer_order_details')
        ->join('materials', 'materials.id', '=', 'customer_order_details.material_id')
        ->join('skus', 'skus.id', '=', 'customer_order_details.sku_id')
        ->leftJoin('tmptblinvswsstock','tmptblinvswsstock.material_id', '=', 'customer_order_details.material_id')
        ->select('customer_order_details.*','materials.title as material_title','materials.dimension','skus.title as sku',
        DB::raw('( CASE customer_order_details.sku_id  WHEN  1 THEN tmptblinvswsstock.qtykg WHEN 2 THEN tmptblinvswsstock.qtypcs WHEN 3 THEN tmptblinvswsstock.qtyfeet  END) AS balqty')
        ,DB::raw('( CASE customer_order_details.sku_id  WHEN  1 THEN tmptblinvswsstock.qtykg - customer_order_details.qtykg  WHEN 2 THEN tmptblinvswsstock.qtypcs - customer_order_details.qtykg WHEN 3 THEN tmptblinvswsstock.qtyfeet - customer_order_details.qtykg  END) AS varqty') )
        ->where('sale_invoice_id',$id)->get();
         $data=compact('cd');


        return view('custorders.deleterec',compact('passwrd','rsrvpo'))
        ->with('customer',Customer::select('id','title')->get())
        ->with('customerorder',CustomerOrder::findOrFail($id))
        ->with($data)
        ->with('skus',Sku::select('id','title')->get());

        // return view('contracts.edit')->with('suppliers',Supplier::select('id','title')->get())->with('contract',$contract)->with('cd',ContractDetails::where('contract_id',$contract->id)->get());
    }







    public function update(Request $request, CustomerOrder $customerorder)
    {
        //  dd($commercialinvoice->commercial_invoice_id());
            //   dd($request->all());
        DB::beginTransaction();
        try {

            //  dd($request->sale_invoice_id);
            $customerorder = CustomerOrder::findOrFail($request->sale_invoice_id);
            $customerorder->quotation_id = $request->quotation_id;
            $customerorder->podate = $request->podate;
            $customerorder->deliverydt = $request->deliverydt;
            $customerorder->poseqno = $request->poseqno;
            $customerorder->pono = $request->pono;
            $customerorder->pqutno = $request->qutno;
            $customerorder->qutdate = $request->qutdate;
            $customerorder->pprno = $request->prno;
            $customerorder->customer_id = $request->customer_id;
            // $customerorder->remarks = $request->remarks;
            $customerorder->discntper = $request->discntper;
            $customerorder->discntamt = $request->discntamt;
            $customerorder->cartage = $request->cartage;


            $customerorder->rcvblamount = $request->rcvblamount;

            $customerorder->salordbal = $request->rcvblamount-$request->delivered;



            $customerorder->saletaxper = $request->saletaxper;
            $customerorder->saletaxamt = $request->saletaxamt;
            $customerorder->totrcvbamount = $request->totrcvbamount;
            $customerorder->save();



            // Get Data
            $cds = $request->customerorder; // This is array
            $cds = CustomerOrderDetails::hydrate($cds); // Convert it into Model Collection
            // Now get old ContractDetails and then get the difference and delete difference
            $oldcd = CustomerOrderDetails::where('sale_invoice_id',$customerorder->id)->get();
            $deleted = $oldcd->diff($cds);
            //  Delete contract details if marked for deletion
            foreach ($deleted as $d) {
                $d->delete();
            }
            // Now update existing and add new
            foreach ($cds as $cd) {
                if($cd->id)
                {
                    $cds = CustomerOrderDetails::where('id',$cd->id)->first();
                    $cds->sale_invoice_id = $customerorder->id;
                    $cds->material_id = $cd->material_id;
                    $cds->sku_id = $cd->sku_id;
                    $cds->repname = $cd['repname'];
                    $cds->brand = $cd['brand'];
                    $cds->qtykg = $cd['qtykg'];
                    $cds->balqty = $cd['qtykg'];
                    $cds->price = $cd['price'];
                    $cds->saleamnt = $cd['saleamnt'];
                    $unit = Sku::where("title", $cd['sku'])->first();
                     $cds->sku_id = $unit->id;
                    //  $cds->sku = $cd['sku'];

                 $cds->save();
                }else
                {
                    //  The item is new, Add it
                     $cds = new CustomerOrderDetails();

                     $cds->sale_invoice_id = $customerorder->id;
                     $cds->material_id = $cd->material_id;
                     $cds->sku_id = $cd->sku_id;
                     $cds->repname = $cd['repname'];
                     $cds->brand = $cd['brand'];
                     $cds->qtykg = $cd['qtykg'];
                     $cds->price = $cd['price'];
                     $cds->saleamnt = $cd['saleamnt'];

                     $unit = Sku::where("title", $cd['sku'])->first();
                      $cds->sku_id = $unit->id;
                     // $cds->sale_invoice_id = $saleinvoices->id;
                    // $cds->material_id = $cd->material_id;
                    // $cds->sku_id = $cd->sku_id;

                    // $cds->qtykg = $cd['bundle1'];
                    // $cds->qtypcs = $cd['bundle2'];
                    // $cds->qtyfeet = $cd['pcspbundle2'];
                    // $cds->price = $cd['pcspbundle1'];
                    // $cds->saleamnt = $cd['ttpcs'];
                    // $cds->locid = $cd['location'];
                    // $cds->salunitid = $cd['sku'];

                    // $cds->sale_invoice_id = $custorders->id;
                    // $cds->material_id = $cd->material_id;
                    // $cds->sku_id = $cd->sku_id;
                    // $cds->repname = $cd['repname'];
                    // $cds->qtykg = $cd['qtykg'];
                    // $cds->qtypcs = $cd['qtypcs'];
                    // $cds->qtyfeet = $cd['qtyfeet'];
                    // $cds->price = $cd['price'];
                    // $cds->saleamnt = $cd['saleamnt'];

                    //  $location = Location::where("title", $cd['location'])->first();
                    //  $cds->locid = $location->id;
                    //  $cds->location = $cd['location'];

                    //  $unit = Sku::where("title", $cd['sku'])->first();
                    //  $cds->sku_id = $unit->id;
                    //  $cds->sku = $cd['sku'];


                    $cds->save();
                }
            }

            DB::update(DB::raw("
            UPDATE customer_orders c
            INNER JOIN (
            SELECT sale_invoice_id,SUM(b.qtykg) AS qty from customer_orders as a inner join customer_order_details as b on a.id=b.sale_invoice_id
            WHERE sale_invoice_id=$customerorder->id GROUP BY sale_invoice_id
            ) x ON c.id = x.sale_invoice_id
            SET c.tplnqty = x.qty  WHERE  c.id = $customerorder->id"));



            //// Details update
            DB::update(DB::raw("
            UPDATE customer_order_details c
            INNER JOIN (
            SELECT b.custplan_id,a.material_id,SUM(feedqty) AS feedqty  FROM sale_invoices_details a
				INNER JOIN sale_invoices AS b ON b.id=a.sale_invoice_id WHERE b.custplan_id=$customerorder->id GROUP BY b.custplan_id,a.material_id
            ) x ON c.sale_invoice_id = x.custplan_id AND c.material_id=x.material_id
            SET c.balqty = c.qtykg - x.feedqty WHERE  c.sale_invoice_id = $customerorder->id"));


            ///**** Master Update
            DB::update(DB::raw("
            UPDATE customer_orders c
            INNER JOIN (
            SELECT custplan_id,SUM(totrcvbamount)-SUM(cartage) AS Dlvred FROM sale_invoices WHERE custplan_id=$customerorder->id
				GROUP BY custplan_id
            ) x ON c.id = x.custplan_id
            SET c.delivered = x.Dlvred,c.salordbal=( coalesce(totrcvbamount,0)-coalesce(cartage,0) )-x.Dlvred WHERE  c.id = $customerorder->id"));


            DB::update(DB::raw("
            UPDATE quotations c
            INNER JOIN (
            SELECT quotation_id,SUM(b.qtykg) AS qty,SUM(b.saleamnt) AS amount from customer_orders as a inner join customer_order_details as b on a.id=b.sale_invoice_id
            WHERE quotation_id=$customerorder->quotation_id GROUP BY quotation_id
            ) x ON c.id = x.quotation_id
            SET c.tqpendqty = c.tqqty - coalesce(x.qty,0), c.tqpendval = c.rcvblamount - coalesce(x.amount,0) WHERE  c.id = $customerorder->quotation_id"));

            DB::update(DB::raw("
            UPDATE quotation_details c
            INNER JOIN (
            SELECT quotation_id,material_id,SUM(b.qtykg) AS qty,SUM(b.saleamnt) AS amount from customer_orders as a inner join customer_order_details as b on a.id=b.sale_invoice_id
            WHERE quotation_id=$customerorder->quotation_id GROUP BY quotation_id,material_id
            ) x ON c.sale_invoice_id = x.quotation_id and c.material_id=x.material_id
            SET c.tqtpendqty = c.qtykg - coalesce(x.qty,0) WHERE  c.sale_invoice_id = $customerorder->quotation_id"));




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
        // $vrtype = $request->p2;
        // $hdng1 = $request->cname;
        // $hdng2 = $request->csdrs;
        // $hdng3 = $request->toc;
        // $head_id = $request->head_id;
        // $head = Head::findOrFail($head_id);
        // $head = Customer::findOrFail($head_id);
        // if($request->has('subhead_id')){
        //     $subhead_id = $request->subhead_id;
            //  Clear Data from Table
            DB::table('tmpqutparrpt')->truncate();
            // foreach($request->subhead_id as $id)
            // {
                DB::table('tmpqutparrpt')->insert([ 'qutid' => $id ]);
        //     }
        // }
        //  Call Procedure
        $mpdf = $this->getMPDFSettings();

        // if($vrtype == 0)
        // {
            $data = DB::select('call procsaleorders()');
        // }
        // if($vrtype == 1)
        // {
        //     $data = DB::select('call proccompsaleorders()');
        // }

        if(!$data)
        {
            Session::flash('info','No data available');
            return redirect()->back();
        }
        $mpdf = $this->getMPDFSettings();
        $collection = collect($data);                   //  Make array a collection
        // $grouped = $collection->groupBy('SupName');       //  Sort collection by SupName
        $grouped = $collection->groupBy('id');       //  Sort collection by SupName
        $grouped->values()->all();                       //  values() removes indices of array

        // dd($grouped);

        foreach($grouped as $g){
             $html =  view('custorders.print')->with('data',$g)->render();
            //  ->with('fromdate',$fromdate)
            //  ->with('todate',$todate)
            //  ->with('headtype',$head->title)
            //  ->with('hdng1',$hdng1)->with('hdng2',$hdng2)->with('hdng3',$hdng3)
            //  ->render();
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





                DB::update(DB::raw("
                UPDATE quotations c
                INNER JOIN (
                SELECT quotation_id,SUM(b.qtykg) AS qty,SUM(b.saleamnt) AS amount from customer_orders as a inner join customer_order_details as b on a.id=b.sale_invoice_id
                WHERE quotation_id=$request->quotation_id GROUP BY quotation_id
                ) x ON c.id = x.quotation_id
                SET c.tqpendqty = c.tqpendqty + coalesce(x.qty,0), c.tqpendval = c.tqpendval + coalesce(x.amount,0) WHERE  c.id = $request->quotation_id"));

                DB::update(DB::raw("
                UPDATE quotation_details c
                INNER JOIN (
                SELECT quotation_id,material_id,SUM(b.qtykg) AS qty,SUM(b.saleamnt) AS amount from customer_orders as a inner join customer_order_details as b on a.id=b.sale_invoice_id
                WHERE quotation_id=$request->quotation_id GROUP BY quotation_id,material_id
                ) x ON c.sale_invoice_id = x.quotation_id and c.material_id=x.material_id
                SET c.tqtpendqty = c.tqtpendqty + coalesce(x.qty,0) WHERE  c.sale_invoice_id = $request->quotation_id"));



                DB::delete(DB::raw(" delete from customer_orders where id=$request->sale_invoice_id   "));
                DB::delete(DB::raw(" delete from customer_order_details where sale_invoice_id=$request->sale_invoice_id   "));










                DB::commit();


                Session::flash('success','Record Deleted Successfully');
                return response()->json(['success'],200);

            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }



    }






}
