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
        $search = $request->search;
        $heads = Head::where(function($q) use ($search){
            $q->where('title','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(5);
         return view('heads.index')->with('heads',$heads);
    }

    public function create()
    {
        return view('heads.create')->with('heads',Head::all());
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

    public function destroy($id)
    {
        return redirect()->back();
    }
}
