<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Dimension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DimensionController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;
        $dimensions = Dimension::where(function($q) use ($search){
            $q->where('title','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(5);
        return view('dimensions.index')->with('dimensions',$dimensions);
    }

    public function create()
    {
        return view('dimensions.create')->with('dimensions',Dimension::all());
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'required|min:3|unique:dimensions'
        ]);
        DB::beginTransaction();
        try {
            $dimension = new Dimension();
            $dimension->title = $request->title;
            $dimension->save();
            DB::commit();
            Session::flash('success','Dimension created');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }


    public function show(Dimension $dimension)
    {
        //
    }

    public function edit(Dimension $dimension)
    {
        return view('dimensions.edit')->with('dimension',$dimension);
    }


    public function update(Dimension $dimension,Request $request)
    {
        $request->validate([
            'title'=>'required|min:3|unique:dimensions,title,'.$dimension->id
        ]);
        DB::beginTransaction();
        try {
            $dimension->title = $request->title;
            if($request->has('status')){
                $dimension->status = 1;
            }else {
                $dimension->status = 0;
            }
            $dimension->save();
            DB::commit();
            Session::flash('info','Dimension updated');
            return redirect()->route('dimensions.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

  
    public function destroy($id)
    {
      
    }
}
