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
            $q->where('title','LIKE',"%$search%")
            ->orWhere('address','LIKE',"%$search%");
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
            'title'=>'required|unique:locations'
        ]);

        DB::beginTransaction();
        try {
            $location = new Location();
            $location->title = $request->title;
            $location->address = $request->address;
            if($request->has('status'))
            {
                $location->status = 1;
            }else {
                $location->status = 0;
            }
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
            'title'=>'required|unique:locations,title,'.$location->id
        ]);
        DB::beginTransaction();
        try {
            $location->title = $request->title;
            $location->address = $request->address;
            if($request->has('status'))
            {
                $location->status = 1;
            }else {
                $location->status = 0;
            }
            $location->save();
            DB::commit();
            Session::flash('info','Location updated');
            return redirect()->route('locations.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
   
    }

    public function destroy($id)
    {
        return redirect()->back();
    }
}
