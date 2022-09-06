<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UnitController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;
        $units = Unit::where(function($q) use ($search){
            $q->where('unitname','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(5);
        return view('units.index')->with('units',$units);
    }

    public function create()
    {
        return view('units.create')->with('units',Unit::all());
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'unitname'=>'required|min:2|unique:tbleunit',
        ]);

        DB::beginTransaction();
        try {
            $unit = new Unit();
            $unit->unitname = $request->unitname;
            $unit->save();
            DB::commit();
            Session::flash('success','Unit created');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
   
    public function edit(Unit $unit)
    {
        return view('units.edit')->with('unit',$unit);
    }


    public function update(Unit $unit,Request $request)
    {
        // dd($request->all());
        $request->validate([
            'unitname'=>'required|min:3|unique:tbleunit,unitname,'. $unit->id ,
        ]);

        DB::beginTransaction();
        try {
            $unit->unitname = $request->unitname;
            $unit->save();
            DB::commit();
            Session::flash('info','Unit updated');
            return redirect()->route('units.index');
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
