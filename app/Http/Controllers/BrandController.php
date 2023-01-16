<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Brand;
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
        $brands = Brand::where(function ($query) use ($search){
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
            $brand = new Brand();
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
            Session::flash('success','Brand created');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function edit(Brand $brand)
    {
        return view('brands.edit')->with('brand',$brand);
    }


    public function update(Brand $brand,Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'required|min:3|unique:brands,title,'. $brand->id ,
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
