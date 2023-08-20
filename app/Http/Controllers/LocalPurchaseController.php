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
        $maxgpno = DB::table('commercial_invoices')->select('gpassno')->max('gpassno')+1;
        return view('localpurchase.create',compact('maxgpno'))
        // return \view ('sales.create',compact('maxdcno','maxblno','maxgpno'))
        ->with('suppliers',Supplier::select('id','title')->where('source_id',1)->get())
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
            $ci->challanno = $request->number;
            $ci->supplier_id = $request->supplier_id;
            $ci->machine_date = $request->invoice_date;
            // $ci->machineno = $request->number;
            $ci->conversionrate = 0;

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

                $lpd->length = 0;
                $lpd->gdsprice = $cont['gdsprice'];
                $lpd->amtinpkr = $cont['amtinpkr'];
                $lpd->location = $cont['location'];
                $location = Location::where("title", $cont['location'])->first();
                $lpd->locid = $location->id;
                $unitid = Sku::where("title", $cont['sku'])->first();
                $lpd->sku_id = $unitid->id;

                if($lpd->sku_id==1)   { $lpd->gdswt = $cont['gdswt']; }
                if($lpd->sku_id==2)   { $lpd->pcs = $cont['gdswt']; }
                if($lpd->sku_id==3)   { $lpd->qtyinfeet = $cont['gdswt']; }

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


        $cd = DB::table('commercial_invoices as a')
        ->join('commercial_invoice_details as b', 'a.id', '=', 'b.commercial_invoice_id')
        ->join('materials as c', 'c.id', '=', 'b.material_id')
        ->join('skus as d', 'd.id', '=', 'b.sku_id')
        ->select('c.id as material_id','c.title','c.category_id','c.category','c.dimension_id','c.dimension','c.sku_id','c.sku','c.brand_id','c.brand'
        ,'b.user_id','b.supplier_id','b.id','b.pcs','b.length','b.qtyinfeet','b.gdsprice','b.amtinpkr','b.perkg','b.purval','b.repname',
        'b.machineno','b.forcust','b.purunit','b.locid','b.location','b.contract_id','d.title as sku',
        DB::raw('( CASE b.sku_id  WHEN  1 THEN b.gdswt WHEN 2 THEN b.pcs WHEN 3 THEN b.qtyinfeet  END) AS gdswt')
        )
        ->where('a.id',$id)->get();

        $data=compact('cd');

         return view('localpurchase.edit')
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

            $commercialinvoice = CommercialInvoice::findOrFail($request->contract_id);
            $commercialinvoice->invoiceno = $request->invoiceno;
            $commercialinvoice->invoice_date = $request->invoice_date;
            $commercialinvoice->supplier_id = $request->supplier_id;
            $commercialinvoice->contract_id = 0;
            $commercialinvoice->challanno = $request->invoiceno;
            $commercialinvoice->machine_date = $request->invoice_date;
            $commercialinvoice->machineno = $request->invoiceno;

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
                    // $cds->contract_id = 0;
                    // $cds->material_id = $cd->material_id;
                    // // $cds->material_title = $cd->material_title;
                    // $cds->repname = $cd->repname;
                    // $cds->supplier_id = $cd->supplier_id;
                    // $cds->user_id = $cd->user_id;
                    // $cds->category_id = $cd->category_id;
                    // $cds->sku_id = $cd->sku_id;
                    // $cds->dimension_id = $cd->dimension_id;
                    // $cds->source_id = $cd->source_id;
                    // $cds->brand_id = $cd->brand_id;
                    // $cds->gdswt = $cd->gdswt;
                    // $cds->perkg = $cd->perkg;
                    // $cds->amtinpkr = $cd->amtinpkr;
                    // $cds->location = $cd->location;
                    // $location = Location::where("title", $cd['location'])->first();
                    // $cds->locid = $location->id;


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
                    // $cds->purunit = $cd->purunit;

                    // $cds->gdswt = $cd->gdswt;
                    $cds->pcs = 0;
                    $cds->qtyinfeet = 0;
                    $cds->length = 0;
                    $cds->gdsprice = $cd->gdsprice;
                    $cds->amtinpkr = $cd->amtinpkr;
                    $cds->location = $cd->location;
                    $location = Location::where("title", $cd['location'])->first();
                    $cds->locid = $location->id;

                    $unitid = Sku::where("title", $cd['sku'])->first();
                    $cds->sku_id = $unitid->id;

                    if($unitid->id==1)   { $cds->gdswt = $cd->gdswt; }
                    if($unitid->id==2)   { $cds->pcs = $cd->gdswt; }
                    if($unitid->id==3)   { $cds->qtyinfeet = $cd->gdswt; }

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
                    // $cds->gdswt = $cd->gdswt;
                    $cds->perkg = 0;
                    $cds->amtinpkr = $cd->amtinpkr;
                    $cds->location = $cd->location;
                    $location = Location::where("title", $cd['location'])->first();
                    $cds->locid = $location->id;
                    $unitid = Sku::where("title", $cd['sku'])->first();
                    $cds->sku_id = $unitid->id;

                    if($unitid->id==1)   { $cds->gdswt = $cd->gdswt; }
                    if($unitid->id==2)   { $cds->pcs = $cd->gdswt; }
                    if($unitid->id==3)   { $cds->qtyinfeet = $cd->gdswt; }
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
