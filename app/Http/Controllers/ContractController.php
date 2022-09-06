<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Item;
use App\Models\Brand;
use App\Models\Group;
use App\Models\Category;
use App\Models\Contract;
use App\Models\ItemSize;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\ContractDetails;
use Illuminate\Support\Facades\Session;

class ContractController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;
        $contracts = Contract::with('supplier:id,sname')
        ->select('id','invdate','invno','supplier_id')
        ->where(function($q) use ($search){
            $q->where('invno','like',"%$search%")
            ->orWhereDate('created_at','like',"%$search%")
            ->orWhereHas('supplier', function($qu) use($search){
                $qu->where('sname','like',"%$search%");
            });
        })
        ->paginate(5);
        return view('contracts.index')->with('contracts',$contracts);
    }

    public function create()
    {
        $categories = Category::select('id','iname0')->get();
        $suppliers = Supplier::select('id','sname')->get();
        $itemsizes = ItemSize::select('id','sizename')->get();
        $brands = Brand::select('id','brandname')->get();
        // $groups = Group::with('categories','items')->where('category_id',4)->get();
        
        $data=compact('categories','suppliers','itemsizes','brands');
        return view('contracts.create')->with($data);
    }

    /** Function Complete*/
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request,[
            'invdate' => 'required|min:3|date',
            'invno' => 'required|min:3',
            'supplier_id' => 'required'
        ]);
        //  Get All data in variables
        $supplier_id = $request->supplier_id;
        $invdate = $request->invdate;
        $invno = $request->invno;
        $itmid0 = $request->categoryId;
        $itmid = $request->itemId;
        $itmsizeid = $request->itemSizeId;
        $brandid = $request->brandid;
        $bundle1 = $request->bundle1;
        $pcspbundle1 = $request->pcspbundle1;
        $bundle2 = $request->bundle2;
        $pcspbundle2 = $request->pcspbundle2;
        $gdswt = $request->gdswt;
        $gdsprice = $request->gdsprice;
        // $maxValue = DB::table('tbleContract')->max('invid')+1;
        DB::beginTransaction();
        try {
            // Create Master Record
            $contract = new Contract();
            // $contract->invid = $maxValue;
            $contract->invno = $invno;
            $contract->invdate = $invdate;
            $contract->supplier_id = $supplier_id;
            $contract->save();
            // Create Contract Master Transaction Data
            for ($i=0; $i < count($brandid); $i++) { 
                # code...
                $contractDetail = new ContractDetails();
                $contractDetail->tblecontractmaster_id = $contract->id;
                $contractDetail->transid = $itmsizeid[$i];
                $contractDetail->brandid = $brandid[$i];
                $contractDetail->bundle1 = $bundle1[$i];
                $contractDetail->pcspbundle1 = $pcspbundle1[$i];
                $contractDetail->bundle2 = $bundle2[$i];
                $contractDetail->pcspbundle2 = $pcspbundle2[$i];
                $contractDetail->gdswt = $gdswt[$i];
                $contractDetail->gdsprice = $gdsprice[$i];
                $contractDetail->save();
            }
            DB::commit();
            Session::flash('success','Contract Information Saved');
            return redirect()->route('contracts.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
   
    }

    public function show(Contract $contract)
    {
        //
    }

    public function edit(Contract $contract)
    {
        //
    }

    public function update(Request $request, Contract $contract)
    {
        //
    }

    public function destroy(Contract $contract)
    {
        //
    }

    //  Function OK
    public function getItems(Request $request)
    {
        $itmid=DB::table('tbleItem')
        ->select ("tbleItem.id","iname")->distinct()
        ->join('tbleobszws','tbleobszws.item_id','=','tbleItem.id')
        ->where('tbleobszws.category_id',$request->category_id)
        ->get();
        return response()->json($itmid,200);
    }
    //  Function Ok
    public function getSizes(Request $request)
    {
        $Myqry="SELECT distinct a.trid,b.sizename FROM tbleobszws as a inner join tblesize as b
        on a.item_size_id = b.id where a.category_id=$request->category_id and a.item_id=$request->item_id" ;
        $itemsizeid=  DB::select ($Myqry);

        return response()->json([$itemsizeid],200);
    }



}
