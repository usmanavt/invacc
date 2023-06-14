<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Sku;
use App\Models\Brand;
use App\Models\Hscode;
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
            ->orWhere('nick','LIKE',"%$search%")
            ->orWhereHas('hscodes', function($qu) use ($search){
                $qu->where('hscode','LIKE',"$search");
            });
        })
        ->orderBy('id','desc')
        ->paginate(5);
        // return $materials;
        return view('materials.index')
        ->with('materials',$materials)
        ->with('skus',Sku::all())
        ->with('categories',Category::all())
        ->with('dimensions',Dimension::all())
        ->with('sources',Source::all())
        ->with('brands',Brand::all())
        ->with('hscodes',Hscode::select('id','hscode')->get());
    }

    public function getMaster(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $materials = Material::where(function ($query) use ($search){
            $query->where('title','LIKE','%' . $search . '%')
            ->orWhere('dimension','LIKE','%' . $search . '%');
        })
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $materials;
    }

    public function create()
    {
        // return view('materials.create')
        //     ->with('skus',Sku::all())
        //     ->with('categories',Category::all())
        //     ->with('dimensions',Dimension::all())
        //     ->with('sources',Source::all())
        //     ->with('brands',Brand::all())
        //     ->with('hscodes',Hscode::select('id','hscode')->get())
        //     ->with('materials',Material::all())
        //     ;
    }

    public function store(Request $request)
    {
        //  dd($request->all());
        $request->validate([
            //  'title'=>'required|min:3|unique:materials'
        ]);

        $title = $request->title;
        $dimension_id = $request->dimension_id;
        $mat = Material::where('dimension_id',$dimension_id)->where('title',$title)->first();
        if($mat)
        {
            // dd($mat);
            Session::flash('info','Same dimension for same title exists');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            {
                $material = new Material();
                $material->title = $request->title;
                $material->nick = $request->nick;
                $material->category_id = $request->category_id;
                $material->dimension_id = $request->dimension_id;
                $material->source_id = 0;
                $material->sku_id = $request->sku_id;
                $material->brand_id = 0;
                $material->hscode_id = 0;
                $material->category = $request->category;
                $material->dimension = $request->dimension;
                // $material->source = $request->source;
                $material->sku = $request->sku;
                // $material->brand = $request->brand;

                $material->qtykg = $request->qtykg;
                $material->qtykgrt = $request->qtykgrt;

                $material->qtypcs = $request->qtypcs;
                $material->qtypcsrt = $request->qtypcsrt;

                $material->qtyfeet = $request->qtyfeet;
                $material->qtyfeetrt = $request->qtyfeetrt;


                $material->save();
            }
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

    public function copyMaterial($id)
    {
        // dd($material);
        return view('materials.copy')
        // ->with('skus',Sku::all())
        // ->with('categories',Category::all())
        ->with('dimensions',Dimension::all())
        // ->with('sources',Source::all())
        // ->with('brands',Brand::all())
        // ->with('hscodes',Hscode::all())
        ->with('material',Material::findOrFail($id))
        ->with('materials',Material::select('id','title','dimension')->get())
        ;
    }

    public function edit(Material $material)
    {
        return view('materials.edit')
        ->with('skus',Sku::all())
        ->with('categories',Category::all())
        ->with('dimensions',Dimension::all())
        ->with('sources',Source::all())
        ->with('brands',Brand::all())
        // ->with('hscodes',Hscode::select('id','hscode')->get())
        ->with('material',$material)
        ;
    }

    public function update(Material $material,Request $request)
    {
        // dd($request->all());
        $request->validate([
            // 'title'=>'required|unique:materials,title,'.$material->id
        ]);
        DB::beginTransaction();
        try {
            $material->title = $request->title;
            $material->nick = $request->nick;
            $material->category_id = $request->category_id;
            $material->dimension_id = $request->dimension_id;
            // $material->source_id = $request->source_id;
            $material->sku_id = $request->sku_id;
            // $material->brand_id = $request->brand_id;
            // $material->hscode_id = $request->hscode_id;
            $material->category = $request->category;
            $material->dimension = $request->dimension;
            // $material->source = $request->source;
            $material->sku = $request->sku;
            // $material->brand = $request->brand;

            $material->qtykg = $request->qtykg;
            $material->qtykgrt = $request->qtykgrt;

            $material->qtypcs = $request->qtypcs;
            $material->qtypcsrt = $request->qtypcsrt;

            $material->qtyfeet = $request->qtyfeet;
            $material->qtyfeetrt = $request->qtyfeetrt;

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
