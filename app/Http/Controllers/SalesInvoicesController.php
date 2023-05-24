<?php

namespace App\Http\Controllers;

use DB;
// use App\Models\Contract;
use App\Models\SaleInvoices;
use App\Models\SaleInvoicesDetails;
use App\Models\Material;
use App\Models\Customer;
use App\Models\Sku;
use Illuminate\Http\Request;
// use App\Models\ContractDetails;
use App\Models\Location;
use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Session;

// LocalPurchaseController
class SalesInvoicesController  extends Controller
{
    public function index(Request $request)
    {
         return view('sales.index');


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
        $cis = SaleInvoices::where('status',$status)
        ->where(function ($query) use ($search){
                $query->where('dcno','LIKE','%' . $search . '%')
                ->orWhere('gpno','LIKE','%' . $search . '%')
                ->orWhere('billno','LIKE','%' . $search . '%');
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
        $contractDetails = SaleInvoicesDetails::where('sale_invoice_id',$request->id)
        ->paginate((int) $size);
        return $contractDetails;
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
        // $locations = Location::select('id','title')->where('status',1)->get();

        // return view('sales.create')
        $maxdcno = DB::table('sale_invoices')->select('*')->max('dcno')+1;
        $maxblno = DB::table('sale_invoices')->select('*')->max('billno')+1;
        $maxgpno = DB::table('sale_invoices')->select('*')->max('gpno')+1;
        return \view ('sales.create',compact('maxdcno','maxblno','maxgpno'))
        ->with('customers',Customer::select('id','title')->get())
        ->with('locations',Location::select('id','title')->get())
        ->with('skus',Sku::select('id','title')->get());

        // ->with('maxdcno',lastsalinvno::select('id','dcno')->get());

        // ->with('lastsno',DB::table('lastsalinvno')->select('*')->get());
    }

    /** Function Complete*/
    public function store(Request $request)
    {
            //    dd($request->all());
        $this->validate($request,[
            'saldate' => 'required|min:3|date',
        //    'title'=>'required|min:3|unique:materials'
            'dcno' => 'required|min:1|unique:sale_invoices',
            'billno' => 'required|min:1|unique:sale_invoices',
            'gpno' => 'required|min:1|unique:sale_invoices',
            'customer_id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $ci = new SaleInvoices();
            $ci->saldate = $request->saldate;
            $ci->dcno = $request->dcno;
            $ci->billno = $request->billno;
            $ci->gpno = $request->gpno;
            $ci->customer_id = $request->customer_id;
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
                $lpd = new SaleInvoicesDetails();
                $lpd->sale_invoice_id = $ci->id;
                $lpd->material_id = $material->id;
                $lpd->sku_id = $material->sku_id;

                $lpd->qtykg = $cont['bundle1'];
                $lpd->qtypcs = $cont['bundle2'];
                $lpd->qtyfeet = $cont['pcspbundle2'];
                $lpd->price = $cont['pcspbundle1'];
                $lpd->saleamnt = $cont['ttpcs'];

                $location = Location::where("title", $cont['location'])->first();
                $lpd->locid = $location->id;
                $lpd->location = $cont['location'];

                $unit = Sku::where("title", $cont['sku'])->first();
                $lpd->salunitid = $unit->id;
                $lpd->sku = $cont['sku'];
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

        return view('sales.edit')
        ->with('customer',Customer::select('id','title')->get())
        // ->with('materials',Material::select('id','category')->get())
        ->with('saleinvoices',SaleInvoices::findOrFail($id))
        ->with('cd',SaleInvoicesDetails::where('sale_invoice_id',$id)->get())
        ->with('locations',Location::select('id','title')->get())
        ->with('skus',Sku::select('id','title')->get());

        // return view('contracts.edit')->with('suppliers',Supplier::select('id','title')->get())->with('contract',$contract)->with('cd',ContractDetails::where('contract_id',$contract->id)->get());
    }


    public function update(Request $request, SaleInvoices $saleinvoices)
    {
        //  dd($commercialinvoice->commercial_invoice_id());
            //  dd($request->all());




        DB::beginTransaction();
        try {

            $saleinvoices = SaleInvoices::findOrFail($request->sale_invoice_id);
            $saleinvoices->saldate = $request->saldate;
            $saleinvoices->dcno = $request->dcno;
            $saleinvoices->billno = $request->billno;
            $saleinvoices->gpno = $request->gpno;
            $saleinvoices->customer_id = $request->customer_id;
            $saleinvoices->discntper = $request->discntper;
            $saleinvoices->discntamt = $request->discntamt;
            $saleinvoices->cartage = $request->cartage;
            $saleinvoices->rcvblamount = $request->rcvblamount;
            $saleinvoices->saletaxper = $request->saletaxper;
            $saleinvoices->saletaxamt = $request->saletaxamt;
            $saleinvoices->totrcvbamount = $request->totrcvbamount;

            $saleinvoices->save();
            // Get Data
            $cds = $request->sales; // This is array
            $cds = SaleInvoicesDetails::hydrate($cds); // Convert it into Model Collection
            // Now get old ContractDetails and then get the difference and delete difference
            $oldcd = SaleInvoicesDetails::where('sale_invoice_id',$saleinvoices->id)->get();
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

                    $cds->sale_invoice_id = $saleinvoices->id;
                    $cds->material_id = $cd->material_id;
                    $cds->sku_id = $cd->sku_id;

                    $cds->qtykg = $cd['qtykg'];
                    $cds->qtypcs = $cd['qtypcs'];
                    $cds->qtyfeet = $cd['qtyfeet'];
                    $cds->price = $cd['price'];
                    $cds->saleamnt = $cd['saleamnt'];

                $location = Location::where("title", $cd['location'])->first();
                $cds->locid = $location->id;
                $cds->location = $cd['location'];

                $unit = Sku::where("title", $cd['sku'])->first();
                $cds->salunitid = $unit->id;
                $cds->sku = $cd['sku'];

                 $cds->save();
                }else
                {
                    //  The item is new, Add it
                    // $cds = new SaleInvoicesDetails();
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
