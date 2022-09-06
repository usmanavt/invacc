<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SourceController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;
        $sources = Source::where(function($q) use ($search){
            $q->where('srcname','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(5);
        return view('sources.index')->with('sources',$sources);
    }

    public function create()
    {
        return view('sources.create')->with('sources',Source::all());
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'srcname'=>'required|min:2|unique:tblesource',
        ]);

        DB::beginTransaction();
        try {
            $source = new Source();
            $source->srcname = $request->srcname;
            $source->save();
            DB::commit();
            Session::flash('success','Source created');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
   
    public function edit(Source $source)
    {
        return view('sources.edit')->with('source',$source);
    }


    public function update(Source $source,Request $request)
    {
        // dd($request->all());
        $request->validate([
            'srcname'=>'required|min:3|unique:tblesource,srcname,'. $source->id ,
        ]);

        DB::beginTransaction();
        try {
            $source->srcname = $request->srcname;
            $source->save();
            DB::commit();
            Session::flash('info','Source updated');
            return redirect()->route('sources.index');
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
