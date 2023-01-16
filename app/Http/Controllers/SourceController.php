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
        return view('sources.index');
    }

    public function getMaster(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $sources = Source::where(function ($query) use ($search){
            $query->where('id','LIKE','%' . $search . '%')
            ->orWhere('title','LIKE','%' . $search . '%');
        })
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $sources;
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'required|min:2|unique:sources',
        ]);

        DB::beginTransaction();
        try {
            $source = new Source();
            $source->title = $request->title;
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
            'title'=>'required|min:3|unique:sources,title,'. $source->id ,
        ]);

        DB::beginTransaction();
        try {
            $source->title = $request->title;
            if($request->has('status'))
            {
                $source->status = 1;
            }else {
                $source->status = 0;
            }
            $source->save();
            DB::commit();
            Session::flash('info','Source updated');
            return redirect()->route('sources.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

}
