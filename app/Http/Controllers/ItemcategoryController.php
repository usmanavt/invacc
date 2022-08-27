<?php

namespace App\Http\Controllers;

use App\Models\Itemcategory;
use Illuminate\Http\Request;
use DB;

class ItemcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $itemcategories = Itemcategory::where(function($q) use ($search){
            $q->where('iname0','LIKE',"%$search%")
            ->orWhere('inname0','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(6);
        return view('itemcategories.index')->with('itemcategories',$itemcategories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $data['co']=  DB::select ("select mheadid as mid,mheadname from tblmanhead ");
        return view('itemcategories.create');
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
                'iname0'=>'required',
                'iname0'=>'required|unique:tbleItem0'

            ]
            );
        $maxValue = DB::table('tbleItem0')->max('icode0')+1;
        // dd($maxValue);
        // try {
            // DB::transaction(function () {
                $itemcategory = new Itemcategory();
                $itemcategory->icode0 = $maxValue;
                $itemcategory->iname0 = $request->iname0;
                $itemcategory->inname0 = $request->inname0;
                $itemcategory->save();
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
     * @param  \App\Models\Itemcategory  $itemcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Itemcategory $itemcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Itemcategory  $itemcategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $itemcategory=Itemcategory::find($id);
        if (is_null($itemcategory))
            {
                // NOT FOUND
                return redirect()->back();
            }
                else
            {


                $data=compact('itemcategory');
                return view('itemcategories.edit')->with($data);
            };
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Itemcategory  $itemcategory
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {

        $itemcategory=Itemcategory::find($id);
                $itemcategory->iname0 = $request->iname0;
                $itemcategory->inname0 = $request->inname0;
                $itemcategory->save();
                return redirect()->route('itemcategories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Itemcategory  $itemcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $itemcategory=Itemcategory::find($id);
            if(!is_null($itemcategory));
    {
        ($itemcategory)->delete();


    }
    return redirect()->back();
    }
}
