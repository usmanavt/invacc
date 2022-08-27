<?php

namespace App\Http\Controllers;

use App\Models\Subhead;
use App\Models\Manhead;
use Illuminate\Http\Request;
use DB;

class SubheadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;

        // $data['co']=DB::table('Tbleco')->get();
        $Myqry="select a.*,b.mheadid as mid,b.mheadname from tblsubhead as a inner join tblmanhead as b
        on a.mheadid=b.mheadid   where subheadname like '%$search%' order by a.id desc ";

         $subheads=  DB::select ($Myqry);
         return view('subheads.index')->with('subheads',$subheads);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$data['co']=DB::table('tblmanhead')->get();
        $data['co']=  DB::select ("select mheadid as mid,mheadname from tblmanhead ");
        return view('subheads.create',$data);

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
                'subheadname'=>'required',
                'subheadname'=>'required|unique:tblsubhead'

            ]
            );


        $maxValue = DB::table('tblsubhead')->max('subheadid')+1;
        // dd($maxValue);
        // try {
            // DB::transaction(function () {
                $subhead = new Subhead();
                $subhead->mheadid = $request->mheadid;
                $subhead->subheadid = $maxValue;
                $subhead->subheadname = $request->subheadname;
                $subhead->ob = $request->ob;
                $subhead->sstatus = $request->sstatus;

                $subhead->save();
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
     * @param  \App\Models\Subhead  $subhead
     * @return \Illuminate\Http\Response
     */
    public function show(Subhead $subhead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subhead  $subhead
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Myqry="select mheadid as mid1,mheadname from tblmanhead ";

        $data1['co']=  DB::select ($Myqry);

        // $data1['co']=DB::table('tblmanhead')->get();
        $subhead=Subhead::find($id);
       if (is_null($subhead))
           {
               // NOT FOUND
               return redirect()->back();
           }
               else
           {

               $data=compact('subhead');
               return view('subheads.edit')->with($data1)->with($data);
           };
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subhead  $subhead
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $subhead=Subhead::find($id);
        $subhead->mheadid = $request->mheadid;
        $subhead->subheadname = $request->subheadname;
        $subhead->ob = $request->ob;
        $subhead->sstatus = $request->sstatus;
        $subhead->save();
        return redirect()->route('subheads.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subhead  $subhead
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subhead=Subhead::find($id);
        if(!is_null($subhead));
{
    ($subhead)->delete();


}
return redirect()->back();
    }
}
