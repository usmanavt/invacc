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
        $search = $request->search;
        $brands = Brand::where(function($q) use ($search){
            $q->where('title','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(5);
        return view('brands.index')->with('brands',$brands);
    }

    public function create()
    {
        return view('brands.create')->with('brands',Brand::all());
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

    public function destroy($id)
    {
        return redirect()->back();
    }
}
