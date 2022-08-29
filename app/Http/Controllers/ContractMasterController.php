<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\ContractMaster;
use Illuminate\Support\Facades\Session;
use App\Models\ContractMasterTransaction;

class ContractMasterController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;

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
        $supdta =  DB::select ("select scode as supid,sname as supname from tblesupplier ");
        $itmdta =  DB::select ("select icode as itmid,iname as itmname from tbleobszws as a inner join tbleitem as b on a.itmid=b.icode where itmid0=1 ");
        $szedta =  DB::select ("select sizeid as szeid,sizename as szename from tblesize ");
        $brddta =  DB::select ("select brandid as bid,brandname as bname from tblebrand ");
        $data=compact('grpdta','supdta','itmdta','szedta','brddta');
        return view('contracts.create')->with($data);
    }

    /** Function Complete*/
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request,[
            'invdate' => 'required|min:3|date',
            'invno' => 'required|min:3',
            'supcode' => 'required'
        ]);
        //  Get All data in variables
        $supcode = $request->supcode;
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
        // dd(count($brandid));
        $maxValue = DB::table('tblecontractmaster')->max('invid')+1;
        // dd($maxValue);
        DB::beginTransaction();
        try {
            // Create Master Record
            $cm = new ContractMaster();
            $cm->invid = $maxValue;
            $cm->invno = $invno;
            $cm->invdate = $invdate;
            $cm->supcode = $supcode;
            $cm->save();
            // Create Contract Master Transaction Data
            for ($i=0; $i < count($brandid); $i++) { 
                # code...
                $cmt = new ContractMasterTransaction();
                $cmt->tinvid = $maxValue;
                $cmt->transid = $itmsizeid[$i];
                $cmt->brandid = $brandid[$i];
                $cmt->bundle1 = $bundle1[$i];
                $cmt->pcspbundle1 = $pcspbundle1[$i];
                $cmt->bundle2 = $bundle2[$i];
                $cmt->pcspbundle2 = $pcspbundle2[$i];
                $cmt->gdswt = $gdswt[$i];
                $cmt->gdsprice = $gdsprice[$i];
                $cmt->save();
            }
            DB::commit();
            Session::flash('success','Contract Information Saved');
            return redirect()->route('contracts.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
   
    }

    public function show(ContractMaster $contractMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tblecontractmaster  $tblecontractmaster
     * @return \Illuminate\Http\Response
     */
    public function edit(ContractMaster $contractMaster)
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
    public function update(Request $request, ContractMaster $contractMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tblecontractmaster  $tblecontractmaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContractMaster $contractMaster)
    {
        //
    }
    //  Function OK
    public function getItem(Request $request)
    {
        // dd($request->all());
        $cid=$request->categoryId;
        $itmid=DB::table('TbleItem')
        ->select ("icode","iname")->distinct()
        ->join('tbleobszws','tbleobszws.itmid','=','TbleItem.icode')
        ->where('tbleobszws.itmid0',$cid)
        ->get();
        return response()->json([$itmid],200);
    }
    //  Function Ok
    public function getSize(Request $request)
    {
        // dd($request->all());
        $itemId=$request->itemId;
        $categoryid=$request->categoryid;
        $Myqry="SELECT distinct a.trid,b.sizename FROM tbleobszws as a inner join tblesize as b
        on a.itmsizeid=b.sizeid where a.itmid0=$categoryid and a.itmid=$itemId" ;
        $itemsizeid=  DB::select ($Myqry);

        return response()->json([$itemsizeid],200);
    }



}
