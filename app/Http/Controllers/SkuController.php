<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SkuController extends Controller
{

    public function index(Request $request)
    {
        return view('skus.index');
    }

    public function getMaster(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $skus = Sku::where(function ($query) use ($search){
            $query->where('id','LIKE','%' . $search . '%')
            ->orWhere('title','LIKE','%' . $search . '%');
        })
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $skus;
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'required|min:2|unique:skus',
        ]);

        DB::beginTransaction();
        try {
            $sku = new Sku();
            $sku->title = $request->title;
            $sku->save();
            DB::commit();
            Session::flash('success','Sku created');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function edit(Sku $sku)
    {
        return view('skus.edit')->with('sku',$sku);
    }


    public function update(Sku $sku,Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'required|min:3|unique:skus,title,'. $sku->id ,
        ]);

        DB::beginTransaction();
        try {
            $sku->title = $request->title;
            if($request->has('status'))
            {
                $sku->status = 1;
            }else {
                $sku->status = 0;
            }
            $sku->save();
            DB::commit();
            Session::flash('info','Unit updated');
            return redirect()->route('skus.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

}
