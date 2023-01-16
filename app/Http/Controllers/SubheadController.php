<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Head;
use App\Models\heads;
use App\Models\Subhead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

// CHART OF ACCOUNTS
class SubheadController extends Controller
{

    public function index(Request $request)
    {
        return view('subheads.index')->with('heads',Head::all());
    }

    public function getMaster(Request $request)
    {
        $search = $request->search;
        $size = $request->size;
        $field = $request->sort[0]["field"];     //  Nested Array
        $dir = $request->sort[0]["dir"];         //  Nested Array
        //  With Tables
        $subhead = Subhead::where(function ($query) use ($search){
            $query->where('id','LIKE','%' . $search . '%')
            ->orWhere('title','LIKE','%' . $search . '%')
            ->orWhere('ob','LIKE','%' . $search . '%');
        })
        ->orderBy($field,$dir)
        ->paginate((int) $size);
        return $subhead;
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'required|unique:subheads|min:3',
            // 'ob'=>'required|numeric'
        ]);
        DB::beginTransaction();
        try {
            $subhead = new Subhead();
            $subhead->head_id = $request->head_id;
            $subhead->title = $request->title;
            if($request->has('ob'))
            {
                $subhead->ob = $request->ob;
            }else {
                $subhead->ob = 0;
            }
            if($request->has('status'))
            {
                $subhead->status = 1;
            }else {
                $subhead->status = 0;
            }
            $subhead->save();
            DB::commit();
            Session::flash('success','Subhead opened');
            return redirect()->route('subheads.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function edit(Subhead $subhead)
    {
        return view('subheads.edit')->with('heads',Head::all())->with('subhead',$subhead);
    }

    public function update(Subhead $subhead,Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'required|min:3|unique:subheads,title,' . $subhead->id,
            // 'ob'=>'required|numeric'
        ]);
        DB::beginTransaction();
        try {
            $subhead->head_id = $request->head_id;
            $subhead->title = $request->title;
            $subhead->ob = $request->ob;
            if($request->has('status'))
            {
                $subhead->status = 1;
            }else {
                $subhead->status = 0;
            }
            $subhead->save();
            DB::commit();
            Session::flash('info','Subhead updated');
            return redirect()->route('subheads.index');
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
