<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Item;
use App\Models\Unit;
use App\Models\Brand;
use App\Models\Source;
use App\Models\Category;
use App\Models\ItemSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $items = Item::where(function($q) use ($search){
            $q->where('iname','LIKE',"%$search%")
            ->orWhere('inname','LIKE',"%$search%");
        })
        ->with('category','brand','itemSize','source')
        ->orderBy('id','desc')
        ->paginate(5);
        return view('items.index')->with('items',$items);
    }

    public function create()
    {
        return view('items.create')
            ->with('units',Unit::all())
            ->with('categories',Category::all())
            ->with('itemsizes',ItemSize::all())
            ->with('sources',Source::all())
            ->with('brands',Brand::all())
            ->with('items',Item::all())
            ;
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'iname'=>'required|min:3|unique:tbleItem'
        ]);
        DB::beginTransaction();
        try {
            $item = new Item();
            $item->iname = $request->iname;
            $item->inname = $request->inname;
            $item->category_id = $request->category_id;
            $item->item_size_id = $request->item_size_id;
            $item->source_id = $request->source_id;
            $item->unit_id = $request->unit_id;
            $item->brand_id = $request->brand_id;
            $item->save();
            DB::commit();
            Session::flash('success','Item created');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }


    public function show(Item $item)
    {
        //
    }

    public function edit(Item $item)
    {
        return view('items.edit')
        ->with('units',Unit::all())
        ->with('categories',Category::all())
        ->with('itemsizes',ItemSize::all())
        ->with('sources',Source::all())
        ->with('brands',Brand::all())
        ->with('item',$item)
        ;
    }

    public function update(Item $item,Request $request)
    {
        // dd($request->all());
        $request->validate([
            'iname'=>'required|unique:tbleItem,iname,'.$item->id
        ]);
        DB::beginTransaction();
        try {
            $item->iname = $request->iname;
            $item->inname = $request->inname;
            $item->category_id = $request->category_id;
            $item->item_size_id = $request->item_size_id;
            $item->source_id = $request->source_id;
            $item->unit_id = $request->unit_id;
            $item->brand_id = $request->brand_id;
            $item->save();
            DB::commit();
            Session::flash('info','Item updated');
            return redirect()->route('items.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }


    public function destroy($id)
    {
  
    }
}
