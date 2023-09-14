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
use App\Models\OpeningGodownStock;

use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Session;

// LocalPurchaseController
class OpeningGodownStockController  extends Controller
{
    public function index(Request $request)
    {
         return view('opstock.index');


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

    // public function getMaster(Request $request)
    // {
    //     $status =$request->status ;
    //     $search = $request->search;
    //     $size = $request->size;
    //     $field = $request->sort[0]["field"];     //  Nested Array
    //     $dir = $request->sort[0]["dir"];         //  Nested Array
    //     $cis = CommercialInvoice::where('status',$status)
    //     ->where(function ($query) use ($search){
    //             $query->where('invoiceno','LIKE','%' . $search . '%')
    //             ->orWhere('challanno','LIKE','%' . $search . '%');
    //         })
    //         ->whereHas('supplier', function ($query) {
    //             $query->where('source_id','=','1');
    //         })
    //     ->with('supplier:id,title')
    //     ->orderBy($field,$dir)
    //     ->paginate((int) $size);
    //     return $cis;
    // }

    public function getMaster(Request $request)
    {

        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        $opstock = DB::table('vwmatindex')
        // ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
        // ->select('contracts.*', 'suppliers.title')
        // ->where('supname', 'like', "%$search%")
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $opstock;


    }

    public function getMastermat(Request $request)
    {


        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $materials = Material::where(function ($query) use ($search){
            $query->where('srchb','LIKE','%' . $search. '%');
            // ->where('dimension','LIKE','%' . substr($search,3,10) . '%');
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
        // $maxgpno = DB::table('commercial_invoices')->select('gpassno')->max('gpassno')+1;
        return view('opstock.create');
        // return \view ('sales.create',compact('maxdcno','maxblno','maxgpno'))
        // ->with('suppliers',Supplier::select('id','title')->where('source_id',1)->get())
        // ->with('locations',Location::select('id','title')->get())
        // ->with('skus',Sku::select('id','title')->get());
        // ->with('purunit',Sku::select('id','title')->get());
    }

    /** Function Complete*/
    public function store(Request $request)
    {
            //    dd($request->all());
        $this->validate($request,[
            // 'invoice_date' => 'required|min:3|date',
            // 'number' => 'required|min:3',
            // 'supplier_id' => 'required',
             'material_id' => 'required|unique:opening_godown_stocks'
        ]);

        DB::beginTransaction();
        try {
            // Create Master Record
            // dd($request->all());
            $ci = new OpeningGodownStock();
            $ci->opdate = $request->opdate;
            $ci->material_id = $request->material_id;

            $ci->ostkwte13 = $request->ostkwte13;
            $ci->ostkpcse13 = $request->ostkpcse13;
            $ci->ostkfeete13 = $request->ostkfeete13;

            $ci->ostkwtgn2 = $request->ostkwtgn2;
            $ci->ostkpcsgn2 = $request->ostkpcsgn2;
            $ci->ostkfeetgn2 = $request->ostkfeetgn2;

            $ci->ostkwtams = $request->ostkwtams;
            $ci->ostkpcsams = $request->ostkpcsams;
            $ci->ostkfeetams = $request->ostkfeetams;

            $ci->ostkwte24 = $request->ostkwte24;
            $ci->ostkpcse24 = $request->ostkpcse24;
            $ci->ostkfeete24 = $request->ostkfeete24;

            $ci->ostkwtbs = $request->ostkwtbs;
            $ci->ostkpcsbs = $request->ostkpcsbs;
            $ci->ostkfeetbs = $request->ostkfeetbs;

            $ci->ostkwtoth = $request->ostkwtoth;
            $ci->ostkpcsoth = $request->ostkpcsoth;
            $ci->ostkfeetoth = $request->ostkfeetoth;

            $ci->ostkwttot = $request->ostkwttot;
            $ci->ostkpcstot = $request->ostkpcstot;
            $ci->ostkfeettot = $request->ostkfeettot;

            $ci->ocostwt = $request->ocostwt;
            $ci->ocostpcs = $request->ocostpcs;
            $ci->ocostfeet = $request->ocostfeet;

            $ci->save();


            DB::insert(DB::raw("
            INSERT INTO godown_stock ( transaction_id,tdate,ttypeid,tdesc,material_id,
            stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,stkfeete24,
            stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet )
            SELECT id,opdate,1,'OPENING',material_id,
            ostkwte13,ostkpcse13,ostkfeete13,ostkwtgn2,ostkpcsgn2,ostkfeetgn2,ostkwtams,ostkpcsams,ostkfeetams,ostkwte24,ostkpcse24,ostkfeete24,
            ostkwtbs,ostkpcsbs,ostkfeetbs,ostkwtoth,ostkpcsoth,ostkfeetoth,ostkwttot,ostkpcstot,ostkfeettot,ocostwt,ocostpcs,ocostfeet
            FROM opening_godown_stocks where id=$ci->id

           "));

           DB::insert(DB::raw("
            INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet)
            SELECT a.id AS transid,opdate,'OPENING',1,a.material_id,b.sku_id,ostkwttot,ostkpcstot,ostkfeettot,ocostwt,ocostpcs,ocostfeet FROM opening_godown_stocks AS a INNER JOIN  materials b
            ON a.material_id=b.id WHERE a.id=$ci->id"));

            // $ci->invoiceno = $request->number;
            // $ci->gpassno = $request->gpassno;
            // $ci->contract_id = 0;
            // $ci->challanno = $request->number;
            // $ci->supplier_id = $request->supplier_id;
            // $ci->machine_date = $request->invoice_date;
            // $ci->machineno = $request->number;
            // $ci->conversionrate = 0;

            // if (!empty($request->insurance)) {
            //     $ci->insurance = $request->insurance;
            //   }
            //   else{
            //     $ci->insurance =  0;
            //   }

            // $ci->collofcustom = $request->collofcustom;
            // $ci->exataxoffie = $request->exataxoffie;
            // $ci->lngnshipdochrgs = 0;
            // $ci->localcartage = 0;
            // $ci->miscexplunchetc = 0;
            // $ci->customsepoy = 0;
            // $ci->weighbridge = 0;
            // $ci->miscexpenses = 0;
            // $ci->agencychrgs = 0;
            // $ci->otherchrgs = $request->otherchrgs;
            // $ci->total = $request->bankntotal;




            // foreach ($request->contracts as $cont) {
            //     $material = Material::findOrFail($cont['id']);
            //     $lpd = new CommercialInvoiceDetails();
            //     $lpd->machine_date = $ci->invoice_date;
            //     $lpd->invoiceno = $ci->invoiceno;
            //     $lpd->commercial_invoice_id = $ci->id;
            //     $lpd->contract_id = 0;
            //     $lpd->material_id = $material->id;
            //     $lpd->supplier_id = $ci->supplier_id;
            //     $lpd->user_id = auth()->id();
            //     $lpd->category_id = $material->category_id;
            //     $lpd->dimension_id = $material->dimension_id;
            //     $lpd->hscode = '12314';
            //     $lpd->itmratio = 0;

            //     $lpd->machineno =  $cont['machineno'];
            //     $lpd->repname = $cont['repname'];
            //     $lpd->forcust = $cont['forcust'];
            //     $lpd->purunit = $cont['purunit'];

            //     $lpd->length = 0;
            //     $lpd->gdsprice = $cont['gdsprice'];
            //     $lpd->amtinpkr = $cont['amtinpkr'];
            //     $lpd->location = $cont['location'];
            //     $location = Location::where("title", $cont['location'])->first();
            //     $lpd->locid = $location->id;
            //     $unitid = Sku::where("title", $cont['sku'])->first();
            //     $lpd->sku_id = $unitid->id;

            //     if($lpd->sku_id==1)   { $lpd->gdswt = $cont['gdswt']; }
            //     if($lpd->sku_id==2)   { $lpd->pcs = $cont['gdswt']; }
            //     if($lpd->sku_id==3)   { $lpd->qtyinfeet = $cont['gdswt']; }

            //     $lpd->save();
            // }






            DB::commit();
             Session::flash('success','Contract Information Saved');
             return response()->json(['success'],200);
            // Session::flash('success','O/Balance created Successfully');
            //    return redirect()->back();



        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

    }

    // public function edit(Contract $contract)
    public function edit($id)
    {


        // $cd = DB::table('opening_godown_stocks as a')
        // ->join('commercial_invoice_details as b', 'a.id', '=', 'b.commercial_invoice_id')
        // ->join('materials as b', 'b.id', '=', 'a.material_id')
        // ->join('skus as d', 'd.id', '=', 'b.sku_id')
        // ->select( 'a.*'  'b.title as material_title',)
        // ->where('a.id',$id)->get();


        // $cd = DB::select('call procogsedit(?)',array( $id ));

        // $data=compact('cd');
        $matid = OpeningGodownStock::where('id',$id)->select('material_id')->first();
        $mat = Material::where('id',$matid->material_id)->first();
         return view('opstock.edit',compact('mat'))
         ->with('openinggodownstock',OpeningGodownStock::findOrFail($id));
        //  ->with($mat)
        //  ->with($data);

    }


    public function update(Request $request, OpeningGodownStock $openinggodownstock)
    {
        //  dd($commercialinvoice->commercial_invoice_id());
        //    dd($request->all());
        DB::beginTransaction();
        try {
            // Save Contract Data First : If changed
            // $commercialinvoice = CommercialInvoice::findOrFail($id);
            //  $commercialinvoice = 43;
            // $commercialinvoice = CommercialInvoice::findOrFail($request->commercial_invoice_id);
            $openinggodownstock = OpeningGodownStock::findOrFail($request->trans_id);
            $openinggodownstock->opdate = $request->opdate;
            $openinggodownstock->material_id = $request->material_id;

            $openinggodownstock->ostkpcse13 = $request->ostkpcse13;
            $openinggodownstock->ostkwte13 = $request->ostkwte13;
            $openinggodownstock->ostkfeete13 = $request->ostkfeete13;

            $openinggodownstock->ostkpcsgn2 = $request->ostkpcsgn2;
            $openinggodownstock->ostkwtgn2 = $request->ostkwtgn2;
            $openinggodownstock->ostkfeetgn2 = $request->ostkfeetgn2;

            $openinggodownstock->ostkpcsams = $request->ostkpcsams;
            $openinggodownstock->ostkwtams = $request->ostkwtams;
            $openinggodownstock->ostkfeetams = $request->ostkfeetams;

            $openinggodownstock->ostkpcse24 = $request->ostkpcse24;
            $openinggodownstock->ostkwte24 = $request->ostkwte24;
            $openinggodownstock->ostkfeete24 = $request->ostkfeete24;

            $openinggodownstock->ostkpcsbs = $request->ostkpcsbs;
            $openinggodownstock->ostkwtbs = $request->ostkwtbs;
            $openinggodownstock->ostkfeetbs = $request->ostkfeetbs;

            $openinggodownstock->ostkpcsoth = $request->ostkpcsoth;
            $openinggodownstock->ostkwtoth = $request->ostkwtoth;
            $openinggodownstock->ostkfeetoth = $request->ostkfeetoth;

            $openinggodownstock->ostkpcstot = $request->ostkpcstot;
            $openinggodownstock->ostkwttot = $request->ostkwttot;
            $openinggodownstock->ostkfeettot = $request->ostkfeettot;

            $openinggodownstock->ocostpcs = $request->ocostpcs;
            $openinggodownstock->ocostwt = $request->ocostwt;
            $openinggodownstock->ocostfeet = $request->ocostfeet;



            $openinggodownstock->save();



            DB::delete(DB::raw(" delete from godown_stock where ttypeid=1 and  transaction_id=$openinggodownstock->id  "));


            DB::insert(DB::raw("
            INSERT INTO godown_stock ( transaction_id,tdate,ttypeid,tdesc,material_id,
            stkwte13,stkpcse13,stkfeete13,stkwtgn2,stkpcsgn2,stkfeetgn2,stkwtams,stkpcsams,stkfeetams,stkwte24,stkpcse24,stkfeete24,
            stkwtbs,stkpcsbs,stkfeetbs,stkwtoth,stkpcsoth,stkfeetoth,stkwttot,stkpcstot,stkfeettot,costwt,costpcs,costfeet )
            SELECT id,opdate,1,'OPENING',material_id,
            ostkwte13,ostkpcse13,ostkfeete13,ostkwtgn2,ostkpcsgn2,ostkfeetgn2,ostkwtams,ostkpcsams,ostkfeetams,ostkwte24,ostkpcse24,ostkfeete24,
            ostkwtbs,ostkpcsbs,ostkfeetbs,ostkwtoth,ostkpcsoth,ostkfeetoth,ostkwttot,ostkpcstot,ostkfeettot,ocostwt,ocostpcs,ocostfeet
            FROM opening_godown_stocks where id=$openinggodownstock->id

           "));

           DB::delete(DB::raw(" delete from office_item_bal where ttypeid=1 and  transaction_id=$openinggodownstock->id  "));


           DB::insert(DB::raw("
            INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet)
            SELECT a.id AS transid,opdate,'OPENING',1,a.material_id,b.sku_id,ostkwttot,ostkpcstot,ostkfeettot,ocostwt,ocostpcs,ocostfeet FROM opening_godown_stocks AS a INNER JOIN  materials b
            ON a.material_id=b.id WHERE a.id=$openinggodownstock->id"));








            // if (!empty($commercialinvoice->insurance)) {
            //     $commercialinvoice->insurance = $request->insurance;
            //   }
            //   else{
            //     $commercialinvoice->insurance = 0;
            //   }
            // $commercialinvoice->collofcustom = $request->collofcustom;;
            // $commercialinvoice->exataxoffie = $request->exataxoffie;
            // $commercialinvoice->otherchrgs = $request->otherchrgs;
            // $commercialinvoice->total = $request->bankntotal;
            // $commercialinvoice->gpassno = $request->gpassno;

            // Get Data
            // $cds = $request->localpurchase; // This is array
            // $cds = CommercialInvoiceDetails::hydrate($cds); // Convert it into Model Collection
            // Now get old ContractDetails and then get the difference and delete difference
            // $oldcd = CommercialInvoiceDetails::where('commercial_invoice_id',$commercialinvoice->id)->get();
            // $deleted = $oldcd->diff($cds);
            //  Delete contract details if marked for deletion
            // foreach ($deleted as $d) {
                // $d->delete();
            // }
            // Now update existing and add new
            // foreach ($cds as $cd) {
                // if($cd->id)
                // {
                    // $cds = CommercialInvoiceDetails::where('id',$cd->id)->first();
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


            //         $cds->machine_date = $cd->invoice_date;
            //         $cds->invoiceno = $cd->invoiceno;
            //         // $cds->commercial_invoice_id = $cd->id;
            //         $cds->contract_id = 0;
            //         $cds->material_id = $cd->material_id;
            //         $cds->supplier_id = $cd->supplier_id;
            //         $cds->user_id = auth()->id();
            //         $cds->category_id = $cd->category_id;
            //         $cds->dimension_id = $cd->dimension_id;
            //         $cds->hscode = '12314';
            //         $cds->itmratio = 0;

            //         $cds->machineno = $cd->machineno;
            //         $cds->repname = $cd->repname;
            //         $cds->forcust = $cd->forcust;
            //         // $cds->purunit = $cd->purunit;

            //         // $cds->gdswt = $cd->gdswt;
            //         $cds->pcs = 0;
            //         $cds->qtyinfeet = 0;
            //         $cds->length = 0;
            //         $cds->gdsprice = $cd->gdsprice;
            //         $cds->amtinpkr = $cd->amtinpkr;
            //         $cds->location = $cd->location;
            //         $location = Location::where("title", $cd['location'])->first();
            //         $cds->locid = $location->id;

            //         $unitid = Sku::where("title", $cd['sku'])->first();
            //         $cds->sku_id = $unitid->id;

            //         if($unitid->id==1)   { $cds->gdswt = $cd->gdswt; }
            //         if($unitid->id==2)   { $cds->pcs = $cd->gdswt; }
            //         if($unitid->id==3)   { $cds->qtyinfeet = $cd->gdswt; }

            //         $cds->save();
            //     }else
            //     {
            //         //  The item is new, Add it

            //         $cds = new CommercialInvoiceDetails();

            //         $cds->commercial_invoice_id = $commercialinvoice->id;
            //         $cds->repname = $cd->repname;
            //         $cds->supplier_id = $request->supplier_id;
            //         $cds->user_id =  auth()->id();
            //         $cds->material_id = $cd->material_id;
            //         $cds->category_id = $cd->category_id;
            //         $cds->dimension_id = $cd->dimension_id;
            //         $cds->source_id = $cd->source_id;
            //         $cds->brand_id = $cd->brand_id;
            //         // $cds->gdswt = $cd->gdswt;
            //         $cds->perkg = 0;
            //         $cds->amtinpkr = $cd->amtinpkr;
            //         $cds->location = $cd->location;
            //         $location = Location::where("title", $cd['location'])->first();
            //         $cds->locid = $location->id;
            //         $unitid = Sku::where("title", $cd['sku'])->first();
            //         $cds->sku_id = $unitid->id;

            //         if($unitid->id==1)   { $cds->gdswt = $cd->gdswt; }
            //         if($unitid->id==2)   { $cds->pcs = $cd->gdswt; }
            //         if($unitid->id==3)   { $cds->qtyinfeet = $cd->gdswt; }
            //         $cds->save();
            //     }
            // }

            // DB::delete(DB::raw(" delete from office_item_bal where ttypeid=3 and  transaction_id=$commercialinvoice->id   "));

            // DB::insert(DB::raw("
            // INSERT INTO office_item_bal(transaction_id,tdate,ttypedesc,ttypeid,material_id,uom,tqtykg,tqtypcs,tqtyfeet,tcostkg,tcostpcs,tcostfeet)
            // SELECT a.id AS transid,a.invoice_date,'Ipurchasing',3,b.material_id,sku_id,gdswt,pcs,qtyinfeet,gdsprice,gdsprice,gdsprice FROM commercial_invoices a INNER JOIN  commercial_invoice_details b
            // ON a.id=b.commercial_invoice_id WHERE a.id=$commercialinvoice->id"));





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
