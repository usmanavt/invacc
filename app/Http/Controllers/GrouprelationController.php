<?php

namespace App\Http\Controllers;

use App\Models\Grouprelation;
use Illuminate\Http\Request;
use DB;
class GrouprelationController extends Controller
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
        $Myqry="select a.*,b.iname0,c.iname,d.sizename,e.srcname,f.brandname,g.locname
        ,h.unitname
        from tbleobszws as a
        inner join tbleitem0 as b  on a.itmid0=b.icode0
        inner join tbleitem as c  on a.itmid=c.icode
        inner join tblesize as d  on a.itmsizeid=d.sizeid
        inner join tblesource as e on e.srcid=a.srcid
        inner join tblebrand as f on f.brandid=a.brandid
        inner join tblelocation as g on g.locid=a.locid
        inner join tbleunit as h on h.unitid=a.purunitid

        where b.iname0 like '%$search%' order by a.id desc ";

         $grouprelations=  DB::select ($Myqry);
         return view('grouprelations.index')->with('grouprelations',$grouprelations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grpdta =  DB::select ("select icode0 as grpid,iname0 as grpname from tbleitem0 ");
        $itmdta=  DB::select ("select icode as itmid,iname as itmname from tbleitem ");
        $szedta=  DB::select ("select sizeid as szeid,sizename as szename from tblesize ");
        $srcdta=  DB::select ("select srcid as sid,srcname as sname from tblesource ");
        $brddta=  DB::select ("select brandid as bid,brandname as bname from tblebrand ");
        $untdta=  DB::select ("select unitid as uid,unitname as uname from tbleunit ");

        $locdta=  DB::select ("select locid as lid,locname as lname from tblelocation ");
        $data=compact('grpdta','itmdta','szedta','srcdta','brddta','untdta','locdta');
        return view('grouprelations.create')->with($data);



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate(
        //     [
        //         'subheadname'=>'required',
        //         'subheadname'=>'required|unique:tblsubhead'

        //     ]
        //     );


        $maxValue = DB::table('tbleobszws')->max('trid')+1;
        // dd($maxValue);
        // try {
            // DB::transaction(function () {
                $grouprelation = new Grouprelation();
                $grouprelation->trid = $maxValue;
                $grouprelation->itmid0 = $request->itmid0;
                $grouprelation->itmid = $request->itmid;
                $grouprelation->itmsizeid = $request->itmsizeid;
                $grouprelation->obqty = $request->obqty;
                $grouprelation->purrate = $request->purrate;
                $grouprelation->costrate = $request->costrate;
                $grouprelation->srcid = $request->srcid;
                $grouprelation->purunitid = $request->purunitid;
                $grouprelation->locid = $request->locid;
                $grouprelation->brandid = $request->brandid;
                $grouprelation->sstatus = $request->sstatus;
                $grouprelation->save();



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
     * @param  \App\Models\Grouprelation  $grouprelation
     * @return \Illuminate\Http\Response
     */
    public function show(Grouprelation $grouprelation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grouprelation  $grouprelation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grpdta =  DB::select ("select icode0 as grpid,iname0 as grpname from tbleitem0 ");
        $itmdta=  DB::select ("select icode as itmid,iname as itmname from tbleitem ");
        $szedta=  DB::select ("select sizeid as szeid,sizename as szename from tblesize ");
        $srcdta=  DB::select ("select srcid as sid,srcname as sname from tblesource ");
        $brddta=  DB::select ("select brandid as bid,brandname as bname from tblebrand ");
        $untdta=  DB::select ("select unitid as uid,unitname as uname from tbleunit ");
        $locdta=  DB::select ("select locid as lid,locname as lname from tblelocation ");

        $grouprelation=Grouprelation::find($id);
       if (is_null($grouprelation))
           {
               // NOT FOUND
               return redirect()->back();
           }
               else
           {

            $data=compact('grouprelation','grpdta','itmdta','szedta','srcdta','brddta','untdta','locdta');
            return view('grouprelations.edit')->with($data);
           };

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grouprelation  $grouprelation
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
                $grouprelation=Grouprelation::find($id);
                $grouprelation->itmid0 = $request->itmid0;
                $grouprelation->itmid = $request->itmid;
                $grouprelation->itmsizeid = $request->itmsizeid;
                $grouprelation->obqty = $request->obqty;
                $grouprelation->purrate = $request->purrate;
                $grouprelation->costrate = $request->costrate;
                $grouprelation->srcid = $request->srcid;
                $grouprelation->purunitid = $request->purunitid;
                $grouprelation->locid = $request->locid;
                $grouprelation->brandid = $request->brandid;
                $grouprelation->sstatus = $request->sstatus;
                $grouprelation->save();
                return redirect()->route('grouprelations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grouprelation  $grouprelation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grouprelation=Grouprelation::find($id);
        if(!is_null($grouprelation));
{
    ($grouprelation)->delete();


}
return redirect()->back();
    }
}
