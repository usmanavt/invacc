<?php

namespace App\Http\Controllers;

use DB;
// use App\Models\Contract;
use App\Models\Quotation;
use App\Models\QuotationDetails;

use App\Models\CustomerOrder;
use App\Models\CustomerOrderDetails;

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
        // dd($request->all());
        $status =$request->status ;
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $cis = CustomerOrder::where('status',$status)
        ->where(function ($query) use ($search){
                $query->where('poseqno','LIKE','%' . $search . '%')
                // ->orWhere('gpno','LIKE','%' . $search . '%')
                ->orWhere('pono','LIKE','%' . $search . '%');
            })
            // ->whereHas('customer', function ($query) {
            //      $query->where('source_id','=','1');
            // })
        ->with('customer:id,title')
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
        $contractDetails = DB::table('vwdetailquotations')->where('sale_invoice_id',$id)->get();
        return response()->json($contractDetails, 200);
    }





    public function create()
    {
        // $locations = Location::select('id','title')->where('status',1)->get();

        // return view('sales.create')
        $mycname='MUHAMMAD HABIB & Co.';
        $maxdcno = DB::table('customer_orders')->select('*')->max('poseqno')+1;
        return \view ('custorders.create',compact('maxdcno','mycname'))
        ->with('customers',Customer::select('id','title')->get())
        ->with('locations',Location::select('id','title')->get())
        ->with('skus',Sku::select('id','title')->get());

        // ->with('maxdcno',lastsalinvno::select('id','poseqno')->get());

        // ->with('lastsno',DB::table('lastsalinvno')->select('*')->get());
    }

    /** Function Complete*/
    public function store(Request $request)
    {
            //    dd($request->all());
        $this->validate($request,[
            'saldate' => 'required|min:3|date',
        //    'title'=>'required|min:3|unique:materials'
            'poseqno' => 'required|min:1|unique:quotations',
            'pono' => 'required|min:1|unique:quotations',
            // 'gpno' => 'required|min:1|unique:sale_invoices',
            'customer_id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $ci = new CustomerOrder();
            $ci->saldate = $request->saldate;
            $ci->valdate = $request->valdate;
            $ci->poseqno = $request->poseqno;
            $ci->pono = $request->pono;
            $ci->customer_id = $request->customer_id;


            $ci->cashcustomer = $request->cashcustomer;
            $ci->cashcustadrs = $request->cashcustadrs;


            $ci->discntper = $request->discntper;
            $ci->discntamt = $request->discntamt;
            $ci->cartage = $request->cartage;
            $ci->rcvblamount = $request->rcvblamount;

            $ci->saletaxper = $request->saletaxper;
            $ci->saletaxamt = $request->saletaxamt;
            $ci->totrcvbamount = $request->totrcvbamount;
            $ci->save();
            foreach ($request->contracts as $cont) {
                $material = Material::findOrFail($cont['id']);
                $lpd = new CustomerOrderDetails();
                $lpd->sale_invoice_id = $ci->id;
                $lpd->material_id = $material->id;
                $lpd->repname = $cont['repname'];
                $lpd->mybrand = $cont['mybrand'];
                $lpd->qtykg = $cont['bundle1'];
                $lpd->price = $cont['pcspbundle1'];
                $lpd->saleamnt = $cont['ttpcs'];

                // $location = Location::where("title", $cont['location'])->first();
                // $lpd->locid = $location->id;
                // $lpd->location = $cont['location'];

                $unit = Sku::where("title", $cont['sku'])->first();
                $lpd->sku_id = $unit->id;
                // $lpd->sku = $cont['sku'];
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

        $cd = DB::table('quotation_details')
        ->join('materials', 'materials.id', '=', 'quotation_details.material_id')
        ->join('skus', 'skus.id', '=', 'quotation_details.sku_id')
        ->select('quotation_details.*','materials.title as material_title','materials.dimension','skus.title as sku')
        ->where('sale_invoice_id',$id)->get();
         $data=compact('cd');

        // DB::table('skus')->select('id AS dunitid','title AS dunit')
        // ->whereIn('id',[1,2])->get();



        return view('quotations.edit')
        ->with('customer',Customer::select('id','title')->get())
        // ->with('materials',Material::select('id','category')->get())
        ->with('customerorder',CustomerOrder::findOrFail($id))
        // ->with('cd',CustomerOrderDetails::where('sale_invoice_id',$id)->get())
        ->with($data)
        ->with('locations',Location::select('id','title')->get())
        ->with('skus',Sku::select('id','title')->get());

        // return view('contracts.edit')->with('suppliers',Supplier::select('id','title')->get())->with('contract',$contract)->with('cd',ContractDetails::where('contract_id',$contract->id)->get());
    }


    public function update(Request $request, CustomerOrder $customerorder)
    {
        //  dd($commercialinvoice->commercial_invoice_id());
            //   dd($request->all());




        DB::beginTransaction();
        try {

            // dd($quotation);
            $customerorder = CustomerOrder::findOrFail($request->sale_invoice_id);
            $customerorder->saldate = $request->saldate;
            $customerorder->valdate = $request->valdate;
            $customerorder->poseqno = $request->poseqno;
            $customerorder->pono = $request->pono;
            $customerorder->customer_id = $request->customer_id;
            $customerorder->cashcustomer = $request->cashcustomer;
            $customerorder->cashcustadrs = $request->cashcustadrs;

            $customerorder->discntper = $request->discntper;
            $customerorder->discntamt = $request->discntamt;
            $customerorder->cartage = $request->cartage;
            $customerorder->rcvblamount = $request->rcvblamount;
            $customerorder->saletaxper = $request->saletaxper;
            $customerorder->saletaxamt = $request->saletaxamt;
            $customerorder->totrcvbamount = $request->totrcvbamount;

            $customerorder->save();
            // Get Data
            $cds = $request->quotations; // This is array
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
                    $cds->mybrand = $cd['mybrand'];
                    $cds->qtykg = $cd['qtykg'];
                    // $cds->qtypcs = $cd['qtypcs'];
                    // $cds->qtyfeet = $cd['qtyfeet'];
                    $cds->price = $cd['price'];
                    $cds->saleamnt = $cd['saleamnt'];

                    //  $location = Location::where("title", $cd['location'])->first();
                    //  $cds->locid = $location->id;
                    //   $cds->location = $cd['location'];

                     $unit = Sku::where("title", $cd['sku'])->first();
                     $cds->sku_id = $unit->id;
                    //  $cds->sku = $cd['sku'];

                 $cds->save();
                }else
                {
                    //  The item is new, Add it
                     $cds = new CustomerOrderDetails();
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

                    $cds->sale_invoice_id = $customerorder->id;
                    $cds->material_id = $cd->material_id;
                    $cds->sku_id = $cd->sku_id;
                    $cds->repname = $cd['repname'];
                    $cds->qtykg = $cd['qtykg'];
                    // $cds->qtypcs = $cd['qtypcs'];
                    // $cds->qtyfeet = $cd['qtyfeet'];
                    $cds->price = $cd['price'];
                    $cds->saleamnt = $cd['saleamnt'];

                    //  $location = Location::where("title", $cd['location'])->first();
                    //  $cds->locid = $location->id;
                    //  $cds->location = $cd['location'];

                     $unit = Sku::where("title", $cd['sku'])->first();
                     $cds->sku_id = $unit->id;
                    //  $cds->sku = $cd['sku'];


                    $cds->save();
                }
            }
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
