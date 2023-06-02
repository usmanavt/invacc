<?php

namespace App\Http\Controllers;

use App\Models\Hscode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HscodeController extends Controller
{

    public function index(Request $request)
    {
        return view('hscodes.index');
    }

    public function getMaster(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $hscodes = Hscode::where(function ($query) use ($search){
            $query->where('id','LIKE','%' . $search . '%')
            ->orWhere('hscode','LIKE','%' . $search . '%');
        })
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $hscodes;
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request,[
            'hscode' => 'required|min:3|unique:hscodes',
            'cd' => 'required|numeric',
            'st' => 'required|numeric',
            'rd' => 'required|numeric',
            'acd' => 'required|numeric',
            'ast' => 'required|numeric',
            'it' => 'required|numeric',
            'wse' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $hscode = new Hscode();
            $hscode->hscode = $request->hscode;
            $hscode->cd = $request->cd;
            $hscode->st = $request->st;
            $hscode->rd = $request->rd;
            $hscode->acd = $request->acd;
            $hscode->ast = $request->ast;
            $hscode->it = $request->it;
            $hscode->wse = $request->wse;
            $hscode->save();
            DB::commit();
            Session::flash('success','Hscode added');
            return redirect()->route('hscodes.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function edit(Hscode $hscode)
    {
        return view('hscodes.edit')->with('hscode',$hscode)->with('hscodes',Hscode::select('id','hscode')->get());
    }

    public function update(Request $request, Hscode $hscode)
    {
        // dd($request->all());
        $this->validate($request,[
            'hscode' => 'required|min:9|unique:hscodes,hscode,'. $hscode->id,
            'cd' => 'required|numeric',
            'st' => 'required|numeric',
            'rd' => 'required|numeric',
            'acd' => 'required|numeric',
            'ast' => 'required|numeric',
            'it' => 'required|numeric',
            'wse' => 'required|numeric',
        ]);
        DB::beginTransaction();
        try {
            $hscode->hscode = $request->hscode;
            $hscode->cd = $request->cd;
            $hscode->st = $request->st;
            $hscode->rd = $request->rd;
            $hscode->acd = $request->acd;
            $hscode->ast = $request->ast;
            $hscode->it = $request->it;
            $hscode->wse = $request->wse;
            $hscode->save();
            DB::commit();
            Session::flash('info','Hscode updated');
            return redirect()->route('hscodes.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
