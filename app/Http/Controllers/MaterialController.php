<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Sku;
use App\Models\Brand;
use App\Models\Source;
use App\Models\Category;
use App\Models\Material;
use App\Models\Dimension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $materials = Material::where(function($q) use ($search){
            $q->where('title','LIKE',"%$search%")
            ->orWhere('nick','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(5);
        // return $materials;
        return view('materials.index')->with('materials',$materials);
    }

    public function getMaster(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $materials = Material::where(function ($query) use ($search){
            $query->where('id','LIKE','%' . $search . '%');
        })
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $materials;
    }

    public function create()
    {
        return view('materials.create')
            ->with('skus',Sku::all())
            ->with('categories',Category::all())
            ->with('dimensions',Dimension::all())
            ->with('sources',Source::all())
            ->with('brands',Brand::all())
            ->with('materials',Material::all())
            ;
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'required|min:3|unique:materials'
        ]);
        DB::beginTransaction();
        try {
            $material = new Material();
            $material->title = $request->title;
            $material->nick = $request->nick;
            $material->category_id = $request->category_id;
            $material->dimension_id = $request->dimension_id;
            $material->source_id = $request->source_id;
            $material->sku_id = $request->sku_id;
            $material->brand_id = $request->brand_id;
            $material->category = $request->category;
            $material->dimension = $request->dimension;
            $material->source = $request->source;
            $material->sku = $request->sku;
            $material->brand = $request->brand;
            $material->save();
            DB::commit();
            Session::flash('success','Material created');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }


    public function show(Material $material)
    {
        //
    }

    public function edit(Material $material)
    {
        return view('materials.edit')
        ->with('skus',Sku::all())
        ->with('categories',Category::all())
        ->with('dimensions',Dimension::all())
        ->with('sources',Source::all())
        ->with('brands',Brand::all())
        ->with('material',$material)
        ;
    }

    public function update(Material $material,Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'required|unique:materials,title,'.$item->id
        ]);
        DB::beginTransaction();
        try {
            $material->title = $request->title;
            $material->nick = $request->nick;
            $material->category_id = $request->category_id;
            $material->dimension_id = $request->dimension_id;
            $material->source_id = $request->source_id;
            $material->sku_id = $request->sku_id;
            $material->brand_id = $request->brand_id;
            $material->category = $request->category;
            $material->dimension = $request->dimension;
            $material->source = $request->source;
            $material->sku = $request->sku;
            $material->brand = $request->brand;
            if($request->has('status'))
            {
                $material->status = 1;
            }else {
                $material->status = 0;
            }
            $material->save();
            DB::commit();
            Session::flash('info','Material updated');
            return redirect()->route('materials.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }


    public function destroy($id)
    {
  
    }
}
