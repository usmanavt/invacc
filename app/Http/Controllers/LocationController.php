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
        return view('locations.index');
    }

    public function getMaster(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $locations = Location::where(function ($query) use ($search){
            $query->where('id','LIKE','%' . $search . '%')
            ->orWhere('title','LIKE','%' . $search . '%');
        })
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $locations;
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
}
