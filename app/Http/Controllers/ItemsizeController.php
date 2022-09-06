<?php

namespace App\Http\Controllers;

use DB;
use App\Models\ItemSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ItemSizeController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;
        $itemsize = Itemsize::where(function($q) use ($search){
            $q->where('sizename','LIKE',"%$search%")
            ->orWhere('sizenname','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(5);
        return view('itemsize.index')->with('itemsize',$itemsize);
    }

    public function create()
    {
        return view('itemsize.create')->with('items',ItemSize::all());
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'sizename'=>'required|min:3|unique:tblesize'
        ]);
        DB::beginTransaction();
        try {
            $itemsize = new Itemsize();
            $itemsize->sizename = $request->sizename;
            $itemsize->sizenname = $request->sizenname;
            $itemsize->save();
            DB::commit();
            Session::flash('success','Item Size created');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }


    public function show(ItemSize $itemsize)
    {
        //
    }

    public function edit(ItemSize $itemsize)
    {
        return view('itemsize.edit')->with('itemsize',$itemsize);
    }


    public function update(ItemSize $itemsize,Request $request)
    {
        $request->validate([
            'sizename'=>'required|min:3|unique:tblesize,sizename,'.$itemsize->id
        ]);
        DB::beginTransaction();
        try {
            $itemsize->sizename = $request->sizename;
            $itemsize->sizenname = $request->sizenname;
            $itemsize->save();
            DB::commit();
            Session::flash('info','ItemSize updated');
            return redirect()->route('itemsize.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

  
    public function destroy($id)
    {
      
    }
}
