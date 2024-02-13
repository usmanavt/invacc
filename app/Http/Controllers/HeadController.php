<?php

namespace App\Http\Controllers;

use App\Models\Head;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HeadController extends Controller
{
    public function index(Request $request)
    {
        return view('heads.index');
    }

    public function getMaster(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $heads = Head::where(function ($query) use ($search){
            $query->where('id','LIKE','%' . $search . '%')
            ->orWhere('title','LIKE','%' . $search . '%');
        })
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $heads;
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'required|unique:heads|min:3',
            // 'ob'=>'required|numeric'
        ]);
        DB::beginTransaction();
        try {
            $head = new Head();
            $head->title = $request->title;
            $head->nature = $request->nature;
            $head->obdlr = $request->obdlr;
            $head->obrup = $request->obrup;


            $head->save();
            DB::commit();
            Session::flash('success','Head opened');
            return redirect()->route('heads.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function edit(Head $head)
    {
        return view('heads.edit')->with('head',$head);
    }

    public function update(Head $head,Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'required|min:3|unique:heads,title,' . $head->id,
            // 'ob'=>'required|numeric'
        ]);
        DB::beginTransaction();
        try {
            $head->title = $request->title;
            $head->nature = $request->nature;

            $head->obdlr = $request->obdlr;
            $head->obrup = $request->obrup;


            if($request->has('status'))
            {
                $head->status = 1;
            }else {
                $head->status = 0;
            }
            $head->save();
            DB::commit();
            Session::flash('info','Head updated');
            return redirect()->route('heads.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
