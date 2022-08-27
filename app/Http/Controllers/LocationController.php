<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use DB;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $locations = Location::where(function($q) use ($search){
            $q->where('locname','LIKE',"%$search%")
            ->orWhere('locaddress','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(6);
        return view('locations.index')->with('locations',$locations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('locations.create');
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
                'locname'=>'required',
                'locname'=>'required|unique:tblelocation'

            ]
            );


        $maxValue = DB::table('tblelocation')->max('locid')+1;
        // dd($maxValue);
        // try {
            // DB::transaction(function () {
                $location = new Location();
                $location->locid = $maxValue;
                $location->locname = $request->locname;
                $location->locaddress = $request->locaddress;
                $location->save();
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
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $location=Location::find($id);
        if (is_null($location))
            {
                // NOT FOUND
                return redirect()->back();
            }
                else
            {


                $data=compact('location');
                return view('locations.edit')->with($data);
            };
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $location=Location::find($id);
                $location->locname = $request->locname;
                $location->locaddress = $request->locaddress;
                $location->save();
             return redirect()->route('locations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $location=Location::find($id);
            if(!is_null($location));
        {
            ($location)->delete();


        }
return redirect()->back();
    }
}
