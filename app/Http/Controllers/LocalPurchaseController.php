<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Contract;
use App\Models\CommercialInvoice;
use App\Models\CommercialInvoiceDetails;
use App\Models\Material;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\ContractDetails;
use App\Models\Location;
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
            ->whereHas('supplier', function ($query) {
                $query->where('source_id','=','1');
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
        $contractDetails = CommercialInvoiceDetails::where('commercial_invoice_id',$request->id)
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
        return view('localpurchase.create')
        ->with('suppliers',Supplier::select('id','title')->get())
        ->with('locations',Location::select('id','title')->get());
    }

    /** Function Complete*/
    public function store(Request $request)
    {
            //   dd($request->all());
        $this->validate($request,[
            'invoice_date' => 'required|min:3|date',
            'number' => 'required|min:3',
            'supplier_id' => 'required'
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
            // bankcharges,collofcustom,exataxoffie,bankntotal
            $ci = new CommercialInvoice();
            $ci->invoice_date = $request->invoice_date;
            $ci->invoiceno = $request->number;
            $ci->contract_id = 0;
            $ci->challanno = $request->number;
            $ci->supplier_id = $request->supplier_id;
            $ci->machine_date = $request->invoice_date;
            $ci->machineno = $request->number;
            $ci->conversionrate = 0;
            $ci->insurance = 0;
            $ci->bankcharges = $request->bankcharges;
            $ci->collofcustom = $request->collofcustom;
            $ci->exataxoffie = $request->exataxoffie;
            $ci->lngnshipdochrgs = 0;
            $ci->localcartage = 0;
            $ci->miscexplunchetc = 0;
            $ci->customsepoy = 0;
            $ci->weighbridge = 0;
            $ci->miscexpenses = 0;
            $ci->agencychrgs = 0;
            $ci->otherchrgs = 0;
            $ci->total = $request->bankntotal;
            $ci->save();



            foreach ($request->contracts as $cont) {
                $material = Material::findOrFail($cont['id']);
                $lpd = new CommercialInvoiceDetails();
                $lpd->machine_date = $ci->invoice_date;
                $lpd->machineno = $ci->invoiceno;
                $lpd->invoiceno = $ci->invoiceno;
                $lpd->commercial_invoice_id = $ci->id;
                $lpd->contract_id = 0;
                $lpd->material_id = $material->id;
                $lpd->supplier_id = $ci->supplier_id;
                $lpd->user_id = auth()->id();
                $lpd->category_id = $material->category_id;
                $lpd->sku_id = $material->sku_id;
                $lpd->dimension_id = $material->dimension_id;
                $lpd->source_id = $material->source_id;
                $lpd->brand_id = $material->brand_id;
                $lpd->hscode = '12314';
                $lpd->itmratio = 0;

                $lpd->gdswt = $cont['bundle1'];
                $lpd->perkg = $cont['pcspbundle1'];
                $lpd->amtinpkr = $cont['ttpcs'];
                $lpd->location = $cont['location'];
                $location = Location::where("title", $cont['location'])->first();
                $lpd->locid = $location->id;

                $lpd->qtyinfeet = 0;
                $lpd->perft = 0;

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

        //    dd(('locations'));
        return view('localpurchase.edit')
        ->with('suppliers',Supplier::select('id','title')->get())
        //->with('materials',Material::select('id','category')->get())
        ->with('commercialInvoice',CommercialInvoice::findOrFail($id))
        ->with('cd',CommercialInvoiceDetails::where('commercial_invoice_id',$id)->get())
        ->with('locations',Location::select('id','title')->get());

        // return view('contracts.edit')->with('suppliers',Supplier::select('id','title')->get())->with('contract',$contract)->with('cd',ContractDetails::where('contract_id',$contract->id)->get());
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

            $commercialinvoice = CommercialInvoice::findOrFail($request->contract_id);
            $commercialinvoice->invoiceno = $request->invoiceno;
            $commercialinvoice->invoice_date = $request->invoice_date;
            $commercialinvoice->supplier_id = $request->supplier_id;
            $commercialinvoice->contract_id = 0;
            $commercialinvoice->challanno = $request->invoiceno;
            $commercialinvoice->machine_date = $request->invoice_date;
            $commercialinvoice->machineno = $request->invoiceno;
            $commercialinvoice->bankcharges = $request->bankcharges;
            $commercialinvoice->collofcustom = $request->collofcustom;;
            $commercialinvoice->exataxoffie = $request->exataxoffie;
            $commercialinvoice->total = $request->bankntotal;

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
                    $cds->contract_id = 0;
                    $cds->material_id = $cd->material_id;
                    // $cds->material_title = $cd->material_title;
                    $cds->supplier_id = $cd->supplier_id;
                    $cds->user_id = $cd->user_id;
                    $cds->category_id = $cd->category_id;
                    $cds->sku_id = $cd->sku_id;
                    $cds->dimension_id = $cd->dimension_id;
                    $cds->source_id = $cd->source_id;
                    $cds->brand_id = $cd->brand_id;
                    $cds->gdswt = $cd->gdswt;
                    $cds->perkg = $cd->perkg;
                    $cds->amtinpkr = $cd->amtinpkr;
                    $cds->location = $cd->location;
                    $location = Location::where("title", $cd['location'])->first();
                    $cds->locid = $location->id;
                    $cds->save();
                }else
                {
                    //  The item is new, Add it
                    $cds = new CommercialInvoiceDetails();
                    $cds->contract_id = $contract->id;
                    $cds->material_id = $cd->material_id;
                    // $cds->material_title = $cd->material_title;
                    $cds->supplier_id = $contract->supplier_id;
                    $cds->user_id = auth()->id();
                    $cds->category_id = $cd->category_id;
                    $cds->sku_id = $cd->sku_id;
                    $cds->dimension_id = $cd->dimension_id;
                    $cds->source_id = $cd->source_id;
                    $cds->brand_id = $cd->brand_id;
                    // $cds->category = $cd->category;
                    // $cds->sku = $cd->sku;
                    // $cds->dimension = $cd->dimension;
                    // $cds->source = $cd->source;
                    // $cds->brand = $cd->brand;
                    $cds->gdswt = $cd->gdswt;
                    $cds->perkg = $cd->perkg;
                    $cds->amtinpkr = $cd->amtinpkr;
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