<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Contract;
use App\Models\Material;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\ContractDetails;
use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Session;

class ContractController extends Controller
{

    public function index(Request $request)
    {
        return view('contracts.index');
    }

    public function getMaster(Request $request)
    {
        // dd($request->all());
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $contracts = Contract::where(function ($query) use ($search){
                $query->where('id','LIKE','%' . $search . '%')
                ->orWhere('number','LIKE','%' . $search . '%');
            })

            // ->whereHas('supplier', function ($query) {
            //     $query->where('source_id','=','2');
            //     // ->orWhere('title','LIKE','%' . $search . '%');
            // })

            ->orWherehas('supplier',function($query) use($search){
                $query->where('title','LIKE',"%$search%");
            })

        ->with('user:id,name','supplier:id,title')
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;
    }

    public function getMasterImp(Request $request)
    {
        // dd($request->all());
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $contracts = Contract::where(function ($query) use ($search){
                $query->where('id','LIKE','%' . $search . '%')
                ->orWhere('number','LIKE','%' . $search . '%');
            })
            // ->orWherehas('supplier',function($query) use($search){
            //     $query->where('title','LIKE',"%$search%");
            // })
            ->whereHas('supplier', function ($query) {
                $query->where('source_id','=','2');
                // ->orWhere('source_id',1);
            })

        ->with('user:id,name','supplier:id,title')
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;
    }


    public function getMasterLoc(Request $request)
    {
        // dd($request->all());
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $contracts = Contract::where(function ($query) use ($search){
                $query->where('id','LIKE','%' . $search . '%')
                ->orWhere('number','LIKE','%' . $search . '%');
            })
            // ->orWherehas('supplier',function($query) use($search){
            //     $query->where('title','LIKE',"%$search%");
            // })
            ->whereHas('supplier', function ($query) {
                $query->where('source_id','=','1');
                // ->orWhere('source_id',1);
            })

        ->with('user:id,name','supplier:id,title')
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $contracts;
    }










    public function getDetails(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $contractDetails = ContractDetails::where('contract_id',$request->id)
        ->paginate((int) $size);
        return $contractDetails;
    }

    public function create()
    {
        return view('contracts.create')->with('suppliers',Supplier::select('id','title')->where('source_id',2)->get());
    }

