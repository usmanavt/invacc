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
        $search = $request->search;
        $subheads = Subhead::where(function($q) use ($search){
            $q->where('title','LIKE',"%$search%")
              ->orWhereHas('head', function($qu) use($search){
                $qu->where('title','like',"%$search%");
            });
        })
        ->with('head')
        ->orderBy('id','desc')
        ->paginate(5);
         return view('subheads.index')->with('subheads',$subheads);

    }

    public function create()
    {
        return view('subheads.create')->with('heads',Head::all())->with('subheads',Subhead::all());
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
            $subhead->ob = $request->ob;
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
