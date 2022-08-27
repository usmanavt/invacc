<?php

namespace App\Http\Controllers;

use App\Models\Tblecontractmaster;
use Illuminate\Http\Request;
use DB;

class TblecontractmasterController extends Controller
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
         return view('contracts.index')->with('subheads',$subheads);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$data['co']=DB::table('tblmanhead')->get();
        $grpdta =  DB::select ("select icode0 as grpid,iname0 as grpname from tbleitem0 ");
        $supdta=  DB::select ("select scode as supid,sname as supname from tblesupplier ");
        $itmdta=  DB::select ("select icode as itmid,iname as itmname from tbleobszws as a inner join tbleitem as b on a.itmid=b.icode where itmid0=1 ");
        $szedta=  DB::select ("select sizeid as szeid,sizename as szename from tblesize ");
        $brddta=  DB::select ("select brandid as bid,brandname as bname from tblebrand ");
        $data=compact('grpdta','supdta','itmdta','szedta','brddta');
        return view('contracts.create')->with($data);
    }

    // public function getitem()

    // {
    //     // $itmdata['data']=  DB::select ("select b.icode as itmid,b.iname as itmname from tbleobszws as a inner join tbleitem as b on a.itmid=b.icode where itmid0=$id ");

    //     $id=$get['id'];
    //     $res=DB::table('Item')
    //     ->join('Grouprelation','Grouprelation.itmid','=','Item.icode')
    //     ->where('Grouprelation.itmid0',$id)
    //     ->get();
    //          return response()->json($res);


    // }





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
                'invdate'=>'required',


            ]
            );


        $maxValue = DB::table('tblecontractmaster')->max('invid')+1;
        // dd($maxValue);
        // try {
            // DB::transaction(function () {
                $cmast = new Tblecontractmaster();
                $cmast->invid = $maxValue;
                $cmast->supcode = $request->supcode;
                $cmast->invdate = $request->invdate;
                $cmast->invno = $request->invno;
                $cmast->save();
        //     });
        //     // return redirect()->route('suppliers.index');
            return redirect()->back();
        // } catch (\Throwable $th) {
        //     DB::rollback();
        //     throw $th;
        // }
    }


    public function show(Tblecontractmaster $tblecontractmaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tblecontractmaster  $tblecontractmaster
     * @return \Illuminate\Http\Response
     */
    public function edit(Tblecontractmaster $tblecontractmaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tblecontractmaster  $tblecontractmaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tblecontractmaster $tblecontractmaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tblecontractmaster  $tblecontractmaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tblecontractmaster $tblecontractmaster)
    {
        //
    }

    public function getItem(Request $request)
    {
        // dd($request->all());
        $cid=$request->cid;
        $itmid=DB::table('TbleItem')
        ->select ("icode","iname")->distinct()
        ->join('tbleobszws','tbleobszws.itmid','=','TbleItem.icode')
        ->where('tbleobszws.itmid0',$cid)
        ->get();
        return response()->json([$itmid],200);
    }

    public function getSize(Request $request)
    {
        // dd($request->all());
        $cid=$request->cid;
        $categoryid=$request->categoryid;

        $itemsizeid=DB::table('tblesize')
        ->select("trid","sizename","tbleobszws.itmid0")->distinct()
        ->join('tbleobszws','tbleobszws.itmsizeid','=','tblesize.sizeid')
        // ->where('tbleobszws.itmid',$cid)
        ->where(function($q) use($cid,$categoryid) {
            $q->where('tbleobszws.itmid',$cid)
            ->orWhere('tbleobszws.itmid0', $categoryid);
        })
        // ->orWhere('tbleobszws.itmid0',$categoryid)
        ->get();
        return response()->json([$itemsizeid],200);
    }



}