    /** Function Complete*/
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request,[
            'invoice_date' => 'required|min:3|date',
            'number' => 'required|min:3',
            'supplier_id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            // Create Master Record
            $contract = new Contract();
            $contract->supplier_id = $request->supplier_id;
            $contract->user_id = auth()->id();
            $contract->invoice_date = $request->invoice_date;
            $contract->number =$request->number;
            $contract->save();
            // Add Details
            foreach ($request->contracts as $cont) {
                $material = Material::findOrFail($cont['id']);
                $cd = new ContractDetails();
                $cd->contract_id = $contract->id;
                $cd->material_id = $material->id;
                $cd->material_title = $material->title;
                $cd->supplier_id = $contract->supplier_id;
                $cd->user_id = auth()->id();
                $cd->category_id = $material->category_id;
                $cd->sku_id = $material->sku_id;
                $cd->dimension_id = $material->dimension_id;
                $cd->source_id = $material->source_id;
                $cd->brand_id = $material->brand_id;
                $cd->category = $material->category;
                $cd->sku = $material->sku;
                $cd->dimension = $material->dimension;
                $cd->source = $material->source;
                $cd->brand = $material->brand;
                $cd->bundle1 = $cont['bundle1'];
                $cd->pcspbundle1 = $cont['pcspbundle1'];
                $cd->bundle2 = $cont['bundle2'];
                $cd->pcspbundle2 = $cont['pcspbundle2'];
                $cd->gdswt = $cont['gdswt'];
                $cd->gdsprice = $cont['gdsprice'];
                $cd->dtyrate = $cont['dtyrate'];
                $cd->invsrate = $cont['invsrate'];

                $cd->save();
            }
            DB::commit();
            Session::flash('success','Contract Information Saved');
            return response()->json(['success'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

    }

    public function edit(Contract $contract)
    {

        // dd($cd);
        return view('contracts.edit')->with('suppliers',Supplier::select('id','title')->where('source_id',2)->get())
        ->with('contract',$contract)
        ->with('cd',ContractDetails::where('contract_id',$contract->id)->get());
    }

    public function update(Request $request, Contract $contract)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            // Save Contract Data First : If changed
            $contract->number = $request->number;
            $contract->invoice_date = $request->invoice_date;
            $contract->supplier_id = $request->supplier_id;
            $contract->save();
            // Get Data
            $cds = $request->contracts; // This is array
            $cds = ContractDetails::hydrate($cds); // Convert it into Model Collection
            // Now get old ContractDetails and then get the difference and delete difference
            $oldcd = ContractDetails::where('contract_id',$contract->id)->get();
            $deleted = $oldcd->diff($cds);
            //  Delete contract details if marked for deletion
            foreach ($deleted as $d) {
                $d->delete();
            }
            // Now update existing and add new
            foreach ($cds as $cd) {
                if($cd->id)
                {
                    $cds = ContractDetails::where('id',$cd->id)->first();
                    $cds->contract_id = $cd->contract_id;
                    $cds->material_id = $cd->material_id;
                    $cds->material_title = $cd->material_title;
                    $cds->supplier_id = $cd->supplier_id;
                    $cds->user_id = $cd->user_id;
                    $cds->category_id = $cd->category_id;
                    $cds->sku_id = $cd->sku_id;
                    $cds->dimension_id = $cd->dimension_id;
                    $cds->source_id = $cd->source_id;
                    $cds->brand_id = $cd->brand_id;
                    $cds->category = $cd->category;
                    $cds->sku = $cd->sku;
                    $cds->dimension = $cd->dimension;
                    $cds->source = $cd->source;
                    $cds->brand = $cd->brand;
                    $cds->bundle1 = $cd->bundle1;
                    $cds->pcspbundle1 = $cd->pcspbundle1;
                    $cds->bundle2 = $cd->bundle2;
                    $cds->pcspbundle2 = $cd->pcspbundle2;
                    $cds->gdswt = $cd->gdswt;
                    $cds->gdsprice = $cd->gdsprice;
                    $cds->dtyrate = $cd->dtyrate;
                    $cds->invsrate = $cd->invsrate;

                    $cds->save();
                }
                else
                {
                    //  The item is new, Add it
                    $cds = new ContractDetails();
                    // $cds->contract_id = $contract->id;
                    // $cds->material_id = $cd->material_id;
                    // $cds->material_title = $cd->material_title;
                    // $cds->supplier_id = $contract->supplier_id;
                    // $cds->user_id = auth()->id();
                    // $cds->category_id = $cd->category_id;
                    // $cds->sku_id = $cd->sku_id;
                    // $cds->dimension_id = $cd->dimension_id;
                    // $cds->source_id = $cd->source_id;
                    // $cds->brand_id = $cd->brand_id;
                    // $cds->category = $cd->category;
                    // $cds->sku = $cd->sku;
                    // $cds->dimension = $cd->dimension;
                    // $cds->source = $cd->source;
                    // $cds->brand = $cd->brand;
                    // $cds->bundle1 = $cd->bundle1;
                    // $cds->pcspbundle1 = $cd->pcspbundle1;
                    // $cds->bundle2 = $cd->bundle2;
                    // $cds->pcspbundle2 = $cd->pcspbundle2;
                    // $cds->gdswt = $cd->gdswt;
                    // $cds->gdsprice = $cd->gdsprice;
                    $cds->contract_id = $cd->contract_id;
                    $cds->material_id = $cd->material_id;
                    $cds->material_title = $cd->material_title;
                    $cds->supplier_id = $cd->supplier_id;
                    $cds->user_id = $cd->user_id;
                    $cds->category_id = $cd->category_id;
                    $cds->sku_id = $cd->sku_id;
                    $cds->dimension_id = $cd->dimension_id;
                    $cds->source_id = $cd->source_id;
                    $cds->brand_id = $cd->brand_id;
                    $cds->category = $cd->category;
                    $cds->sku = $cd->sku;
                    $cds->dimension = $cd->dimension;
                    $cds->source = $cd->source;
                    $cds->brand = $cd->brand;
                    $cds->bundle1 = $cd->bundle1;
                    $cds->pcspbundle1 = $cd->pcspbundle1;
                    $cds->bundle2 = $cd->bundle2;
                    $cds->pcspbundle2 = $cd->pcspbundle2;
                    $cds->gdswt = $cd->gdswt;
                    $cds->gdsprice = $cd->gdsprice;
                    $cds->dtyrate = $cd->dtyrate;
                    $cds->invsrate = $cd->invsrate;




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
