<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Brand;
use App\Models\Specification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{

    public function index(Request $request)
    {
        return view('brands.index');
    }

    public function getMaster(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $brands = Specification::where(function ($query) use ($search){
            $query->where('id','LIKE','%' . $search . '%')
            ->orWhere('title','LIKE','%' . $search . '%');
        })
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $brands;
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'required|min:2|unique:brands',
        ]);

        DB::beginTransaction();
        try {
            $brand = new Specification();
            $brand->title = $request->title;
            $brand->status = 1;
            // if($request->has('status'))
            // {
            //     $brand->status = 1;
            // }
            // else {
            //     $brand->status = 0;
            // }
            $brand->save();
            DB::commit();
            Session::flash('success','Brand created');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function edit(Specification $brand)
    {
        return view('brands.edit')->with('brand',$brand);
    }


    public function update(Specification $brand,Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'required|min:3|unique:specifications,title,'. $brand->id ,
        ]);

        DB::beginTransaction();
        try {
            $brand->title = $request->title;
            if($request->has('status'))
            {
                $brand->status = 1;
            }
            else {
                $brand->status = 0;
            }
            $brand->save();
            DB::commit();
            Session::flash('info','Brand updated');
            return redirect()->route('brands.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

}
