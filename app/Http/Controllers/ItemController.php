<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $items = Item::where(function($q) use ($search){
            $q->where('iname','LIKE',"%$search%")
            ->orWhere('inname','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(6);
        return view('items.index')->with('items',$items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'iname'=>'required',
                'iname'=>'required|unique:tbleItem'

            ]
            );
        $maxValue = DB::table('tbleItem')->max('icode')+1;
        // dd($maxValue);
        // try {
            // DB::transaction(function () {
                $item = new Item();
                $item->icode = $maxValue;
                $item->iname = $request->iname;
                $item->inname = $request->inname;
                $item->save();
        //     });
        //     // return redirect()->route('suppliers.index');
            return redirect()->back();
        // } catch (\Throwable $th) {
        //     DB::rollback();
        //     throw $th;
        // }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item=Item::find($id);
        if (is_null($item))
            {
                // NOT FOUND
                return redirect()->back();
            }
                else
            {
                $data=compact('item');
                return view('items.edit')->with($data);
            };
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $item=Item::find($id);
                $item->iname = $request->iname;
                $item->inname = $request->inname;
                $item->save();
                return redirect()->route('items.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item=Item::find($id);
            if(!is_null($item));
    {
        ($item)->delete();


    }
    return redirect()->back();
    }
}
