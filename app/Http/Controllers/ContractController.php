<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Contract;
use App\Models\Material;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\ContractDetails;
use Illuminate\Support\Facades\Session;

class ContractController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;
        $contracts = Contract::select('id','invoice_date','number','supplier_id')
        ->where(function($q) use ($search){
            $q->where('number','like',"%$search%")
            ->orWhereDate('created_at','like',"%$search%")
            ->orWhereHas('supplier', function($qu) use($search){
                $qu->where('title','like',"%$search%");
            });
        })
        ->paginate(5);
        return view('contracts.index')->with('contracts',$contracts);
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
                $query->where('id','LIKE','%' . $search . '%');
            })
            // ->orWhereHas('category',function($query) use($search){
            //     $query->where('iname0','LIKE',"%$search%");
            // })
            // ->orWhereHas('brand',function($query) use($search){
            //     $query->where('brandname','LIKE',"%$search%");
            // })
            // ->orWherehas('itemSize',function($query) use($search){
            //     $query->where('sizename','LIKE',"%$search%");
            // })
            // ->orWherehas('unit',function($query) use($search){
            //     $query->where('unitname','LIKE',"%$search%");
            // })
            // ->orWherehas('source',function($query) use($search){
            //     $query->where('srcname','LIKE',"%$search%");
            // })
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
        return view('contracts.create')->with('suppliers',Supplier::select('id','title')->get());
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
        return view('contracts.edit')->with('suppliers',Supplier::select('id','title')->get())->with('contract',$contract)->with('cd',ContractDetails::where('contract_id',$contract->id)->get());
    }

    public function update(Request $request, Contract $contract)
    {
        //
    }

    public function destroy(Contract $contract)
    {
        //
    }

}
