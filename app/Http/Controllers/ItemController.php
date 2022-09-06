<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Item;
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
        ->orderBy('id','desc')
        ->paginate(5);
        return view('items.index')->with('items',$items);
    }

    public function create()
    {
        return view('items.create')->with('items',Item::all());
    }

    public function store(Request $request)
    {
        $request->validate([
                'iname'=>'required|unique:tbleItem'
            ]);
            DB::beginTransaction();
            try {
                $item = new Item();
                $item->iname = $request->iname;
                $item->inname = $request->inname;
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
        return view('items.edit')->with('item',$item);
    }

    public function update(Item $item,Request $request)
    {
        $request->validate([
            'iname'=>'required|unique:tbleItem,iname,'.$item->id
        ]);
        DB::beginTransaction();
        try {
            $item->iname = $request->iname;
            $item->inname = $request->inname;
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
