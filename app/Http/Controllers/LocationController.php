<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocationController extends Controller
{

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

    public function create()
    {
        return view('locations.create')->with('locations',Location::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'locname'=>'required|unique:tblelocation'
        ]);

        DB::beginTransaction();
        try {
            $location = new Location();
            $location->locname = $request->locname;
            $location->locaddress = $request->locaddress;
            $location->save();
            DB::commit();
            Session::flash('success','Location created');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

    }

   
    public function show(Location $location)
    {
        //
    }


    public function edit(Location $location)
    {
        return view('locations.edit')->with('location',$location);
    }

 
    public function update(Location $location,Request $request)
    {
        $request->validate([
            'locname'=>'required|unique:tblelocation,locname,'.$location->id
        ]);
        DB::beginTransaction();
        try {
            $location->locname = $request->locname;
            $location->locaddress = $request->locaddress;
            $location->save();
            DB::commit();
            Session::flash('info','Location created');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
   
    }

    public function destroy($id)
    {

    }
}
