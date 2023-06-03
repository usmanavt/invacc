<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Care;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CareController extends Controller
{

    public function index(Request $request)
    {
        return view('cares.index');
    }

    public function getMaster(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $care = Care::where(function ($query) use ($search){
            $query->where('id','LIKE','%' . $search . '%')
            ->orWhere('title','LIKE','%' . $search . '%');
        })
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $care;
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'required|min:1|unique:cares'
        ]);
        DB::beginTransaction();
        try {
            $care = new Care();
            $care->title = $request->title;
            $care->status = 1;
            $care->save();
            DB::commit();
            Session::flash('success','care created');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function edit(Care $care)
    {
        return view('cares.edit')->with('care',$care);
    }

    public function update(Care $care,Request $request)
    {
        $request->validate([
            'title'=>'required|min:1|unique:cares,title,'.$care->id
        ]);
        DB::beginTransaction();
        try {
            $care->title = $request->title;
            if($request->has('status')){
                $care->status = 1;
            }else {
                $care->status = 0;
            }
            $care->save();
            DB::commit();
            Session::flash('info','Care updated');
            return redirect()->route('cares.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
