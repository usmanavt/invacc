<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Dimension;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DimensionController extends Controller
{

    public function index(Request $request)
    {
        return view('dimensions.index');
    }

    public function getMaster(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $dimensions = Dimension::where(function ($query) use ($search){
            $query->where('id','LIKE','%' . $search . '%')
            ->orWhere('title','LIKE','%' . $search . '%');
        })
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $dimensions;
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'required|min:1|unique:dimensions'
        ]);
        DB::beginTransaction();
        try {
            $dimension = new Dimension();
            $dimension->title = $request->title;
            $dimension->status = 1;
            $dimension->save();
            DB::commit();
            Session::flash('success','Dimension created');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function edit(Dimension $dimension)
    {
        return view('dimensions.edit')->with('dimension',$dimension);
    }

    public function update(Dimension $dimension,Request $request)
    {

    // usman khanr
        //    dd($request->all(),$dimension);
        $request->validate([
            // 'title'=>'required|min:1|unique:dimensions,title'
            // 'title'=>'required|min:1|unique:dimensions'
            // 'title'=>'required|min:3|unique:dimensions,title,'. $dimension->id ,
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
            // $cl = Material::where('dimension_id',$dimension->id)->get();
            // if (!count($cl) <= 0)
            // {
            //     // $cl->dimension = $request->title;
            //     // $cl->save();
            //     dd($dimension->id);
            // }

            // DB::update(DB::raw("UPDATE materials set dimension= ' $request->title ' where dimension_id=$dimension->id"));

            DB::update(DB::raw("UPDATE materials INNER JOIN dimensions ON dimensions.id=materials.dimension_id
            SET DIMENSION=LTRIM(dimensions.title) WHERE materials.id=$dimension->id "));





            DB::commit();
            Session::flash('info','Dimension updated');
            return redirect()->route('dimensions.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
