<?php

namespace App\Http\Controllers;

use DB;
// use App\Models\Contract;
use App\Models\Quotation;
use App\Models\QuotationDetails;

use App\Models\CustomerOrder;
use App\Models\CustomerOrderDetails;

use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetails;

use App\Models\Supplier;


use App\Models\Material;
use App\Models\Customer;
use App\Models\Sku;
use Illuminate\Http\Request;
// use App\Models\ContractDetails;
use App\Models\Location;
use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Session;


// LocalPurchaseController
class PurchaseReturnController  extends Controller
{
    public function index(Request $request)
    {
         return view('purchasereturn.index');


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

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $cis = DB::table('vwprmast')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        // ->with('customer:id,title')
        ->where('supname', 'like', "%$search%")
         ->orWhere('prno', 'like', "%$search%")
         ->orWhere('commercial_invoice_id', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $cis;

    }


    public function getDetails(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $contractDetails = purchase_return_details::where('prid',$request->id)
        ->paginate((int) $size);
        return $contractDetails;
    }

    public function getMasterqut(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $contracts = DB::table('vwsalefrprmast')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        ->where('supname', 'like', "%$search%")
        ->orWhere('invoiceno', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;


    }

    public function getDetailsqut(Request $request)
    {
        $id = $request->id;
        // $abc = DB::select('call proctest0(1)');
        //  $contractDetails = DB::table('vwdetailquotations')->where('sale_invoice_id',$id)->get();
        $contractDetails = DB::select('call procprdetail(?)',array( $id ));
        return response()->json($contractDetails, 200);
    }


    public function create()
    {
        // $locations = Location::select('id','title')->where('status',1)->get();

        // return view('sales.create')
        // $mycname='MUHAMMAD HABIB & Co.';
        $maxposeqno = DB::table('purchase_returns')->select('*')->max('prno')+1;
        return \view ('purchasereturn.create',compact('maxposeqno'))
        ->with('supplier',Supplier::select('id','title')->get());
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
            $qutclose = Quotation::findOrFail($request->quotation_id);
            $qutclose->closed = 0;
            $qutclose->save();


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
            // }
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


        return view('custorders.edit')
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






            DB::commit();
            Session::flash('success','Contract Information Saved');
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }


    public function destroy(Contract $contract)
    {
        //
    }

    public function printContract($id)
    {
        // dd($id);
        $contract = Contract::findOrFail($id);
        $cd = ContractDetails::where('contract_id',$contract->id)->get();
        $html = view('contracts.print')->with('cd',$cd)->with('contract',$contract)->render();
        $filename = $contract->id . '.pdf';
        ini_set('max_execution_time', '2000');
        ini_set("pcre.backtrack_limit", "100000000");
        ini_set("memory_limit","8000M");
        ini_set('allow_url_fopen',1);
        $temp = storage_path('temp');
        // Create the mPDF document
        $mpdf = new PDF( [
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_header' => '3',
            'margin_top' => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
            'default_font_size' => 9,
            'orientation' => 'L'
        ]);
        $mpdf->SetHTMLFooter('
            <table width="100%" style="border-top:1px solid gray">
                <tr>
                    <td width="33%">{DATE j-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    <td width="33%" style="text-align: right;">' . $filename . '</td>
                </tr>
            </table>');
        $chunks = explode("chunk", $html);
        foreach($chunks as $key => $val) {
            $mpdf->WriteHTML($val);
        }
        $mpdf->Output($filename,'I');
        // 'D': download the PDF file
        // 'I': serves in-line to the browser
        // 'S': returns the PDF document as a string
        // 'F': save as file $file_out
    }
}
